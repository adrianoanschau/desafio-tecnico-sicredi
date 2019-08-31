<?php

namespace App\Repositories;

use App\Enums\HttpStatusCodeEnum;
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
        $schedule = $this->newQuery()->find($id);

        if (!is_null($schedule->currentSession)) {
            throw new Exception('Esta pauta já possui uma sessão aberta.', HttpStatusCodeEnum::CONFLICT);
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
        $schedule = $this->newQuery()->find($id);

        if (is_null($schedule->currentSession)) {
            throw new Exception('Esta pauta não possui uma sessão aberta.', HttpStatusCodeEnum::NOT_FOUND);
        }
        $schedule->currentSession()->update([
            'closed_at' => Carbon::now(),
        ]);
        $schedule->refresh();

        return $schedule;
    }
}
