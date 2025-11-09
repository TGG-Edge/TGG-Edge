<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

trait MailTrait
{
    /**
     * Send an email with optional attachments.
     *
     * @param string|array $to
     * @param string $subject
     * @param string $view Blade view path OR raw HTML content
     * @param array $data Data for view (or used in view)
     * @param array $attachments Array of file paths => ['path' => '/full/path/file.pdf', 'name' => 'file.pdf'] OR simple ['/path/a.pdf']
     * @param array $options ['from' => '', 'from_name' => '', 'is_html' => true, 'cc' => [], 'bcc' => [], 'reply_to' => null, 'queue' => false]
     * @return bool
     */
    public function sendMail($to, $subject, $view, $data = [], $attachments = [], $options = [])
    {
        try {
            $from = $options['from'] ?? config('mail.from.address');
            $fromName = $options['from_name'] ?? config('mail.from.name');
            $isHtml = $options['is_html'] ?? true;
            $cc = (array) ($options['cc'] ?? []);
            $bcc = (array) ($options['bcc'] ?? []);
            $replyTo = $options['reply_to'] ?? null;
            $queue = $options['queue'] ?? false;

            $mailer = function ($message) use ($to, $subject, $view, $data, $attachments, $from, $fromName, $isHtml, $cc, $bcc, $replyTo) {
                $message->from($from, $fromName);

                if (is_array($to)) {
                    $message->to($to);
                } else {
                    $message->to($to);
                }

                $message->subject($subject);

                if (!empty($cc)) {
                    $message->cc($cc);
                }
                if (!empty($bcc)) {
                    $message->bcc($bcc);
                }
                if ($replyTo) {
                    $message->replyTo($replyTo);
                }

                // Fix: use html() or text() instead of setBody()
                if ($isHtml) {
                    if (view()->exists($view)) {
                        $message->html(view($view, $data)->render());
                    } else {
                        $message->html($view); // raw HTML string
                    }
                } else {
                    if (view()->exists($view)) {
                        $message->text(view($view, $data)->render());
                    } else {
                        $message->text(strip_tags($view));
                    }
                }

                // attachments
                foreach ($attachments as $att) {
                    if (is_array($att)) {
                        if (!empty($att['path']) && file_exists($att['path'])) {
                            $message->attach($att['path'], [
                                'as' => $att['name'] ?? basename($att['path']),
                                'mime' => $att['mime'] ?? null
                            ]);
                        }
                    } else {
                        if (file_exists($att)) {
                            $message->attach($att);
                        }
                    }
                }
            };

            if ($queue) {
                Mail::queue($mailer);
            } else {
                Mail::send([], [], $mailer);
            }

            return true;
        } catch (Exception $e) {
            Log::error("MailTrait::sendMail failed - " . $e->getMessage(), [
                'to' => $to, 'subject' => $subject
            ]);
            return false;
        }
    }

}
