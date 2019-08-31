<?php

namespace App\Repositories;

use App\Exceptions\ScheduleHasSessionException;
use App\Exceptions\ScheduleNotHasSessionException;
use App\Models\Schedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ScheduleRepository extends BaseRepository
{
    /** @var string */
    protected $modelClass = Schedule::class;

    /**
     * @param int $id
     *
     * @return Model
     * @throws Exception
     */
    public function openSession(int $id)
    {
        /** @var Schedule $schedule */
        $schedule = $this->findByID($id);

        if (!is_null($schedule->currentSession)) {
            throw new ScheduleHasSessionException();
        }

        $schedule->sessions()->create();
        $schedule->refresh();

        return $schedule;
    }

    /**
     * @param int $id
     *
     * @return Model
     * @throws Exception
     */
    public function closeSession(int $id)
    {
        /** @var Schedule $schedule */
        $schedule = $this->findByID($id);

        if (is_null($schedule->currentSession)) {
            throw new ScheduleNotHasSessionException();
        }
        $schedule->currentSession()->update([
            'closed_at' => Carbon::now(),
        ]);
        $schedule->refresh();

        return $schedule;
    }
}
