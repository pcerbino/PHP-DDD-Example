<?php

namespace Jobberwocky\Jobs\Application;

use Jobberwocky\Jobs\Domain\JobRepositoryInterface;

class FindJobByKeywordService
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepositoryLocal,
        private readonly JobRepositoryInterface $jobRepositoryRemote
    ) {
    }

    public function execute(string $keyword)
    {
        $jobs = array_merge(
            $this->jobRepositoryLocal->findByKeyword($keyword)->jobs,
            $this->jobRepositoryRemote->findByKeyword($keyword)->jobs
        );
        return $jobs;
    }
}