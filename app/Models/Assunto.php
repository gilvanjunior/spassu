<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assunto';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descricao'
    ];

    // Relacionamentos
    public function livro()
    {
        return $this->belongsToMany(Livro::class, 'livro_assunto', 'id_assunto', 'id_livro');
    }

}
