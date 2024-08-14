function limpaFormulario(){
    $("#descricao").val("");
}

function preencherFormulario(){
    $('#descricao').val(descricao);
}

$(document).ready(function() {
    preencherFormulario();
});

$(document).on('click', '#btn_novo_assunto', function(){
    window.location = '/assunto/cadastrar';
});

$('.editar').click(function(){
    window.location = '/assunto/editar/' + $(this).data('id');
});

$(document).on('click', '.delete', function(){
    let id = $(this).data('id');
    let nome = $(this).data('nome');
    $('#modal_nome').text(nome);
    $('#assunto_id').val(id);
});