# AppWeb - Acompanhamento de Dados de Saúde

Aplicação Laravel construída para registrar usuários, persistir seus dados de saúde e fornecer um dashboard moderno com métricas métricas, como peso, altura, meta de emagrecimento e IMC.

## Funcionamento

1. **Cadastro e autenticação**
   - O formulário valida nome, e-mail, senha e dados métricos (`peso`, `altura`, `idade`, `sexo`, `objetivo_peso`, `data_objetivo`).
   - O `ControllerUser` delega a criação ao `UserService` e garante persistência na tabela `users`. Há um modal de atualização de peso que chama `ControllerDados::alterarpeso`.

2. **Camada de dados**
   - `UserRepository` abstrai o modelo `User`, enquanto `DadosRepository` e `DadosService` concentram criação, consulta e atualização da tabela `dados_usuario`.
   - O IMC é calculado em metros no `DadosService::calcularIMC` com classificação (`Abaixo do peso`, `Peso normal`, etc.`).

3. **Dashboard**
   - `ControllerDados::dashboard` compõe o objeto `dadosUsuario`, calcula o IMC e o nível, e passa para a view.
   - A view `home.index` exibe cards com peso atual, objetivo, idade, altura e o resultado do IMC, além de permitir edição de peso via modal JS.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Use `php artisan serve` e acesse `http://localhost:8000`. Registre um usuário preenchendo todos os campos para que o dashboard já carregue informações reais.

## Testes e manutenções

- Roteamento está em `routes/web.php`.
- Serviços e repositórios estão em `app/Services` e `app/Repository`.
- Atualize o modal de peso para enviar `POST` a `route('dados.alterarPeso', Auth::id())`.
