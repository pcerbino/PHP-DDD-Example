<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobKeywords
{
    private array $keywords;

    public function __construct(array $keywords)
    {
        $this->keywords = $keywords;
    }

    public function list(): array
    {
        return $this->keywords;
    }

    public function __toArray()
    {
        return $this->keywords;
    }
}
