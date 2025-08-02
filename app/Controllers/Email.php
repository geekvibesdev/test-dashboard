<?php

namespace App\Controllers;

class Email extends BaseController
{
    protected $email;
    protected $email_from;
    protected $email_from_title;

    public function __construct()
    {
        $this->email             = \Config\Services::email();
        $this->email_from        = env('email_from');
        $this->email_from_title  = env('email_from_title');
    }

    public function sendEmail($to, $subject, $message ): bool
    {
        $this->email->setFrom($this->email_from, $this->email_from_title);
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        $enviado = $this->email->send();
        if (!$enviado) {
            log_message('error', 'Email error: ' . $this->email->printDebugger(['headers', 'subject', 'body']));
        }
        return $enviado;
    }
}
