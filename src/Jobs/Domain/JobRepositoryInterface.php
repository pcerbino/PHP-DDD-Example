<?php

namespace Jobberwocky\Jobs\Domain;

interface JobRepositoryInterface
{
    public function create(Job $job): void;
    public function findByKeyword(string $keyword): array;
}
