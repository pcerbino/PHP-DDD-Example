<?php

declare(strict_types=1);

namespace Jobberwocky\Jobs\Domain;

final class Job {

    private ?JobId $id = null;

    public function __construct(
        private JobTitle $title,
        private JobCompany $company,
        private JobDescription $description,
        private JobKeywords $keywords
    ) {
    }

    public function id(): ?JobId
    {
        return $this->id;
    }

    public function company(): JobCompany
    {
        return $this->company;
    }

    public function title(): JobTitle
    {
        return $this->title;
    }

    public function description(): JobDescription
    {
        return $this->description;
    }

    public function keywords(): JobKeywords
    {
        return $this->keywords;
    }

    public function setId(JobId $id)
    {
        $this->id = $id;
    }
}
