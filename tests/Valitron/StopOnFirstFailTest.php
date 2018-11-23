<?php
use Valitron\Validator;
class StopOnFirstFail extends BaseTestCase
{
    public function testStopOnFirstFail()
    {
        $rules = [
            'myField1' => [
                ['lengthMin', 5, 'message' => 'myField1 must be 5 characters minimum'],
                ['url', 'message' => 'myField1 is not a valid url'],
                ['urlActive', 'message' => 'myField1 is not an active url'],
            ],
        ];

        $v = new Validator([
            'myField1' => 'myVal',
        ]);

        $v->mapFieldsRules($rules);
        $v->stopOnFirstFail(true);
        $this->assertFalse($v->validate());

        $errors = $v->errors();
        $this->assertCount(1, $errors['myField1']);
    }
}
