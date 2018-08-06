<?php
declare(strict_types=1);

namespace Glomex\Common\Specification\Test\Unit;

use Glomex\Common\Specification\NotSpecification;
use Glomex\Common\Specification\SpecificationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for NotSpecification
 */
class NotSpecificationTest extends TestCase
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
    }

    public function testConstruct(): void
    {
        $this->specificationMock
            ->expects(static::never())
            ->method(static::anything());

        $specification = new NotSpecification($this->specificationMock);

        static::assertAttributeSame(
            $this->specificationMock,
            'specification',
            $specification
        );
    }

    /**
     * @param bool $parentSpecificationResult
     * @param bool $targetResult
     *
     * @dataProvider parentSpecificationResultDataProvider
     */
    public function testIsSatisfiedBy(bool $parentSpecificationResult, bool $targetResult): void
    {
        $targetCandidate = 'target-candidate';

        $this->specificationMock
            ->expects(static::once())
            ->method('isSatisfiedBy')
            ->with($targetCandidate)
            ->willReturn($parentSpecificationResult);

        $specification = $this->getCut();
        $result = $specification->isSatisfiedBy($targetCandidate);

        static::assertSame($targetResult, $result);
    }

    /**
     * @return array
     */
    public function parentSpecificationResultDataProvider(): array
    {
        return [
            'positive' => [true, false],
            'negative' => [false, true],
        ];
    }

    /**
     * @return NotSpecification
     */
    private function getCut(): NotSpecification
    {
        return new NotSpecification($this->specificationMock);
    }
}
