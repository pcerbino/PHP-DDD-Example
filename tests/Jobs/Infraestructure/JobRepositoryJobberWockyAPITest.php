<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jobberwocky\Jobs\Infrastructure\JobRepositoryJobberWockyAPI;
use Jobberwocky\Jobs\Domain\JobRepositoryAdapterResponse;
use GuzzleHttp\Client;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\StreamInterface;

class JobRepositoryJobberWockyAPITest extends TestCase
{
    private $streamInterface;
    private $responseInterface;
    private $httpClient;
    private $jobRepositoryAdapter;

    protected function setUp(): void
    {
        $this->streamInterface = $this->createMock(StreamInterface::class);
        $this->responseInterface = $this->createMock(ResponseInterface::class);
        $this->httpClient = $this->createMock(Client::class);
        $this->jobRepositoryAdapter = $this->createMock(JobRepositoryAdapterResponse::class);
    }

    public function testFindByKeyword(): void
    {
        $remoteJobs = '[["Job 3¿", 3000, "Argentina"],["Job 4", 4000, "Uruguay"]]';

        $this->streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn($remoteJobs);

        $this->responseInterface->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/jobs?name=PHP')
            ->willReturn($this->responseInterface);

        $this->jobRepositoryAdapter->expects($this->once())
            ->method('createAdapter')
            ->willReturn($this->jobRepositoryAdapter);

        $jobRepository = new JobRepositoryJobberWockyAPI($this->httpClient, $this->jobRepositoryAdapter);
        $result = $jobRepository->findByKeyword('PHP');

        $this->assertInstanceOf(JobRepositoryAdapterResponse::class, $result);
    }  
}
