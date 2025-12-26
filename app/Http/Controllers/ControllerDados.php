<?php

namespace App\Http\Controllers;

use App\Services\DadosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ControllerDados extends Controller
{
    protected DadosService $dadosService;

    public function __construct(DadosService $dadosService)
    {
        $this->dadosService = $dadosService;
    }


    public function alterarpeso(Request $request, $id)
    {
        $request->validate([
            'peso' => 'required|numeric',
        ]);

        try {
            $dadosUsuario = $this->dadosService->updatePeso($id, $request->input('peso'));
            return redirect()->back()->with('success', 'Peso atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Falha ao atualizar peso: ' . $e->getMessage()])->withInput();
        }
    }

    public function dashboard()
    {
        $id = Auth::id();

        $dadosUsuario = $this->dadosService->getAllByUserId($id);
        $resultadoIMC = $this->dadosService->calcularIMC($dadosUsuario->peso, $dadosUsuario->altura);
        [$IMC, $nivelIMC] = $resultadoIMC;

        if (!$IMC || !$dadosUsuario) {
            return redirect()->route('users.index')->withErrors(['error' => 'Dados do usuário não encontrados.']);
        }   

        return view('home.index', compact('dadosUsuario', 'IMC', 'nivelIMC'));
    }


}