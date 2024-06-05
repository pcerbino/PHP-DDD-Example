<?php

namespace Jobberwocky\Jobs\Infrastructure;

use GuzzleHttp\Exception\GuzzleException;
use Jobberwocky\Jobs\Domain\Job;
use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;
use Jobberwocky\Jobs\Domain\JobRepositoryInterface;
use GuzzleHttp\Client;

class JobRepositoryJobberWockyAPI implements JobRepositoryInterface
{
    private JobRepositoryAdapterResponse $adapter;

    public function __construct(private Client $client, string $baseUri, JobRepositoryAdapterResponse $adapter)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);

        $this->adapter = $adapter;
    }

    public function findByKeyword(string $keyword): JobRepositoryAdapterResponse
    {
        try {
            $response = $this->client->get("/jobs?name={$keyword}");
        } catch (GuzzleException $e) {
            return [];
        }
        return $this->adapter->createAdapter(
            json_decode($response->getBody()->getContents(), true)
        );
    }

    public function create(Job $job): void
    {
        return ;
    }
}
