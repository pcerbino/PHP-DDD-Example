<?php

namespace Jobberwocky\Jobs\Domain;

class JobTitle
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function value(): string
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->title;
    }
}
