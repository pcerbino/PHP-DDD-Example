<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jobberwocky\Jobs\Application\CreateJobService;
use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use Jobberwocky\Jobs\Domain\Job;

class CreateJobServiceTest extends TestCase
{
    private $jobRepository;
    private $createJobService;

    protected function setUp(): void
    {
        $this->jobRepository = $this->createMock(JobRepositoryInterface::class);
        $this->createJobService = new CreateJobService($this->jobRepository);
    }

    public function testExecuteWithValidParameters(): void
    {
        $title = 'Software Engineer';
        $country = 'USA';
        $salary = 100000;
        $keywords = ['PHP', 'Laravel', 'MySQL'];

        $this->jobRepository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Job::class));

        $job = $this->createJobService->execute($title, $country, $salary, $keywords);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($title, $job->title()->value());
        $this->assertEquals($country, $job->country()->value());
        $this->assertEquals($salary, $job->salary()->value());
        $this->assertEquals($keywords, $job->keywords()->list());
    }

    public function testExecuteWithInvalidParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $title = '';
        $country = '';
        $salary = -1;
        $keywords = [];

        $this->createJobService->execute($title, $country, $salary, $keywords);
    }
}
