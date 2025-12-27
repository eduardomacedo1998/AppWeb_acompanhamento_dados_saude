<?php

namespace App\Repository;

use App\Models\UserWeightHistory;


class UserWeightHistoryRepository
{
    public function create(array $data): UserWeightHistory
    {
        return UserWeightHistory::create($data);
    }

    public function findByUserId(int $userId)
    {
        return UserWeightHistory::where('user_id', $userId)->orderBy('recorded_at', 'asc')->get();
    }
}