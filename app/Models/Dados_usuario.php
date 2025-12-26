<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dados_usuario extends Model
{
    use HasFactory;

    protected $table = 'dados_usuario';
    protected $fillable = [
        'id_usuario',
        'idade',
        'peso',
        'altura',
        'sexo',
        'objetivo_peso',
        'data_objetivo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public $timestamps = true;


    public function getallbyid($id_usuario)
    {
        return self::where('id_usuario', $id_usuario)->first();
    }
}
