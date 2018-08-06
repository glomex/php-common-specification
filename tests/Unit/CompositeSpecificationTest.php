<?php
declare(strict_types=1);

namespace Glomex\Common\Specification\Test\Unit;

use Glomex\Common\Specification\AndSpecification;
use Glomex\Common\Specification\NotSpecification;
use Glomex\Common\Specification\OrSpecification;
use Glomex\Common\Specification\SpecificationInterface;
use Glomex\Common\Specification\Test\Mock\MockSpecification;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for CompositeSpecification
 */
class CompositeSpecificationTest extends TestCase
{
    /** @var SpecificationInterface|MockObject */
    private $specificationMock;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->specificationMock = $this->createMock(SpecificationInterface::class);
        $this->specificationMock
            ->expects(static::never())
            ->method(static::anything());
    }

    public function testAnd(): void
    {
        $baseSpecification = $this->getCut();

        $result = $baseSpecification->and($this->specificationMock);

        static::assertInstanceOf(AndSpecification::class, $result);
        static::assertAttributeSame(
            [
                $baseSpecification,
                $this->specificationMock
            ],
            'specifications',
            $result
        );
    }

    public function testOr()
    {
        $baseSpecification = $this->getCut();

        $result = $baseSpecification->or($this->specificationMock);

        static::assertInstanceOf(OrSpecification::class, $result);
        static::assertAttributeSame(
            [
                $baseSpecification,
                $this->specificationMock
            ],
            'specifications',
            $result
        );
    }

    public function testNot()
    {
        $baseSpecification = $this->getCut();

        $result = $baseSpecification->not();

        static::assertInstanceOf(NotSpecification::class, $result);
        static::assertAttributeSame(
            $baseSpecification,
            'specification',
            $result
        );
    }

    /**
     * @return MockSpecification
     */
    private function getCut(): MockSpecification
    {
        return new MockSpecification();
    }
}
