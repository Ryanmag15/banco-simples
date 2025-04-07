<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Serviço responsável por realizar transferências entre usuários.
 *
 * Este serviço valida as regras de negócio, verifica saldo e autorização externa,
 * executa a transação financeira entre contas, notifica o recebedor e registra as transferências.
 */
class TransferService
{
    /**
     * Realiza uma transferência entre dois usuários.
     *
     * Verifica se o pagador é diferente do recebedor, se tem saldo suficiente, se a transação é idêntica a uma recente,
     * e se há autorização externa antes de efetuar a transferência.
     *
     * @param array $data Dados da transferência, contendo:
     *  - int 'payer' ID do usuário que envia
     *  - int 'payee' ID do usuário que recebe
     *  - float 'value' Valor da transferência
     *
     * @return array Resultado da transferência com IDs e valor
     *
     * @throws \Exception Em caso de violação de regras, saldo insuficiente, falha de autorização ou notificação
     */
    public function handle(array $data): array
    {
        $payerId = $data['payer'];
        $payeeId = $data['payee'];
        $value   = $data['value'];

        if ($payerId == $payeeId) {
            throw new \Exception('Payer e Payee não podem ser iguais.', 422);
        }

        $payer = User::findOrFail($payerId);
        $payee = User::findOrFail($payeeId);

        if ($payer->account->typeAccount['internal_name'] === 'merchant') {
            throw new \Exception('Lojistas não podem enviar transferências.', 403);
        }

        if ($payer->account->balance < $value) {
            throw new \Exception('Saldo insuficiente.', 400);
        }

        $cacheKey = "recent_transaction_{$payerId}";
        $lastTransaction = Cache::get($cacheKey);

        if (
            $lastTransaction &&
            $lastTransaction['payee'] == $payeeId &&
            $lastTransaction['value'] == $value
        ) {
            throw new \Exception('Transação idêntica detectada. Altere o valor para continuar.', 409);
        }

        $authResponse = Http::get('https://util.devi.tools/api/v2/authorize');
        if ($authResponse->failed()) {
            throw new \Exception('Autorização negada, realizando reversão da transação.', 401);
        }

        $payer->account()->decrement('balance', $value);
        $payee->account()->increment('balance', $value);

        $notificationResponse = Http::post('https://util.devi.tools/api/v1/notify', [
            'message' => 'Você recebeu uma transferência de R$ ' . number_format($value, 2, ',', '.'),
            'to' => $payee->email,
        ]);
        if ($notificationResponse->failed()) {
            throw new \Exception('Falha ao notificar o Recebedor, realizando reversão da transação.', 500);
        }

        Cache::put($cacheKey, [
            'payee' => $payeeId,
            'value' => $value,
        ], now()->addSeconds(30));

        $this->createTransfers($payer, $payee, $value);

        return [
            'from'  => $payer->id,
            'to'    => $payee->id,
            'value' => $value,
        ];
    }

    /**
     * Registra as transferências no banco de dados.
     *
     * Cria dois registros:
     * - Um de saída (output) para o pagador
     * - Um de entrada (input) para o recebedor
     *
     * @param \App\Models\User $payer Usuário que envia a transferência
     * @param \App\Models\User $payee Usuário que recebe a transferência
     * @param float $value Valor da transferência
     *
     * @return void
     *
     * @throws \Exception Em caso de falha ao salvar as transferências
     */
    private function createTransfers(object $payer, object $payee, string $value)
    {
        Transfer::create([
            'account_id' => $payer->account->id,
            'type' => 'output',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => $value,
        ]);

        Transfer::create([
            'account_id' => $payee->account->id,
            'type' => 'input',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => $value,
        ]);
    }
}
