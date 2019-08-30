<?php

namespace Tests\Unit;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    public function testCanCreateSchedule()
    {
        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->post(route('schedules.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function testCanUpdateSchedule()
    {
        $associate = factory(Schedule::class)->create();

        $data = [
            'title' => $this->faker->name,
            'description' => $this->faker->cpf,
        ];

        $this->put(route('schedules.update', $associate->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testCanShowSchedule()
    {
        $associate = factory(Schedule::class)->create();

        $this->get(route('schedules.show', $associate->id))
            ->assertStatus(200);
    }

    public function testCanDeleteSchedule()
    {
        $associate = factory(Schedule::class)->create();

        $this->delete(route('schedules.destroy', $associate->id))
            ->assertStatus(204);
    }

    public function testCanListSchedules()
    {
        /** @var Collection $schedules */
        $schedules = factory(Schedule::class, 2)->create()->map(function (Schedule $associate) {
            return $associate->only([ 'id', 'title', 'description' ]);
        });

        $this->get(route('schedules.index'))
            ->assertStatus(200)
            ->assertJson($schedules->toArray())
            ->assertJsonStructure([
                '*' =>[ 'id', 'title', 'description' ]
            ]);
    }
}
