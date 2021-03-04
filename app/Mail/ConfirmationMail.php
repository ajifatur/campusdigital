<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Komisi;
use App\User;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($user, $komisi)
    {
        $this->user = $user;
        $this->komisi = $komisi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // CS
        $cs = User::where('role','=',role_cs())->first();
		
		// Get data user
		$user = User::find($this->user);
		$komisi = Komisi::find($this->komisi);
		
        return $this->from($cs->email, get_website_name())->markdown('email/confirmation')->subject('Verifikasi Komisi Member '.get_website_name())->with([
            'user' => $user,
            'komisi' => $komisi,
        ]);
    }
}
