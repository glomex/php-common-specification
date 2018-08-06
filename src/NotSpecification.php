<?php
declare(strict_types=1);

namespace Glomex\Common\Specification;

/**
 * Not Composite Specification
 */
class NotSpecification extends CompositeSpecification
{
    /** @var SpecificationInterface */
    private $specification;

    /**
     * NotSpecification constructor.
     * @param SpecificationInterface $specification
     */
    public function __construct(
        SpecificationInterface $specification
    ) {
        $this->specification = $specification;
    }

    /**
     * @inheritdoc
     */
    public function isSatisfiedBy($candidate): bool
    {
        return !$this->specification->isSatisfiedBy($candidate);
    }
}
