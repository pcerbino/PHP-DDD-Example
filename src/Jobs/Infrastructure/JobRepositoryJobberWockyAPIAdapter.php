<?php

namespace Jobberwocky\Jobs\Infrastructure;

use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;

class JobRepositoryJobberWockyAPIAdapter implements JobRepositoryAdapterResponse
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
                'title' => $job[0],
                'salary' => $job[1],
                'country' => $job[2]
            ];
        }
    }
}
