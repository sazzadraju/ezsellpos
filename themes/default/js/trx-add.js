    $(function () {
        $('#dtt_trx').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
        });

        $("input[name='payment_type']").change(function(){
            $("input[name='debit_amount']").val('');
            $("input[name='tot_amount']").val('');
            $('#tot_sub_p').html('');
            var id = $(this).val();
            if(id==2){
                $('#upo').hide(500);
                $('#refund_div').hide(500);
                $('#credit_check_div').hide(500);
                $('#amount_div').show(500);
            }else if(id==3){
                $('#upo').hide(500);
                var credit=$('#supplier_name option:selected').attr('actp');
                $('#refund_div').show(500);
                $('#debit_amount_org').val(credit);
                $('#credit_check_div').hide(500);
                $('#amount_div').hide(500);
            }else{
                $('#refund_div').hide(500);
                $('#upo').show(500);
                $('#credit_check_div').show(500);
                $('input[name="amount_type"][value="1"]').prop("checked", true);
                $('#amount_div').show(500);
            }
        });
        $("input[name='amount_type']").change(function(){
            var id = $(this).val();
            $("input[name='debit_amount']").val('');
            $("input[name='tot_amount']").val('');
            $('#tot_sub_p').html('');
            var credit=$('#supplier_name option:selected').attr('actp');
            if(id==2){
                $('#refund_div').show(500);
                $('#amount_div').hide(500);
                $('#debit_amount_org').val(credit);
            }else if(id==3){
                $('#refund_div').show(500);
                $('#amount_div').show(500);
                $('#debit_amount_org').val(credit);

            }else{
                $('#refund_div').hide(500);
                $('#amount_div').show(500);
            }
        });
        
        $("select#account").change(function(){
            var option = $('option:selected', this).attr('actp');
            var value = $('option:selected', this).val();
            ref_acc_fields_by_account(option,value);
        });
        
        $("select#store").change(function(){
            var stores = [];
            stores.push($(this).val());
            //console.log(JSON.stringify(stores));
            $.ajax({
                type: "POST",
                url: URL + "account-management/transaction/ajx-accounts-under-stores",
                data: {stores : stores},
                success: function (result) {
                    $('#account').html(result);
                }
            });
            
            if(trx_with === 'employee'){
                $.ajax({
                    type: "POST",
                    url: URL + "account-management/transaction/ajx-users-under-stores/1",
                    data: {stores : stores},
                    success: function (result) {
                        $('#employee_id').html(result);
                    }
                });
            }
            if(trx_with === 'customer'){
                $.ajax({
                    type: "POST",
                    url: URL + "account-management/transaction/ajx-customer-list",
                    data: {stores : stores},
                    success: function (result) {
                        $('#customer_name').html(result);
                    }
                });
            }
        });

        $("#pay_method").change(function () {
            ref_acc_fields_by_payment_method($(this).val());
        });
    });
    
    function ref_acc_fields_by_account(acc_type_id,value){
        if(acc_type_id==2||acc_type_id==4){
            $('#h_pay_method').val(1);
        } else if(acc_type_id==3){
            $('#h_pay_method').val(3);
        } else{
            $('#h_pay_method').val(0);
        }
        
        switch(acc_type_id){
            case '1':  // Bank Account
                $('#v_pay_method').show(500);
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').hide(500);
                $('#v_ref_trx_no').hide(500);
                $('select#pay_method option').removeAttr("selected");
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;

            case '3':  // Mobile Bank Account
                $('#v_pay_method').hide(500);
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').show(500);
                $('#v_ref_trx_no').show(500);
                $('select#pay_method option').removeAttr("selected");
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;

            case '2':  // Cash Account
            default:   // other
                $('#v_pay_method').hide(500);
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').hide(500);
                $('#v_ref_trx_no').hide(500);
                $('select#pay_method option').removeAttr("selected");
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;
        }
        $.ajax({
            type: "POST",
            url: URL+'account-management/accountBalanceByID',
            data: 'id='+value,
            async: false,
            success: function (result) {
               $('#account_balance').html(result);
                //alert(result);
            }
        });
    }


    function ref_acc_fields_by_payment_method(payment_method_id){
//        $('#h_pay_method').val($('option:selected', this).attr('actp'));
        
        $('#h_pay_method').val(payment_method_id);
        
        switch(payment_method_id){
            case '2':  // card
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').show(500);
                $('#v_ref_acc_no').show(500);
                $('#v_ref_trx_no').show(500);
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;

            case '3':  // mobile account
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').show(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').show(500);
                $('#v_ref_trx_no').show(500);
                $('select#pay_method option').removeAttr("selected");
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;

            case '4':  // check
                $('#v_ref_bank').show(500);
                $('#select#ref_bank').removeAttr("selected");
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').show(500);
                $('#v_ref_trx_no').hide(500);
                $('select#ref_card option').removeAttr("selected");
                $('#ref_acc_no').val('');
                $('#ref_trx_no').val('');
                break;

            case '1':  // cash
            default:   // other
                $('#v_ref_bank').hide(500);
                $('#v_ref_mobile_bank').hide(500);
                $('#v_ref_card').hide(500);
                $('#v_ref_acc_no').hide(500);
                $('#v_ref_trx_no').hide(500);
                break;
        }
    }
