<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $data;

    /**
     * Crie uma nova instância de mensagem de e-mail.
     *
     * @param mixed $data
     * @return void
     */
    public function __construct($data, $subj)
    {
        $this->data = $data;
        $this->subject = $subj;
    }
    /**
     * Execute a construção da mensagem.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirmarEmail')
            ->with(['data' => $this->data]);
    }
}
