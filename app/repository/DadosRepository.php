<?php

namespace App\Repository;

use App\Models\Dados_usuario;


class DadosRepository 
{
    public function getAllByUserId(int $id_usuario): ?Dados_usuario
    {
        return Dados_usuario::where('id_usuario', $id_usuario)->first();
    }

    public function create(array $data): Dados_usuario
    {
        return Dados_usuario::create($data);
    }

    public function update(int $id_usuario, array $data): ?Dados_usuario
    {
        $dados = Dados_usuario::where('id_usuario', $id_usuario)->first();
        if ($dados) {
            $dados->update($data);
            return $dados;
        }
        return null;
    }
}