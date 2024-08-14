@extends('adminlte::page')

@section('title', 'Lista de livros')

@section('plugins.Datatables', true)

@section('content_header')
    <h1>Lista de livros</h1>
@stop

{{-- Setup data for datatables --}}
@php
$heads = [
    'ID',
    'Título',
    'Preço',
    ['label' => 'Ações', 'no-export' => true, 'width' => 3],
];
$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, ['orderable' => false]],
];
$config['data'] = [];

foreach($livros as $livro){
    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow editar" title="Edit" data-id="'.$livro->id.'">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow delete" title="Delete" data-id="'.$livro->id.'" data-nome="'.$livro->nome.'" data-toggle="modal" data-target="#modal_delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
    $preco = 'R$ '.number_format($livro->preco,2);
    $config['data'][] = [$livro->id, $livro->titulo, $preco, '<nobr>'.$btnEdit.$btnDelete.'</nobr>'];
}

@endphp

@section('content')
    <div class="row">
        <div class="col-sm-10">&nbsp;</div>
        <div class="col-sm-2">
            <x-adminlte-button label="Novo livro" id="btn_novo_livro" type="buttom" theme="primary" icon="fas fa-book" class="mr-6" />
        </div>
    </div>
    <br>
    <x-adminlte-card class="shadow">
        @if (session('message'))
            <x-adminlte-alert theme="{{ session('type') }}" icon="" dismissable>
                {{ session('message') }}
            </x-adminlte-alert>
        @endif

        
    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1"  head-theme="dark" :heads="$heads">
        @foreach($config['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach
    </x-adminlte-datatable>
    </x-adminlte-card>
    <x-adminlte-modal id="modal_delete" title="Exclusão de Registro" theme="danger" icon="fas fa-trash"
        static-backdrop>
        <p class="text-center">O livro <strong><span id="modal_nome"></span></strong> será deletado da base de
            dados. <br> Deseja realmente executar esta ação?</p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <form action="deletar" method="POST" id="form_delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="livro_id" value="">
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
                    <x-adminlte-button type="submit" theme="outline-success" label="Deletar" class="ml-2" />
                </form>
            </div>
        </x-slot>
    </x-adminlte-modal>
@stop

@section('css')
@stop

@section('js')
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
