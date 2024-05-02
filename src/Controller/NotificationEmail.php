<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;


class NotificationEmail extends Email
{
    public function __construct(string $recipientEmail, string $subject)
    {
        parent::__construct();

        $this->to($recipientEmail);
        $this->subject($subject);
        $this->html('<p>This is a test email sent from Symfony Mailer.</p>');
    }
}
