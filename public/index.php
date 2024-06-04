<?php

declare(strict_types=1);

use Jobberwocky\Jobs\Infrastructure\JobRepositorySQLite;
use Jobberwocky\Jobs\Application\CreateJobService;
use Jobberwocky\Jobs\Application\FindJobByKeywordService;
use Jobberwocky\Jobs\Interfaces\Http\Controller\JobController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$repository = new JobRepositorySQLite();
$createJobService = new CreateJobService($repository);
$findJobService = new FindJobByKeywordService($repository);
$jobController = new JobController($createJobService, $findJobService);

$app->post('/job', [$jobController, 'createJob']);
$app->get('/jobs', [$jobController, 'findJob']);

$app->run();
