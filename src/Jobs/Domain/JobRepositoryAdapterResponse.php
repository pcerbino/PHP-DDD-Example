<?php

namespace Jobberwocky\Jobs\Domain;

interface JobRepositoryAdapterResponse
{
    public function createAdapter(array $jobs): JobRepositoryAdapterResponse;
}
