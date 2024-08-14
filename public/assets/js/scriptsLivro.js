function limpaFormulario(){
    $("#autor_id").val("");
    $("#assunto_id").val("");
    $("#titulo").val("");
}

function preencherFormulario(){
    $('#titulo').val(titulo);
    $('#id_autor').val(id_autor);
    $('#id_assunto').val(id_assunto);
    $('#preco').val(preco);
}

$(document).ready(function() {
    preencherFormulario();
    $(".numeric").numeric({ decimalPlaces: 2 });
    if($("[name='hdn_id_autor[]']").length == 0){
        $('#tableAutor').hide();
    }
    if($("[name='hdn_id_assunto[]']").length == 0){
        $('#tableAssunto').hide();
    }
    
});

$(document).on('click', '#btn_novo_livro', function(){
    window.location = '/livro/cadastrar';
});

$('.editar').click(function(){
    window.location = '/livro/editar/' + $(this).data('id');
});

function validaForm() {
    if( $("[name='hdn_id_autor[]']").length == 0){
        mensagem = 'É necessário selecionar ao menos um autor';
        $('#modal_messagem_texto').text(mensagem); 
        $('#modal_mensagem').modal('toggle'); 

        return false;
    }

    if( $("[name='hdn_id_assunto[]']").length == 0){
        mensagem = 'É necessário selecionar ao menos um assunto';
        $('#modal_messagem_texto').text(mensagem); 
        $('#modal_mensagem').modal('toggle'); 

        return false;
    }
    $('#form_cadastrar_atualizar').submit();
    
}

function verificaAssuntosCadastrados(){
    $('#tableAssunto tbody tr').each(function() {
        var existingId = $(this).find('td:first').text();
        if (existingId == id) {
            exists = true;
            
            return false; // Interrompe o loop
        }
    });
}

function verificaAutoresCadastrados(){
    $('#tableAutor tbody tr').each(function() {
        var existingId = $(this).find('td:first').text();
        if (existingId == id) {
            exists = true;
            
            return false; // Interrompe o loop
        }
    });
}

$('#btn_adicionar_assunto').click(function() {
    $('#tableAssunto').show();
    var id = $('#id_assunto').val();
    var descricao = $('#id_assunto option:selected').text();
    var exists = false;
    
    if(id){
        $('#tableAssunto tbody tr').each(function() {
            var existingId = $(this).find('td:first').text();
            if (existingId == id) {
                exists = true;
                
                return false; // Interrompe o loop
            }
        });

        // Se o ID ja existe, exibe uma mensagem e não adiciona a linha
        if (exists) {
            $('#modal_messagem_texto').text('O assunto '+descricao+' já foi inserido.'); 
            $('#modal_mensagem').modal('toggle'); 
        } else {            

            var newRow = `
                <tr data-idassunto="${id}">
                    <td>${id}<input type="hidden" name="hdn_id_assunto[]" value="${id}"></td>
                    <td>${descricao}</td>
                    <td>
                        <x-adminlte-button class="btn btn-xs btn-default text-danger mx-1 shadow delete_livro_assunto" label="testar" icon="fas fa-danger"  title="Delete" data-idassunto="${id}" data-descricao="${descricao}" data-tipo="novo">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </x-adminlte-button>
                    </td>
                </tr>            
            `;

            $('#tableAssunto tbody').append(newRow);
        }
    }else{
        $('#modal_messagem_texto').text('Selecione um assunto.'); 
        $('#modal_mensagem').modal('toggle'); 
    }
    
});

$('#btn_adicionar_autor').click(function() {
    $('#tableAutor').show();
    var id = $('#id_autor').val();
    var nome = $('#id_autor option:selected').text();
    var exists = false;
    
    if(id){
        $('#tableAutor tbody tr').each(function() {
            var existingId = $(this).find('td:first').text();
            if (existingId == id) {
                exists = true;
                
                return false; // Interrompe o loop
            }
        });

        // Se o ID ja existe, exibe uma mensagem e não adiciona a linha
        if (exists) {
            $('#modal_messagem_texto').text('O autor '+nome+' já foi inserido.'); 
            $('#modal_mensagem').modal('toggle'); 
        } else {            

            var newRow = `
                <tr data-idautor="${id}">
                    <td>${id}<input type="hidden" name="hdn_id_autor[]" value="${id}"></td>
                    <td>${nome}</td>
                    <td>
                        <x-adminlte-button class="btn btn-xs btn-default text-danger mx-1 shadow delete_livro_autor" label="testar" icon="fas fa-danger"  title="Delete" data-idautor="${id}" data-descricao="${nome}" data-tipo="novo">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </x-adminlte-button>
                    </td>
                </tr>            
            `;

            $('#tableAutor tbody').append(newRow);
        }
    }else{
        $('#modal_messagem_texto').text('Selecione um autor.'); 
        $('#modal_mensagem').modal('toggle');        
    }
    
});

$(document).on('click', '.delete_livro_autor', function(){
    
    
    if($(this).data('tipo') == "novo"){
        $("tr[data-idautor='"+$(this).data('idautor')+"']").remove();
    }else{
        let id = $(this).data('id');
        let nome = $(this).data('nome');
        $('#modal_nome_autor').text(nome);
        $('#id_livro_autor').val(id);
        $('#modal_delete_livro_autor').modal('toggle'); 
    }
    
});

$(document).on('click', '.delete_livro_assunto', function(){
    if($(this).data('tipo') == "novo"){
        $("tr[data-idassunto='"+$(this).data('idassunto')+"']").remove();
    }else{
        let idAssunto = $(this).data('idassunto');
        let idlivro = $(this).data('idlivro');
        let descricao = $(this).data('descricao');
        $('#modal_descrica_assunto').text(descricao);
        $('#modal_id_assunto').val(idAssunto);
        $('#modal_id_livro_assunto').val(idlivro);
    }
});


