@extends('adminlte::page')

@section('title', 'Cadastro de Livro')

@section('content_header')
    <h1>{{ $livro ? 'Alterar' : 'Cadastrar' }} Livro</h1>
@stop
{{-- Setup data for datatables --}}
@php
$headsAutor = [
    ['label' => 'ID', 'width' => 5],
    'Nome',
    ['label' => 'Ações', 'no-export' => true, 'width' => 3],
];
$headsAssunto = [
    ['label' => 'ID', 'width' => 5],
    'Descrição',
    ['label' => 'Ações', 'no-export' => true, 'width' => 3],
];

$configAutor['data'] = [];
$configAssunto['data'] = [];

if($livro && $livro->autor()->exists()){
    foreach($livro->autor as $autor){
        $hiddenIdAutor = '<input type="hidden" name="hdn_id_autor[]" value="'.$autor->id.'">';
        $btnDelete = '<x-adminlte-button class="btn btn-xs btn-default text-danger mx-1 shadow delete_livro_autor" label="testar" icon="fas fa-danger"  title="Delete" data-idautor="'.$autor->id.'"  data-idlivro="'.$livro->id.'" data-nome="'.$autor->nome.'" data-tipo="banco">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                      </x-adminlte-button>';
        $configAutor['data'][] = [$autor->id.$hiddenIdAutor, $autor->nome, '<nobr>'.$btnDelete.'</nobr>'];
    }
}

if($livro && $livro->assunto()->exists()){
    foreach($livro->assunto as $assunto){
        $hiddenIdAssunto = '<input type="hidden" name="hdn_id_assunto[]" value="'.$assunto->id.'">';
        $btnDelete = '<x-adminlte-button class="btn btn-xs btn-default text-danger mx-1 shadow delete_livro_assunto" label="testar" icon="fas fa-danger"  title="Delete" data-idassunto="'.$assunto->id.'"  data-idlivro="'.$livro->id.'" data-descricao="'.$assunto->descricao.'"data-tipo="banco">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                      </x-adminlte-button>';
                    
        $configAssunto['data'][] = [$assunto->id.$hiddenIdAssunto, $assunto->descricao, '<nobr>'.$btnDelete.'</nobr>'];
    }
}

@endphp

