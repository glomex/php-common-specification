<?php
declare(strict_types=1);

namespace Glomex\Common\Specification\Test\Unit;

use Glomex\Common\Specification\OrSpecification;
use Glomex\Common\Specification\SpecificationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for OrSpecificationTest
 */
class OrSpecificationTest extends TestCase
{
    public function testConstruct(): void
    {
        $specificationsMocks = [];
        for ($i = 0; $i <= 3; $i++) {
            $specificationMock = $this->createMock(SpecificationInterface::class);
            $specificationMock
                ->expects(static::never())
                ->method(static::anything());

            $specificationsMocks[] = $specificationMock;
        }

        $specification = new OrSpecification(...$specificationsMocks);

        static::assertAttributeSame(
            $specificationsMocks,
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
            'firstPositive' => [[true, null, null], true],
            'lastPositive' => [[false, false, true], true],
            'middlePositive' => [[false, true, null], true],
            'allNegative' => [[false, false, false], false],
            'empty' => [[], false],
        ];
    }

    /**
     * @param array $specifications
     * @return OrSpecification
     */
    private function getCut(array $specifications): OrSpecification
    {
        return new OrSpecification(...$specifications);
    }
}
