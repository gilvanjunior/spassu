<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autor';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome'
    ];

    // Relacionamentos
    public function livro()
    {
        return $this->belongsToMany(Livro::class, 'livro_autor', 'id_autor', 'id_livro');
    }
}
