<?php

namespace Jobberwocky\Jobs\Application;

use Jobberwocky\Jobs\Domain\JobRepositoryInterface;

class FindJobByKeywordService
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository
    ) {
    }

    public function execute(string $keyword)
    {
        $jobs = $this->jobRepository->findByKeyword($keyword);
        return $jobs;
    }
}