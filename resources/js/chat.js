jQuery(function($){
    
    /* Ouvindo eventos do chat */

    var $companyId = $('meta[name="company-id"]').attr('content');

    Echo.private(`channel-chat.${$companyId}`)
    .listen('.message.received', (e) => {
        $('#messages').append(e.html);
    });

    // Pegando evento de total de notificações
    Echo.private(`channel-total-chat-notifications.${$companyId}`)
        .listen('.total.notifications', (e) => {
            $('#notifications .number').html(e.total);
        });

    Echo.private(`channel-lead-message-read.${$companyId}`)
        .listen('.lead.message.read', (e) => {
            $('#' + e.sid).replaceWith(e.html);
        });

    /* Ouvindo eventos do chat */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* Criando uma nova mensagem */
    $('#chat').on('submit', function(event){
        event.preventDefault();

        var $url = $(this).attr('action');
        var $message = $('#message').val();

        if($message.length > 0){
            $.ajax({
                beforeSend: function(){
                    $('#message').val('');
                },
                type: 'post',
                dataType: 'json',
                url: $url,
                data: {
                    message: $message,
                },
                success: function(response){
                    if(response.success){
                        $('#messages').append(response.data);
                    }
                }
            });
        }

    });
    /* Criando uma nova mensagem */

    /* Atualização do total de notificações do chat */

    // Primeira chamada
    notificationsChat();
   
    function notificationsChat(){

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '/total-status',
            success: function(response){
                $('#notifications .number').html(response.total);
            }
        });

    }
    /* Atualização do total de notificações do chat */

});