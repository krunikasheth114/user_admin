<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use  App\Mail\VerifyUser;

class RegisterUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validatedData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($validatedData)
    {
        $this->validatedData = $validatedData;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::debug($this->validatedData->email);

        try {
            Mail::to($this->validatedData->email)->send(new VerifyUser($this->validatedData->otp));
        } catch (\Exception $e) {
            \Log::debug('Send OTP mail : ', ['error' => $e]);
        }
    }
}
