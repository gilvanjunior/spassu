@extends('adminlte::page')

@section('title', 'Cadastro de Assuntos')

@section('content_header')
    <h1>Cadastro de assuntos</h1>
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

            <x-adminlte-button label="Cadastrar" id="btn_cadastrar_atualizar" type="submit" theme="success" icon="fas fa-save" class="mr-1" />
            <x-adminlte-button label="Cancelar" icon="fas fa-ban" onclick="location.href=''" />
        </form>
    </x-adminlte-card>

    <!-- <x-adminlte-card title="Listagem de livros" header-class="text-uppercase rounded-bottom" icon="fas fa-lg fa-book"
        class="shadow">

        <x-slot name="toolsSlot">
            <div class="input-group input-group-sm" style="width: 150px;">
                <div class="spinner-border mr-3 d-none" role="carregando_listar_livro"></div>
            </div>
        </x-slot>

        <table id="listar_livro" class="table table-responsive">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Assunto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tbody_listar_livro"></tbody>
        </table>
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
                    <input type="hidden" name="id" id="id" value="">
                    <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
                    <x-adminlte-button type="submit" theme="outline-success" label="Deletar" class="ml-2" />
                </form>
            </div>
        </x-slot>
    </x-adminlte-modal> -->
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('/assets/js/scriptsLivro.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
