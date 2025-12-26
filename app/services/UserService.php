<?php

namespace App\Services;

use App\Repository\UserRepository;


class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $data)
    {
        // Separar dados do usuário e dados adicionais
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
        
        $dadosAdicionais = [
            'idade' => $data['idade'],
            'peso' => $data['peso'],
            'altura' => $data['altura'],
            'sexo' => $data['sexo'],
            'objetivo_peso' => $data['objetivo_peso'],
            'data_objetivo' => $data['data_objetivo'],
        ];
        
        // Criar usuário
        $user = $this->userRepository->create($userData);
        
        // Criar dados do usuário
        $dadosUsuario = new \App\Models\dados_usuario();
        $dadosUsuario->id_usuario = $user->id;
        $dadosUsuario->fill($dadosAdicionais);
        $dadosUsuario->save();
        
        return $user;
    }

    public function dadosusuario($id)
    {
        return \App\Models\dados_usuario::where('id_usuario', $id)->first();
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

}





