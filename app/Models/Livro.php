<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livro';

    protected $fillable = ['titulo', 'preco'];

    public function assunto()
    {
        return $this->belongsToMany(Assunto::class, 'livro_assunto', 'id_livro', 'id_assunto');
    }

    public function autor()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'id_livro', 'id_autor');
    }
}
