import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './chat';

jQuery(function($){

    // Opções de conta
    $('.account .edit-account a').on('click', function(e){

        e.preventDefault();

        $('.account .items').toggleClass('open');

    });

    /* Controle de popups */
    var $popup = $('.popup');
    if($popup.length > 0){
        setTimeout(function(){
            $popup.fadeOut(400, function(){
                $(this).remove();
            });
        }, 3000);
    }
    /* Controle de popups */

    /* Realizando busca de entidades */
    $('#search-entity').on('submit', function(e){
        e.preventDefault();

        loadStatuses($(this).attr('action'), 1);
    });

    /* Filtrando leads */
    $('.filter-button').on('click', function(e){
        var page = $(this).attr('data-page');
        let link = $('#search-entity').attr('action');
        loadStatuses(link, page);
    })
    /* Filtrando leads */
    // Adiciona evento de clique aos links de navegação
    $(document).on('click', '.pagination .prev, .pagination .next', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('-inactive')) {
            var page = $(this).attr('data-page');
            let link = $('#search-entity').attr('action');
            loadStatuses(link, page);
        }
    });

    function loadStatuses(url, page = 1) {

        var $search = $('#search').val();
        var $url = url;
        var $withWhatsapp = $('#withWhatsapp').val();
        var $status = $('#status').val();
        var $lastContact = $('#lastContact').val();
        var $callScheduled = $('#callScheduled').val();
        var $created_at = $('#created_at').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            beforeSend: function () {
                $('.body-table table tbody').html(`
                    <tr>
                        <td colspan="8">
                            <div class="spinner"></div>
                        </td>
                    </tr>`);
            },
            type: "post",
            dataType: "json",
            url: $url,
            data: {
                search: $search,
                withWhatsapp: $withWhatsapp,
                status: $status,
                lastContact: $lastContact,
                callScheduled: $callScheduled,
                created_at: $created_at,
                page: page,
            },
            success: function (response) {
                var html = ``;

                setTimeout(function(){

                    $('.pagination .from').text(response.from);
                    $('.pagination .to').text(response.to);
                    $('.pagination .total').text(response.total);

                    // Atualiza o estado dos botões de navegação
                    if (response.currentPage == 1) {
                        $('.pagination .prev').addClass('-inactive');
                    } else {
                        $('.pagination .prev').removeClass('-inactive').attr('data-page', response.currentPage - 1);
                    }

                    if (response.currentPage == response.lastPage) {
                        $('.pagination .next').addClass('-inactive');
                    } else {
                        $('.pagination .next').removeClass('-inactive').attr('data-page', response.currentPage + 1);
                    }

                    $('#entity-quantity').html(`(${response.total})`);
                    $('.body-table table tbody').html(response.html);
                }, 100);
            },
        });
        
    }
    /* Realizando busca de entidades */

    /* Buscando cidades */

    $('.states').on('change', function(){

        getCities($(this).val());

    });

    function getCities(uf){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            beforeSend: function () {
                $('#cities').html(`<option>Carregando...</option>`);
            },
            type: "post",
            dataType: "json",
            url: '/get-cities',
            data: {
                uf: uf,
            },
            success: function (response) {
                var html = ``;

                setTimeout(function(){
                    $('.cities').html(`${response.html}`);
                }, 100);
            },
        });

    }
    /* Buscando cidade */


    /* Máscaras */
    phoneMask();

    function phoneMask(){
        $('.phoneMask').on('blur', function(e){
            var $value = $(this).val().replace(/[ \-\(\)]/g, '');
            var $number = '';

            /*"67 9 96555725"*/
            if($value.length == 11){
                $value.split('').forEach((v, i) => {
                    switch(i){
                        case 0:
                            $number = '(' + v;
                            break;
                        case 1:
                            $number += v + ') ';
                        break;
    
                        case 2:
                            $number += v + ' ';
                        break;
    
                        case 6:
                            $number += v + ' ';
                        break;
    
                        default:
                            $number += v;
    
                    }
                });
            }else{
                $value.split('').forEach((v, i) => {
                    switch(i){
                        case 0:
                            $number = '(' + v;
                            break;
                        case 1:
                            $number += v + ') ';
                        break;
    
                        case 2:
                            $number += '9 ' + v;
                        break;

                        case 5:
                            $number += v + ' ';
                        break;
    
                        default:
                            $number += v;
    
                    }
                });
            }

            $(this).val($number)
        });
    }
    /* Máscaras */

});