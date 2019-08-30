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
}
