<?php

namespace App\Services\Transfer\Notification;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    protected int $payeeId;
    protected float $value;

    public function __construct(int $payeeId, float $value)
    {
        $this->payeeId = $payeeId;
        $this->value = $value;
    }

    public function handle()
    {
        $payee = User::find($this->payeeId);

        Http::post('https://util.devi.tools/api/v1/notify', [
            'message' => 'Você recebeu R$ ' . number_format($this->value, 2, ',', '.'),
            'to' => $payee->email,
        ]);
    }
}
