<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Blade;

class DynamicEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public EmailTemplate $emailTemplate;
    public array $data; // This will hold the dynamic variables (e.g., ['user_name' => 'John Doe'])


    /**
     * Create a new message instance.
     */
    public function __construct(EmailTemplate $emailTemplate, array $data = [])
    {
        $this->emailTemplate = $emailTemplate;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $processedSubject = Blade::render(
            $this->emailTemplate->subject,
            array_merge($this->data, ['app_name' => config('app.name')]) // Add app_name by default
        );

        return new Envelope(
            subject: $processedSubject,
        );

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Render the email body using Blade, passing the dynamic data
        $renderedBody = Blade::render(
            $this->emailTemplate->body,
            array_merge($this->data, ['app_name' => config('app.name')]) // Add app_name by default
        );

        return new Content(
            htmlString: $renderedBody,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
