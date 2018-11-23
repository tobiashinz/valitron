<?php
use Valitron\Validator;
class MapRulesTest extends BaseTestCase
{
    public function testMapSingleFieldRules()
    {
        $rules = [
            'required',
            ['lengthMin', 4],
        ];

        $v = new Validator([]);
        $v->mapFieldRules('myField', $rules);
        $this->assertFalse($v->validate());
        $this->assertEquals(2, sizeof($v->errors('myField')));

        $v2 = new Validator(['myField' => 'myVal']);
        $v2->mapFieldRules('myField', $rules);
        $this->assertTrue($v2->validate());
    }

    public function testSingleFieldDot()
    {
        $v = new Valitron\Validator([
            'settings' => [
                ['threshold' => 50],
                ['threshold' => 90],
            ],
        ]);
        $v->mapFieldRules('settings.*.threshold', [
            ['max', 50],
        ]);

        $this->assertFalse($v->validate());
    }

    public function testMapMultipleFieldsRules()
    {
        $rules = [
            'myField1' => [
                'required',
                ['lengthMin', 4],
            ],
            'myField2' => [
                'required',
                ['lengthMin', 5],
            ],
        ];

        $v = new Validator([
            'myField1' => 'myVal',
        ]);
        $v->mapFieldsRules($rules);

        $this->assertFalse($v->validate());
        $this->assertFalse($v->errors('myField1'));
        $this->assertEquals(2, sizeof($v->errors('myField2')));
    }

    public function testCustomMessageSingleField()
    {
        $rules = [
            ['lengthMin', 14, 'message' => 'My Custom Error'],
        ];

        $v = new Validator([
            'myField' => 'myVal',
        ]);
        $v->mapFieldRules('myField', $rules);
        $this->assertFalse($v->validate());
        $errors = $v->errors('myField');
        $this->assertEquals('My Custom Error', $errors[0]);
    }

    public function testCustomMessageMultipleFields()
    {
        $rules = [
            'myField1' => [
                ['lengthMin', 14, 'message' => 'My Custom Error 1'],
            ],
            'myField2' => [
                ['lengthMin', 14, 'message' => 'My Custom Error 2'],
            ],
        ];

        $v = new Validator([
            'myField1' => 'myVal',
            'myField2' => 'myVal',
        ]);

        $v->mapFieldsRules($rules);
        $this->assertFalse($v->validate());

        $errors1 = $v->errors('myField1');
        $this->assertEquals('My Custom Error 1', $errors1[0]);

        $errors2 = $v->errors('myField2');
        $this->assertEquals('My Custom Error 2', $errors2[0]);
    }
}
