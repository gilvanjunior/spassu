<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LivroAssunto extends Pivot
{
    protected $table = 'livro_assunto';
    protected $fillable = ['id_livro', 'id_assunto'];
}