@section('content')
    <x-adminlte-card class="shadow">
        @if (session('message'))
            <x-adminlte-alert theme="{{ session('type') }}" icon="" dismissable>
                {{ session('message') }}
            </x-adminlte-alert>
        @endif

        <form action="" id="form_cadastrar_atualizar" method="POST">
            @csrf            
            <div class="row">               
                
                <div class="col-sm-6">
                    <x-adminlte-input type="text" name="titulo" id="titulo" label="Titulo" placeholder="Título" enable-old-support></x-adminlte-input>
                </div>
                <div class="col-sm-6">
                    <x-adminlte-input class="numeric" type="text" name="preco" id="preco" label="Preço" placeholder="Preço" enable-old-support>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            R$
                        </div>
                    </x-slot>
                    </x-adminlte-input>                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-adminlte-select class="form-control" name="id_autor" label="Autor">
                        <option class="d-none" value="">Selecione um autor</option>
                        @forelse ($autores as $autor)
                            <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
                        @empty
                            <option value="">Nenhum livro cadastrado</option>
                        @endforelse
                    </x-adminlte-select>                    
                </div>
                <div class="col-sm-2"><div>&nbsp;</div>
                    <x-adminlte-button style="margin-top: 8px;" label="Adicionar autor" id="btn_adicionar_autor" theme="primary" icon="fas fa-plus" class="mr-1" />
                </div>
            </div>            
            <div class="row">
                <x-adminlte-datatable id="tableAutor" head-theme="dark" :heads="$headsAutor">
                    
                    @foreach($configAutor['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-adminlte-select class="form-control" name="id_assunto" label="Assunto" enable-old-support>
                        <option class="d-none" value="">Selecione um Assunto</option>
                        @forelse ($assuntos as $assunto)
                            <option value="{{ $assunto->id }}">{{ $assunto->descricao }}</option>                            
                        @empty
                            <option value="">Nenhum assunto vinculado</option>
                        @endforelse
                    </x-adminlte-select>                    
                </div>
                <div class="col-sm-2"><div>&nbsp;</div>
                    <x-adminlte-button style="margin-top: 8px;" label="Adicionar assunto" id="btn_adicionar_assunto" theme="primary" icon="fas fa-plus" class="" />
                </div>
            </div>
            <div class="row">
                <x-adminlte-datatable id="tableAssunto"  head-theme="dark" :heads="$headsAssunto">                    
                    @foreach($configAssunto['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach 
                </x-adminlte-datatable>
            </div>
            @if($livro)
                <x-adminlte-button label="Salvar" id="btn_cadastrar_atualizar" onclick="validaForm()" theme="success" icon="fas fa-save" class="mr-1" />
            @else
                <x-adminlte-button label="Cadastrar" id="btn_cadastrar_atualizar" onclick="validaForm()" theme="success" icon="fas fa-save" class="mr-1" />                
            @endif   
            <x-adminlte-button label="Cancelar" icon="fas fa-ban" onclick="location.href='/livro/listar'" />
            <div id="autor-delete"></div>
            <div id="assunto-delete"></div>
        </form>
    </x-adminlte-card>
    <x-adminlte-modal id="modal_delete_livro_autor" title="Exclusão de Registro" theme="danger" icon="fas fa-trash"
        static-backdrop>
        <p class="text-center">O autor <strong><span id="modal_nome_autor"></span></strong> será desvinculado do livro. <br> Deseja realmente executar esta ação?</p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <form action="/livroautor/deletar-autor-livro" method="POST" id="form_delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_autor" id="modal_id_autor" value="">
                    <input type="hidden" name="id" id="modal_id_livro_autor" value="">
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
                    <x-adminlte-button type="submit" theme="outline-success" label="Deletar" class="ml-2" />
                </form>
            </div>
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modal_delete_livro_asunto" title="Exclusão de Registro" theme="danger" icon="fas fa-trash"
        static-backdrop>
        <p class="text-center">O assunto <strong><span id="modal_descrica_assunto"></span></strong> será desvinculado. <br> Deseja realmente executar esta ação?</p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <form action="/livroassunto/deletar-assunto-livro" method="POST" id="form_delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_assunto" id="modal_id_assunto" value="">
                    <input type="hidden" name="id" id="modal_id_livro_assunto" value="">
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
                    <x-adminlte-button type="submit" theme="outline-success" label="Deletar" class="ml-2" />
                </form>
            </div>
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modal_mensagem" title="Alerta" theme="warning" icon="fas fa-warning"
        static-backdrop>
        <p class="text-center" id="modal_messagem_texto"></p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <x-adminlte-button theme="primary" label="Ok" data-dismiss="modal" />
            </div>
        </x-slot>
    </x-adminlte-modal>
@stop

@section('css')
@stop

@section('js')
    <script>
        let titulo = "{{ $livro ? $livro->titulo : '' }}";
        let id_autor = "{{ $livro ? $livro->id_autor : '' }}";
        let id_assunto = "{{ $livro ? $livro->id_assunto : '' }}";
        let preco = "{{ $livro ? $livro->preco : '' }}";
    </script>
    <script src="{{ asset('/assets/js/jquery.numeric.js') }}"></script>
    
    <script src="{{ asset('/assets/js/scriptsLivro.js') }}"></script>  
      
    @if(Session::has('messageSystem'))
    <script>
    let title = "<strong>{{ Session::get('title') }}</strong>";
    let body = "{{ Session::get('messageSystem') }}";
    let type = "{{ Session::get('type') }}";
    $(document).ready(function() {
        $(document).Toasts('create', {
            title: title,
            body: body,
            class: type,
            autohide: true,
            delay: 5000
        });
    });
    </script>
    @endif
@stop
