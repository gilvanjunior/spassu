<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;

class HomeController extends Controller
{

    protected $livro;
    protected $autor;
    protected $assunto;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Livro $livro, Autor $autor, Assunto $assunto)
    {
        $this->livro = $livro;
        $this->autor = $autor;
        $this->assunto = $assunto;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $livros = $this->livro->get();
        $autores = $this->autor->get();
        $assuntos = $this->assunto->get();
        $totalValorlivros = $this->retornaTotalValorLivros();
        return view('home', compact(['livros','autores','assuntos', 'totalValorlivros']));        
    }

    public function retornaTotalValorLivros(){        
        $valor = $this->livro::sum('preco');        
        return number_format($valor, 2, ',', '.');;                 
    }
}
