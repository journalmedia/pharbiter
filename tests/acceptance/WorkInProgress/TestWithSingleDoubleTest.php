<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Acceptance\WorkInProgress;

use JournalMedia\PharbiterTest\Acceptance\TestCase;

class TestWithSingleDoubleTest extends TestCase
{
    /**
     * @test
     */
    public function without_an_annotation()
    {
        $output = shell_exec(
            sprintf(
                "./pharb check %s/fixtures/RepositoryTestToBeInspected.php it_saves_an_entity",
                __DIR__
            )
        );

        $this->assertSame(
            "No contract marked for Fake\\Porter::export()\n",
            $output
        );
    }
}
