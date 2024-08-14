@extends('adminlte::page')

@section('title', 'Cadastro de assuntos')

@section('content_header')
    <h1>{{ $assunto ? 'Alterar' : 'Cadastrar' }} assunto</h1>
@stop

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
                    <x-adminlte-input type="text" name="descricao" id="descricao" label="Descrição" placeholder="Descrição do assunto" enable-old-support></x-adminlte-input>
                </div>
            </div>
            @if($assunto)
                <x-adminlte-button label="Salvar" id="btn_cadastrar_atualizar" type="submit" theme="success" icon="fas fa-save" class="mr-1" />
            @else
                <x-adminlte-button label="Cadastrar" id="btn_cadastrar_atualizar" type="submit" theme="success" icon="fas fa-save" class="mr-1" />                
            @endif   
            <x-adminlte-button label="Cancelar" icon="fas fa-ban" onclick="location.href='/assunto/listar'" />
        </form>
    </x-adminlte-card>
    <x-adminlte-modal id="modal_delete" title="Exclusão de Registro" theme="danger" icon="fas fa-trash"
        static-backdrop>
        <p class="text-center">Conta de numero <strong><span id="modal_nome"></span></strong> será deletado da base de
            dados. <br> Deseja realmente executar esta ação?</p>
        <x-slot name="footerSlot">
            <div class="justify-content-end">
                <form action="" method="POST" id="form_delete">
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
    <script>
        let descricao = "{{ $assunto ? $assunto->descricao : null }}";
    </script>
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
