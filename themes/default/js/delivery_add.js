
function setAgentStaff(evl) {
    //alert(evl.value);
    var name=evl.value;
    var final=0;
    var result = name.split('@');
    if(result.length>1){
        var final= result[0];
    }
    if(final==0){
        $('#order_sort_data').html('');
    } else{
        $.ajax({
            type: "POST",
            url: URL+'delivery/show_agent_staff_list',
            data: {id:final},
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                //alert(data);
                $('#order_sort_data').html(data);
                $('.loading').fadeOut("slow");
            }
        });
    }

}
function setServiceRange(evl){
    var name=evl.value;
    var final=0;
    var result = name.split('@');
    if(result.length>1){
        var final= result[0];
    }
    if(final==0){
        $('#service_range').html('<option value="0" selected>Select One</option>');
    } else{
        $.ajax({
            type: "POST",
            url: URL+'delivery/show_service_range',
            data: {id:final},
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#service_range').html(data);
                $('#service_price').val('');
                $('.loading').fadeOut("slow");
            }
        });
    }
}
function setServicePrice(evl) {
    var option = $('option:selected', evl).attr('actp');
   $('#service_price').val(option);
}
function checkAccounts(evl) {
    var option = $('option:selected', evl).attr('actp');
    $html='<input type="hidden" name="account_method" id="account_method" value="'+option+'">';
    if(option==3){
        $html += '<div class="col-md-4">';
        $html += '<div class="form-group row">';
        $html += '<label class="col-sm-12 col-form-label" for="">Reff Transaction No</label>';
        $html += '<div class="col-sm-12">';
        $html += '<input class="form-control" type="text" id="ref_trx_no" name="ref_trx_no">';
        $html += '</div>';
        $html += '</div>';
        $html += '</div>';
    }
    $('#ref_trx_no').html($html);
}
function setDelPerson(evl) {
    var name=evl.value;
    var final=0;
    var result = name.split('@');
    if(result.length>1){
        var final= result[0];
    }
    if(final==0){
        $('#delivery_person').html('<option value="0" selected>Select One</option>');
    } else{
        $.ajax({
            type: "POST",
            url: URL+'delivery/show_delivery_person_agent',
            data: {id:final},
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                var result = $.parseJSON(data);
                //console.log(result);
                $('.loading').fadeOut("slow");
                $('#delivery_person1').html(result.person);
                $('#service_name').html(result.service);
                
            }
        });
    }
}
function add_delivery() {
    var cus=$('#customer_id').val();
    if(cus){
        $.ajax({
            type: "POST",
            url: URL+'delivery/show_customer_address',
            data: {id:cus},
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                if(data!=1){
                    $('#delivery_add').modal('toggle');
                    $('#customer_data').html(data);
                }
                $('.loading').fadeOut("slow");
            }
        });

    }else{
        $('#EmptyAlert').modal('toggle');
        $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Please select customer first.');
    }
}
function addCustomerAddress() {
    var rowCount = $('#addressTR > tbody >tr').length;
    $.ajax({
        type: "POST",
        url: URL+'delivery/customer_address_add',
        data: {id:rowCount},
        async: false,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (data) {
            $('#addressTR > tbody:last').append(data);
            $('.loading').fadeOut("slow");
            $('#addAdr').html('');
        }
    });

}

$.validator.setDefaults({
    submitHandler: function (form) {
        var currentForm = $('#delivery_info')[0];
        var formData = new FormData(currentForm);
        var ck_id=$('input[name="check_address"]:checked').attr('id');
        var ck_val=$('input[name="check_address"]:checked').val();
        var cs_id=$('#customer_id').val();
        formData.append('customer_id', cs_id);
        if(ck_val!='new'){
            var type=$('#type_'+ck_id).text();
            var dis=$('#dis_'+ck_id).text();
            var area=$('#area_'+ck_id).text();
            var details=$('#details_'+ck_id).text();
            var addr=details+', '+area+', '+dis;
            formData.append('address', addr);
        }else{
            var dis1 = $('#city_division option:selected').attr('actp');
            var divi = $('#address_location option:selected').attr('actp');
            var details1=  $('textarea#addr_line_1').val();
            var addr1=details1+', '+divi+', '+dis1;
            formData.append('address', addr1);
        }
        $.ajax({
            url: URL+"delivery/add_delivery_charge_sales",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (response) {
                $('#delivery_add').modal('toggle');
                $('#show_delivery').html(response);
                $('.loading').fadeOut("slow");
            }
        });
    }
});

function locationAddress(value){
    var cat = value.substring(0,4);
    var id = value.substring(5);

    // $('#select2-location-container').html("");
    if(cat == "divi"){
        var html = "<option value='0'>Select District</option>";
        $('#address_location').html("");
        $.ajax({
            type: "POST",
            url: URL+'customer_settings/customer/get_district',
            data: {id: id},
            success: function (result) {
                var data = JSON.parse(result);
                if (result) {
                    var length = data.length;
                    for(var i = 0; i < length; i++){
                        var val = data[i].id_district;
                        var district = data[i].district_name_en;
                        html += "<option actp='"+district+"' value = '"+'dist-'+val+"'>"+district+"</option>";
                    }

                    $('#address_location').html(html);
                    $('#division_id').val(id);
                    $('#city_id').val("");
                    $('#district_id').val("");
                    $('#city_location_id').val("");
                    return true;
                } else {
                    alert('data not found !');
                    return false;
                }
            }
        });
    }else if(cat == "city"){
        var html = "<option value='0'>Select Location</option>";
        $('#address_location').html("");
        $.ajax({
            type: "POST",
            url: URL+'customer_settings/customer/get_city_location',
            data: {id: id},
            success: function (result) {

                var data = JSON.parse(result);
                if (result) {
                    var length = data.length;
                    for(var i = 0; i < length; i++){
                        var val = data[i].id_area;
                        var location = data[i].area_name_en;
                        html += "<option actp='"+location+"' value = '"+'city-'+val+"'>"+location+"</option>";
                    }

                    $('#address_location').html(html);
                    $('#city_id').val(id);
                    $('#division_id').val("");
                    $('#district_id').val("");
                    $('#city_location_id').val("");
                }
            }
        });
    }
}
function cityDistLoc(value){
    var cat = value.substring(0,4);
    var id = value.substring(5);

    if(cat == "city"){
        $('#city_location_id').val(id);
    }else if(cat == "dist"){
        $('#district_id').val(id);
    }
}


