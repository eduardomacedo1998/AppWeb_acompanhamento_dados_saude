<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWeightHistory extends Model
{
    use HasFactory;

    protected $table = 'user_weight_history'; // Adicione esta linha com o nome exato da tabela no seu banco

    protected $fillable = [
        'user_id',
        'weight',
        'recorded_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    


}
