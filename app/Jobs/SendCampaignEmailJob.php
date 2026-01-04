<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendCampaignEmailJob implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipientId;

    public function __construct($recipientId)
    {
        $this->recipientId = $recipientId;
    }

    public function handle()
    {
        $recipient = CampaignRecipient::with('campaign.template')
            ->find($this->recipientId);

        if (!$recipient) return;

        $campaign = $recipient->campaign;
        $template = $campaign->template;
        $data     = $recipient->payload;

        if (!isset($data['email'])) {
            $recipient->update(['status' => 'failed']);
            return;
        }

        // Replace variables
        $body = $template->content['body'];
        foreach ($data as $key => $value) {
            $body = str_replace('[['.$key.']]', $value, $body);
        }

        $extra_data = ['invite_link' => $template->invite_link ?? '', 'year' => date('Y')];
        foreach ($extra_data as $key => $value) {
            $body = str_replace('[['.$key.']]', $value, $body);
        }

        try {

            Mail::html($body, function ($message) use ($data, $template) {
                $message->to($data['email'])
                        ->subject($template->title ?? 'Notification');
            });

            $recipient->update(['status' => 'sent']);

        } catch (Throwable $e) {
            $recipient->update(['status' => 'failed']);
        }
    }
}
