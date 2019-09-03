<?php

namespace App\Observers;

use App\Models\ScheduleSession;
use Carbon\Carbon;

class ScheduleSessionObserver
{
    /**
     * Handle the schedule session "creating" event.
     *
     * @param  ScheduleSession  $scheduleSession
     * @return void
     */
    public function creating(ScheduleSession $scheduleSession)
    {
        $scheduleSession->opened_at = Carbon::now();
    }

    /**
     * Handle the schedule session "created" event.
     *
     * @param  ScheduleSession  $scheduleSession
     * @return void
     */
    public function created(ScheduleSession $scheduleSession)
    {
        $scheduleSession->schedule->currentSession()
            ->associate($scheduleSession)->save();
    }

    /**
     * Handle the schedule session "updated" event.
     *
     * @param  ScheduleSession  $scheduleSession
     * @return void
     */
    public function updating(ScheduleSession $scheduleSession)
    {
        $dirty = $scheduleSession->getDirty();
        if (isset($dirty['closed_at'])) {
            $scheduleSession->schedule->currentSession()->dissociate()->save();
        }
    }
}
