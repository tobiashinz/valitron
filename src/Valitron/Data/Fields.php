<?php

namespace Valitron\Data;

use Exception;

/**
 * Data container.
 */
class Fields
{
    private $data;

    public function __construct(array $input)
    {
        $this->data = $input;
    }

    public function get(string $key, $defaultValue = null)
    {
        $keys = explode('.', $key);
        $source = $this->data;

        try {
            return $this->fetchValue($keys, $source);
        } catch (Exception $e) {
            return $defaultValue;
        }
    }

    /**
     * Fetch a value from a data set
     * Supports dot and * syntax.
     *
     * @param array $keys
     * @param $source
     *
     * @throws Exception
     *
     * @return mixed
     */
    private function fetchValue(array $keys, $source)
    {
        if (sizeof($keys) === 0) {
            return $source;
        }

        $key = array_shift($keys);

        if ($key === '*') {
            if (count($keys) === 0) {
                if (! is_array($source)) {
                    throw new Exception();
                }

                return $source;
            }
            $nextKey = array_shift($keys);
            $next = [];

            array_map(function ($item) use ($keys, $nextKey, &$next) {
                $next = array_merge($next, (array) $this->fetchValue($keys, $item[$nextKey]));
            }, $source);

            return $next;
        }
        if (! is_array($source) || ! array_key_exists($key, $source)) {
            throw new Exception();
        }

        return $this->fetchValue($keys, $source[$key]);
    }
}
