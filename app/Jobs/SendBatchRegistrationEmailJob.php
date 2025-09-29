<?php

namespace App\Jobs;

use App\Mail\NewRegistrationEmail;
use App\Models\Candidate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBatchRegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public $candidates;

    /**
     * Create a new job instance.
     *
     * @param array $candidates
     * @return void
     */
    public function __construct(array $candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $chunkedCandidates = array_chunk($this->candidates, 50);

        foreach ($chunkedCandidates as $chunk) {
            foreach ($chunk as $candidateData) {
                $candidate = Candidate::where('email', $candidateData['email'])->first();

                if ($candidate) {
                    Mail::to($candidate->email)->send(new NewRegistrationEmail($candidate, $candidateData['password']));
                }
            }
        }
    }
}
