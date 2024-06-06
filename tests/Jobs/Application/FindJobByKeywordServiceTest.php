<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jobberwocky\Jobs\Application\FindJobByKeywordService;
use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use Jobberwocky\Jobs\Infrastructure\JobRepositoryJobberWockyAPIAdapter;
use Jobberwocky\Jobs\Infrastructure\JobRepositorySQLiteAdapter;

class FindJobByKeywordServiceTest extends TestCase
{
    private $jobRepositoryLocal;
    private $jobRepositoryRemote;
    private $findJobByKeywordService;

    protected function setUp(): void
    {
        $this->jobRepositoryLocal = $this->createMock(JobRepositoryInterface::class);
        $this->jobRepositoryRemote = $this->createMock(JobRepositoryInterface::class);

        $this->findJobByKeywordService = new FindJobByKeywordService(
            $this->jobRepositoryLocal,
            $this->jobRepositoryRemote
        );
    }

    public function testExecuteWithValidKeyword(): void
    {
        $keyword = 'PHP';
        
        $localJobs = [
            ['title' => 'Job 1', 'salary' => 1000, 'country' => 'Brazil'],
            ['title' => 'Job 2', 'salary' => 2000, 'country' => 'India']
        ];
        
        $remoteJobs = [
            ['Job 3', 3000, 'Argentina'],
            ['Job 4', 4000, 'Uruguay']
        ];
        
        $expectedJobs = [
            ['title' => 'Job 1', 'salary' => 1000, 'country' => 'Brazil'],
            ['title' => 'Job 2', 'salary' => 2000, 'country' => 'India'],
            ['title' => 'Job 3', 'salary' => 3000, 'country' => 'Argentina'],
            ['title' => 'Job 4', 'salary' => 4000, 'country' => 'Uruguay']
        ];

        $sqlAdapter = new JobRepositorySQLiteAdapter();
        $sqlAdapter->createAdapter($localJobs);
        $apiAdapter = new JobRepositoryJobberWockyAPIAdapter;
        $apiAdapter->createAdapter($remoteJobs);

        $this->jobRepositoryLocal->expects($this->once())
            ->method('findByKeyword')
            ->with($keyword)
            ->willReturn($sqlAdapter);

        $this->jobRepositoryRemote->expects($this->once())
            ->method('findByKeyword')
            ->with($keyword)
            ->willReturn($apiAdapter);

        $jobs = $this->findJobByKeywordService->execute($keyword);

        $this->assertEquals($expectedJobs, $jobs);
    }

    public function testExecuteWithEmptyKeyword(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $keyword = '';

        $this->findJobByKeywordService->execute($keyword);
    }
}
