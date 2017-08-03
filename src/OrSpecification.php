<?php
declare(strict_types=1);

namespace Glomex\Common\Specification;

/**
 * Or Composite Specification
 * @package Glomex\Common\Specification
 */
class OrSpecification
{
    /** @var SpecificationInterface[] */
    private $specifications;

    /**
     * OrSpecification constructor.
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
            if ($specification->isSatisfiedBy($candidate)) {
                return true;
            }
        }

        return false;
    }
}
