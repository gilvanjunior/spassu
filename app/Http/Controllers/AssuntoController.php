<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssuntoRequest;
use App\Models\Assunto;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Level;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AssuntoController extends Controller
{

    protected $assunto;
    protected $livro;

    public function __construct(Assunto $assunto, Livro $livro)
    {
        $this->middleware('auth');
        $this->livro = $livro;
        $this->assunto = $assunto;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $assuntos = $this->assunto->get();

        return view('assuntos.listar', compact('assuntos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    function create(Request $request): array|bool
    {
        try {
            DB::BeginTransaction();

            $assunto = $this->assunto::create([
                'descricao' => $request->input('descricao')               
            ]); 

            if (!$assunto) {
                return false;
            }

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Assunto cadastrado com sucesso!',
                'type' => 'bg-success',
            ];

        } catch (\Exception $e) {
            DB::rollback();
            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao cadastrar o Assunto. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Assunto", Level::Error);
        }

        return $notification;
    }

    public function verificaExisteAssunto($request): array|bool
    {
        
        if (Assunto::where('descricao', $request->input('descricao') )->exists()) {
            $notification = [
                'title' => 'Aviso',
                'messageSystem' => 'o assunto ' . $request->input('descricao') . ' já está cadastrado!',
                'type' => 'bg-warning',
            ];   
            return $notification;         
        }  

        return false;
    }

    public function store(StoreAssuntoRequest $request): JsonResponse|RedirectResponse
    {
        $notificationExisteAssunto = $this->verificaExisteAssunto($request);
        if ($notificationExisteAssunto) 
            $notificacao = $notificationExisteAssunto;

        $notificationAssuntoCreate = $this->create($request);
        if ($notificationAssuntoCreate) 
            $notificacao = $notificationAssuntoCreate;

        return redirect()->action([AssuntoController::class, 'index'])->with($notificacao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        $assunto = null;
        
        if($request->id)
            $assunto = $this->assunto->find($request->id);

        return view('assuntos.create', compact(['assunto']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        
        try {
            DB::BeginTransaction();

            $assunto = $this->assunto::where('id', $request->id)->update([
                'descricao' => $request->input('descricao')
            ]);

            if ($assunto) {

                DB::commit();

                $notification = [
                    'title' => 'Sucesso',
                    'messageSystem' => 'Assunto alterado com sucesso!',
                    'type' => 'bg-success',
                ];
            }

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao alterar assunto. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
        }

        return redirect()->action([AssuntoController::class, 'index'])->with($notification);
    }

    public function verificaExisteLivrosAssunto($request): array|bool
    {
        $totalLivros = $this->livro::where('id_assunto', $request->id)->count();
        if($totalLivros > 0){
            $notification = [
                'title' => 'Aviso',
                'messageSystem' => 'Erro ao deletar. Existem ' . $totalLivros . ' livros cadastrados para este assunto.',
                'type' => 'bg-warning',
            ];            
            $this->registerLog($notification['messageSystem'], "Assunto", Level::Warning);
            return $notification;
        }

        return false;
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(Request $request): RedirectResponse
    {

        $notificationExisteLivro = $this->verificaExisteLivrosAssunto($request);
        if($notificationExisteLivro)
            return back()->with($notificationExisteLivro);

        $notificationDeleteAssunto = $this->destroy($request);
        if($notificationDeleteAssunto)
            return back()->with($notificationDeleteAssunto);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): array
    {
        try {
            DB::BeginTransaction();

            $this->assunto::where('id', $request->id)->delete();

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Assunto deletado com sucesso!',
                'type' => 'bg-success',
            ];

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao deletar assunto. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Assunto", Level::Error);            
        }

        return $notification;
    }
}
