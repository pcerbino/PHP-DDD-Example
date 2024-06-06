<?php

namespace Jobberwocky\Jobs\Infrastructure;

use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;
use Jobberwocky\Jobs\Domain\Job;
use Jobberwocky\Jobs\Domain\JobId;
use PDO;

class JobRepositorySQLite implements JobRepositoryInterface
{
    private PDO $pdo;
    private JobRepositoryAdapterResponse $adapter;

    public function __construct($adapter)
    {
        $this->pdo = new PDO('sqlite:../database/sqlite.db');
        $this->checkJobTable();

        $this->adapter = $adapter;
    }

    private function checkJobTable(): void
    {
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS jobs 
            (id INTEGER PRIMARY KEY, title TEXT, country TEXT, salary TEXT)
        ');
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS job_keywords 
            (job_id INTEGER, keyword TEXT, FOREIGN KEY (job_id) REFERENCES jobs(id))
        ');
    }

    public function create(Job $job): void
    {
        if ($job->id() === null) {
            $stmt = $this->pdo->prepare('
                INSERT INTO jobs VALUES (null, :title, :country, :salary)
            ');
            $stmt->execute([
                'title' => $job->title()->value(),
                'country' => $job->country()->value(),
                'salary' => $job->salary()->value()
            ]);
            $jobId = new JobId($this->pdo->lastInsertId());
            $job->setId($jobId);
        
        } else {
            $stmt = $this->pdo->prepare('
                UPDATE jobs 
                SET title = :title, country = :country, salary = :salary 
                WHERE id = :id
            ');
            $stmt->execute([
                'id' => $job->id()->value(),
                'title' => $job->title()->value(),
                'country' => $job->country()->value(),
                'salary' => $job->salary()->value()
            ]);
        }

        $stmt = $this->pdo->prepare('
            DELETE FROM job_keywords 
            WHERE job_id = :job_id
        ');
        $stmt->execute(['job_id' => $job->id()]);

        $stmt = $this->pdo->prepare('
            INSERT INTO job_keywords (job_id, keyword) 
            VALUES (:job_id, :keyword)
        ');

        foreach ($job->keywords()->list() as $keyword) {
            $stmt->execute(['job_id' => $job->id(), 'keyword' => $keyword]);
        }
    }

    public function findByKeyword($keyword): JobRepositoryAdapterResponse
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM jobs 
            WHERE id IN (
                SELECT job_id FROM job_keywords WHERE keyword = :keyword
            )
        ");
        $stmt->execute(['keyword' => $keyword]);
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->adapter->createAdapter($jobs);
    }
}
