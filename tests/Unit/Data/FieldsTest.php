<?php

namespace Valitron\Test\Unit\Data;

use PhpCsFixer\Tests\TestCase;
use Valitron\Data\Fields;

class FieldsTest extends TestCase
{
    public function testRetrievingData()
    {
        $data = new Fields([
            'id' => 'user-1',
            'person' => [
                'firstname' => 'Willem',
                'lastname' => 'Wollebrants',
            ],
            'cars' => [
                'nissan' => [
                    'color' => 'red',
                    'plate' => [
                        'number' => 'abc-123',
                        'country' => 'BE',
                    ],
                ],
                'peugeot' => [
                    'color' => 'blue',
                    'plate' => [
                        'number' => 'xyz-987',
                        'country' => 'NL',
                    ],
                ],
            ],
            'meta' => [
                'tags' => [
                    ['type' => 'profession', 'value' => 'developer'],
                    ['type' => 'hobby', 'value' => 'guitar'],
                ],
            ],
        ]);

        $this->assertEquals('user-1', $data->get('id'));
        $this->assertEquals('Willem', $data->get('person.firstname'));

        $this->assertEquals([
            'firstname' => 'Willem',
            'lastname' => 'Wollebrants',
        ], $data->get('person'));

        $this->assertEquals([
            'firstname' => 'Willem',
            'lastname' => 'Wollebrants',
        ], $data->get('person.*'));

        $this->assertEquals(['red', 'blue'], $data->get('cars.*.color'));
        $this->assertEquals(['BE', 'NL'], $data->get('cars.*.plate.country'));

        $this->assertEquals(['profession', 'hobby'], $data->get('meta.tags.*.type'));

        $this->assertNull($data->get('meta.tags.*.updated'));
    }
}
