<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

final class Job {

    private ?JobId $id = null;

    public function __construct(
        private JobTitle    $title,
        private JobCountry  $country,
        private JobSalary   $salary,
        private JobKeywords $keywords
    ) {
    }

    public function id(): ?JobId
    {
        return $this->id;
    }

    public function country(): JobCountry
    {
        return $this->country;
    }

    public function title(): JobTitle
    {
        return $this->title;
    }

    public function salary(): JobSalary
    {
        return $this->salary;
    }

    public function keywords(): JobKeywords
    {
        return $this->keywords;
    }

    public function setId(JobId $id): void
    {
        $this->id = $id;
    }
}
