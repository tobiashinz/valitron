<?php

namespace Valitron\Test\Unit\Data\Rule;

use PHPUnit\Framework\TestCase;
use Valitron\Data\Fields;
use Valitron\Rule\CallableWrapper;

class CallableWrapperTest extends TestCase
{
    public function testCreatingWrapper()
    {
        $testValue = 'my-value';
        $testFields = new Fields();
        $testParams = [];

        $rule = new CallableWrapper('my-rule', function ($value, Fields $fields, array $params = []) use ($testValue, $testFields, $testParams) {
            $this->assertSame($testValue, $value);
            $this->assertSame($testFields, $fields);
            $this->assertSame($params, $params);

            return true;
        });

        $this->assertEquals('my-rule', $rule->getName());
        $this->assertTrue($rule->validate($testValue, $testFields, $testParams));
    }

    public function testWrapperMustAlwaysReturnBool()
    {
        $passingRule = new CallableWrapper('my-rule', function ($value, Fields $fields, array $params = []) {
            return 1;
        });
        $this->assertTrue($passingRule->validate('value', new Fields()));

        $failingRule = new CallableWrapper('my-rule', function ($value, Fields $fields, array $params = []) {
            return 0;
        });
        $this->assertFalse($failingRule->validate('value', new Fields()));

        $voidRule = new CallableWrapper('my-rule', function ($value, Fields $fields, array $params = []) {
            //do nothing
        });
        $this->assertFalse($voidRule->validate('value', new Fields()));
    }
}
