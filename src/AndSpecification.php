<?php
declare(strict_types=1);

namespace Glomex\Common\Specification;

/**
 * AND Composite Specification
 * @package Glomex\Common\Specification
 */
class AndSpecification extends CompositeSpecification
{
    /** @var SpecificationInterface[] */
    private $specifications;

    /**
     * AndSpecification constructor.
     * @param SpecificationInterface[] ...$specifications
     */
    public function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @inheritdoc
     */
    public function isSatisfiedBy($candidate): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
