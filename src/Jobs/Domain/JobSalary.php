<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobSalary
{
    private int $salary;

    public function __construct(int $salary)
    {
        $this->salary = $salary;
    }

    public function value(): int
    {
        return $this->salary;
    }
}
