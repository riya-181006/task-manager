<?php
namespace App\Jobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskMail;
class SendEmailJob implements ShouldQueue
{
    use Queueable;
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function handle()
    {
        $mail = new TaskMail($this->data);
        Mail::to($this->data->task_owner_email)->send($mail);
    }
}