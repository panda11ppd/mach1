
define(['bootstrap'], function() {

    var nav = $('.theme-navbar')
    nav.affix({
        offset: {
            top: nav.offset().top + $('.theme-orderarea').height(),
            bottom: 0
        }
    })

    TBUI.bd.scrollspy({
        target: '.theme-navbar',
        offset: nav.height() + 20
    })

})



$('.theme-contentbox a').attr('target', '_blank')


stap.order = function(dom, ops){

    dom.addClass('disabled')

    var theme_id = Number(dom.data('id'))

    $.ajax({
        type: 'POST',
        url: TBUI.URL + '/action/member',
        data: {
            action: 'order',
            id: theme_id
        },
        dataType: 'json',
        success: function(data) {
            if (data.msg) {
                alert(data.msg)
            }

            if (!data.error && data.response) {
                location.href = TBUI.URL + '/member/order/' + data.response.order_id
            }

        }
    })

}


