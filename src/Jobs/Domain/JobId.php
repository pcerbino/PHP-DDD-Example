<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
