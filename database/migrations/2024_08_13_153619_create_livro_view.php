<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLivroView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW livro_view AS
            SELECT 
                livro.id AS id_livro,
                livro.titulo AS livro_titulo,
                autor.id AS id_autor,
                autor.nome AS autor_nome,
                assunto.id AS id_assunto,
                assunto.descricao AS assunto_descricao
            FROM 
                livro
            LEFT JOIN 
                livro_autor ON livro.id = livro_autor.id_livro
            LEFT JOIN 
                autor ON livro_autor.id_autor = autor.id
            LEFT JOIN 
                livro_assunto ON livro.id = livro_assunto.id_livro
            LEFT JOIN 
                assunto ON livro_assunto.id_assunto = assunto.id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS livro_view;");
    }
}
