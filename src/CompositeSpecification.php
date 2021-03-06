<?php
declare(strict_types=1);

namespace Glomex\Common\Specification;

/**
 * Abstract Composite Specification
 */
abstract class CompositeSpecification implements SpecificationInterface
{
    /**
     * @inheritdoc
     */
    abstract public function isSatisfiedBy($candidate): bool;

    /**
     * @param SpecificationInterface $specification
     * @return AndSpecification
     */
    public function and(SpecificationInterface $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @param SpecificationInterface $specification
     * @return OrSpecification
     */
    public function or(SpecificationInterface $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @return NotSpecification
     */
    public function not(): NotSpecification
    {
        return new NotSpecification($this);
    }
}
