<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

class JobCountry
{
    private string $country;

    public function __construct(string $country)
    {
        $this->country = $country;
    }

    public function value(): string
    {
        return $this->country;
    }

    public function __toString()
    {
        return $this->country;
    }
}
