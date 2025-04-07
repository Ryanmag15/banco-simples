<?php

namespace App\Http\Controllers;

use App\Services\Transfer\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Realiza uma transferência entre dois usuários.
     *
     * Este método valida os dados da requisição, inicia uma transação no banco de dados,
     * e chama o serviço de transferência para efetuar a operação. Caso ocorra qualquer exceção,
     * a transação é revertida.
     *
     * @param \Illuminate\Http\Request $request Requisição HTTP contendo os dados da transferência:
     *   - int $payer ID do usuário que envia
     *   - int $payee ID do usuário que recebe
     *   - float $value Valor da transferência
     *
     * @return \Illuminate\Http\JsonResponse
     *   - 200 Sucesso na transferência
     *   - 400 Erro ao realizar a transferência
     */
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'payer' => 'required|numeric|exists:users,id',
            'payee' => 'required|numeric|exists:users,id',
            'value' => 'required|numeric|min:0.01',
            'idempotency_key' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $result = (new TransferService())->handle($validated);
            DB::commit();
            return response()->json(['message' => 'Transferência realizada com sucesso!', 'data' => $result], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro na transferência', 'message' => $e->getMessage()], 400);
        }
    }
}
