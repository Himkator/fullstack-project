<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentMail extends Mailable {
    use Queueable, SerializesModels;

    public $studentName;
    public $courseTitle;

    public function __construct($studentName, $courseTitle) {
        $this->studentName = $studentName;
        $this->courseTitle = $courseTitle;
    }

    public function build() {
        return $this
            ->from('noreply@f1academy.com', 'F1 Academy')
            ->subject('F1 Academy – Enrollment Confirmation')
            ->view('enrollment')
            ->text('enrollment_plain');
    }
}