<?php


namespace App\Services;

use App\Repository\DadosRepository;
use App\Models\Dados_usuario;

class DadosService
{
    protected DadosRepository $dadosRepository;

    public function __construct(DadosRepository $dadosRepository)
    {
        $this->dadosRepository = $dadosRepository;
    }

    public function getAllByUserId(int $id_usuario): ?Dados_usuario
    {
        return $this->dadosRepository->getAllByUserId($id_usuario);
    }

    public function create(array $data): Dados_usuario
    {
        return $this->dadosRepository->create($data);
    }

    public function update(int $id_usuario, array $data): ?Dados_usuario
    {
        return $this->dadosRepository->update($id_usuario, $data);
    }

    public function updatePeso(int $id_usuario, float $novoPeso): ?Dados_usuario
    {
        $dados = $this->dadosRepository->getAllByUserId($id_usuario);
        if ($dados) {
            $dados->peso = $novoPeso;
            $dados->save();
            return $dados;
        }
        return null;
    }


    public function calcularIMC(float $peso, float $altura): array
    {
        if ($altura <= 0) {
            throw new \InvalidArgumentException("Altura deve ser maior que zero.");
        }

        // convertendo os valores em float para garantir precisão
        $peso = floatval($peso);
        $altura = floatval($altura);
        $calculo_imc = [];
        $nivel_imc = '';

        $alturaEmMetros = $altura / 100;

        $IMC = $peso / ($alturaEmMetros * $alturaEmMetros);

        switch (true) {
            case ($IMC < 18.5):
                $nivel_imc = 'Abaixo do peso';
                break;
            case ($IMC >= 18.5 && $IMC < 24.9):
                $nivel_imc = 'Peso normal';
                break;
            case ($IMC >= 25 && $IMC < 29.9):
                $nivel_imc = 'Sobrepeso';
                break;
            case ($IMC >= 30):
                $nivel_imc = 'Obesidade';
                break;
        }

        $imc = round($IMC, 2);

        $calculo_imc[] = $imc;
        $calculo_imc[] = $nivel_imc;


        // verificar se o IMC é um número válido ou null

       if ($IMC <= 0 || is_nan($IMC) || is_infinite($IMC)) {
           throw new \RuntimeException("Cálculo do IMC resultou em um valor inválido.");
       }

        return $calculo_imc;
    }

  
}