<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivroAssuntoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livro_assunto', function (Blueprint $table) {
            $table->id();

            // Colunas de chave estrangeira
            $table->unsignedBigInteger('id_livro');
            $table->unsignedBigInteger('id_assunto');

            // Chaves estrangeiras explicitamente configuradas com o nome da tabela em singular
            $table->foreign('id_livro')
                  ->references('id')
                  ->on('livro')   // Especifica a tabela 'livro' sem pluralização
                  ->onDelete('cascade');

            $table->foreign('id_assunto')
                  ->references('id')
                  ->on('assunto')   // Especifica a tabela 'assunto' sem pluralização
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
        Schema::dropIfExists('livro_assunto');
    }
}
