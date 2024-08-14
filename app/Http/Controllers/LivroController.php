<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLivroRequest;
use App\Models\LivroAssunto;
use App\Models\LivroAutor;
use Monolog\Level;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LivroController extends Controller
{
    protected $livro;
    protected $autor;
    protected $assunto;
    protected $livroAutor;
    protected $livroAssunto;

    public function __construct(Livro $livro, Autor $autor, Assunto $assunto, LivroAutor $livroAutor,LivroAssunto $livroAssunto)
    {
        $this->livro = $livro;
        $this->autor = $autor;
        $this->assunto = $assunto;
        $this->livroAssunto = $livroAssunto;
        $this->livroAutor = $livroAutor;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        
        $livros = $this->livro->get();
        $autores = $this->autor->get();
        $assuntos = $this->assunto->get();
        $livroAssuntos = $this->livroAssunto->get();

        return view('livros.listar', compact(['livros','autores','assuntos']));
    }

    public function store(StoreLivroRequest $request): RedirectResponse
    {
        try {
            DB::BeginTransaction();
            if(!$request->input('id_assunto')){
                $notification = [
                    'title' => 'Erro',
                    'messageSystem' => 'Selecione ao menos um assunto!',
                    'type' => 'bg-danger',
                ];
                return redirect()->action([LivroController::class, 'index'])->with($notification);
            }

            if(!$request->input('id_autor')){
                $notification = [
                    'title' => 'Erro',
                    'messageSystem' => 'Selecione ao menos um autor!',
                    'type' => 'bg-danger',
                ];
                return redirect()->action([LivroController::class, 'index'])->with($notification);
            }

            $livro = $this->livro::create([
                'titulo'        => $request->input('titulo'),
                'preco'         => $request->input('preco'),
            ]); 

            if ($livro) {
                foreach($request->input('hdn_id_autor') as $id_autor){
                    $this->livroAutor::create([
                        'id_livro'  => $livro->id,
                        'id_autor'  => $id_autor,
                    ]);
                }
    
                foreach($request->input('hdn_id_assunto') as $id_assunto){
                    $this->livroAssunto::create([
                        'id_livro'      => $livro->id,
                        'id_assunto'    => $id_assunto,
                    ]);
                }

                DB::commit();

                $notification = [
                    'title' => 'Sucesso',
                    'messageSystem' => 'livro cadastrado com sucesso!',
                    'type' => 'bg-success',
                ];                
            }

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao cadastrar Livro. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];            
        }

        return redirect()->action([LivroController::class, 'index'])->with($notification);
    }

    public function listarLivro(): JsonResponse
    {
        try {

            $livros = $this->livro->get();

            $res = [
                'status' => true,
                'data' => $livros,
            ];
            return response()->json($res);
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'error' => [
                    'title' => 'Erro!',
                    'message' => 'Erro ao listar contas. Código de erro: ' . $e->getMessage(),
                    'type' => 'bg-danger',
                ]
            ];
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request): View
    {
        $livro = null;
        $autores = $this->autor->get();
        $assuntos = $this->assunto->get();
        
        if($request->id){
            $livro = Livro::with(['assunto', 'autor'])->findOrFail($request->id);
        }    

        return view('livros.create', compact(['livro','autores','assuntos']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        
        try {
            DB::BeginTransaction();

            $livro = $this->livro::where('id', $request->id)->update([
                'titulo' => $request->input('titulo'),
                'preco'         => $request->input('preco'),                
            ]);

            if ($livro) {

                DB::commit();

                $notification = [
                    'title' => 'Sucesso',
                    'messageSystem' => 'Livro alterado com sucesso!',
                    'type' => 'bg-success',
                ];
                return back()->with($notification);               
            }

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao alterar livro. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            return back()->with($notification);          
        }
    }

    /**
     * Delete the specified resource in storage.
     */
    public function delete(Request $request): RedirectResponse
    {
        $notification = $this->destroy($request);
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): array
    {
        try {
            DB::BeginTransaction();

            $this->livro::where('id', $request->id)->delete();

            DB::commit();

            $notification = [
                'title' => 'Sucesso',
                'messageSystem' => 'Livro deletado com sucesso!',
                'type' => 'bg-success',
            ];

        } catch (\Exception $e) {
            DB::rollback();

            $notification = [
                'title' => 'Erro do Sistema',
                'messageSystem' => 'Erro ao deletar livro. Código de erro: '. $e->getMessage(),
                'type' => 'bg-danger',
            ];
            $this->registerLog($notification['messageSystem'], "Livro", Level::Error);            
        }

        return $notification;
    }
}


?>