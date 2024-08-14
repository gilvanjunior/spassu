<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Assunto;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class AssuntoTest extends TestCase
{

    public function testIndexDisplaysAssuntoList()
    {
        // Faz a requisição para a rota de index
        $response = $this->actingAs(User::factory()->create())->get(route('assunto.listar'));

        // Verifica se a resposta está correta
        $response->assertStatus(200);

        // Verifica se a view correta está sendo carregada
        $response->assertViewIs('assuntos.listar');

        // Verifica se os dados corretos estão sendo passados para a view
        $response->assertViewHas('assuntos');
    }
    
    public function testStoreCreatesAssuntoAndRedirectsWithSuccessMessage()
    {
        $user = User::factory()->create();
        $data = ['descricao' => 'Novo Assunto'];

        // Faz a requisição para a rota de store
        $response = $this->actingAs($user)->post(route('assunto.cadastrar'), $data);

        // Verifica se o assunto foi criado no banco de dados
        $this->assertDatabaseHas('assunto', ['descricao' => 'Novo Assunto']);

        // Verifica se a resposta é um redirecionamento com a mensagem correta
        $response->assertStatus(302);
        $response->assertSessionHas('messageSystem', 'Assunto cadastrado com sucesso!');
    }


    
}