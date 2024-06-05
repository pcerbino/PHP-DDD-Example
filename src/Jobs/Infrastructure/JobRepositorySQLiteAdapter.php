<?php

namespace Jobberwocky\Jobs\Infrastructure;

use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;

class JobRepositorySQLiteAdapter implements JobRepositoryAdapterResponse
{
    public array $jobs = [];

    public function createAdapter(array $jobs): JobRepositoryAdapterResponse
    {
        $this->adaptJobs($jobs);
        return $this;
    }

    private function adaptJobs(array $jobs): void
    {
        foreach ($jobs as $job) {
            $this->jobs[] = [
                'title' => $job['title'],
                'salary' => $job['salary'],
                'country' => $job['country']
            ];
        }
    }
}
