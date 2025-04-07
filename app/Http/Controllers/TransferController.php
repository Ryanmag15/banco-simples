<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Transfer;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }

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
        // Se quiser validar, descomente e ajuste conforme necessário
        $request->validate([
            'payer' => 'required|numeric|exists:users,id',
            'payee' => 'required|numeric|exists:users,id',
            'value' => 'required|numeric|min:0.01',
        ]);

        $transferService = new TransferService();

        DB::beginTransaction();
        try {
            $response = $transferService->handle($request->only(['payer', 'payee', 'value']));
            DB::commit();
            return response()->json(['message' => 'Transferência realizada com sucesso!', 'data' => $response], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao realizar transferência', 'message' => $e->getMessage()], 400);
        }
    }
}
