<?php

namespace App\Jobs;

use App\Mail\NormalMail;
use App\Mail\PecMail;
use App\Mail\TestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NormalEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $request)
    {
        $this->email = $email;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::mailer('smtp')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->to($this->email)->send(new NormalMail($this->email, $this->request, 'smtp'));
    }
}
