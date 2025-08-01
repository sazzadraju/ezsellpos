$( document ).ready(function() {
    // On Load Event
    //$("#acc_type").val( $('input[name="tid"]').val() ).change();
    var id = $('input[name="tid"]').val();
    if(id==='1'){
        prep_bank_acc_form();
    } else if(id==='2'){
        prep_cash_acc_form();
    } else if(id==='3'){
        prep_mob_acc_form();
    } else{
        reset_all_acc_form();
    }

    // Event on clicking Tab
    $("a.tb").on('click', function(e){
        var id = $(this).attr('id').match(/\d+/);
        $('input[name="tid"]').val(id);
        $("#acc_type").val(id).change();
    });

    // AccountType >> On Change Event
    $("#acc_type").on('change', function(e){
        var id = $(this).val();
        if(id==='1'){
            prep_bank_acc_form();
        } else if(id==='2'){
            prep_cash_acc_form();
        } else if(id==='3'){
            prep_mob_acc_form();
        } else{
            reset_all_acc_form();
        }
    });
});

function prep_bank_acc_form(){
    // Bank/Account Name
    $('#d_bank_name').removeClass("disp-off");
    $('#d_cash_acc_name').addClass("disp-off");
    $('#d_acc_name').addClass("disp-off");
    
    // Account No
    $("#d_acc_no").removeClass("disp-off");
    
    // Bank Acount fields
    $(".ba").removeClass("disp-off");
    
    // Cash Acount fields
    $(".ca").addClass("disp-off");
    
    // Mobile Acount fields
    $(".ma").addClass("disp-off");
}

function prep_cash_acc_form(){
    // Bank/Account Name
    $('#d_bank_name').addClass("disp-off");
    $('#d_cash_acc_name').removeClass("disp-off");
    $('#d_acc_name').addClass("disp-off");
    
    // Account No
    $("#d_acc_no").addClass("disp-off");
    
    // Bank Acount fields
    $(".ba").addClass("disp-off");
    
    // Cash Acount fields
    $(".ca").removeClass("disp-off");
    
    // Mobile Acount fields
    $(".ma").addClass("disp-off");
}

function prep_mob_acc_form(){
    // Bank/Account Name
    $('#d_bank_name').addClass("disp-off");
    $('#d_cash_acc_name').addClass("disp-off");
    $('#d_acc_name').removeClass("disp-off");
    
    // Account No
    $("#d_acc_no").removeClass("disp-off");
    
    // Bank Acount fields
    $(".ba").addClass("disp-off");
    
    // Cash Acount fields
    $(".ca").addClass("disp-off");
    
    // Mobile Acount fields
    $(".ma").removeClass("disp-off");
}

function reset_all_acc_form(){
    // Bank/Account Name
    $('#d_bank_name').addClass("disp-off");
    $('#d_cash_acc_name').addClass("disp-off");
    $('#d_acc_name').addClass("disp-off");
    
    // Account No
    $("#d_acc_no").addClass("disp-off");
    
    // Bank Acount fields
    $(".ba").addClass("disp-off");
    
    // Cash Acount fields
    $(".ca").addClass("disp-off");
    
    // Mobile Acount fields
    $(".ma").addClass("disp-off");
}


function edit_account11(id) {
    $.ajax({
        url: URL + 'account-settings-account/edit-account-info/'+id,
        data: {id: id},
        type: 'post',
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (result) {
            if (result) {
                var data = JSON.parse(result);
                console.log(data);
                
                var division_id = data.result[0].div_id;
                var district_id = data.result[0].dist_id;
                var city_id = data.result[0].city_id;
                var area_id = data.result[0].area_id;
                $('#edit_supplier_id').val(data.result[0].id_supplier);
                $('#edit_supplier_code').val(data.result[0].supplier_code);
                $('#edit_full_name').val(data.result[0].supplier_name);
                $('#edit_contact_person').val(data.result[0].contact_person);
                $('#edit_email').val(data.result[0].email);
                $('#edit_phone').val(data.result[0].phone);
                $('#edit_addr_line_1').val(data.result[0].addr_line_1);
                $('#edit_version').val(data.result[0].version);
                if (division_id != 0) {
                    $('[id="city_division1"]').val('divi-' + division_id).change();
                    setTimeout(function () {
                        $('[id="edit_address_location"]').val('dist-' + district_id).change();
                    }, 100);
                }

                if (city_id != 0) {
                    $('[id="city_division1"]').val('city-' + city_id).change();
                    setTimeout(function () {
                        $('[id="edit_address_location"]').val('city-' + area_id).change();
                    }, 200);
                }

                var html = "";

                for (var i = 0; i < data.store.length; i++) {
                    var selected = "";
                    for (var j = 0; j < data.supplier_store.length; j++) {
                        if (data.store[i].id_store == data.supplier_store[j].store_id) {
                            selected = "selected";
                        }
                    }
                    html += "<option " + selected + " value='" + data.store[i].id_store + "'>" + data.store[i].store_name + "</option>";
                }
                $('[id="edit_store_id"]').html(html);
                $('.loading').fadeOut("slow");

                return false;
            } else {
                return false;
            }
        }
    });
}
