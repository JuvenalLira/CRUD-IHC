$(document).ready(function(){
    var page = $('meta[name=base]').attr('content');

    //Consulta cliente
    $('body').on('click', "#btn_search", function(e){
        e.preventDefault();

        var form = $("#form_search");
        var form_data = form.serialize();

        var url = page+"Ajax/clientes/Read.php";
		
        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {

                if (data['status'] == 'success') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-user"></i> '+data['message']+'</div></div></div>');

                } else if (data['status'] == 'info') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-info-circle"></i>  '+data['message']+'</div></div></div>');

                } else if (data['status'] == 'warning') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-triangle-exclamation"></i>  '+data['message']+'</div></div></div>');

                } else {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-times-circle"></i>  '+data['message']+'</div></div></div>');
                }

                setTimeout(function () {
                    $('#status-container').hide();
                    $('.loading').css('display', 'none');

                }, 3000);

                if(data['Lines'] == 0){
                    $('.row').html('');
                    return false;
                }

                var register = data['cliente_cadastro'];
                var stats = data['cliente_status'];

                var mount = '<tr></tr><td><p clas="font-text-sub"><b>Cliente:</b></p><p>'+data['cliente_nome']+'</p></td>\n'+
                '<td><p class="font-text-sub"><b>Cadastrado:</b></p><p>'+register+'</p></td>\n'+
                '<td><p class="font-text-sub"><b>E-mail:</b></p><p>'+data['cliente_email']+'</p></td>\n'+
                '<td><p class="font-text-sub"><b>Status:</b></p><p class="font-text-sub">'+stats+'</p></td>\n'+
                '<td><p class="text-center"><a href="#" title="Visualizar e editar informações" class="radius btn_edit editClient" data-id="'+data['cliente_id']+'"><i class="fa fa-pen"></i></a>&nbsp;&nbsp;<a href="#" title="Remover este registro" class= "radius btn_delete deleteClient" data-id="'+data['cliente_id']+'"><i class="fa fa-trash-alt"></i></a></p></td><tr>'
                
                $('.row').html(mount);

            }

        });
    });

    //Deletar cliente
    $(document).on('click', ".deleteClient", function(e){
        e.preventDefault();

        var value = $(this).attr('data-id');

        var url = page+"Ajax/clientes/Delete.php?val="+value;
		
        $.ajax({
            url: url,
            type: 'POST',
            data: value,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {

                if (data['status'] == 'success') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-user"></i> '+data['message']+'</div></div></div>');

                } else if (data['status'] == 'info') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-info-circle"></i>  '+data['message']+'</div></div></div>');

                } else if (data['status'] == 'warning') {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-triangle-exclamation"></i>  '+data['message']+'</div></div></div>');

                } else {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-' + data['status'] + '"><div class="status-message"><i class="fa fa-times-circle"></i>  '+data['message']+'</div></div></div>');
                }

                setTimeout(function () {
                    $('#status-container').hide();
                    $('.loading').css('display', 'none');

                    if(data['redirect'] !== ''){
                        window.location.href = data['redirect'];
                    }

                }, 3000);


            }

        });
    });

    //Criar cliente
    $("#form_clientNew").on('submit', function (e) {
        e.preventDefault();
	
		var form = $("#form_clientNew");
		var url = page+"Ajax/clientes/Create.php";
		
        form.ajaxSubmit({
            url: url,
            data: form,
            dataType: 'json',
			contentType: false,
            processData: false,
         
            success: function (data) {
               if(data['status'] == 'success'){
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-'+data['status']+'"><div class="status-message"> <span class="fa fa-check-circle"></span>  '+data['message']+'</div></div></div>');

                }else if(data['status'] == 'info'){
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-'+data['status']+'"><div class="status-message"> <span class="fa fa-info-circle"></span>  '+data['message']+'</div></div></div>');

                }else if(data['status'] == 'warning'){
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-'+data['status']+'"><div class="status-message"> <span class="fa fa-triangle-exclamation"></span>  '+data['message']+'</div></div></div>');

                } else {
                    $(".result").text('');
                    $(".result").prepend('<div id="status-container" class="status-top-right text-center"><div class="status status-'+data['status']+'"><div class="status-message"> <span class="fa fa-times-circle"></span>  '+data['message']+'</div></div></div>');
                }

                setTimeout(function () {
                    $('#status-container').hide();
                    $('.loading').hide();
					
                    if(data['redirect'] != ''){
                        window.location.href= data['redirect'];
                    }
                }, 3000); 
            }
        });
        return false;
    });

    
});