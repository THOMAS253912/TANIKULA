<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contacts;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->contacts['email'])
                ->markdown('pages.contact.contactUsEmail')
                ->attachFromStorage($this->contacts['screenshot'])
                ->with([
                        'subject' => $this->contacts['subject'],
                        'message' => $this->contacts['message'],
                        'email' => $this->contacts['email'],
                        'phone_number' => $this->contacts['phone_number'],
                        'fullname' => $this->contacts['fullname']
                    ]);
    }
}
