<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $site_mame;
    public $user;
    public $confirmation_code;

    public function __construct($site_mame, $user, $confirmation_code)
    {
        $this->site_mame         = $site_mame;
        $this->user              = $user;
        $this->confirmation_code = $confirmation_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
//    public function build()
//    {
//        return $this->view('email.UserRegisteredEmail')
//                    ->with('site_mame', $this->site_mame)
//                    ->with('user', $this->user)
//                    ->with('confirmation_code', $this->confirmation_code);
//    }
//

    public function build()
    {
        return $this->markdown('email.UserRegisteredEmail')
                    ->with('site_mame', $this->site_mame)
                    ->with('user', $this->user)
                    ->with('confirmation_code', $this->confirmation_code);
    }
}
