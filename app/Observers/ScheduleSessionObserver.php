<?php

namespace App\Observers;

use App\Models\ScheduleSession;

class ScheduleSessionObserver
{
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
