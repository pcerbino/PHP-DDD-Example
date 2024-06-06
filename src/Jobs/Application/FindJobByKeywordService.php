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
        if (empty($keyword))
        {
            throw new \InvalidArgumentException('Keyword is required');
        }
        $jobs = array_merge(
            $this->jobRepositoryLocal->findByKeyword($keyword)->getJobs(),
            $this->jobRepositoryRemote->findByKeyword($keyword)->getJobs()
        );
        return $jobs;
    }
}