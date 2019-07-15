<?php

namespace App\Jobs;

use App\Helpers\SendMail;
use App\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $feedback;
    /**
     * Create a new job instance.
     *
     * @param Feedback $feedback
     * @return void
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @param  \App\Helpers\SendMail  $mail
     * @return void
     */
    public function handle(SendMail $mail)
    {
        $mail->feedbackMail($this->feedback->first_name, $this->feedback->phone);

    }
}
