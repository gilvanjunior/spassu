<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class LivroTest extends TestCase
{

    public function testIndexDisplaysLivroList()
    {
        // Faz a requisição para a rota de index
        $response = $this->actingAs(User::factory()->create())->get(route('livro.listar'));

        // Verifica se a resposta está correta
        $response->assertStatus(200);

        // Verifica se a view correta está sendo carregada
        $response->assertViewIs('livros.listar');

        // Verifica se os dados corretos estão sendo passados para a view
        $response->assertViewHas('livros');
    }
    
    public function testStoreCreatesLivroAndRedirectsWithSuccessMessage()
    {
        $user = User::factory()->create();
        $data = ['titulo' => 'Novo livro', 'id_autor' => 3, 'id_assunto' => 3, 'preco' => 5];

        // Faz a requisição para a rota de store
        $response = $this->actingAs($user)->post(route('livro.cadastrar'), $data);

        // Verifica se o livro foi criado no banco de dados
        $this->assertDatabaseHas('livro', ['titulo' => 'Novo livro']);

        // Verifica se a resposta é um redirecionamento com a mensagem correta
        $response->assertStatus(302);
        $response->assertSessionHas('messageSystem', 'livro cadastrado com sucesso!');
    }

    public function testDeleteRemovesLivroAndRedirectsWithSuccessMessage()
    {
        $user = User::factory()->create();     
        $data = ['titulo' => 'Novo livro', 'id_autor' => 3, 'id_assunto' => 3, 'preco' => 5];   
        $livro = Livro::factory()->create($data);

        // Faz a requisição para a rota de delete
        $response = $this->actingAs($user)->delete(route('livro.deletar', $livro->id));

        // Verifica se o assunto foi removido do banco de dados
        $this->assertDatabaseMissing('livro', ['id' => $livro->id]);

        // Verifica se a resposta é um redirecionamento com a mensagem correta
        $response->assertStatus(302);
        $response->assertSessionHas('messageSystem', 'livro deletado com sucesso!');
    }
    
}