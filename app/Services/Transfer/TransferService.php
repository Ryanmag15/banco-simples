<?php

namespace App\Services\Transfer;

use App\Models\Transfer;
use App\Services\Transfer\Validators\TransferValidator;
use App\Services\Transfer\Authorizer\ExternalAuthorizer;
use App\Services\Transfer\Cache\TransactionCache;
use App\Services\Transfer\Notification\NotifyUserJob;
use App\Services\Transfer\TransferExecutor;
use Illuminate\Support\Facades\Bus;

class TransferService
{
    public function handle(array $data): array
    {
        // Verifica se já existe uma transferência com a mesma chave de idempotência
        $existingTransfer = Transfer::where('idempotency_key', $data['idempotency_key'])->first();
        if (!empty($existingTransfer)) {
            return [
                'from' => $existingTransfer->payer_id,
                'to' => $existingTransfer->payee_id,
                'value' => $existingTransfer->value,
                'idempotency_key' => $existingTransfer->idempotency_key,
            ];
        }

        // Validação dos dados
        (new TransferValidator())->validate($data);

        // Autorização externa
        (new ExternalAuthorizer())->authorize();

        // Executa a transferência (aqui é importante passar a idempotency_key)
        $executor = new TransferExecutor();
        $result = $executor->execute($data);

        // Notificação assíncrona via fila
        Bus::dispatch(new NotifyUserJob($data['payee'], $data['value']));

        // Armazena em cache para rastreio ou auditoria
        (new TransactionCache())->store($data);

        return $result;
    }
}
