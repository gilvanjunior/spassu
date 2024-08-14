<?php

namespace App\Http\Controllers;

use App\Models\LivroAutor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class LivroAutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $livroAutores = LivroAutor::with(['livro', 'autor'])->get();
        return view('livro_autor.index', compact('livroAutores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('livro_autor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livro,id',
            'autor_id' => 'required|exists:autor,id',
        ]);

        LivroAutor::create($request->all());

        return redirect()->route('livro_autor.index')
                         ->with('success', 'Relacionamento Livro-Autor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LivroAutor $livroAutor): View
    {
        return view('livro_autor.show', compact('livroAutor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LivroAutor $livroAutor): View
    {
        return view('livro_autor.edit', compact('livroAutor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LivroAutor $livroAutor): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livro,id',
            'autor_id' => 'required|exists:autor,id',
        ]);

        $livroAutor->update($request->all());

        return redirect()->route('livro_autor.index')
                         ->with('success', 'Relacionamento Livro-Autor atualizado com sucesso!');
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(Request $request): RedirectResponse
    {
        $livroAutor = LivroAutor::query()
                ->where('id_livro', '=', $request->id)
                ->where('id_autor', '=', $request->id_autor)
                ->first();

        $notification = $this->destroy($livroAutor);

        return redirect()->action(
            [LivroController::class, 'edit'], ['id' => $livroAutor->id_livro]
        )->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LivroAutor $livroAutor): array
    {
        try {
            DB::BeginTransaction();

            $livroAutor->delete();

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Autor excluído com sucesso!',
                'type' => 'bg-success',
            ];

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao exluir assunto do livro. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];                      
        }

        return $notification ;
    }
}
