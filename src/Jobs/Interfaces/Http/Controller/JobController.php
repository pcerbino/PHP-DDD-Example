<?php

namespace Jobberwocky\Jobs\Interfaces\Http\Controller;

use Jobberwocky\Jobs\Application\CreateJobService;
use Jobberwocky\Jobs\Application\FindJobByKeywordService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class JobController
{
    public function __construct(
        private readonly CreateJobService $createJobService,
        private FindJobByKeywordService $findJobByKeywordService
    ) { }

    public function createJob(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (
            !isset($data['title']) 
            || !isset($data['country']) 
            || !isset($data['salary']) 
            || !isset($data['keywords'])
        ) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Missing required fields']));
        }

        try {
            $job = $this->createJobService->execute(
                $data['title'],
                $data['country'],
                $data['salary'],
                $data['keywords']
            );
        } catch (\Exception $e) { // Implement better exception handling
            return  $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'An error occurred']));
        }

        $response->getBody()->write(json_encode([
            'id' => $job->id()->value(),
            'title' => $job->title()->value(),
            'salary' => $job->salary()->value(),
            'country' => $job->country()->value(),
            'keywords' => $job->keywords()->list()
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function findJob(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['keyword'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Missing required field keyword']));
        }

        $jobs = $this->findJobByKeywordService->execute($data['keyword']);
        $response->getBody()->write(json_encode($jobs));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
