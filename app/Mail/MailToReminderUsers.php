<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailToReminderUsers extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reminder.create')->subject('New Appointment Placed')->with([
            'title' => $this->data['title'],
            'description' => $this->data['description'],
            'location_title' => $this->data['location_title'],
            'lattitude' => $this->data['lattitude'],
            'longitude' => $this->data['longitude'],
            'start' => $this->data['start'],
            'end' => $this->data['end'],
            'url' => $this->data['url_student'],
        ]);
    }
}
