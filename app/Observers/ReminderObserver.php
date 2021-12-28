<?php

namespace App\Observers;

use App\Mail\MailToReminderAdvisor;
use App\Mail\MailToReminderUsers;
use App\Mail\MailToUpdateReminderAdvisor;
use App\Mail\MailToUpdateReminderUsers;
use App\Models\Reminder;
use Illuminate\Support\Facades\Mail;

class ReminderObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;
    /**
     * Handle the Reminder "created" event.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return void
     */
    public function created(Reminder $reminder)
    {

        $data['title'] = $reminder->title;
        $data['description'] = $reminder->description;
        $data['location_title'] = $reminder->location_title;
        $data['location_title'] = $reminder->location_title;
        $data['lattitude'] = $reminder->lattitude;
        $data['longitude'] = $reminder->longitude;
        $data['start'] = $reminder->start;
        $data['end'] = $reminder->end;
        $data['url_student'] = config('app.url') . '/appointment/'.$reminder->slug;
        $data['url_advisor'] = config('app.url') . '/advisor/appointment/' . $reminder->slug;
        Mail::to($reminder->student)->send(new MailToReminderUsers($data));
        Mail::to($reminder->advisor)->send(new MailToReminderAdvisor($data));
    }

    /**
     * Handle the Reminder "updated" event.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return void
     */
    public function updated(Reminder $reminder)
    {
        $data['title'] = $reminder->title;
        $data['description'] = $reminder->description;
        $data['location_title'] = $reminder->location_title;
        $data['location_title'] = $reminder->location_title;
        $data['lattitude'] = $reminder->lattitude;
        $data['longitude'] = $reminder->longitude;
        $data['start'] = $reminder->start;
        $data['end'] = $reminder->end;
        $data['status'] = ($reminder->status)?'Confirmed':'Not Confirmed Yet';
        $data['url_student'] = config('app.url') . '/appointment/' . $reminder->slug;
        $data['url_advisor'] = config('app.url') . '/advisor/appointment/' . $reminder->slug;
        Mail::to($reminder->student)->send(new MailToUpdateReminderUsers($data));
        Mail::to($reminder->advisor)->send(new MailToUpdateReminderAdvisor($data));
    }

    /**
     * Handle the Reminder "deleted" event.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return void
     */
    public function deleted(Reminder $reminder)
    {
        $data['title'] = $reminder->title;
        $data['description'] = $reminder->description;
        $data['location_title'] = $reminder->location_title;
        $data['location_title'] = $reminder->location_title;
        $data['lattitude'] = $reminder->lattitude;
        $data['longitude'] = $reminder->longitude;
        $data['start'] = $reminder->start;
        $data['end'] = $reminder->end;
        $data['status'] = 'Deleted';
        $data['url_student'] = config('app.url') . '/student/reminders';
        $data['url_advisor'] = config('app.url') . '/advisor/reminder';
        Mail::to($reminder->student)->send(new MailToUpdateReminderUsers($data));
        Mail::to($reminder->advisor)->send(new MailToUpdateReminderAdvisor($data));
    }

    /**
     * Handle the Reminder "restored" event.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return void
     */
    public function restored(Reminder $reminder)
    {
        //
    }

    /**
     * Handle the Reminder "force deleted" event.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return void
     */
    public function forceDeleted(Reminder $reminder)
    {
        //
    }
}
