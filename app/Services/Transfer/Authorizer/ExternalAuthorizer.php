<?php

namespace App\Services\Transfer\Authorizer;

use Illuminate\Support\Facades\Http;

class ExternalAuthorizer
{
    public function authorize(): void
    {
        $response = Http::get('https://util.devi.tools/api/v2/authorize');
        if ($response->failed()) {
            throw new \Exception('Autorização negada.', 401);
        }
    }
}
