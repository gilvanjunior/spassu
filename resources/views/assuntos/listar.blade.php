@extends('adminlte::page')

@section('title', 'Lista de assuntos')

@section('plugins.Datatables', true)

@section('content_header')
    <h1>Lista de assuntos</h1>
@stop

{{-- Setup data for datatables --}}
@php
$heads = [
    'ID',
    'Nome',    
    ['label' => 'Ações', 'no-export' => true, 'width' => 3],
];
$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
$config['data'] = [];

foreach($assuntos as $assunto){
    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow editar" title="Edit" data-id="'.$assunto->id.'">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow delete" title="Delete" data-id="'.$assunto->id.'" data-nome="'.$assunto->nome.'" data-toggle="modal" data-target="#modal_delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
    $config['data'][] = [$assunto->id, $assunto->descricao, '<nobr>'.$btnEdit.$btnDelete.'</nobr>'];
}

@endphp

@section('content')
    <div class="row">
        <div class="col-sm-10">&nbsp;</div>
        <div class="col-sm-2">
            <x-adminlte-button label="Novo assunto" id="btn_novo_assunto" type="buttom" theme="primary" icon="fas fa-book" class="mr-6" />
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
        <p class="text-center">O assunto <strong><span id="modal_nome"></span></strong> será deletado da base de
            dados. <br> Deseja realmente executar esta ação?</p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <form action="deletar" method="POST" id="form_delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="assunto_id" value="">
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
    <script src="{{ asset('/assets/js/scriptsAssunto.js') }}"></script>
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
