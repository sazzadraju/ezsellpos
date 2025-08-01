'use strict';


function isNumber(event) {
    event = (event) ? event : window.event;
    if(event.which == 8 || event.which == 0){
        return true;
    }
    if(event.which < 46 || event.which > 59) {
        return false;
    } // prevent if not number/dot
    
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
    } 
}
function jsCurrency(currency,price) {
    var data=currency.split('@');
    if(data[1]=='R'){
        return price+' '+data[0];
    }else{
        return data[0]+' '+price;
    }
}
$('.NumberOnly').keypress(function(evt) {
     evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
});
$('.Number').keypress(function(event) {
    if(event.which == 8 || event.which == 0){
        return true;
    }
    if(event.which < 46 || event.which > 59) {
        return false;
    } // prevent if not number/dot
    
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
    } 
});
function show_image(id) {

    $('.modal-body-img').empty();
    var img = $('#img_' + id).html();
    //alert(img);
    $(img).appendTo('.modal-body-img');
    $('#imageModal').modal({show: true});
}
function ImageExist(url)
{
    var img = new Image();
    img.src = url;
    return img.height != 0;
}

function is_display_type(display_type) {
    return $('.display-type').css('content') == display_type || $('.display-type').css('content') == '"' + display_type + '"';
}
function not_display_type(display_type) {
    return $('.display-type').css('content') != display_type && $('.display-type').css('content') != '"' + display_type + '"';
}

$(function () {
    $('[rel="tooltip"]').tooltip({trigger: "hover"});

    // #7. FORM STEPS FUNCTIONALITY

    $('.step-trigger-btn').on('click', function () {
        var btn_href = $(this).attr('href');
        $('.step-trigger[href="' + btn_href + '"]').click();
        return false;
    });

    // FORM STEP CLICK
    $('.step-trigger').on('click', function () {
        var prev_trigger = $(this).prev('.step-trigger');
        if (prev_trigger.length && !prev_trigger.hasClass('active') && !prev_trigger.hasClass('complete'))
            return false;
        var content_id = $(this).attr('href');
        $(this).closest('.step-triggers').find('.step-trigger').removeClass('active');
        $(this).prev('.step-trigger').addClass('complete');
        $(this).addClass('active');
        $('.step-content').removeClass('active');
        $('.step-content' + content_id).addClass('active');
        return false;
    });
    // END STEPS FUNCTIONALITY


    // #8. SELECT 2 ACTIVATION

    if ($('.select2').length) {
        $('.select2').select2();
    }

    // #9. CKEDITOR ACTIVATION

    if ($('#ckeditor1').length) {
        CKEDITOR.replace('ckeditor1');
    }


    // #11. MENU RELATED STUFF

    // INIT MOBILE MENU TRIGGER BUTTON
    $('.mobile-menu-trigger').on('click', function () {
        $('.menu-mobile .menu-and-user').slideToggle(200, 'swing');
        return false;
    });

    // INIT MENU TO ACTIVATE ON HOVER
    var menu_timer;
    $('.menu-activated-on-hover ul.main-menu > li.has-sub-menu').mouseenter(function () {
        var $elem = $(this);
        clearTimeout(menu_timer);
        $elem.closest('ul').addClass('has-active').find('> li').removeClass('active');
        $elem.addClass('active');
    });
    $('.menu-activated-on-hover ul.main-menu > li.has-sub-menu').mouseleave(function () {
        var $elem = $(this);
        menu_timer = setTimeout(function () {
            $elem.removeClass('active').closest('ul').removeClass('has-active');
        }, 200);
    });

    // INIT MENU TO ACTIVATE ON CLICK
    $('.menu-activated-on-click li.has-sub-menu > a').on('click', function (event) {
        var $elem = $(this).closest('li');
        if ($elem.hasClass('active')) {
            $elem.removeClass('active');
        } else {
            $elem.closest('ul').find('li.active').removeClass('active');
            $elem.addClass('active');
        }
        return false;
    });

    // #12. CONTENT SIDE PANEL TOGGLER

    $('.content-panel-toggler, .content-panel-close, .content-panel-open').on('click', function () {
        $('.all-wrapper').toggleClass('content-panel-active');
    });




    // #16. OUR OWN CUSTOM DROPDOWNS 
    $('.os-dropdown-trigger').on('mouseenter', function () {
        $(this).addClass('over');
    });
    $('.os-dropdown-trigger').on('mouseleave', function () {
        $(this).removeClass('over');
    });

    // #17. BOOTSTRAP RELATED JS ACTIVATIONS

    // - Activate tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // - Activate popovers
    $('[data-toggle="popover"]').popover();
});

///////////////////////////////////// CUstom File type//////////////////////////////////////////////

$(function () {
    $('input').change(function () {
        var label = $(this).parent().find('span');
        if (typeof (this.files) != 'undefined') { // fucking IE      
            if (this.files.length == 0) {
                label.removeClass('withFile').text(label.data('default'));
            } else {
                var file = this.files[0];
                var name = file.name;
                var size = (file.size / 1048576).toFixed(3); //size in mb 
                label.addClass('withFile').text(name + ' (' + size + 'mb)');
            }
        } else {
            var name = this.value.split("\\");
            label.addClass('withFile').text(name[name.length - 1]);
        }
        return false;
    });
});
// $(window).on('load', function(){
//     $('.loader2').fadeOut();
//     $('.preloader').delay(200).fadeOut('slow');
//     $('body').delay(200).css({
//         'display': 'visible'
//     });
// });



// =============================================================================
// Input amount. Valid numeric data. Allows only 2 digits after decimal point
function amountInpt(el, evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot
    if (number.length > 1 && charCode == 46) {
        return false;
    }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
        return false;
    }
    return true;
}
function getSelectionStart(o)
{
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate();
        r.moveEnd('character', o.value.length);
        if (r.text == '')
            return o.value.length;
        return o.value.lastIndexOf(r.text);
    } else
        return o.selectionStart;
}

function numericOnly(elem)
{
    elem.value = elem.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
}
$('#cat_name').on('change', '', function (e) {
    var value=this.value;
    $.ajax({
        type: 'POST',
        url: URL+'product_settings/products/getsubcategory',
        data: 'id=' + value,
        success: function (result) {
            var html = '';
            var data = JSON.parse(result);
            if (result) {
                var length = data.length;
                html = "<option value = '0'>Select One</option>";
                for (var i = 0; i < length; i++) {
                    var val = data[i].id_product_category;
                    var name = data[i].cat_name;
                    html += "<option value = '" + val + "'>" + name + "</option>";
                }
            }
            $("#pro_sub_category").html(html);
        }
    });
});

// =============================================================================