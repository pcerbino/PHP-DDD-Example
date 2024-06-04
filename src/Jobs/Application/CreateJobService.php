<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Application;

use Jobberwocky\Jobs\Domain\JobCompany;
use Jobberwocky\Jobs\Domain\JobDescription;
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

    public function execute(string $title, string $company, string $description, array $keywords): Job
    {
        $job = new Job(
            new JobTitle($title), 
            new JobCompany($company),
            new JobDescription($description),
            new JobKeywords($keywords)
        );
        $this->jobRepository->create($job);
        return $job;
    }
}
