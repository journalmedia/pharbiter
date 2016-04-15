<?php
declare(strict_types=1);

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_saves_an_entity()
    {
        // Explicit collaborators
        $porter = $this->prophesize("Fake/Porter");

        $entity = ["Some Entity"];

        $repository = $this->createRepository($porter->reveal());

        $repository->save($entity);

        $porter->export($entity)
            ->shouldHaveBeenCalled();
    }

    private function createRepository($porter)
    {
        return new stdClass($porter);
    }
}
