        
	$(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
        totalCalculation();
    });
$( function() {
    $( "#product_name" ).autocomplete({
        minLength: 0,
        source: function( request, response ) {
            var startTime= new Date().getTime();
            $.ajax({
                type: 'GET',
                url: URL+"get_products_auto_sales",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    //console.log(data);
                    response(data);
                    var Time = new Date().getTime()-startTime;
                    var diff=(Time/1000).toString();
                    console.log(diff);
                }
            });
        },
        focus: function (event, ui) {
        $("#product_name").val(ui.item.label);
        },
        select: function(event, ui) {
        $('#src_product_id').val(ui.item.value); // display the selected text
        $('#src_batch_no').val(ui.item.batch_no); // save selected id to hidden input
        return false;
        } 
    });
    $( "#src_customer_name" ).autocomplete({
        minLength: 0,
        source: function( request, response ) {
            $.ajax({
                type: 'GET',
                url: URL+"get_customers_auto",
                dataType: "json",
                data: {
                    request: request.term
                },
                success: function( data ) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
        $("#src_customer_name").val(ui.item.label);
        },
        select: function(event, ui) {
        $('#show_customer_balance').html(ui.item.balance);
        $('#show_customer_phone').html(ui.item.phone);
        $('#src_customer_balance').val(ui.item.balance);
        $('#src_customer_id').val(ui.item.value);
        updateCustomerPoints(ui.item.points, true);
        checkCustomerDiscount(ui.item.value);
        return false;
        }
    });
    $( "#src_sales_person" ).autocomplete({
        minLength: 0,
        source: function( request, response ) {
            $.ajax({
                type: 'GET',
                url: URL+"get_sales_person_auto",
                dataType: "json",
                data: {
                    request: request.term
                },
                success: function( data ) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            $("#src_sales_person").val(ui.item.label);
        },
        select: function(event, ui) {
            $('#sales_person').val(ui.item.value);
            return false;
        } 
    });
});
$("#add_product_to_cart").submit(function () {
    var $html = '';
    $('#product_name-error').html('');
    var dataString = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: URL+'temp_add_cart_for_sales',
        data: dataString,
        async: false,
        // beforeSend: function () {
        //     $('.loading').show();
        // },
        success: function (result) {
            //$('.loading').fadeOut("slow");
            //console.log(result);
            var result = $.parseJSON(result);
            if(result.status==1){
            	var exist = 1;
            	$("input[name='stock_id[]']").each(function () {
                    id_value = $(this).val();
                    var id_full = $(this).attr('id');
                    var id = id_full.split("_").pop(-1);
                    if (id_value == result.product.stock_id) {
                    	var total_stock=Number($('#total_qty_' + id).val());
                    	var sale_qty=Number($('#qty_' + id).val());
                        if (total_stock == sale_qty) {
                            alert('Stock Not Available');
                        }else{
                        	var discount_amount =0;
                        	sale_qty+=1;
                        	var unit_price = $("#unit_price_" + id).val();
                        	var discount = $("#discount_" + id).val();
                        	if(discount!=''){
                        		discount_amount = ((unit_price * sale_qty) * discount) / 100;
                        	}
                        	var vat_tot = 0;
						    var def_vat = $("#def_vat_" + id).val();
						    if(def_vat!=''){
						    	vat_tot = (((unit_price * sale_qty) - discount_amount) * def_vat) / 100;
						    }
						    var tot_val = ((unit_price * sale_qty) - discount_amount) + vat_tot;
						    var dis=(discount_amount>0)?Number(discount_amount.toFixed(2)):'';
						    var vat=(vat_tot>0)?Number(vat_tot.toFixed(2)):'';
						    $('#qty_' + id).val(sale_qty);
						    $("#discount_amt_" + id).val(dis);
						    $("#def_vat_amt_" + id).val(vat);
						    $("#total_price_" + id).val(Number(tot_val.toFixed(2)));
                        }
                        exist=2;
                        return false;
                    }
                });
            	if(exist==1){
            		$('#addSection > tbody').prepend(result.data);
            	}
            	totalCalculation();
            }else{
            	alert(result.message);
            }
            
            //alert(result);
            $('#product_name').val('');
            $('#src_product_id').val('');
            $('#src_batch_no').val('');
            $('#product_name').focus();
			$('#count_row').val( function(i, oldval) {
			    return ++oldval;
			});
            return false;
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});
function checkCustomerDiscount(id){
	$.ajax({
	  	url: URL+"sales_settings/sales/get_customer_balance",
	  	type: "GET",
	  	datatype: "json", 
	  	data: {
	    	id: id
  		},
	  	success: function(result) {
	  		var result = $.parseJSON(result);
	  		//console.log(result.status);
	  		if(result.status=='1'){
	  			//console.log(result.data);
	  			var cus_dis = $('#cus_dis').text();
	  			var product_total=Number($('#cart_total').html());
	  			var per=Number(result.data.discount);
                var	amount=(product_total*per)/100;
                if (cus_dis.trim()) {
                    $('#cus_dis').html(per);
                    $('#cus_dis_total').html(amount);
                } else {
                    var div='<tr id="show_customer_discount_div"> <td>Cus. Dis. <b id="cus_dis">' + per + '</b>% <label class="switch"><input type="checkbox" name="ck_cus_dis" id="ck_cus_dis" checked onclick="discount_chk()"><span class="slider round"></span></label> </td><td id="cus_dis_total">'+ amount +'</td> </tr>';
    				$('#all_discount').prepend(div);
                }
                $('#tmp_customer_dis_rate').val(Number(result.data.discount));
                $('#tmp_customer_dis_target_sale').val(Number(result.data.target_sales_volume));
                
	  		}else{
	  			$("#show_customer_discount_div").remove();
	  			$('#tmp_customer_dis_rate').val('');
                $('#tmp_customer_dis_target_sale').val('');
	  		}
            var pr_total = Number($('#grand_total').text());
            if (pr_total > 0) {
                sumDiscountCalculation();
            }
	  	}
	});
}
function totalCalculation(){
	var total_qty_sh=parseInt(0),item_array=[];
    var total_item_sh=parseInt(0);
    var total_vat=parseInt(0);
    var total_discount=parseInt(0);
    var product_total=parseInt(0);
    var unit_total=parseInt(0);
    $('input[name^="total_price"]').each(function () {
        var id_f = $(this).attr('id');
        var div_id = id_f.split("_").pop(-1);
        var unit_val = $('#unit_price_' + div_id).val()*1;
        var unit_qty = $('#qty_' + div_id).val()*1;
        var discount = $('#discount_amt_' + div_id).val()*1;
        var vat = $('#def_vat_amt_' + div_id).val()*1;
        var pro_id_u = $('#pro_id_' + div_id).val();
        unit_total += (unit_val * unit_qty);
        product_total = ($(this).val() * 1) + product_total;
        total_discount = discount + total_discount;
        total_vat = vat + total_vat;
        total_qty_sh=total_qty_sh+unit_qty;
        item_array.push(pro_id_u);
    });
    var itemUniqueArray = item_array.filter(function(itm, i, a) {
        return i == a.indexOf(itm);
    });
    $('#total_item_show').html(itemUniqueArray.length);
    $('#total_qty_show').html(Number(total_qty_sh.toFixed(2))); 
    $('#total_unit_price_show').html(Number(unit_total.toFixed(2))); 
    $('#total_discount_show').html(Number(total_discount.toFixed(2))); 
    $('#total_vat_show').html(Number(total_vat.toFixed(2))); 
    $('#total_price_show').html(Number(product_total.toFixed(2))); 
    $('#original_product_price').val(Number(unit_total.toFixed(2)));
    $('#cart_total_price').val(Number(product_total.toFixed(2)));
    $('#cart_total').html(Number(product_total.toFixed(2))); 
    
    sumDiscountCalculation();
}
function sumDiscountCalculation(){
	var product_total=Number($('#cart_total').html());
	var purchase_promotion=$('#total_pur_promo_val').val();
    var min_purchase_amt=Number($('#min_purchase_amt').val());
    var cus_dis = $('#cus_dis').text();
    //var dis_per = $('#pur_dis_total').text();
    var cart_dis = Number($('#cart_dis').text());
    var special_dis = $('#dis_per').text();
    var special_dis_taka = $('#dis_taka').text();
    var cus_taka = cart_taka = 0;
    var pur_dis_amt = special_dis_amount = 0;
    if(purchase_promotion!='' && min_purchase_amt <= product_total){
    	//alert('a');
    	var rate = Number(purchase_promotion.split('&&')[0]);
    	var amount = Number(purchase_promotion.split('&&')[1]);
    	var pur_dis_per = $('#pur_dis').text();
    	if (rate > 0) {
    		var amount_val=(product_total*rate)/100;
        }
        if (pur_dis_per.trim()) {
    		$('#pur_dis').html(rate);
    		if ($('#ck_pur_dis').is(':checked')) {
    			pur_dis_amt = Number(amount_val.toFixed(2));
	            $('#pur_dis_total').html(pur_dis_amt);
	        }else{
	        	$('#pur_dis_total').html('00');
	        }
    	}else{
    		pur_dis_amt = Number(amount_val.toFixed(2));
    		var div='<tr id="show_purchase_discount_div"> <td>Pur. Dis <b id="pur_dis">' + rate + '</b>% <label class="switch"><input type="checkbox" name="ck_pur_dis" id="ck_pur_dis" checked onclick="discount_chk()"><span class="slider round"></span></label> </td><td id="pur_dis_total">'+ pur_dis_amt +'</td> </tr>';
    		$('#all_discount').prepend(div);
    	}
    }else{
    	$('#show_purchase_discount_div').remove();
    }
    var customer_dis=Number($('#tmp_customer_dis_rate').val());
    if(customer_dis > 0){
    	var customer_target=Number($('#tmp_customer_dis_target_sale').val());
    	if(customer_target <= product_total){
    		var amount_val=(product_total*customer_dis)/100;
            $('#cus_dis').html(customer_dis);
            if ($('#ck_cus_dis').is(':checked')) {
            	cus_taka = Number(amount_val.toFixed(2));
	            $('#cus_dis_total').html(cus_taka);
	        }else{
	        	$('#cus_dis_total').html('00');
	        }
    	}else{
    		$('#cus_dis').html('0');
            $('#cus_dis_total').html('00');
    	}
    }
    var sp_dis_per = $('#show_special_discount_div').text();
    if (sp_dis_per.trim()) {
	    if ($('#ck_sp_dis').is(':checked')) {
	        if (special_dis != '') {
	            var sp_dis = special_dis.slice(0, -1);
	            special_dis_amount = (product_total * sp_dis) / 100;
	            $('#dis_taka').html(Number(special_dis_amount.toFixed(2)));
	        } else if (special_dis_taka != '00') {
	            special_dis_amount = special_dis_taka * 1;
	        }
	    }else{
	    	$('#dis_taka').html('00');
	    }
	}
	var card_dis_per = $('#show_card_discount_div').text();
    if (card_dis_per.trim()) {
	    if ($('#ck_cart_dis').is(':checked')) {
            if (cart_dis > 0) {
                cart_taka = (product_total * cart_dis) / 100;
                $('#cart_dis_total').html(Number(cart_taka.toFixed(2)));
            }
        }else{
	    	$('#cart_dis_total').html('00');
	    }
	}
	var grand_total=product_total-(cus_taka + cart_taka + pur_dis_amt + special_dis_amount);
    var config_round=Number($('#config_round').val());
    if(config_round>0){
        var mod=( grand_total %  config_round);
        if((config_round/2)>mod){
            grand_total=grand_total-mod;
            $('#con_round').html(-Number(mod.toFixed(2)));
        }else{
            grand_total=(grand_total-mod)+config_round;
             $('#con_round').html(Number((config_round-mod).toFixed(2)));
        }
    }
	$('#grand_total').html(Number(grand_total.toFixed(2)));
    var replace_total = $('#replace_total').html();
    if($.trim(replace_total)){
      grand_total=grand_total-(Number(replace_total));
    }
	$('#cash').val(Number(grand_total.toFixed(2)));
	amount_check();
}
function discount_chk(){
	sumDiscountCalculation();
}
function add_special_discount(){
	var percent=Number($("#percent").val());
	var taka=Number($("#taka").val());
	if(percent > 0 || taka > 0){
		var sp_dis_per = $('#show_special_discount_div').text();
		if (!sp_dis_per.trim()) {
			var div='<tr id="show_special_discount_div"> <td>Discount<b id="dis_per"></b> <label class="switch"><input type="checkbox" name="ck_sp_dis" id="ck_sp_dis" checked onclick="discount_chk()"><span class="slider round"></span></label> </td><td id="dis_taka">00</td> </tr>';
    		$('#all_discount').prepend(div);
		}
    	if (percent > 0) {
    		$('#dis_per').html(percent + '%');
        }else{
        	$('#dis_per').html('');
    		$('#dis_taka').html(taka);
    	}
	}else{
		$('#show_special_discount_div').remove();
	}
	var card_promotion=$("#card_promotion option:selected").val();
	if (card_promotion != 0) {
        var val_data = card_promotion.split('@')[1];
        var chk_dis = $('#cart_dis').text();
        if (chk_dis.trim()) {
            $('#cart_dis').html(val_data);
        } else {
            var div='<tr id="show_card_discount_div"> <td>Card Dis.<b id="cart_dis">'+ val_data +'</b>% <label class="switch"><input type="checkbox" name="ck_cart_dis" id="ck_cart_dis" checked onclick="discount_chk()"><span class="slider round"></span></label> </td><td id="cart_dis_total">00</td> </tr>';
    		$('#all_discount').prepend(div);
        }
    }else{
    	$('#show_card_discount_div').remove();
    }
    sumDiscountCalculation();
    UIkit.modal("#Discount").hide();

}
$('input.sp_discount').on('input', function (e) {
    var id = this.id;
    var val = this.value;
    //alert(val+'==='+id);
    if (val != '') {
        if (id === 'percent') {
            $("#taka").prop("disabled", true);
        } else {
            $("#percent").prop("disabled", true);
        }
    } else {
        $("#percent").prop("disabled", false);
        $("#taka").prop("disabled", false);
    }

});
$('input.payment').on('input', function (e) {
    amount_check();
});
$('input.amount_round').click(function () {
    amount_check();
});
$('input#cash_paid').on('input', function (e) {
    var cash=$('#cash').val();
    var cash_paid=$('#cash_paid').val();
    var amount=cash-cash_paid;
    $('#change_amt').val(Number(amount.toFixed(2)));
});
function amount_check() {
    var chk_empty='';
    var total=0;
    var pr_total = $('#grand_total').text();
    var replace_data = $('#replace_data').text();
    if (pr_total <= 0 && replace_data=='') {
        $('#alert_text').text('Please add product first.');
        $('#emptyAlert').modal('toggle');
        $('#card_payment').val('');
        $('#cash').val('');
        $('#mobile_amount').val('');
        $('input[id=product_name]').focus();
    } else {
        var multiple_payment = $('#multiple_payment').val();
        var paid_div='';
        if(multiple_payment=='1'){
            var cart = $('#m_card_payment').val() * 1;
            var cash = $('#m_cash').val() * 1;
            var mobile = $('#m_mobile_amount').val() * 1;
            paid_div=(cash>0)?'Cash='+cash:'';
            paid_div+=(cart>0)?', Cart='+cart:'';
            paid_div+=(mobile>0)?', Mob='+mobile:'';
            $('#show_multiple_payment').html(paid_div);
        }else{
            var cart = $('#card_payment').val() * 1;
            var cash = $('#cash').val() * 1;
            var mobile = $('#mobile_amount').val() * 1;
            paid_div=(cash>0)?'Cash='+cash:'';
            paid_div+=(cart>0)?'Cart='+cart:'';
            paid_div+=(mobile>0)?'Mob='+mobile:'';
            $('#paid_div').html(paid_div);
        }
        var replace_total = $('#replace_total').html();
        var remit_total = Number($('#remit_text').text());
        remit_total = isNaN(remit_total) ? 0 : remit_total;
        var paid_amt = cart + cash + mobile;
        var all_paid=paid_amt + remit_total;
        $('#paid_amount').html(paid_amt);
        if($.trim(replace_total)){
            replace_total=Number(replace_total);
            all_paid=all_paid+replace_total;
        }
        if ($('#round_check').prop("checked") == true) {
            var tot_due_m = all_paid - pr_total;
            $('#round').html(Number(tot_due_m.toFixed(2)));
            $('#tot_due_amount').html('00');
        } else {
            var tot_due_p = pr_total - all_paid;
            $('#tot_due_amount').html(Number(tot_due_p.toFixed(2)));
            $('#round').html('00');
        }
    }
}
function change_batch(ele) {
    var id_full = ele.id;
    var div_id = id_full.split("_").pop(-1);
    var value = ele.value;
    var product_id = $('#pro_id_' + div_id).val();
    var check = 0;
    $('select[name="batch[]"]').each(function () {
        var id_f = $(this).attr('id');
        var div_id = id_f.split("_").pop(-1);
        var pro_id = $('#pro_id_' + div_id).val();
        var batch_old = $(this).val();
        if ((pro_id == product_id) && (batch_old == value)) {
            check += 1;
        }
    });
    if (check == 2) {
        var old_id = $('#old_batch_' + div_id).val();
        $("#" + id_full).val(old_id).change();
        $('#alert_text').html('This batch number already exist.');
        $('#emptyAlert').modal('toggle');
    } else {
        $.ajax({
            type: "POST",
            url: URL+'check_batch_product',
            data: 'product_id=' + product_id + '&batch_no=' + value,
            async: false,
            success: function (data) {
                var result = $.parseJSON(data);
                $('.loading').fadeOut("slow");
                if (result.data != '') {
                    var def_vat = Number($('#def_vat_' + div_id).val());
                    var dis_key = Number($('#discount_' + div_id).val());
                    $('#stock_id_' + div_id).val(result.data[0].id_stock);
                    $('#total_qty_' + div_id).val(Number(result.data[0].total_qty));
                    $('#unit_price_' + div_id).val(Number(result.data[0].selling_price_est));
                    var selling_price=result.data[0].selling_price_est*1;
                    var discount=0; vat = 0;
                    var dis_val = 0;
                    if (dis_key >0) {
                        discount = (selling_price * dis_key) / 100;
                    }
                    var discount_price=selling_price-discount;
                    if (def_vat >0) {
                        vat = (discount_price * def_vat) / 100;
                    }
                    var tot_value = discount_price + vat;
                    $('#total_price_' + div_id).val(Number(tot_value.toFixed(2)));
                    $('#qty_' + div_id).val('1');
                    $('#discount_amt_' + div_id).val(Number(discount.toFixed(2)));
                    $('#def_vat_amt_' + div_id).val(Number(vat.toFixed(2)));
                    $('#old_batch_' + div_id).val(value);
                    totalCalculation();
                }
            }
        });
    }
}
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
var button_pressed;
$('.submit_sale').click(function () {
    button_pressed = $(this).attr('id');
});
$("#submit_sales_form").submit(function () {
    var sale_type = button_pressed;
    $('#sub_check_pro').hide();
    $('#sub_check_w').show();
    var gift_sale=0;
    if($('#gift_sale').prop('checked') === true){
       gift_sale=1;
    }
	var formArray = new FormData($(this)[0]);
	let dataString = new FormData($("#cart_data")[0]);
	for (var pair of formArray.entries()) {
	    dataString.append(pair[0], pair[1]);
	}
    if (validateSalesForm() != false) {
        $('#sub_check_pro').hide();
        var $html = '';
        var grand_total = $('#grand_total').text();
        var cart_total = $('#cart_total').text();
        var dis_per = $('#dis_per').text();
        var dis_taka = $('#dis_taka').text();
        var cus_dis = $('#cus_dis').text();
        var cus_dis_total = $('#cus_dis_total').text();
        var pur_dis = $('#pur_dis').text();
        var pur_dis_total = $('#pur_dis_total').text();
        var card_dis = $('#cart_dis').text();
        var card_dis_total = $('#cart_dis_total').text();
        var paid_amt = $('#paid_amount').text();
        var round_amt = $('#round').text();
        var round_amt = ($('#round').length)?round_amt:0;
        var con_round_amt = $('#con_round').text();
        var due_amt = $('#tot_due_amount').text();
        //var order_paid_amount = $('#order_paid_amount').text();
        var sales_person_name =$('#src_sales_person').val();
        var sales_person =$('#sales_person').val();
        dataString.append('sales_person_name', sales_person_name);
        dataString.append('sales_person', sales_person);
        dataString.append('print_type', sale_type);
        dataString.append('cart_total', cart_total);
        dataString.append('con_round_amt', con_round_amt);
        dataString.append('paid_amt', paid_amt + '@' + round_amt + '@' + due_amt);
        dataString.append('special_dis', dis_per + '@' + dis_taka);
        dataString.append('cus_dis', cus_dis + '@' + cus_dis_total);
        dataString.append('pur_dis', pur_dis + '@' + pur_dis_total);
        dataString.append('card_dis', card_dis + '@' + card_dis_total);
        dataString.append('grand_total', grand_total);
        dataString.append('gift_sale', gift_sale);
        $.ajax({
            type: "POST",
            url: URL+'sales_add',
            data: dataString,
            async: false,
            // beforeSend: function () {
            //     $('.loading').show();
            // },
            success: function (data) {
                $('.loading').fadeOut("slow");
                if (data != 'error') {
                    $('#sale_view').html(data);
                    if (sale_type == 'print') {
                        $("#sale_view").print({
                            globalStyles: false,
                            mediaPrint: false,
                            stylesheet: URL+"themes/default/css/sale_print_view.css",
                            iframe: false,
                            noPrintSelector: ".avoid-this",
                            // append : "Free jQuery Plugins!!!<br/>",
                            // prepend : "<br/>jQueryScript.net!"
                        });
                        setTimeout( function() {
                            window.location.replace(URL+"sales");
                        }, 1000 );
                        
                    } else if (sale_type == 'a4print') {
                        //alert(button_pressed);
                        $("#sale_view").print({
                            globalStyles: false,
                            mediaPrint: false,
                            stylesheet: URL+"themes/default/css/a4_print.css",
                            iframe: false,
                            noPrintSelector: ".avoid-this",
                            // append : "Free jQuery Plugins!!!<br/>",
                            // prepend : "<br/>jQueryScript.net!"
                        });
                        setTimeout(function () {
                            window.location.replace(URL+"sales");
                        }, 1000);

                    } else {
                        $('#SaleDetails').modal('toggle');
                    }
                }else{
                    $('#emptyAlert').modal('toggle');
                    $('#alert_text').html('<span class="glyphicon glyphicon-warning-sign"></span> Unable to Process Sales. Your Internet Connection is very slow.');
                }
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;

    }else{
        return false;
    }
	
});
$('.submit_sale').click(function(){
    var config_customer = $('#config_customer').val();
    var customer_id = $('#src_customer_id').val();
    if(config_customer == '0' && customer_id == ''){
        $('#sub_check_pro').show();
        $('#sub_check_w').hide();
        $('#emptyCustomer').modal('toggle');
        $('#customer_alert_text').html('Are you sure to Sale without Customer Selection?');
        return false;
    } 
});
function confirmEmptyCustomer(){
    $('#emptyCustomer').modal('toggle');
    $('#submit_sales_form').submit();
}
$(document).on('input', '.change_price', function () {
    var m_id = this.id;
    var id = m_id.split('_').pop(-1);
    var qty = Number($("#qty_" + id).val());
    var total_qty = Number($("#total_qty_" + id).val());
    if (qty > total_qty) {
        $(this).addClass("focus_error");
        $('#emptyAlert').modal('toggle');
        $('#alert_text').html('Stock qty limit is over');
    } else {
        $(this).removeClass("focus_error");
        var discount_amount=0;
        var un_p = $("#unit_price_" + id).val();
        var discount = Number($("#discount_" + id).val());
        if (discount >0) {
            discount_amount = ((un_p * qty) * discount) / 100;
        }
        var vat_tot = 0;
        var def_vat = $("#def_vat_" + id).val();
        vat_tot = (((un_p * qty) - discount_amount) * def_vat) / 100;
        $("#def_vat_amt_" + id).val(Number(vat_tot.toFixed(2)));
        $("#discount_amt_" + id).val(Number(discount_amount.toFixed(2)));
        var tot_val = ((qty * un_p) - discount_amount) + vat_tot;
        tot_val = Number(tot_val.toFixed(2));
        $("#total_price_" + id).val(tot_val);
        totalCalculation();
    }
});

function multiple() {
    var tot=Number($("#grand_total").html());
    $("#m_total").html(tot);
    clear_payment();
    amount_check();
    //var modal = UIkit.modal("#MultiplePay");
    if(tot>0){
        //modal.show(); 
        $('#MultiplePay').modal('toggle');
        $('#payCash').addClass('disabled');
        $('#payCard').addClass('disabled');
        $('#payMob').addClass('disabled');
    }

}
$('input.m_payment').on('input', function (e) {
    var cart = Number($('#m_card_payment').val());
    var cash = Number($('#m_cash').val());
    var mobile = Number($('#m_mobile_amount').val());
    var paid=(cart+cash+mobile);
    var total =Number($('#m_total').html());
    $('#m_paid_total').html(Number(paid.toFixed(2)));
    $('#m_due').html(Number((total-paid).toFixed(2)));

});
// $('.paymentTab').click(function () {
//     id = $(this).attr('id');
//     clear_payment();
// });
function clear_payment() {
    $('#cash').val('');
    $('#cash_paid').val('');
    $('#change_amt').val('');
    $('#card_payment').val('');
    $('#card_number').val('');
    $('#card_type').val(0).change();
    $('#bank_name').val(0).change();
    $('#mobile_amount').val('');
    $('#mob_bank_name').val(0).change();
    $('#transaction_no').val('');
    $('#mob_acc_no').val('');
    amount_check();
}
function add_multiple_payment(){
    if (validateMultiple() != false) {
        var total =Number($('#m_total').html());
        var paid=Number($('#m_paid_total').html());
        var due =Number($('#m_due').html());
        var cart = $('#m_card_payment').val() * 1;
        var cash = $('#m_cash').val() * 1;
        var mobile = $('#m_mobile_amount').val() * 1;
        var paid_div=''; var text='';
        if(cash>0){
            paid_div+='Cash='+cash
            text+='<p> Cash:   '+cash+'</p>';
        }
        if(cart>0){
            paid_div+=' Cart='+cart
            text+='<p> Cart:   '+cart+'</p>';
        }
        if(mobile>0){
            paid_div+=' Mob='+mobile
            text+='<p> Mobile: '+mobile+'</p>';
        }
        $('#show_multiple_payment').html(text);
        $('#paid_amount').html(paid);
        $('#paid_div').html(paid_div);
        $('#multiple_payment').val(1);
        //var modal = UIkit.modal("#MultiplePay");
        //modal.hide(); 
        $('#MultiplePay').modal('toggle');
        if ($('#round_check').prop("checked") == true) {
            var tot_due_m = paid - total;
            $('#round').html(Number(tot_due_m.toFixed(2)));
            $('#tot_due_amount').html('00');
        } else {
            var tot_due_p = total - paid;
            $('#tot_due_amount').html(Number(tot_due_p.toFixed(2)));
            $('#round').html('00');
        }
        if(paid==0){
            $('#payCash').removeClass('disabled');
            $('#payCard').removeClass('disabled');
            $('#payMob').removeClass('disabled'); 
        }
    }       
}
function enablePayment(){
    var paid=Number($('#m_paid_total').html());
    if(paid==0){
        $('#payCash').removeClass('disabled');
        $('#payCard').removeClass('disabled');
        $('#payMob').removeClass('disabled'); 
    }
}

function validateMultiple() {
    var error_count = 0;
    var mobile_name='#m_mobile_amount';
    var cash_name='#m_cash';
    var cart_name='#m_card_payment';
    var mobile_cash = $(mobile_name).val();
    var cart = $(cart_name).val();
    var cash = $(cash_name).val();
    if (mobile_cash == '' && cart == '' && cash == '') {
        error_count += 1;
        $(cash_name).focus();
        $(cash_name).addClass("focus_error");
        $(mobile_name).addClass("focus_error");
        $(cart_name).addClass("focus_error");
    } else {
        $(cash_name).removeClass("focus_error");
        $(mobile_name).removeClass("focus_error");
        $(cart_name).removeClass("focus_error");
    }
    if (cart != '') {
        // if ($('#m_card_number').val() == '') {
        //     error_count += 1;
        //     $('#m_card_number').addClass("focus_error");
        // } else {
        //     $('#m_card_number').removeClass("focus_error");
        // }
        var card_type = $('#m_card_type option:selected').val();
        if (card_type == 0) {
            error_count += 1;
            $('#m_card_type').addClass("focus_error");
        } else {
            $('#m_card_type').removeClass("focus_error");
        }
        var bank_name = $('#m_bank_name option:selected').val();
        if (bank_name == 0) {
            error_count += 1;
            $('#m_bank_name').addClass("focus_error");
        } else {
            $('#m_bank_name').removeClass("focus_error");
        }
    }
    if (mobile_cash != '') {
        // if ($('#m_transaction_no').val() == '') {
        //     error_count += 1;
        //     $('#m_transaction_no').addClass("focus_error");
        // } else {
        //     $('#m_transaction_no').removeClass("focus_error");
        // }
        // if ($('#m_mob_acc_no').val() == '') {
        //     error_count += 1;
        //     $('#m_mob_acc_no').addClass("focus_error");
        // } else {
        //     $('#m_mob_acc_no').removeClass("focus_error");
        // }
        var mob_bank_name = $('#m_mob_bank_name option:selected').val();
        if (mob_bank_name == 0) {
            error_count += 1;
            $('#m_mob_bank_name').addClass("focus_error");
        } else {
            $('#m_mob_bank_name').removeClass("focus_error");
        }
    }
    if (error_count > 0) {
        return false;
    } else {
        return true;
    }
}
function validateSalesForm() {
    var error_count = 0;
    var payment_type = $('#multiple_payment').val();
    var customer_id = $('#src_customer_id').val();
    if(payment_type=='1'){
        var mobile_cash = $('#m_mobile_amount').val();
        var cart = $('#m_card_payment').val();
        var cash = $('#m_cash').val(); 
    }else{
        var mobile_cash = $('#mobile_amount').val();
        var cart = $('#card_payment').val();
        var cash = $('#cash').val();  
    }
    // var token_no = $('#token_no').val();
    // if(token_no==''){
    //     $('#sub_check_pro').show();
    //     $('#sub_check_w').hide();
    //     $('#EmptyAlert').modal('toggle');
    //     $('#alert_data').html('<span class="glyphicon glyphicon-warning-sign"></span> Multiple time submit not allow.');
    //     return false;
    // }
    var total = (mobile_cash * 1) + (cart * 1) + (cash * 1);
    if (!$.trim(customer_id)) {
       
        var due = $('#tot_due_amount').html() * 1;
        if (due != 0) {
            $('#sub_check_pro').show();
            $('#sub_check_w').hide();
            $('#emptyAlert').modal('toggle');
            $('#alert_text').html('Due or over payment not allow.');
            return false;
        }
    }
    if ($.trim(customer_id)) {
        var due = $('#tot_due_amount').html() * 1;
        if (due < 0) {
            $('#sub_check_pro').show();
            $('#sub_check_w').hide();
            $('#emptyAlert').modal('toggle');
            $('#alert_text').html('Over payment not allow.');
            return false;
        }
    }
    $("input[name='pro_id[]']").each(function () {
        var id_full = $(this).attr('id');
        var id = id_full.split("_").pop(-1);
        var stk_qty = $('#total_qty_' + id).val() * 1;
        var sale_qty = $('#qty_' + id).val() * 1;
        if (sale_qty > stk_qty) {
            error_count += 1;
            $('#qty_' + id).addClass("focus_error");
            $('#qty_' + id).focus();
        } else {
            $('#qty_' + id).removeClass("focus_error");
        }
    });
    if (mobile_cash == '' && cart == '' && cash == '') {
        error_count += 1;
        if(payment_type==''){
            $('#cash').focus();
            $('#cash').addClass("focus_error");
            $('#mobile_amount').addClass("focus_error");
            $('#card_payment').addClass("focus_error");
        }else{
            $('#multiple_payment_error').html('Multiple Mayment is Empty.');
        }        
    } else {
        $('#multiple_payment_error').html('');
        $('#cash').removeClass("focus_error");
        $('#mobile_amount').removeClass("focus_error");
        $('#card_payment').removeClass("focus_error");
    }
    var change_amt = $('#change_amt').val()*1;
    if(cash != '' && change_amt>0){
        $('#cash').addClass("focus_error");
        $('#cash_paid').addClass("focus_error");
        $('#sub_check_pro').show();
        $('#sub_check_w').hide();
        $('#emptyAlert').modal('toggle');
        $('#alert_text').html('Change amount must be greater than total cash amount.');
        return false;
    }else{
        $('#cash').removeClass("focus_error");
        $('#cash_paid').removeClass("focus_error");
    }
    if (cart != '') {
        if(payment_type==''){
            // if ($('#card_number').val() == '') {
            //     error_count += 1;
            //     $('#card_number').addClass("focus_error");
            // } else {
            //     $('#card_number').removeClass("focus_error");
            // }
            var card_type = $('#card_type option:selected').val();
            if (card_type == 0) {
                error_count += 1;
                $('#card_type').addClass("focus_error");
            } else {
                $('#card_type').removeClass("focus_error");
            }
            var bank_name = $('#bank_name option:selected').val();
            if (bank_name == 0) {
                error_count += 1;
                $('#bank_name').addClass("focus_error");
            } else {
                $('#bank_name').removeClass("focus_error");
            }
        }
    }
    if (mobile_cash != '') {
        if(payment_type==''){
            // if ($('#transaction_no').val() == '') {
            //     error_count += 1;
            //     $('#transaction_no').addClass("focus_error");
            // } else {
            //     $('#transaction_no').removeClass("focus_error");
            // }
            // if ($('#mob_acc_no').val() == '') {
            //     error_count += 1;
            //     $('#mob_acc_no').addClass("focus_error");
            // } else {
            //     $('#mob_acc_no').removeClass("focus_error");
            // }
            var mob_bank_name = $('#mob_bank_name option:selected').val();
            if (mob_bank_name == 0) {
                error_count += 1;
                $('#mob_bank_name').addClass("focus_error");
            } else {
                $('#mob_bank_name').removeClass("focus_error");
            }
        }
    }
    if (error_count > 0) {
        $('#sub_check_pro').show();
        $('#sub_check_w').hide();
        $('#emptyAlert').modal('toggle');
        $('#alert_text').html('Please Fill-up Required Fields.');
        return false;
    } else {
        //$('#token_no').val('');
        return true;
    }

    $(document).ready(function () {
        var hasCustomer = $('#src_customer_id').val() !== '';
        var pointsValue = $('#points').val();
        updateCustomerPoints(pointsValue, hasCustomer);
    });

}
function hold_sale() {
    var cus_id = $('#src_customer_id').val();
    var count=0;
    $('input[name^="pro_id"]').each(function () {
        count++;
    });
    var stock = $('#stock_id_1').val();
    if (count==0) {
        $('#emptyAlert').modal('toggle');
        $('#alert_text').html('Add Product First.');
    } else {
        var dataString = new FormData($('#cart_data')[0]);
        dataString.append('customer_id', cus_id);
        $.ajax({
            type: "POST",
            url: URL+'hold_sale_add',
            data: dataString,
            async: false,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                var result = $.parseJSON(data);
                //console.log(data);
                if (result.status != 'success') {
                    $('#showMessage').html('Error in data insertion.');
                } else {
                    $('#showMessage').html(result.message);
                    $('#showMessage').show();
                    setTimeout(function () {
                        window.location.href = URL+"sales";
                    }, 500);
                }
                $('.loading').fadeOut("slow");
                return false;
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }
}
function restore_hold() {
        $.ajax({
            url: URL+"hold_sale_list",
            type: "GET",
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (data) {
                $('#restore_hold_data').html(data);
                $('.loading').fadeOut("slow");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }

        });
    }

    // Sales Return Start  //

    function invoiceProductList() {
        var invoice=$('#invoice').val();
        $('#invoice_error').html('');
        if(invoice==''){
            $('#invoice_error').html('Enter Invoice No');
        }else{
            $.ajax({
                type: "POST",
                url: URL+'sales_settings/sales/temp_add_return_sale',
                data: {invoice:invoice},
                async: false,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (result) {
                    //alert(result);
                    //console.log(result);
                    $('#resultInvoiceData').html(result);
                    $('.loading').fadeOut("slow");
                    return false;
                }
            });
            return false;
        }
    }

    function checkbox(ele) {
        var id_full=ele.id;
        var id = id_full.split("_").pop(-1);
        if(ele.checked){
            $("#return_qty_"+id).prop('disabled', false);
            $("#selling_price_"+id).prop('disabled', false);
        } else{
            $("#return_qty_"+id).val('');
            $("#return_qty_"+id).prop('disabled', true);
            $("#selling_price_"+id).prop('disabled', true);
        }
    }
    function sale_print_tharmal() {
        $("#sale_view").print({
            globalStyles: false,
            mediaPrint: false,
            stylesheet: "<?= base_url(); ?>themes/default/css/sale_print_view.css",
            iframe: false,
            noPrintSelector: ".avoid-this"
        });

    }
    function changeIdByRows(id,freeQty){
        var count_row=$('#count_row').val()*1;
        var $qty='input[id^="qty_'+id+'"]:last';
        var $pro_id='input[id^="pro_id_'+id+'"]:last';
        var $total_qty='input[id^="total_qty_'+id+'"]:last';
        var $unit_price='input[id^="unit_price_'+id+'"]:last';
        var $discount='input[id^="discount_'+id+'"]:last';
        var $old_discount='input[id^="old_discount_'+id+'"]:last';
        var $discount_amt='input[id^="discount_amt_'+id+'"]:last';
        var $def_vat='input[id^="def_vat_'+id+'"]:last';
        var $old_def_vat='input[id^="old_def_vat_'+id+'"]:last';
        var $def_vat_amt='input[id^="def_vat_amt_'+id+'"]:last';
        var $total_price='input[id^="total_price_'+id+'"]:last';
        var $tr='tr[id^="'+id+'"]:last';
        var $freeIcon='span[id^="freeIcon_'+id+'"]:last';
        
        $($qty).attr("id","qty_"+count_row);
        $($pro_id).attr("id","pro_id_"+count_row);
        $($total_qty).attr("id","total_qty_"+count_row);
        $($unit_price).attr("id","unit_price_"+count_row);
        $($discount).attr("id","discount_"+count_row);
        $($old_discount).attr("id","old_discount_"+count_row);
        $($discount_amt).attr("id","discount_amt_"+count_row);
        $($def_vat).attr("id","def_vat_"+count_row);
        $($old_def_vat).attr("id","old_def_vat_"+count_row);
        $($def_vat_amt).attr("id","def_vat_amt_"+count_row);
        $($total_price).attr("id","total_price_"+count_row);
        $($tr).attr("id",count_row);
        $($freeIcon).attr("id","freeIcon_"+count_row);

        //$($tr).addClass('table-primary');
        
        var show_pro_id= $("#pro_id_"+id).val();
        var show_total_qty= $("#total_qty_"+id).val();
        var show_unit_price= $("#unit_price_"+id).val();
        var show_discount= $("#discount_"+id).val();
        var show_def_vat= $("#def_vat_"+id).val();
        $("#qty_"+count_row).val(freeQty);
        $("#pro_id_"+count_row).val(show_pro_id);
        $("#total_qty_"+count_row).val(show_total_qty);
        $("#unit_price_"+count_row).val(show_unit_price);
        $("#old_discount_"+count_row).val(show_discount);
        $("#old_def_vat_"+count_row).val(show_def_vat);
        $('#freeIcon_' + count_row).show();

        var unit_total=(show_unit_price*freeQty);
        $('#discount_amt_' + count_row).val(unit_total);
        $('#discount_' + count_row).val(100);
        $('#def_vat_amt_' + count_row).val(0);
        $('#def_vat_' + count_row).val(0);
        $('#total_price_' + count_row).val(0);


        var prv_qty=$("#qty_"+id).val()*1;
        prv_qty=prv_qty-freeQty;
        var prv_vat=$("#def_vat_"+id).val()*1;
        unit_total=(show_unit_price*prv_qty);
        
        vat_tot = (unit_total * prv_vat) / 100;
        $("#qty_"+id).val(prv_qty);
        $('#discount_amt_' + id).val(0);
        $('#discount_' + id).val(0);
        $('#def_vat_amt_' + id).val(vat_tot);
        var tot_val = unit_total + vat_tot;
        $('#total_price_' + id).val(tot_val);
        count_row++;
        $('#count_row').val(count_row);
    }
    function show_points(val) {
        $('#cur_pnt').html(val);
    }
    function updateCustomerPoints(points, hasCustomer) {
        var sanitized = Number(points);
        if (!hasCustomer || isNaN(sanitized)) {
            sanitized = 0;
        }
        var displayPoints = sanitized;
        if (Math.floor(displayPoints) !== displayPoints) {
            displayPoints = displayPoints.toFixed(2);
        }
        $('#show_customer_points').html(displayPoints);
        if (hasCustomer) {
            $('#points').val(sanitized);
        } else {
            $('#points').val('');
        }
        $('#remit_point').val('');
        $('#remit_taka_val').val('');
        $('#remit_text').html('0.00');
        $('#remit_summary').hide();
        $('#remit_val').html('');
        $('#remit_error').html('');
        $('#remit').val('');
        var perAmount = Number($('#point_per_amount').val());
        if (hasCustomer && sanitized > 0 && perAmount > 0) {
            $('#remit_val').html('<button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#pointDetails" onclick="show_points(' + sanitized + ')">Redeem</button>');
        }
        var currentTotal = Number($('#grand_total').text());
        if (currentTotal > 0) {
            amount_check();
        }
    }
    function add_remit_point() {
        var rem = $('#remit').val() * 1;
        var total = $('#cur_pnt').html() * 1;
        $('#remit_error').html('');
        if (rem === 0) {
            $('#remit_error').html('Field is required');
        } else if (rem > total) {
            $('#remit_error').html('Point is too large');
        } else {
            var taka = Number($('#point_per_amount').val());
            if (isNaN(taka)) {
                taka = 0;
            }
            var redeemAmount = rem * taka;
            var formattedRedeem = redeemAmount.toFixed(2);
            $('#remit_val').html('<div class="remit-points-show">Remit: ' + rem + '</div>');
            $('#remit_point').val(rem);
            $('#remit_taka_val').val(formattedRedeem);
            $('#remit_text').html(formattedRedeem);
            $('#remit_summary').show();
            $('#remit').val('');
            $('#pointDetails').modal('toggle');
            totalCalculation();
        }

    }

$(document).ready(function () {
    var hasCustomer = $('#src_customer_id').val() !== '';
    var pointsValue = $('#points').val();
    updateCustomerPoints(pointsValue, hasCustomer);
});
