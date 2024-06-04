<?

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
    ) {
    }

    public function createJob(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $job = $this->createJobService->execute(
            $data['title'],
            $data['company'],
            $data['description'],
            $data['keywords']
        );

        $response->getBody()->write(json_encode([
            'id' => $job->id()->value(),
            'title' => $job->title()->value(),
            'description' => $job->description()->value(),
            'company' => $job->company()->value(),
            'keywords' => $job->keywords()->list()
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function findJob(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $jobs = $this->findJobByKeywordService->execute($data['keyword']);
        $response->getBody()->write(json_encode($jobs));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
