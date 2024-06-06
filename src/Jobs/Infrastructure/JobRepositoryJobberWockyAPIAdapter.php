<?php

namespace Jobberwocky\Jobs\Infrastructure;

use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;

class JobRepositoryJobberWockyAPIAdapter implements JobRepositoryAdapterResponse
{
    private array $jobs = [];

    public function createAdapter(array $jobs): JobRepositoryAdapterResponse
    {
        $this->adaptJobs($jobs);
        return $this;
    }

    public function getJobs(): array
    {
        return $this->jobs;
    }

    private function adaptJobs(array $jobs): void
    {
        foreach ($jobs as $job) {
            $this->jobs[] = [
                'title' => $job[0],
                'salary' => $job[1],
                'country' => $job[2]
            ];
        }
    }
}
