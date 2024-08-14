<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivroAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->id();

            // Colunas de chave estrangeira
            $table->unsignedBigInteger('id_livro');
            $table->unsignedBigInteger('id_autor');

            // Chaves estrangeiras explicitamente configuradas com o nome da tabela em singular
            $table->foreign('id_livro')
                  ->references('id')
                  ->on('livro')   // Especifica a tabela 'livro' sem pluralização
                  ->onDelete('cascade');

            $table->foreign('id_autor')
                  ->references('id')
                  ->on('autor')   // Especifica a tabela 'autor' sem pluralização
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livro_autor');
    }
}
