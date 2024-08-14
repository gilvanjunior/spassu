<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAutorRequest;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\LivroAutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Level;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Auth;

class AutorController extends Controller
{

    protected $autor;
    protected $livro;
    protected $livroAutor;

    public function __construct(Autor $autor, Livro $livro, LivroAutor $livroAutor)
    {
        $this->middleware('auth');
        $this->livro      = $livro;
        $this->autor      = $autor;
        $this->livroAutor = $livroAutor;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $autores = $this->autor->get();

        return view('autores.listar', compact('autores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    private function create($request): array|bool
    {
        try {
            DB::BeginTransaction();

            $autor = $this->autor::create([
                'nome' => $request->input('nome')               
            ]); 

            if (!$autor) {
                return false;
            }

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Autor cadastrado com sucesso!',
                'type' => 'bg-success',
            ];
            

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao cadastrar o Autor. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Autor", Level::Error);            
        }

        return $notification;
    }

    private function verificaExisteAutor($request): array|bool
    {
        
        if (Autor::where('nome', $request->input('nome') )->exists()) {
            $notification = [
                'title' => 'Aviso',
                'messageSystem' => 'O autor ' . $request->input('nome') . ' já está cadastrado!',
                'type' => 'bg-warning',
            ];   
            return $notification;         
        }  

        return false;
    }

    public function store(StoreAutorRequest $request): JsonResponse|RedirectResponse
    {
        
        $notificationExisteAutor = $this->verificaExisteAutor($request);
        if ($notificationExisteAutor) 
            $notificacao = $notificationExisteAutor;
        

        $notificationAutorCreate = $this->create($request);
        if ($notificationAutorCreate) 
            $notificacao = $notificationAutorCreate;

        return redirect()->action([AutorController::class, 'index'])->with($notificacao);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        $autor = null;
        
        if($request->id)
            $autor = $this->autor->find($request->id);

        return view('autores.create', compact(['autor']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            DB::BeginTransaction();

            $autor = $this->autor::where('id', $request->id)->update([
                'nome' => $request->input('nome')
            ]);

            if ($autor) {

                DB::commit();

                $notification = [
                    'title' => 'Sucesso',
                    'messageSystem' => 'Autor alterado com sucesso!',
                    'type' => 'bg-success',
                ];
                return redirect()->action([AutorController::class, 'index'])->with($notification);
            }

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao alterar autor. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Autor", Level::Error);
            return back()->with($notification);
        }
    }

    public function verificaExisteLivrosAutor($request): array|bool
    {
        $totalLivros = $this->livroAutor::where('id_autor', $request->id)->count();
        if($totalLivros > 0){
            $notification = [
                'title' => 'Aviso',
                'messageSystem' => 'Erro ao deletar. Existem ' . $totalLivros . ' livros cadastrados para este autor.',
                'type' => 'bg-warning',
            ];            
            $this->registerLog($notification['messageSystem'], "Autor", Level::Warning);
            return $notification;
        }

        return false;
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(Request $request): RedirectResponse
    {

        $notificationExisteLivro = $this->verificaExisteLivrosAutor($request);
        if($notificationExisteLivro)
            return back()->with($notificationExisteLivro);

        $notificationDeleteAutor = $this->destroy($request);
        if($notificationDeleteAutor)
            return back()->with($notificationDeleteAutor);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request): array
    {
        try {
            DB::BeginTransaction();

            $this->autor::where('id', $request->id)->delete();

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Autor deletado com sucesso!',
                'type' => 'bg-success',
            ];

            $this->registerLog($notification['messageSystem'].' - id:'.$request->id, "Autor", Level::Warning);

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao deletar autor. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Autor", Level::Error);            
        }

        return $notification;
    }
}
