<?php

namespace App\Http\Controllers;

use App\Models\LivroAssunto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class LivroAssuntoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $livroAssuntos = LivroAssunto::with(['livro', 'assunto'])->get();
        return view('livro_assunto.index', compact('livroAssuntos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('livro_assunto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livro,id',
            'assunto_id' => 'required|exists:assunto,id',
        ]);

        LivroAssunto::create($request->all());

        return redirect()->route('livro_assunto.index')
                         ->with('success', 'Relacionamento Livro-Assunto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LivroAssunto $livroAssunto): View
    {
        return view('livro_assunto.show', compact('livroAssunto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LivroAssunto $livroAssunto): View
    {
        return view('livro_assunto.edit', compact('livroAssunto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LivroAssunto $livroAssunto): RedirectResponse
    {
        $request->validate([
            'livro_id' => 'required|exists:livro,id',
            'assunto_id' => 'required|exists:assunto,id',
        ]);

        $livroAssunto->update($request->all());

        return redirect()->route('livro_assunto.index')
                         ->with('success', 'Relacionamento Livro-Assunto atualizado com sucesso!');
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(Request $request): RedirectResponse
    {
        $livroAssunto = LivroAssunto::query()
                ->where('id_livro', '=', $request->id)
                ->where('id_assunto', '=', $request->id_assunto)
                ->first();

        $notification = $this->destroy($livroAssunto);

        return redirect()->action(
            [LivroController::class, 'edit'], ['id' => $livroAssunto->id_livro]
        )->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LivroAssunto $livroAssunto): array
    {
        try {
            DB::BeginTransaction();

            $livroAssunto->delete();

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Assunto excluído com sucesso!',
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
