<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobDescription
{
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function value(): string
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->description;
    }
}