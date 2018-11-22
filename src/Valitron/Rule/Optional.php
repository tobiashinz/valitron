<?php

namespace Valitron\Rule;

use Valitron\Data\Fields;

class Optional implements Rule
{
    public function getName(): string
    {
        return 'optional';
    }

    public function validate($value, Fields $fields, array $params = []): bool
    {
        //always return true
        return true;
    }
}
