<?php

namespace Valitron\Test\Unit\Data\Rule;

use PHPUnit\Framework\TestCase;
use Valitron\Data\Fields;
use Valitron\Rule\Optional;

class OptionalTest extends TestCase
{
    public function testOptionalValidatorAlwaysReturnsTrue()
    {
        $validator = new Optional();

        $this->assertTrue($validator->validate('any-value', new Fields()));
    }
}
