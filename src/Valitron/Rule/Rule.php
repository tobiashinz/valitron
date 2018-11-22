<?php

namespace Valitron\Rule;

use Valitron\Data\Fields;

interface Rule
{
    /**
     * Get the (human readable) name for this validator.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Check if the provided value is valid for this validator.
     *
     * @param $value
     * @param Fields $fields
     * @param array  $params
     *
     * @return bool
     */
    public function validate($value, Fields $fields, array $params = []): bool;
}
