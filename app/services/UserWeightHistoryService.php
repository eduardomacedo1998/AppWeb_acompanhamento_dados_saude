<?php

namespace App\Services;

use App\Repository\UserWeightHistoryRepository;

class UserWeightHistoryService
{
    private $model_weight_history;

    public function __construct(UserWeightHistoryRepository $model_weight_history)
    {
        $this->model_weight_history = $model_weight_history;
    }
    public function createWeightHistory(int $id_usuario, float $peso)
    {
        return $this->model_weight_history->create([
            'user_id' => $id_usuario,
            'weight' => $peso,
            'recorded_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getWeightHistoryByUserId(int $userId)
    {
        return $this->model_weight_history->findByUserId($userId);
    }
}