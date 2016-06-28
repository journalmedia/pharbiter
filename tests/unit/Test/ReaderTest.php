<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Unit\Test;

use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\ClassLoader;
use JournalMedia\Pharbiter\Filesystem;
use JournalMedia\Pharbiter\Test\DoubleMethodConfiguration;
use JournalMedia\Pharbiter\Test\Reader;
use JournalMedia\Pharbiter\Test\Test;
use JournalMedia\PharbiterTest\Unit\UnitTestCase;

class ReaderTest extends UnitTestCase
{
    /**
     * @test
     */
    public function it_reads_a_test()
    {
        // Explicit collaborators
        $classLoader = $this->prophesize(ClassLoader::class);
        $filesystem = $this->prophesize(Filesystem::class);

        $testCaseLocation = TestCaseLocation::fromString("tests/fixtures/tests/RepositoryTest.php");
        $testName = TestName::fromString("it_saves_an_entity");

        $reader = new Reader($classLoader->reveal(), $filesystem->reveal());

        /** @contract ? */
        $classLoader->getClassName("tests/fixtures/tests/RepositoryTest.php")
            ->willReturn("JournalMedia\\PharbiterTest\\FixtureTests\\RepositoryTest");

        /** @contract ? */
        $filesystem->readBetween("tests/fixtures/tests/RepositoryTest.php", 11, 24)
            ->willReturn($this->createTestCode());

        $test = $reader->readTest($testCaseLocation, $testName);

        $this->assertEquals(
            Test::fromDoubleMethodConfigurations(collect([
                DoubleMethodConfiguration::fromClassAndMethod('Fake\Porter', "export")
            ])),
            $test
        );
    }

    private function createTestCode()
    {
        return <<<'EOT'
            public function it_saves_an_entity()
            {
                // Explicit collaborators
                $porter = $this->prophesize('Fake\Porter');

                $entity = ["Some Entity"];

                $repository = $this->createRepository($porter->reveal());

                $repository->save($entity);

                $porter->export($entity)
                    ->shouldHaveBeenCalled();
            }
EOT;
    }
}
