<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Autor;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class AutorTest extends TestCase
{

    public function testIndexDisplaysAssuntoList()
    {
        // Faz a requisição para a rota de index
        $response = $this->actingAs(User::factory()->create())->get(route('autor.listar'));

        // Verifica se a resposta está correta
        $response->assertStatus(200);

        // Verifica se a view correta está sendo carregada
        $response->assertViewIs('autores.listar');

        // Verifica se os dados corretos estão sendo passados para a view
        $response->assertViewHas('autores');
    }
    
    public function testStoreCreatesAssuntoAndRedirectsWithSuccessMessage()
    {
        $user = User::factory()->create();
        $data = ['nome' => 'Novo Autor'];

        // Faz a requisição para a rota de store
        $response = $this->actingAs($user)->post(route('autor.cadastrar'), $data);

        // Verifica se o autor foi criado no banco de dados
        $this->assertDatabaseHas('autor', ['nome' => 'Novo Autor']);

        // Verifica se a resposta é um redirecionamento com a mensagem correta
        $response->assertStatus(302);
        $response->assertSessionHas('messageSystem', 'Autor cadastrado com sucesso!');
    }


    
}