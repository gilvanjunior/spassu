<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LivroAutor extends Pivot
{
    protected $table = 'livro_autor';
    protected $fillable = ['id_livro', 'id_autor'];
}