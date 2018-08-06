<?php
declare(strict_types=1);

namespace Glomex\Common\Specification\Test\Unit;

use Glomex\Common\Specification\AndSpecification;
use Glomex\Common\Specification\SpecificationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for AndSpecificationTest
 */
class AndSpecificationTest extends TestCase
{
    public function testConstruct(): void
    {
        $specificationsMock = [];
        for ($i = 0; $i <= 3; $i++) {
            $specification = $this->createMock(SpecificationInterface::class);
            $specification
                ->expects(static::never())
                ->method(static::anything());

            $specificationsMock[] = $specification;
        }

        $specification = new AndSpecification(...$specificationsMock);

        static::assertAttributeSame(
            $specificationsMock,
            'specifications',
            $specification
        );
    }

    /**
     * @param array $specificationsResult
     * @param bool $targetResult
     *
     * @dataProvider specificationsDataProvider
     */
    public function testIsSatisfiedBy(array $specificationsResults, bool $targetResult): void
    {
        $targetCandidate = 'candidate';

        $specificationsMocks = [];
        foreach ($specificationsResults as $specificationResult) {
            $specificationMock = $this->createMock(SpecificationInterface::class);
            if (null === $specificationResult) {
                $specificationMock
                    ->expects(static::never())
                    ->method(static::anything());
            } else {
                $specificationMock
                    ->expects(static::once())
                    ->method('isSatisfiedBy')
                    ->with($targetCandidate)
                    ->willReturn((bool) $specificationResult);
            }

            $specificationsMocks[] = $specificationMock;
        }

        $specification = $this->getCut($specificationsMocks);
        $result = $specification->isSatisfiedBy($targetCandidate);

        static::assertSame($targetResult, $result);
    }

    /**
     * @return array
     */
    public function specificationsDataProvider(): array
    {
        return [
            'allPositive' => [[true, true, true], true],
            'firstNegative' => [[false, null, null], false],
            'middleNegative' => [[true, false, null], false],
            'lastNegative' => [[true, true, false], false],
            'empty' => [[], true],
        ];
    }

    /**
     * @param array $specifications
     * @return AndSpecification
     */
    private function getCut(array $specifiactions): AndSpecification
    {
        return new AndSpecification(...$specifiactions);
    }
}
