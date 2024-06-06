<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Jobberwocky\Jobs\Infrastructure\JobRepositoryJobberWockyAPI;
use Jobberwocky\Jobs\Infrastructure\JobRepositoryJobberWockyAPIAdapter;
use Jobberwocky\Jobs\Infrastructure\JobRepositorySQLite;
use Jobberwocky\Jobs\Application\CreateJobService;
use Jobberwocky\Jobs\Application\FindJobByKeywordService;
use Jobberwocky\Jobs\Infrastructure\JobRepositorySQLiteAdapter;
use Jobberwocky\Jobs\Interfaces\Http\Controller\JobController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();
$client = new GuzzleHttp\Client(['base_uri' => $_ENV['JobberwockyExteneralJobsAPI']]);

$localAdapter = new JobRepositorySQLiteAdapter();
$localRepository = new JobRepositorySQLite($localAdapter);
$createJobService = new CreateJobService($localRepository);

$remoteAdapter = new JobRepositoryJobberWockyAPIAdapter();
$remoteRepository = new JobRepositoryJobberWockyAPI($client, $remoteAdapter);

$findJobService = new FindJobByKeywordService($localRepository, $remoteRepository);

$jobController = new JobController($createJobService, $findJobService);

$app->post('/job', [$jobController, 'createJob']);
$app->get('/jobs', [$jobController, 'findJob']);

$app->run();
