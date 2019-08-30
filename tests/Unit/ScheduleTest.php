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
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();

        $data = [
            'title' => $this->faker->name,
            'description' => $this->faker->cpf,
        ];

        $this->put(route('schedules.update', $schedule->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testCanShowSchedule()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();

        $this->get(route('schedules.show', $schedule->id))
            ->assertStatus(200);
    }

    public function testCanDeleteSchedule()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();

        $this->delete(route('schedules.destroy', $schedule->id))
            ->assertStatus(204);
    }

    public function testCanListSchedules()
    {
        /** @var Collection $schedules */
        $schedules = factory(Schedule::class, 2)->create()->map(function (Schedule $schedule) {
            return $schedule->only([ 'id', 'title', 'description' ]);
        });

        $this->get(route('schedules.index'))
            ->assertStatus(200)
            ->assertJson($schedules->toArray())
            ->assertJsonStructure([
                '*' =>[ 'id', 'title', 'description' ]
            ]);
    }

    public function testCanOpenScheduleSession()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();

        $this->put(route('schedules.openSession', [
            'schedule' => $schedule->id
        ]), [])
            ->assertStatus(200)
            ->assertJson($schedule->toArray());
    }
}
