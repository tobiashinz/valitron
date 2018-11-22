<?php

namespace Valitron\Validator;

use Valitron\Data\Fields;

class CallableWrapper implements Validator
{
    private $name;
    private $handler;

    public function __construct(string $name, callable $handler)
    {
        $this->name = $name;
        $this->handler = $handler;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function validate($value, Fields $fields, array $params = []): bool
    {
        return (bool) call_user_func_array($this->handler, [$value, $fields, $params]);
    }
}
