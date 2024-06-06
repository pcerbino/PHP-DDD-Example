<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Jobberwocky\Jobs\Domain\Job;
use Jobberwocky\Jobs\Domain\JobTitle;
use Jobberwocky\Jobs\Domain\JobCountry;
use Jobberwocky\Jobs\Domain\JobSalary;
use Jobberwocky\Jobs\Domain\JobKeywords;

class JobTest extends TestCase
{
    public $jobTitle;
    public $jobCountry;
    public $jobSalary;
    public $jobKeywords;

    public function setUp(): void
    {
        $this->jobTitle = new JobTitle('Software Engineer');
        $this->jobCountry = new JobCountry('USA');
        $this->jobSalary = new JobSalary(100000);
        $this->jobKeywords = new JobKeywords(['PHP', 'Laravel', 'MySQL']);
    }

    public function testJob(): void
    {
        $job = new Job($this->jobTitle, $this->jobCountry, $this->jobSalary, $this->jobKeywords);

        $this->assertEquals('Software Engineer', $job->title()->value());
        $this->assertEquals('USA', $job->country()->value());
        $this->assertEquals(100000, $job->salary()->value());
        $this->assertEquals(['PHP', 'Laravel', 'MySQL'], $job->keywords()->list());
    }
}
