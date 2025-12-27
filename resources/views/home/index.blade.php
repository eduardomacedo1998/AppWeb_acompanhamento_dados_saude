@extends('layouts.main')

    @section('title', 'Dashboard')

    @section('content')
    @php
        $dados = $dadosUsuario ?? Auth::user();
        $peso = $dados->peso ?? null;
        $altura = $dados->altura ?? null;
        $objetivo = $dados->objetivo_peso ?? null;
        $idade = $dados->idade ?? null;
        $goalDate = $dados->data_objetivo ?? null;
        $sexo = $dados->sexo ?? null;
        $weightToLose = ($peso && $objetivo) ? number_format($peso - $objetivo, 1) : null;
    @endphp
    <div class="container">
        <div class="header">
            <h1>Bem-vindo, <span class="user-name">{{ Auth::user()->name }}!</span></h1>
            <p>Acompanhe sua jornada fitness e alcance seus objetivos</p>
        </div>

        <!-- Quick Stats Cards -->
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-title">Peso Atual</div>
                <div class="card-value">{{ $peso ? number_format($peso, 1) : 'N/A' }}<span class="card-unit">kg</span></div>
                <div class="card-subtitle">Último peso registrado</div>
            </div>

            <div class="card">
                <div class="card-title">Altura</div>
                <div class="card-value">{{ $altura ? number_format($altura, 1) : 'N/A' }}<span class="card-unit">cm</span></div>
                <div class="card-subtitle">Sua altura</div>
            </div>

            <div class="card">
                <div class="card-title">Meta de Peso</div>
                <div class="card-value">{{ $objetivo ? number_format($objetivo, 1) : 'N/A' }}<span class="card-unit">kg</span></div>
                <div class="card-subtitle">Peso alvo</div>
            </div>

            <div class="card">
                <div class="card-title">Idade</div>
                <div class="card-value">{{ $idade ?? 'N/A' }}<span class="card-unit">years</span></div>
                <div class="card-subtitle">Sua idade</div>
            </div>

            <div class="card">
                <div class="card-title">IMC</div>
                <div class="card-value">{{ $IMC ? number_format($IMC, 2) : 'N/A' }}</div>
                <div class="card-subtitle">Índice de massa corporal</div>
                <div class="card-subtitle">{{ $nivelIMC ?? '' }}</div>
                
            </div>
        </div>

        <!-- Detailed Stats Section -->
        <div class="stats-section">
            <h2>Informações do Perfil</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-label">E-mail</div>
                    <div class="stat-value" style="font-size: 16px; word-break: break-all;">{{ Auth::user()->email }}</div>
                </div>

                <div class="stat-item">
                    <div class="stat-label">Gênero</div>
                    <div class="stat-value">
                        @if ($sexo === 'M')
                            Masculino
                        @elseif ($sexo === 'F')
                            Feminino
                        @elseif ($sexo)
                            Outro
                        @else
                            Não informado
                        @endif
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-label">Data da Meta</div>
                    <div class="stat-value" style="font-size: 16px;">{{ $goalDate ?? 'Not set' }}</div>
                </div>

                <div class="stat-item">
                    <div class="stat-label">Peso a Perder</div>
                    <div class="stat-value">
                        {{ $weightToLose ?? 'N/A' }}<span class="card-unit">kg</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section">
            <h2>Acompanhamento</h2>

            @if ($peso && $objetivo && $peso > 0)
                @php
                    $progressPercentage = min((($peso - $objetivo) / $peso) * 100, 100);
                @endphp
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Meta de Emagrecimento</span>
                        <span>{{ number_format($progressPercentage, 1) }}%</span>
                    </div>
                    <div class="progress-bar">
                    
                        <div class="progress-fill">{{ number_format($progressPercentage, 1) }}%</div>
                    </div>
                </div>
            @else
                <div class="no-data">Sem dados de peso. Complete seu perfil.</div>
            @endif

            <div class="button-group">
                <button type="button" class="btn btn-primary" id="editWeightBtn">Editar Peso</button>
                <a href="#" id="weighing" class="btn btn-secondary">Registrar Entrada de Peso</a>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="weightModal">
        <div class="modal-card-custom">
            <button type="button" class="modal-close" id="closeWeightModal">×</button>
            <h3>Atualizar Peso</h3>
            <form action="{{ route('dados.alterarPeso', ['id' => Auth::id()]) }}" method="post">
                @csrf
                <div class="modal-form-group">
                    <label for="peso_modal">Novo peso (kg)</label>
                    <input type="number" id="peso_modal" name="peso" step="0.1" min="0" required value="{{ $peso ?? '' }}">
                </div>
                <button type="submit" class="modal-submit">Salvar</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        //  console.log('Script loaded');
        const modal = document.getElementById('weightModal');
        const editBtn = document.getElementById('weighing');
        const closeBtn = document.getElementById('closeWeightModal');

        // console.log('Modal:', modal);
        // console.log('Edit button:', editBtn);

        function toggleModal(show) {
            console.log('Toggle modal:', show);
            if (show) {
                modal.classList.add('is-visible');
            } else {
                modal.classList.remove('is-visible');
            }
        }

        if (editBtn) {
            editBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                console.log('Edit button clicked');
                toggleModal(true);
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => toggleModal(false));
        }

        if (modal) {
            modal.addEventListener('click', (event) => {
                // Atualizado para verificar a nova classe
                if (!event.target.closest('.modal-card-custom')) {
                    toggleModal(false);
                }
            });
        }
    </script>
    @endpush
    @endsection
