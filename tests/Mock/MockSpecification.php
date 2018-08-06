<?php
declare(strict_types=1);

namespace Glomex\Common\Specification\Test\Mock;

use Glomex\Common\Specification\CompositeSpecification;

/**
 * MockSpecification for test CompositeSpecification
 */
class MockSpecification extends CompositeSpecification
{
    /**
     * @inheritdoc
     */
    public function isSatisfiedBy($candidate): bool
    {
        return true;
    }
}
