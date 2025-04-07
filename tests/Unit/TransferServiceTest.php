<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\User;
use App\Services\TransferService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testa se a transferência entre dois usuários é realizada com sucesso.
     *
     * Este teste simula:
     * - Requisição externa de autorização e notificação (via Http::fake)
     * - Criação de dois usuários e suas contas
     * - Execução do serviço de transferência
     * - Verificação dos dados retornados
     * - Verificação se os registros de transferência foram persistidos corretamente no banco de dados
     *
     * @return void
     */
    public function test_deve_realizar_transferencia_com_sucesso()
    {
        // Simula as respostas das APIs externas de autorização e notificação
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response(['message' => 'Autorizado'], 200),
            'https://util.devi.tools/api/v1/notify' => Http::response(['message' => 'Notificado'], 200),
        ]);

        // Cria dois usuários no banco de dados (pagador e recebedor)
        $payer = User::factory()->create();
        $payee = User::factory()->create();

        // Cria uma conta para cada usuário
        $payerAccount = Account::factory()->create(['user_id' => $payer->id]);
        $payeeAccount = Account::factory()->create(['user_id' => $payee->id]);

        // Monta os dados da transferência simulada
        $data = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100.00,
        ];

        // Mock do cache para evitar chamadas reais
        Cache::shouldReceive('get')->once()->andReturn(null);
        Cache::shouldReceive('put')->once();

        // Executa a transferência via service
        $service = new TransferService();
        $response = $service->handle($data);

        // Valida se o retorno da transferência está correto
        $this->assertEquals($payer->id, $response['from']);
        $this->assertEquals($payee->id, $response['to']);
        $this->assertEquals(100.00, $response['value']);

        // Verifica se os registros foram persistidos corretamente no banco
        $this->assertDatabaseHas('transfers', [
            'type' => 'output',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => 100.00,
        ]);
        $this->assertDatabaseHas('transfers', [
            'type' => 'input',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => 100.00,
        ]);
    }
}
