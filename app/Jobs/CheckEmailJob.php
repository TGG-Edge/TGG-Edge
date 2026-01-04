<?php

namespace App\Jobs;

use App\Models\CampaignCheckEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CheckEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;
    protected int $userId;

    public function __construct(array $data, int $userId)
    {
        $this->data = $data;
        $this->userId = $userId;
    }

    public function handle()
    {
        if (empty($this->data['email'])) {
            return;
        }

        $response = Http::get(
            'https://www.disify.com/api/email/' . $this->data['email']
        );

        if (!$response->ok()) {
            return;
        }

        $res = $response->json();

        $isValid =
            isset($res['format'], $res['disposable'], $res['dns']) &&
            $res['format'] === true &&
            $res['dns'] === true &&
            $res['disposable'] === false;

        CampaignCheckEmail::create([
            'name'       => $this->data['name'] ?? null,
            'email'      => $this->data['email'],
            'is_valid'   => $isValid ? 1 : 0,
            'format'     => $res['format'] ?? 0,
            'domain'     => $res['domain'] ?? null,
            'disposable' => $res['disposable'] ?? 0,
            'dns'        => $res['dns'] ?? 0,
            'whitelist'  => $res['whitelist'] ?? 0,
            'created_by' => $this->userId,
        ]);
    }
}
