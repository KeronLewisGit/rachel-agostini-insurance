<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lead = $this->lead;

        $mail = (new MailMessage)
            ->subject("New {$lead->typeLabel()}: {$lead->name} ({$lead->reference})")
            ->greeting("New lead, {$lead->reference}")
            ->line("**{$lead->name}** sent a {$lead->typeLabel()}".($lead->productName() ? " about {$lead->productName()}." : '.'))
            ->line($lead->summary ?? '');

        if ($lead->phone) {
            $mail->line("Phone: {$lead->phone}".($lead->preferred_contact ? " (prefers {$lead->preferred_contact})" : ''));
        }

        if ($lead->email) {
            $mail->line("Email: {$lead->email}");
        }

        if ($lead->message) {
            $mail->line('"'.$lead->message.'"');
        }

        return $mail
            ->line("Priority score: {$lead->score}/100. Source: {$lead->sourceLabel()}.")
            ->action('Open in lead tracker', route('admin.leads.show', $lead))
            ->salutation('Sent by your website lead tracker.');
    }
}
