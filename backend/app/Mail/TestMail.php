<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name = '';
    // public $from = '';
    // public $verif_code = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from)
    {
        $this->name = $from;
        // $this->from = $array->from;
        // $this->verif_code = $array->verif_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $address = 'test@codebriefly2.com';
  $name = 'Test Mail';
  $subject = 'Test Mail';
  return $this->view('emails')
      ->from($address, $name)
      ->cc($address, $name)
      ->bcc($address, $name)
      ->replyTo($address, $name)
      ->subject($subject)
      ->with([
        'CustomOption' => 'CustomValue',
        'CustomOption' => 'CustomValue'
      ]);
    }
}
