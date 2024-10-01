<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VolunteerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $title, $description)
    {
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->subject($this->title)
            ->view('emails.volunteer_notification')
            ->with([
                'type' => $this->type,
                'title' => $this->title,
                'description' => $this->description,
            ]);


    }
}
