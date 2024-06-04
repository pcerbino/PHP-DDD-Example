<?php

namespace Jobberwocky\Jobs\Infrastructure;

use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use Jobberwocky\Jobs\Domain\Job;
use Jobberwocky\Jobs\Domain\JobId;
use PDO;

class JobRepositorySQLite implements JobRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:../database/sqlite.db');
        $this->checkJobTable();
    }

    private function checkJobTable(): void
    {
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS jobs 
            (id INTEGER PRIMARY KEY, title TEXT, company TEXT, description TEXT)
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
                INSERT INTO jobs VALUES (null, :title, :company, :description)
            ');
            $stmt->execute([
                'title' => $job->title(),
                'company' => $job->company(),
                'description' => $job->description()
            ]);
            $jobId = new JobId($this->pdo->lastInsertId());
            $job->setId($jobId);
        
        } else {
            $stmt = $this->pdo->prepare('
                UPDATE jobs 
                SET title = :title, company = :company, description = :description 
                WHERE id = :id
            ');
            $stmt->execute([
                'id' => $job->id(),
                'title' => $job->title(),
                'company' => $job->company(),
                'description' => $job->description()
            ]);
        }

        $stmt = $this->pdo->prepare("DELETE FROM job_keywords WHERE job_id = :job_id");
        $stmt->execute(['job_id' => $job->id()]);

        $stmt = $this->pdo->prepare("INSERT INTO job_keywords (job_id, keyword) VALUES (:job_id, :keyword)");

        foreach ($job->keywords()->list() as $keyword) {
            $stmt->execute(['job_id' => $job->id(), 'keyword' => $keyword]);
        }
    }

    public function findByKeyword($keyword): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM jobs 
            WHERE id IN (
                SELECT job_id FROM job_keywords WHERE keyword = :keyword
            )
        ");
        $stmt->execute(['keyword' => $keyword]);
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $jobs;
    }
}
