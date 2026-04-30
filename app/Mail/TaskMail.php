<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class TaskMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Creation Modification',
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'email.notification',
            with: ['data' => $this->data]
        );
    }
    @return array<int, Attachment>
    public function attachments(): array
    {
        return [];
    }
}
