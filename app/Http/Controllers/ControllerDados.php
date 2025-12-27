<?php

namespace App\Http\Controllers;

use App\Services\DadosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserWeightHistoryService;


class ControllerDados extends Controller
{
    protected DadosService $dadosService;
    protected UserWeightHistoryService $userWeightHistoryService;

    public function __construct(DadosService $dadosService, UserWeightHistoryService $userWeightHistoryService)
    {
        $this->dadosService = $dadosService;
        $this->userWeightHistoryService = $userWeightHistoryService;
    }


    public function alterarpeso(Request $request, $id)
    {
        $request->validate([
            'peso' => 'required|numeric',
        ]);

        $id = Auth::id();

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Atualiza o peso atual
            $this->dadosService->updatePeso($id, $request->input('peso'));    

            // Registra no histórico
            $this->userWeightHistoryService->createWeightHistory(Auth::id(), $request->input('peso'));

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->back()->with('success', 'Peso e histórico atualizados com sucesso!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Falha ao atualizar dados: ' . $e->getMessage()])->withInput();
        }
    }

    public function dashboard()
    {
        $id = Auth::id();

        $dadosUsuario = $this->dadosService->getAllByUserId($id);
        $weightHistory = $this->userWeightHistoryService->getWeightHistoryByUserId($id);

        $resultadoIMC = $this->dadosService->calcularIMC($dadosUsuario->peso, $dadosUsuario->altura);
        [$IMC, $nivelIMC] = $resultadoIMC;
        

        if (!$IMC || !$dadosUsuario) {
            return redirect()->route('users.index')->withErrors(['error' => 'Dados do usuário não encontrados.']);
        }   

        return view('home.index', compact('dadosUsuario', 'IMC', 'nivelIMC', 'weightHistory'));
    }


    


}