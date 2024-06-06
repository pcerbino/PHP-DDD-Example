<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jobberwocky\Jobs\Domain\JobKeywords;

class JobKeywordsTest extends TestCase
{
    public function testJobKeywords(): void
    {
        $keywords = new JobKeywords(['PHP', 'Laravel', 'MySQL']);

        $this->assertEquals(['PHP', 'Laravel', 'MySQL'], $keywords->list());
    }
}
