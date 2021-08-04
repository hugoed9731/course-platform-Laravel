<?php

namespace App\Mail;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectCourse extends Mailable
{
    use Queueable, SerializesModels;

    public $course;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->course = $course;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reject-course')
        ->subject('Curso rechazado');
        // subject - es el asunto del correo que se va a enviar
    // esta vista es la que vamos a enviar por correo electronico
    }
}
