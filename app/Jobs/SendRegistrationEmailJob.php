<?php

namespace App\Jobs;

use App\Mail\NewRegistrationEmail;
use App\Models\Candidate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendRegistrationEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $candidate;
    public $plainPassword;


    public function __construct(Candidate $candidate, $plainPassword)
    {
        $this->candidate = $candidate;
        $this->plainPassword = $plainPassword;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->candidate->email)->send(new NewRegistrationEmail($this->candidate, $this->plainPassword));

    }
}
