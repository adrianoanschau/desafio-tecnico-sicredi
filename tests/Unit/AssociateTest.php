<?php

namespace Tests\Unit;

use App\Models\Associate;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AssociateTest extends TestCase
{
    public function testCanCreateAssociate()
    {
        $data = [
            'name' => $this->faker->name,
            'document' => $this->faker->cpf,
        ];

        $this->post(route('associates.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function testCanUpdateAssociate()
    {
        /** @var Associate $schedule */
        $associate = factory(Associate::class)->create();

        $data = [
            'name' => $this->faker->name,
            'document' => $this->faker->cpf,
        ];

        $this->put(route('associates.update', $associate->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testCanShowAssociate()
    {
        /** @var Associate $schedule */
        $associate = factory(Associate::class)->create();

        $this->get(route('associates.show', $associate->id))
            ->assertStatus(200);
    }

    public function testCanDeleteAssociate()
    {
        /** @var Associate $schedule */
        $associate = factory(Associate::class)->create();

        $this->delete(route('associates.destroy', $associate->id))
            ->assertStatus(204);
    }

    public function testCanListAssociates()
    {
        /** @var Collection $associates */
        $associates = factory(Associate::class, 2)->create()->map(function (Associate $associate) {
            return $associate->only([ 'id', 'name', 'document' ]);
        });

        $this->get(route('associates.index'))
            ->assertStatus(200)
            ->assertJson($associates->toArray())
            ->assertJsonStructure([
                '*' =>[ 'id', 'name', 'document' ]
            ]);
    }
}
