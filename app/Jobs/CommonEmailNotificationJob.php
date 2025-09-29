<?php

namespace App\Jobs;

use App\Mail\CommonEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class CommonEmailNotificationJob implements ShouldQueue
{
    use Queueable;

    protected $emails;
    protected $template_name;
    public function __construct($emails, $template_name)
    {
        $this->emails=$emails;
        $this->template_name=$template_name;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->emails as $email)
        {
            Mail::to($email)->send(new CommonEmailNotification($this->template_name));
        }
    }
}
