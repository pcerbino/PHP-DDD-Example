<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Application;

use Jobberwocky\Jobs\Domain\JobCountry;
use Jobberwocky\Jobs\Domain\JobSalary;
use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use Jobberwocky\Jobs\Domain\JobTitle;
use Jobberwocky\Jobs\Domain\Job;
use Jobberwocky\Jobs\Domain\JobKeywords;

class CreateJobService
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function execute(
        string $title, 
        string $country, 
        int $salary, 
        array $keywords
    ): Job
    {
        if (empty($title) || empty($country) || empty($salary) || empty($keywords))
        {
            throw new \InvalidArgumentException('All fields are required');
        }

        $job = new Job(
            new JobTitle($title), 
            new JobCountry($country),
            new JobSalary($salary),
            new JobKeywords($keywords)
        );
        $this->jobRepository->create($job);
        return $job;
    }
}
