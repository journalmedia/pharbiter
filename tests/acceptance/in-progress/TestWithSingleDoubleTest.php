<?php
declare(strict_types=1);

class TestWithSingleDoubleTest extends AcceptanceTestCase
{
    /**
     * @test
     */
    public function without_an_annotation()
    {
        $output = shell_exec("./pharb fixtures/tests/RepositoryTest.php it_saves_an_entity");

        $this->assertSame(
            "No contract marked for Fake/Porter::export()",
            $output
        );
    }
}
