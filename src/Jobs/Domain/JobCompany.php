<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobCompany
{
    private string $company;

    public function __construct(string $company)
    {
        $this->company = $company;
    }

    public function value(): string
    {
        return $this->company;
    }

    public function __toString()
    {
        return $this->company;
    }
}
