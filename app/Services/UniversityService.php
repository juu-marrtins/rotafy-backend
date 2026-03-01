<?php

namespace App\Services;

use App\Exceptions\BadGatewayException;
use App\Exceptions\UnprocessableContentException;
use App\Models\University;
use App\Repositories\UniversityRepository;
use Illuminate\Support\Facades\Http;

class UniversityService
{
    public function __construct(
        protected UniversityRepository $universityRepository
    ){}

    public function validate(string $cnpj): array {
        $ulr = env('VALIDATOR_URL') . $cnpj;

        try{
            $response = Http::get($ulr);
            $data = $response->json();
        } catch (\Exception $e) {
            throw new BadGatewayException('Não foi possível validar o CNPJ', $e->getMessage());
        }

        $codes = collect($data['atividade_principal'] ?? [])
            ->merge($data['atividades_secundarias'] ?? [])
            ->pluck('code')
            ->filter()
            ->values();

        $validCodes = collect(explode(',', env('VALID_UNIVERSITY_CODES')));
        $hasValidCode = $codes->intersect($validCodes)->isNotEmpty();

        if (! $hasValidCode || $data['situacao'] !== 'ATIVA') {
            throw new UnprocessableContentException(
                'CNPJ não pertence a uma universidade válida'
            );
        }

        return [
            'name' => $data['nome'],
            'city' => $data['municipio'],
            'state' => $data['uf'],
            'cnpj' => $cnpj,
        ];
    }

    public function create(array $data): University {
        return $this->universityRepository->create($data);
    }

    public function getOrCreateByCnpj(string $cnpj): ?int {
        $universityId = $this->universityRepository->getIdByCnpj($cnpj);
        if ($universityId) {
            return $universityId;
        }

        return $this->create($this->validate($cnpj))->id;
    }
}