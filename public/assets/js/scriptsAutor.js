function limpaFormulario(){
    $("#autor_id").val("");
    $("#assunto_id").val("");
    $("#titulo").val("");
}

function preencherFormulario(){
    $('#nome').val(nome);
}

$(document).ready(function() {
    preencherFormulario();
});

$(document).on('click', '#btn_novo_autor', function(){
    window.location = '/autor/cadastrar';
});

$('.editar').click(function(){
    window.location = '/autor/editar/' + $(this).data('id');
});

$(document).on('click', '.delete', function(){
    let id = $(this).data('id');
    let nome = $(this).data('nome');
    $('#modal_nome').text(nome);
    $('#autor_id').val(id);
});