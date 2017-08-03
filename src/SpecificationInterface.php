<?php
declare(strict_types=1);

namespace Glomex\Common\Specification;

/**
 * Interface SpecificationInterface
 * @package Glomex\Common\Specification
 */
interface SpecificationInterface
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool;
}
