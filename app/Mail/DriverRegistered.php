<?php

namespace App\Mail;

use App\Models\Driver;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function build()
    {
        return $this->subject('Registration Successful')
            ->markdown('emails.driver_registered');
    }
}
