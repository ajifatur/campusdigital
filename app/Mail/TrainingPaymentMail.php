<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\PelatihanMember;
use App\User;

class TrainingPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($pelatihan, $user)
    {
        $this->pelatihan = $pelatihan;
        $this->user = $user;
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
		
		// Get data pelatihan
		$pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->find($this->pelatihan);
		
		// Get data user
		$user = is_int($this->user) ? User::find($this->user) : $this->user;
		
        return $this->from($cs->email, get_website_name())->markdown('email/training-payment')->subject('Verifikasi Pembayaran Pelatihan')->with([
            'pelatihan' => $pelatihan,
            'user' => $user,
        ]);
    }
}
