<?php

namespace Valitron\Test\Unit\Data\Validator;

use PHPUnit\Framework\TestCase;
use Valitron\Data\Fields;
use Valitron\Validator\Optional;

class OptionalValidatorTest extends TestCase
{
    public function testOptionalValidatorAlwaysReturnsTrue()
    {
        $validator = new Optional();

        $this->assertTrue($validator->validate('any-value', new Fields()));
    }
}
