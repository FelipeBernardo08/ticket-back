<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EMail extends Mailable
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
        return $this->view('emails.EMail') // Defina a visualização
            ->with(['data' => $this->data]); // Passe dados para a visualização se necessário
    }
}
