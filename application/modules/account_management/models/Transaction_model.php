<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Lists accounts for Transaction
     */
    public function listTrxAccounts($stores = [], $acc_type = 0, $acc_use = 0)
    {
        foreach ($stores as $k => $v) {
            if (empty($stores[$k])) unset($stores[$k]);
        }
        if (!(isset($stores) && !empty($stores))) return [];

        $acc_type = (int)$acc_type;
        $acc_use = (int)$acc_use;

        $this->db->select("
            a.id_account AS acc_id,
             a.curr_balance AS curr_balance,
            CASE a.acc_type_id
              WHEN 1 THEN b.bank_name
              WHEN 2 THEN a.account_name
              WHEN 3 THEN b.bank_name
              WHEN 4 THEN a.account_name
              ELSE ''
            END AS acc_name,
            a.account_no AS acc_no,
            a.acc_type_id AS acc_type", FALSE);
        $this->db->from("accounts AS a");
        $this->db->join('accounts_stores AS acs', 'acs.account_id = a.id_account');
        $this->db->join('banks AS b', 'b.id_bank = a.bank_id', 'left');
        if (!empty($acc_type)) {
            $this->db->where("a.acc_type_id", $acc_type);
        }
        if (empty($acc_use)) {
            // Office uses OR Both
            $this->db->where("(a.acc_uses_id = 1 OR a.acc_uses_id = 3)", NULL, FALSE);
        } else {
            $this->db->where("a.acc_uses_id", $acc_use);
        }
        $this->db->where("a.status_id", 1);
        $this->db->where("acs.store_id IN (" . implode(',', $stores) . ")", NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function listTrxUsers($user_type, $stores = [])
    {
        $employees = array();
        $this->db->select("id_user, fullname");
        $this->db->from("users");
        $this->db->where("user_type_id", $user_type);
        $this->db->where("status_id", 1);
        if ($user_type != 2) {
            $this->db->where("store_id IN (" . implode(',', $stores) . ")", NULL, FALSE);
        }
        $this->db->order_by("fullname", "asc");

        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $res) {
            $employees[$res->id_user] = $res->fullname;
        }

        return $employees;
    }

    public function listCustomerUnpaidOrders($customer_id, $store_id = 0)
    {
        $this->db->select("s.id_sale AS id, s.invoice_no, s.tot_amt, s.paid_amt, s.due_amt, s.dtt_add", FALSE);
        $this->db->from("sales AS s");
        $this->db->where("s.customer_id", $customer_id);
        $this->db->where("s.store_id", $store_id);
        $this->db->where("s.status_id", 1);
        $this->db->where("s.settle", 0);
        $this->db->where("s.due_amt >", 0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function office_trx_child_categories($parent_id, $qty_multiplier)
    {
        $data = [];

        $this->db->select("id_transaction_category AS id, trx_name", FALSE);
        $this->db->from("transaction_categories");
        $this->db->where("parent_id", $parent_id);
        $this->db->where("qty_modifier", $qty_multiplier);
        $this->db->where("status_id", 1);

        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as $res) {
            $data[$res['id']] = $res['trx_name'];
        }

        return $data;
    }


    public function ListAccountsUnderStores()
    {
        $stores = array();
        $this->db->select("id_store, store_name");
        $this->db->from("stores");
        $this->db->where("status_id", 1);
        $this->db->where("id_store IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        $this->db->order_by("store_name", "asc");

        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $res) {
            $stores[$res->id_store] = $res->store_name;
        }

        return $stores;
    }

    public function listTrxTypes($trx_with)
    {
        $data = [];

        if ($trx_with == 'office') {
            // LISTS Parent categories
            $this->db->select("id_transaction_category AS id, trx_name, qty_modifier AS qty_multiplier", FALSE);
            $this->db->from("transaction_categories");
            $this->db->where("parent_id", 0);
            $this->db->where("status_id", 1);
            // $this->db->order_by("trx_name asc");
        } else {
            $this->db->select("id_transaction_type AS id, trx_name, qty_multiplier", FALSE);
            $this->db->from("transaction_types");
            $this->db->where("trx_with", $trx_with);
            $this->db->where("status_id", 1);
            $this->db->order_by("sort_order asc", "trx_name asc");
        }

        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $res) {
            $data[$res['qty_multiplier']][$res['id']] = $res['trx_name'];
        }

        return $data;
    }

    public function listSupplierUnpaidPurchases($supplier_id, $store_id = 0)
    {
        $this->db->select('id_purchase_receive AS id, invoice_no, tot_amt, due_amt, paid_amt, dtt_receive', FALSE);
        $this->db->from('purchase_receives');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('store_id', $store_id);
        $this->db->where('status_id', 1);
         $this->db->where("settle", 0);
        $this->db->where('due_amt >', 0);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function addCustomerTransaction($data, $payment_data, $trx_amt, $document_data,$customer_balance)
    {
        try {
            $this->db->trans_start();

            ## INSERT sale_transactions TBL. Get insert_id.
            $trx_id = $this->commonmodel->commonInsertSTP('sale_transactions', $data);
            $this->commonmodel->update_balance_amount('customers', 'balance', $customer_balance, '-', array('id_customer' => $data['customer_id']));
            ## BATCH INSERT transaction_details TBL.
            $trx_det = [];
            foreach ($trx_amt as $ta) {
                if ($ta['pay_amt'] > 0) {
                    $trx_det = [
                        'sale_transaction_id' => $trx_id,
                        'sale_id' => $ta['id'],
                        'amount' => $ta['pay_amt'],
                        'qty_multiplier' => $data['qty_multiplier'],
                        'status_id' => 1,
                        'version' => 1,
                        'dtt_add' => $data['dtt_trx'],
                        'uid_add' => $data['tot_amount'],
                    ];
                    $this->commonmodel->commonInsertSTP('sale_transaction_details', $trx_det);
                }
            }
            // $this->commonmodel->batchInsert('sale_transaction_details', $trx_det);

            ## INSERT sale_transaction_payments TBL.
            $payment_data['sale_transaction_id'] = $trx_id;
            $tmp = $this->commonmodel->commonInsertSTP('sale_transaction_payments', $payment_data);

            ## UPD account current balance
            $this->commonmodel->updAccCurrBalance($payment_data['account_id'], $payment_data['amount'], $data['qty_multiplier']);

            ## UPD sales TBL with paid_amt, due_amt.
            foreach ($trx_amt as $ta) {
                if ($ta['pay_amt'] > 0) {
                    $sales_upd = [
                        'paid_amt' => $ta['paid_amt'] + $ta['pay_amt'],
                        'due_amt' => $ta['due_amt'] - $ta['pay_amt'],
                        'settle' => $ta['settle'],
                        'dtt_mod' => $data['dtt_add'],
                        'uid_mod' => $data['uid_add'],
                    ];
                    $this->commonmodel->commonUpdateSTP('sales', $sales_upd, ['id_sale' => $ta['id']]);
                }
            }

            ## INSERT DOCUMENT FILE RECORDS
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $array2[$key] = $value;
                }
                $array2['ref_id'] = $trx_id;
                $this->commonmodel->commonInsertSTP('documents', $array2);
            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Customer Transaction Save failed.");
            }

            //$msg = "Customer Transaction Saved successfully.";
            $sts = TRUE;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            //$msg = $e->getMessage();
            $sts = FALSE;
        }

        return $sts;
    }

    public function updCustomerTransaction($id, $data, $payment_data, $trx_upd_amt, $trx_del_id, $document_data_del = '', $document_data, $customer_id)
    {
        $response = array('status' => 'failed', 'message' => '');

        try {
            $this->db->trans_start();

            $this->commonmodel->commonUpdateSTP('sale_transactions', $data, ['id_sale_transaction' => $id], TRUE);

            if (!empty($trx_del_id)) {
                ## Deactivate transaction_details and Adjust sales amounts
                $sql = "UPDATE sales s
                    JOIN sale_transaction_details d ON d.sale_id = s.id_sale
                    SET s.due_amt = s.due_amt + d.amount
                    , s.paid_amt = s.paid_amt - d.amount
                    , s.dtt_mod = '{$data['dtt_mod']}' 
                    , s.uid_mod = {$data['uid_mod']}
                    , d.status_id = 2
                    , d.dtt_mod = '{$data['dtt_mod']}'
                    , d.uid_mod = {$data['uid_mod']}
                    , d.version = d.version+1
                    WHERE s.id_sale IN (" . implode($trx_del_id, ',') . ")";
                $this->db->query($sql);
            }

            if (!empty($trx_upd_amt)) {
                foreach ($trx_upd_amt as $ta) {
                    ## UPDATE sale_transaction_details TBL.
                    $trx_det = [
                        'amount' => $ta['pay_amt'],
                        'dtt_mod' => $data['dtt_mod'],
                        'uid_mod' => $data['uid_mod'],
                    ];
                    $where = [
                        'sale_transaction_id' => $id,
                        'sale_id' => $ta['sale_id'],
                    ];
                    $this->commonmodel->commonUpdate('sale_transaction_details', $trx_det, $where, TRUE);

                    ## UPD sales TBL with new paid_amt, due_amt.
                    $sql = "UPDATE sales
                        SET paid_amt = paid_amt + {$ta['pay_amt']} - {$ta['paid_earlier_amt']}
                        , due_amt = {$ta['due_amt']} - {$ta['pay_amt']}
                        , dtt_mod = '{$data['dtt_mod']}'
                        , uid_mod = {$data['uid_mod']}
                        , `version` = `version` + 1
                        WHERE id_sale = {$ta['sale_id']}";
                    $this->db->query($sql);
                }
            }

            ## hold previous value for UPD account current balance
            $tmp = $this->commonmodel->getAmtQtyMultiplierForCustomerTrx($id);

            ## UPDATE sale_transaction_payments TBL.
            $this->commonmodel->commonUpdateSTP('sale_transaction_payments', $payment_data, ['sale_transaction_id' => $id], TRUE);

            ## UPD account current balance
            if ($payment_data['account_id'] == $tmp['account_id']) {
                $this->commonmodel->updAccCurrBalance(
                    $payment_data['account_id'],
                    $payment_data['amount'] - $tmp['amount'],
                    $tmp['qty_multiplier']
                );
            } else {
                // UPD curr_balance of previous account
                $this->commonmodel->updAccCurrBalance(
                    $tmp['account_id'],
                    -1 * $tmp['amount'],
                    $tmp['qty_multiplier']
                );

                // UPD curr_balance of current account
                $this->commonmodel->updAccCurrBalance(
                    $payment_data['account_id'],
                    $payment_data['amount'],
                    $tmp['qty_multiplier']
                );

            }
            $new_balance = 0;
            if ($payment_data['amount'] > $tmp['amount']) {
                $new_balance = $payment_data['amount'] - $tmp['amount'];
                $this->commonmodel->update_balance_amount('customers', 'balance', $new_balance, '-', array('id_customer' => $customer_id));
            } else if ($tmp['amount'] > $payment_data['amount']) {
                $new_balance = $tmp['amount'] - $payment_data['amount'];
                $this->commonmodel->update_balance_amount('customers', 'balance', $new_balance, '+', array('id_customer' => $customer_id));
            }
            $tmp = ['id' => $id, 'dtt_mod' => $data['dtt_mod'], 'uid_mod' => $data['uid_mod']];
            if (!empty($document_data)) {
                $this->updDocumentRecords($tmp, $document_data_del, $document_data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Customer Transaction Update Failed.");
            }

            $response = [
                'status' => 'success',
                'message' => "Customer Transaction Updated successfully."
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            //$msg = $e->getMessage();
            $response = [
                'status' => 'failed',
                'message' => "Customer Transaction Update Failed."
            ];
        }

        return $response;
    }

  

    public function addSupplierTransaction($data, $trx_amt, $document_data = [],$d_amount,$payment_type,$amount_type)
    {
        try {
            $this->db->trans_start();

            ## INSERT transactions TBL. Get insert_id.
            if(!empty($d_amount)){
                $trx_id=$this->commonmodel->commonInsertSTP('transactions', $d_amount);
            }
            if($amount_type!=2){
                $trx_id = $this->commonmodel->commonInsertSTP('transactions', $data);
            }

            if(($payment_type==1 &&$amount_type==1) || ($payment_type==1 && $amount_type==3)){
                $this->commonmodel->update_balance_amount('suppliers', 'balance', $data['tot_amount'], '-', array('id_supplier' => $data['ref_id']));
            }
            if($payment_type==2){
                $this->commonmodel->update_balance_amount('suppliers', 'credit_balance', $data['tot_amount'], '+', array('id_supplier' => $data['ref_id']));
            }
            if(($payment_type==1 &&$amount_type==2) || ($payment_type==1 && $amount_type==3)){
                $this->commonmodel->update_balance_amount('suppliers', 'credit_balance', $d_amount['tot_amount'], '-', array('id_supplier' => $data['ref_id']));
            }
            if($payment_type==3){
                $this->commonmodel->update_balance_amount('suppliers', 'credit_balance', $data['tot_amount'], '-', array('id_supplier' => $data['ref_id']));
            }
            ## UPD account current balance
            if($payment_type==3){
                $this->commonmodel->updAccCurrBalance($data['account_id'], $data['tot_amount'], 1);
            }else if($data['tot_amount']!=''){
                $this->commonmodel->updAccCurrBalance($data['account_id'], $data['tot_amount'], $data['qty_multiplier']);
            }

            $trx_det = [];
            ## BATCH INSERT transaction_details TBL.
            if($payment_type==1){
                foreach ($trx_amt as $ta) {
                    if ($ta['pay_amt'] > 0) {
                        $trx_det = [
                            'transaction_id' => $trx_id,
                            'ref_id' => $ta['id'],
                            'amount' => $ta['pay_amt'],
                            'qty_multiplier' => $data['qty_multiplier'],
                            'dtt_add' => $data['dtt_add'],
                            'uid_add' => $data['uid_add'],
                            'status_id' => 1,
                            'version' => 1,
                        ];
                        $this->commonmodel->commonInsertSTP('transaction_details', $trx_det);
                    }
                }
                ## UPD purchase_receives TBL with paid_amt, due_amt.
                foreach ($trx_amt as $ta) {
                    if ($ta['pay_amt'] > 0) {
                        $purchsrcv_upd = [
                            'paid_amt' => $ta['paid_amt'] + $ta['pay_amt'],
                            'due_amt' => $ta['due_amt'] - $ta['pay_amt'],
                            'settle'  => $ta['settle'],
                            'dtt_mod' => $data['dtt_add'],
                            'uid_mod' => $data['uid_add'],
                        ];
                        $this->commonmodel->commonUpdateSTP('purchase_receives', $purchsrcv_upd, ['id_purchase_receive' => $ta['id']]);
                    }
                }
            }

            ## INSERT DOCUMENT FILE RECORDS
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $array2[$key] = $value;
                }
                $array2['ref_id'] = $trx_id;
                $this->commonmodel->commonInsertSTP('documents', $array2);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Supplier Transaction Save failed.");
            }

            $msg = "Supplier Transaction Saved successfully.";
            $sts = TRUE;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
        }

        return $sts;
    }


    public function updSupplierTransaction($id, $data, $trx_upd_amt, $trx_del_id, $trx_del_amt, $document_data_del = '', $document_data = [])
    {
        $response = array('status' => 'failed', 'message' => '');

        try {
            $this->db->trans_start();

            ## hold previous value for UPD account current balance
            $tmp = $this->commonmodel->getAmtQtyMultiplierForOtherTrx($id);

            ## UPD transactions TBL.
            $this->commonmodel->commonUpdateSTP('transactions', $data, ['id_transaction' => $id], TRUE);

            ## UPD account current balance
            if ($data['account_id'] == $tmp['account_id']) {
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'] - $tmp['amount'],
                    $tmp['qty_multiplier']
                );
            } else {
                // UPD curr_balance of previous account
                $this->commonmodel->updAccCurrBalance(
                    $tmp['account_id'],
                    -1 * $tmp['amount'],
                    $tmp['qty_multiplier']
                );

                // UPD curr_balance of current account
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'],
                    $tmp['qty_multiplier']
                );
            }

            if (!empty($trx_del_id)) {
                ## Deactivate transaction_details and Adjust purchase_receives amounts
                $sql = "UPDATE purchase_receives r
                    JOIN transaction_details d ON d.ref_id = r.id_purchase_receive
                    SET r.due_amt = r.due_amt + d.amount
                    , r.paid_amt = r.paid_amt - d.amount
                    , r.dtt_mod = '{$data['dtt_mod']}'
                    , r.uid_mod = {$data['uid_mod']}
                    , d.status_id = 2
                    , d.dtt_mod = '{$data['dtt_mod']}'
                    , d.uid_mod = {$data['uid_mod']}
                    , d.`version` = d.`version`+1
                    WHERE d.transaction_id = {$id}
                    AND d.ref_id IN (" . implode($trx_del_id, ',') . ")";
                $this->db->query($sql);
            }

            if (!empty($trx_upd_amt)) {
                foreach ($trx_upd_amt as $ta) {
                    ## UPDATE transaction_details TBL.
                    $trx_det = [
                        'amount' => $ta['pay_amt'],
                        'dtt_mod' => $data['dtt_mod'],
                        'uid_mod' => $data['uid_mod'],
                    ];

                    $where = [
                        'transaction_id' => $id,
                        'ref_id' => $ta['id'],
                    ];
                    $this->commonmodel->commonUpdateSTP('transaction_details', $trx_det, $where, TRUE);

                    ## UPD purchase_receives TBL with new paid_amt, due_amt.
                    $sql = "UPDATE purchase_receives
                        SET paid_amt = paid_amt + {$ta['pay_amt']} - {$ta['paid_earlier_amt']}
                        , due_amt = due_amt - {$ta['pay_amt']}
                        , dtt_mod = '{$data['dtt_mod']}'
                        , uid_mod = {$data['uid_mod']}
                        , `version` = `version` + 1
                        WHERE id_purchase_receive = {$ta['id']}";
                    $this->db->query($sql);
                }
            }

            ## UPDATE DOCUMENT FILE RECORDS
            $tmp = ['id' => $id, 'dtt_mod' => $data['dtt_mod'], 'uid_mod' => $data['uid_mod']];
            if (!empty($document_data)) {
                $this->updDocumentRecords($tmp, $document_data_del, $document_data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Supplier Transaction Save failed.");
            }

            $response = [
                'status' => 'success',
                'message' => "Supplier Transaction Saved successfully."
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
            $response = [
                'status' => 'failed',
                'message' => "Supplier Transaction Save Failed."
            ];
        }

        return $response;
    }

    public function addOfficeTransaction($data, $document_data = [])
    {
        try {
            $this->db->trans_start();

            ## INSERT transactions TBL. Get insert_id.
            $trx_id = $this->commonmodel->commonInsertSTP('transactions', $data);

            ## UPD account current balance
            $this->commonmodel->updAccCurrBalance($data['account_id'], $data['tot_amount'], $data['qty_multiplier']);

            ## INSERT DOCUMENT FILE RECORDS
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $array2[$key] = $value;
                }
                $array2['ref_id'] = $trx_id;
                $this->commonmodel->commonInsertSTP('documents', $array2);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Office Transaction Save failed.");
            }

            $msg = "Office Transaction Saved successfully.";
            $sts = TRUE;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
        }

        return $sts;
    }


    public function updOfficeTransaction($id, $data, $document_data_del = '', $document_data = [])
    {
        $response = array('status' => 'failed', 'message' => '');

        try {
            $this->db->trans_start();

            ## hold previous value for UPD account current balance
            $tmp = $this->commonmodel->getAmtQtyMultiplierForOtherTrx($id);

            ## UPD transactions TBL.
            $this->commonmodel->commonUpdateSTP('transactions', $data, ['id_transaction' => $id], TRUE);

            ## UPD account current balance
            if ($data['account_id'] == $tmp['account_id']) {
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'] - $tmp['amount'],
                    $tmp['qty_multiplier']
                );
            } else {
                // UPD curr_balance of previous account
                $this->commonmodel->updAccCurrBalance(
                    $tmp['account_id'],
                    -1 * $tmp['amount'],
                    $tmp['qty_multiplier']
                );

                // UPD curr_balance of current account
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'],
                    $tmp['qty_multiplier']
                );
            }

            $tmp = ['id' => $id, 'dtt_mod' => $data['dtt_mod'], 'uid_mod' => $data['uid_mod']];
            if (!empty($document_data)) {
                $this->updDocumentRecords($tmp, $document_data_del, $document_data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Customer Transaction Save failed.");
            }

            $response = [
                'status' => 'success',
                'message' => "Office Transaction Saved successfully."
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
            $response = [
                'status' => 'failed',
                'message' => "Office Transaction Save Failed."
            ];
        }

        return $response;
    }


    public function addEmployeeTransaction($data, $ref_id, $document_data = [])
    {
        try {
            $this->db->trans_start();

            ## INSERT transactions TBL. Get insert_id.
            $trx_id = $this->commonmodel->commonInsertSTP('transactions', $data);

            ## INSERT transaction_details TBL.
            $emp_trx = [
                'transaction_id' => $trx_id,
                'ref_id' => $ref_id,
                'qty_multiplier' => $data['qty_multiplier'],
                'dtt_add' => $data['dtt_add'],
                'uid_add' => $data['uid_add'],
                'status_id' => $data['status_id'],
                'version' => $data['version'],
            ];
            $emp_trx_id = $this->commonmodel->commonInsertSTP('transaction_details', $emp_trx);

            ## UPD account current balance
            $this->commonmodel->updAccCurrBalance($data['account_id'], $data['tot_amount'], $data['qty_multiplier']);

            ## INSERT DOCUMENT FILE RECORDS
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $array2[$key] = $value;
                }
                $array2['ref_id'] = $trx_id;
                $this->commonmodel->commonInsertSTP('documents', $array2);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Employee Transaction Save failed.");
            }

            $msg = "Employee Transaction Saved successfully.";
            $sts = TRUE;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            $sts = FALSE;
        }

        return $sts;
    }


    public function updEmployeeTransaction($id, $data, $document_data_del = '', $document_data = [])
    {
        try {
            $this->db->trans_start();

            ## hold previous value for UPD account current balance
            $tmp = $this->commonmodel->getAmtQtyMultiplierForOtherTrx($id);

            ## UPD transactions TBL.
            $this->commonmodel->commonUpdateSTP('transactions', $data, ['id_transaction' => $id], TRUE);

            ## UPD account current balance
            if ($data['account_id'] == $tmp['account_id']) {
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'] - $tmp['amount'],
                    $tmp['qty_multiplier']
                );
            } else {
                // UPD curr_balance of previous account
                $this->commonmodel->updAccCurrBalance(
                    $tmp['account_id'],
                    -1 * $tmp['amount'],
                    $tmp['qty_multiplier']
                );

                // UPD curr_balance of current account
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'],
                    $tmp['qty_multiplier']
                );
            }

            $tmp = ['id' => $id, 'dtt_mod' => $data['dtt_mod'], 'uid_mod' => $data['uid_mod']];
            if (!empty($document_data)) {
                $this->updDocumentRecords($tmp, $document_data_del, $document_data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Employee Transaction Save failed.");
            }

            $response = [
                'status' => 'success',
                'message' => "Employee Transaction Saved successfully."
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'failed',
                'message' => "Employee Transaction Save Failed."
            ];
        }

        return $response;
    }

    public function addInvestorTransaction($data, $trx_type_id, $document_data = [])
    {
        try {
            $this->db->trans_start();

            ## INSERT transactions TBL. Get insert_id.
            $trx_id = $this->commonmodel->commonInsertSTP('transactions', $data);

            $qty_mult = 0;

            if ($data['qty_multiplier'] == '1') {
                $qty_mult = 1;
                $this->commonmodel->update_balance_amount('users', 'balance', $data['tot_amount'], '+', array('id_user' => $data['ref_id']));
            } else if ($data['qty_multiplier'] == '-1') {
                $qty_mult = -1;
                $this->commonmodel->update_balance_amount('users', 'balance', $data['tot_amount'], '-', array('id_user' => $data['ref_id']));
            } else if ($data['qty_multiplier'] == '0') {
                $qty_mult = -1;
            }

            ## UPD account current balance
            $this->commonmodel->updAccCurrBalance($data['account_id'], $data['tot_amount'], $qty_mult);

            ## INSERT DOCUMENT FILE RECORDS
            if (!empty($document_data)) {
                foreach ($document_data as $key => $value) {
                    $array2[$key] = $value;
                }
                $array2['ref_id'] = $trx_id;
                $this->commonmodel->commonInsertSTP('documents', $array2);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Investor Transaction Save failed.");
            }

            $msg = "Investor Transaction Saved successfully.";
            $sts = TRUE;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            //$msg = $e->getMessage();
            $msg = "Investor Transaction Save failed.";
            $sts = FALSE;
        }

        return $sts;
    }

    public function updInvestorTransaction($id, $data, $document_data_del = '', $document_data = [])
    {
        try {
            $this->db->trans_start();

            ## hold previous value for UPD account current balance
            $tmp = $this->commonmodel->getAmtQtyMultiplierForOtherTrx($id);

            ## UPD transactions TBL.
            $this->commonmodel->commonUpdateSTP('transactions', $data, ['id_transaction' => $id], TRUE);

            ## UPD account current balance
            if ($data['account_id'] == $tmp['account_id']) {
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'] - $tmp['amount'],
                    $tmp['qty_multiplier']
                );
            } else {
                // UPD curr_balance of previous account
                $this->commonmodel->updAccCurrBalance(
                    $tmp['account_id'],
                    -1 * $tmp['amount'],
                    $tmp['qty_multiplier']
                );

                // UPD curr_balance of current account
                $this->commonmodel->updAccCurrBalance(
                    $data['account_id'],
                    $data['tot_amount'],
                    $tmp['qty_multiplier']
                );
            }

            $tmp = ['id' => $id, 'dtt_mod' => $data['dtt_mod'], 'uid_mod' => $data['uid_mod']];
            if (!empty($document_data)) {
                $this->updDocumentRecords($tmp, $document_data_del, $document_data);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Employee Transaction Save failed.");
            }

            $response = [
                'status' => 'success',
                'message' => "Employee Transaction Saved successfully."
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'failed',
                'message' => "Employee Transaction Save Failed."
            ];
        }

        return $response;
    }

    public function listTransactions($type, $limit, $offset = 0)
    {
        $data = ['total' => '', 'items' => []];

        switch ($type) {
            case 'customer':
                $data['total'] = $this->totCustomerTrx();
                $data['items'] = $this->listCustomerTrx($data['total'], $limit, $offset);
                break;

            case 'supplier':
                $data['total'] = $this->totSupplierTrx();
                $data['items'] = $this->listSupplierAllTrx($data['total'], $limit, $offset);
                break;

            case 'office':
                $data['total'] = $this->totOfficeTrx();
                $data['items'] = $this->listOfficeTrx($data['total'], $limit, $offset);
                break;

            case 'employee':
                $data['total'] = $this->totEmployeeTrx();
                $data['items'] = $this->listEmployeeTrx($data['total'], $limit, $offset);
                break;

            case 'investor':
                $data['total'] = $this->totInvestorTrx();
                $data['items'] = $this->listInvestorTrx($data['total'], $limit, $offset);
                break;

            default:
                $data = ['total' => '', 'items' => []];
                break;
        }

        return $data;
    }

    public function searchTransactions($type, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $inv_no = '',$store_id='')
    {
        $data = ['total' => '', 'items' => []];

        switch ($type) {
            case 'customer':
                $data['total'] = $this->totCustomerTrx($date_from, $date_to, $trx_no, $inv_no,$store_id);
                $data['items'] = $this->listCustomerTrx($data['total'], $limit, $offset, $date_from, $date_to, $trx_no, $inv_no,$store_id);
                break;

            case 'supplier':
                $data['total'] = $this->totSupplierTrx($date_from, $date_to, $trx_no, $inv_no,$store_id);
                $data['items'] = $this->listSupplierTrx($data['total'], $limit, $offset, $date_from, $date_to, $trx_no, $inv_no,$store_id);
                break;

            case 'office':
                $data['total'] = $this->totOfficeTrx($date_from, $date_to, $trx_no,$store_id);
                $data['items'] = $this->listOfficeTrx($data['total'], $limit, $offset, $date_from, $date_to, $trx_no,$store_id);
                break;

            case 'employee':
                $data['total'] = $this->totEmployeeTrx($date_from, $date_to, $trx_no,$store_id);
                $data['items'] = $this->listEmployeeTrx($data['total'], $limit, $offset, $date_from, $date_to, $trx_no,$store_id);
                break;

            case 'investor':
                $data['total'] = $this->totInvestorTrx($date_from, $date_to, $trx_no,$store_id);
                $data['items'] = $this->listInvestorTrx($data['total'], $limit, $offset, $date_from, $date_to, $trx_no,$store_id);
                break;

            default:
                $data = ['total' => '', 'items' => []];
                break;
        }

        return $data;
    }

    public function totCustomerTrx($date_from = '', $date_to = '', $trx_no = '', $invoice_no = '', $store_id = '')
    {
        $this->db->select("1 AS id", FALSE);
        $this->db->from("sale_transactions AS t");
        $this->db->join('sale_transaction_details AS td', "td.sale_transaction_id = t.id_sale_transaction AND td.status_id=1 AND t.status_id=1");
        $this->db->join('sales AS s', 's.id_sale = td.sale_id');
        $this->db->join('customers AS c', 'c.id_customer=t.customer_id');
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($invoice_no)) {
            $this->db->where("s.invoice_no LIKE ", '%' . trim($invoice_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->group_by("t.id_sale_transaction");

        return $this->db->count_all_results();
    }

    public function listCustomerTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $invoice_no = '', $store_id = '')
    {
        $this->db->select("
            t.id_sale_transaction AS id
          , t.trx_no
          , GROUP_CONCAT(DISTINCT s.invoice_no SEPARATOR '<br> ') as inv_no
          , c.full_name AS customer_name
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          , t.store_id
          ", FALSE);
        $this->db->from("sale_transactions AS t");
        $this->db->join('sale_transaction_details AS td', "td.sale_transaction_id = t.id_sale_transaction AND td.status_id=1 AND td.qty_multiplier=1");
        $this->db->join('sales AS s', 's.id_sale = td.sale_id');
        $this->db->join('customers AS c', 'c.id_customer=t.customer_id');
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($invoice_no)) {
            $this->db->where("s.invoice_no LIKE ", '%' . trim($invoice_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->group_by("t.id_sale_transaction");
        $this->db->order_by("t.dtt_trx DESC, t.id_sale_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function totSupplierTrx($date_from = '', $date_to = '', $trx_no = '', $inv_no = '', $store_id = '')
    {
        $this->db->select("1 AS id", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details AS d', 't.id_transaction = d.transaction_id');
        $this->db->join('purchase_receives AS p', 'p.id_purchase_receive = d.ref_id AND p.status_id=1');
        $this->db->join('suppliers AS s', 's.id_supplier = t.ref_id');
        $this->db->where("t.trx_with", 'supplier');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($inv_no)) {
            $this->db->where("p.invoice_no LIKE ", '%' . trim($inv_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->group_by("t.id_transaction");

        return $this->db->count_all_results();
    }

    public function listSupplierTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $inv_no = '', $store_id = '')
    {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , GROUP_CONCAT(DISTINCT p.invoice_no SEPARATOR '<br>') AS inv_no
          , s.supplier_name AS supplier_name
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          , t.store_id
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details AS d', 't.id_transaction = d.transaction_id','left');
        $this->db->join('purchase_receives AS p', 'p.id_purchase_receive = d.ref_id AND p.status_id=1');
        $this->db->join('suppliers AS s', 's.id_supplier = t.ref_id');
        $this->db->where("t.trx_with", 'supplier');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($inv_no)) {
            $this->db->where("p.invoice_no LIKE ", '%' . trim($inv_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->group_by("t.id_transaction");
        $this->db->order_by("t.dtt_trx DESC, t.id_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }
    public function listSupplierAllTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $inv_no = '', $store_id = '')
    {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , s.supplier_name AS supplier_name
          , GROUP_CONCAT(DISTINCT p.type_name SEPARATOR ',') AS type_name
          , sum(t.tot_amount) tot_amount
          , t.trx_mvt_type_id
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          , t.store_id
          ", FALSE);
        // , CONCAT(s.supplier_code, ': ', s.supplier_name) AS supplier_name
        $this->db->from("transactions AS t");
        $this->db->join('transaction_mvt_types AS p', 'p.id_transaction_mvt_type = t.trx_mvt_type_id');
        $this->db->join('suppliers AS s', 's.id_supplier = t.ref_id');
        $this->db->where("t.trx_with", 'supplier');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($inv_no)) {
            $this->db->where("p.invoice_no LIKE ", '%' . trim($inv_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.id_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }


    public function totOfficeTrx($date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("1 AS id", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_categories AS c', 'c.id_transaction_category = t.ref_id');
        $this->db->where("t.trx_with", 'office');
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->where("t.status_id", 1);
        return $this->db->count_all_results();
    }

    public function listOfficeTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          , t.store_id
          ", FALSE);
        // , c.trx_name AS type_name
        $this->db->from("transactions AS t");
        //$this->db->join('transaction_categories AS c', 'c.id_transaction_category = t.ref_id');
        $this->db->where("t.trx_with", 'office');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->order_by("t.dtt_trx DESC, t.id_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function totEmployeeTrx($date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("1 AS id", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details d', 'd.transaction_id = t.id_transaction');
        $this->db->join('transaction_types AS tt', 'tt.id_transaction_type = d.ref_id');
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'employee');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        return $this->db->count_all_results();
    }

    public function listEmployeeTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("
          t.id_transaction AS id
        , t.`trx_no`
        , u.fullname AS emp_name
        , tt.trx_name
        , t.tot_amount
        , t.qty_multiplier
        , DATE(t.dtt_trx) AS transaction_date
        , t.description
        , t.store_id
        ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details d', 'd.transaction_id = t.id_transaction');
        $this->db->join('transaction_types AS tt', 'tt.id_transaction_type = d.ref_id');
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'employee');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->order_by("t.dtt_trx DESC, t.id_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function totInvestorTrx($date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("1 AS id", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'investor');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        return $this->db->count_all_results();
    }

    public function listInvestorTrx($total, $limit, $offset = 0, $date_from = '', $date_to = '', $trx_no = '', $store_id = '')
    {
        $this->db->select("
          t.id_transaction AS id
        , t.trx_no
        , u.fullname AS type_name
        , t.tot_amount
        , t.qty_multiplier
        , DATE(t.dtt_trx) AS transaction_date
        , t.description
        , t.store_id
        ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->where("t.trx_with", 'investor');
        $this->db->where("t.status_id", 1);
        if (!empty($store_id)) {
            $this->db->where("t.store_id", $store_id);
        }
        else if ($this->session->userdata['login_info']['user_type_i92'] != 3) {
            $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        }
        if (!empty($trx_no)) {
            $this->db->where("t.trx_no LIKE ", '%' . trim($trx_no) . '%');
        }
        if (!empty($date_from)) {
            $this->db->where("t.dtt_trx >=", $date_from . ' 00:00:00');
        }
        if (!empty($date_to)) {
            $this->db->where("t.dtt_trx <=", $date_to . ' 23:59:59');
        }
        $this->db->order_by("t.dtt_trx DESC, t.id_transaction DESC");

        if (isset($limit) && $total > $limit) {
            if (isset($offset)) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function trxDetails($type, $id)
    {
        switch ($type) {
            case 'customer':
                $data = $this->getCustomerTrxDetails($id);
                break;

            case 'supplier':
                $data = $this->getSupplierTrxDetails($id);
                break;

            case 'office':
                $data = $this->getOfficeTrxDetails($id);
                break;

            case 'employee':
                $data = $this->getEmployeeTrxDetails($id);
                break;

            case 'investor':
                $data = $this->getInvestorTrxDetails($id);
                break;

            default:
                $data = [];
                break;
        }
        return $data;
    }

    public function getDocument($id)
    {
        $this->db->select("id_document,name,description,file");
        $this->db->from("documents");
        $this->db->where('doc_type', 'Transaction');
        $this->db->where('ref_id', $id);
        $this->db->where('status_id',1);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCustomerTrxDetails($id)
    {

        $this->db->select("
            t.id_sale_transaction
          , t.trx_no
          , t.customer_id
          , c.full_name
          , t.store_id
          , t.description
          , t.tot_amount
          , t.qty_multiplier
          , t.is_doc_attached
          , t.dtt_trx
          , t.status_id
          ", FALSE);
        $this->db->from("sale_transactions AS t");
        $this->db->join('customers AS c', 'c.id_customer = t.customer_id');
        $this->db->where('t.id_sale_transaction', $id);
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_ids']);
        //$this->db->where("t.store_id IN (".implode(',', $this->session->userdata['login_info']['store_ids']).")", NULL, FALSE);
        $query = $this->db->get();
        $data = $query->result_array();

        if (isset($data[0])) {
            $data[0]['trx_details'] = $this->customerTrxDetails($id);
            $data[0]['payment_details'] = $this->customerPaymentDetails($id);
            $data[0]['documents'] = $this->listDocuments($id);
            return $data[0];
        }

        return [];
    }

    public function customerTrxDetails($id)
    {
        $this->db->select("
            d.id_sale_transaction_detail AS id
          , d.sale_id
          , s.invoice_no
          , d.amount
          , s.due_amt
          , s.tot_amt
          ", FALSE);
        $this->db->from("sale_transaction_details AS d");
        $this->db->join('sales AS s', 's.id_sale = d.sale_id AND s.status_id = 1');
        $this->db->where('d.sale_transaction_id', $id);
        $this->db->where('d.status_id', 1);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function customerPaymentDetails($id)
    {
        $this->db->select("
            p.id_sale_transaction_payment AS id
          , p.amount
          , p.account_id
          , a.acc_type_id
          , a.account_name
          , p.payment_method_id
          , p.ref_acc_no
          , p.ref_bank_id
          , p.ref_card_id
          , p.ref_trx_no
          ", FALSE);
        $this->db->from("sale_transaction_payments AS p");
        $this->db->join("accounts AS a", "a.id_account = p.account_id");
        $this->db->where('p.sale_transaction_id', $id);
        $this->db->where('p.status_id', 1);
        $this->db->group_by('p.id_sale_transaction_payment');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function customerTrxData($id)
    {
        $this->db->select("
            s.invoice_no
          , s.tot_amt
          , d.amount
          , d.ref_id
          , s.due_amt
          , d.status_id
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details AS d', 't.id_transaction = d.transaction_id');
        $this->db->join('sales AS s', 's.id_sale = d.ref_id');
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where('t.trx_with', 'customer');
        $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        $this->db->where("d.status_id", 1);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSupplierTrxDetails($trx_id)
    {

        $this->db->select("
            t.id_transaction
          , t.trx_no
          , t.dtt_add
          , c.id_supplier AS supplier_id
          , c.supplier_name
          , c.supplier_code
          , c.phone
          , ur.fullname
          , s.store_name
          , s.address_line
          , t.tot_amount
          , t.qty_multiplier
          , t.dtt_trx
          , t.description
          , t.account_id
          , a.acc_type_id
          , fn_account_name_by_id(t.account_id) AS account_name
          , t.payment_method_id
          , t.ref_bank_id
          , t.ref_card_id
          , t.ref_acc_no
          , t.ref_trx_no
          , t.is_doc_attached
          , t.store_id
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('suppliers AS c', 'c.id_supplier = t.ref_id');
        $this->db->join('stores AS s', 's.id_store = t.store_id');
        $this->db->join('accounts AS a', 'a.id_account = t.account_id');
        $this->db->join('users AS ur', 'ur.id_user = t.uid_add');
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where('t.trx_with', 'supplier');
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_ids']);
        //$this->db->where("t.store_id IN (".implode(',', $this->session->userdata['login_info']['store_ids']).")", NULL, FALSE);
        $this->db->where("t.status_id", 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();

        if (isset($data[0])) {
            $data[0]['trx_details'] = [];
            $data[0]['trx_details'] = $this->supplierTrxData($trx_id);
            if ($data[0]['is_doc_attached']) {
                $data[0]['documents'] = $this->listDocuments($trx_id);
            }
            return $data[0];
        }

        return [];
    }
    
    public function getSupplierTrxIdDetails($trx_id)
    {
        $this->db->select("
            t.id_transaction
          , t.trx_no
          , t.dtt_add
          , c.id_supplier AS supplier_id
          , c.supplier_name
          , c.supplier_code
          , c.phone
          , ur.fullname
          , s.store_name
          , s.address_line
          , t.tot_amount
          , t.qty_multiplier
          , t.dtt_trx
          , t.description
          , t.account_id
          , a.acc_type_id
          , fn_account_name_by_id(t.account_id) AS account_name
          , t.payment_method_id
          , t.ref_bank_id
          , t.ref_card_id
          , t.ref_acc_no
          , t.ref_trx_no
          , t.is_doc_attached
          , t.store_id
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('suppliers AS c', 'c.id_supplier = t.ref_id');
        $this->db->join('stores AS s', 's.id_store = t.store_id');
        $this->db->join('accounts AS a', 'a.id_account = t.account_id');
        $this->db->join('users AS ur', 'ur.id_user = t.uid_add');
        $this->db->where('t.trx_no', $trx_id);
        $this->db->where('t.trx_with', 'supplier');
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_ids']);
        //$this->db->where("t.store_id IN (".implode(',', $this->session->userdata['login_info']['store_ids']).")", NULL, FALSE);
        $this->db->where("t.status_id", 1);
        $this->db->group_by("t.trx_no");
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();

        if (isset($data[0])) {
            $data[0]['trx_details'] = [];
            $data[0]['trx_details'] = $this->supplierTrxNoData($trx_id);
            if ($data[0]['is_doc_attached']) {
                $data[0]['documents'] = $this->listDocuments($trx_id);
            }
            return $data[0];
        }

        return [];
    }
    public function getSupplierTrxPayment($trx_no)
    {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , t.tot_amount
          , t.trx_mvt_type_id
          , t.qty_multiplier
          , p.type_name
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_mvt_types AS p', 'p.id_transaction_mvt_type = t.trx_mvt_type_id');
        $this->db->where("t.trx_no", $trx_no);
        $this->db->where("t.status_id", 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function supplierTrxData($trx_id)
    {
        $this->db->select("
            p.invoice_no
          , p.tot_amt
          , d.amount
          , d.ref_id, 
          , p.due_amt
          , d.status_id
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details AS d', 't.id_transaction = d.transaction_id');
        $this->db->join('purchase_receives AS p', 'p.id_purchase_receive = d.ref_id');
        $this->db->where('d.transaction_id', $trx_id);
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        $this->db->where("d.status_id", 1);
        $this->db->group_by('p.id_purchase_receive');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function supplierTrxNoData($trx_id)
    {
        $this->db->select("id_transaction");
        $this->db->from("transactions");
        $this->db->where("trx_no", $trx_id);
        $this->db->order_by("id_transaction", 'DESC');
        $query = $this->db->get();
        $data= ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        $this->db->select("
            p.invoice_no
          , p.tot_amt
          , d.amount
          , d.ref_id, 
          , p.due_amt
          , d.status_id
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_details AS d', 't.id_transaction = d.transaction_id');
        $this->db->join('purchase_receives AS p', 'p.id_purchase_receive = d.ref_id');
        $this->db->where('d.transaction_id', $data[0]['id_transaction']);
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        $this->db->where("d.status_id", 1);
        $this->db->group_by('p.id_purchase_receive');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOfficeTrxDetails($trx_id)
    {

        $this->db->select("
            t.id_transaction
          , t.trx_no
          , t.dtt_add
          , t.ref_id AS type_id
          , '0' AS child_type_id
          , s.store_name
          , s.address_line
          , u.fullname
          , t.tot_amount
          , t.qty_multiplier
          , t.dtt_trx
          , t.description
          , a.acc_type_id
          , t.account_id
          , t.store_id
          , fn_account_name_by_id(t.account_id) AS account_name
          , t.payment_method_id
          , t.ref_bank_id
          , t.ref_card_id
          , t.ref_acc_no
          , t.ref_trx_no
          , t.is_doc_attached
          , tc.trx_name sub_category
          , tsc.trx_name category
          ", FALSE);
          //, tc.trx_name AS type_name

        $this->db->from("transactions AS t");
        $this->db->join('transaction_categories AS tc', 'tc.id_transaction_category = t.ref_id','left');
        $this->db->join('transaction_categories AS tsc', 'tsc.id_transaction_category = tc.parent_id','left');
        $this->db->join('accounts AS a', 'a.id_account = t.account_id');
        $this->db->join('stores AS s', 's.id_store = t.store_id');
        $this->db->join('users AS u', 'u.id_user = t.uid_add');
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where('t.trx_with', 'office');
        //$this->db->where('t.store_id', $this->session->userdata['login_info']['store_ids']);
        $this->db->where("t.store_id IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        $this->db->where("t.status_id", 1);
        $query = $this->db->get();
        $data = $query->result_array();

        if (isset($data[0])) {
            // reset type_id and child_type_id
            $tmp = $this->get_parent_type_id_for_office($data[0]['type_id']);
            $data[0]['type_id'] = $tmp['type_id'];
            $data[0]['child_type_id'] = $tmp['child_type_id'];

            $data[0]['documents'] = $this->listDocuments($trx_id);

            return $data[0];
        }

        return [];
    }

    public function get_parent_type_id_for_office($id)
    {
        $data = ['type_id' => $id, 'child_type_id' => 0];

        $this->db->select("parent_id");
        $this->db->from("transaction_categories");
        $this->db->where("id_transaction_category", $id);
        $query = $this->db->get();
        $res = $query->row();
        if (!empty($res->parent_id)) {
            $data = ['type_id' => $res->parent_id, 'child_type_id' => $id];
        }

        return $data;
    }

    public function officeTrxData($trx_id)
    {
        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , s.trx_name AS type_name
          , t.tot_amount
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.description
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_types AS s', 's.id_transaction_type = t.ref_id');
        $this->db->where("t.trx_with", 'office');
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where('t.store_id', $this->session->userdata['login_info']['store_id']);
        $this->db->where("t.status_id", 1);

        $query = $this->db->get();
        $data = $query->result_array();
        return isset($data[0]) ? $data[0] : [];
    }

    public function getEmployeeTrxDetails($trx_id)
    {
        $this->db->select("
            t.id_transaction
          , t.trx_no
          , t.ref_id
          , t.dtt_add
          , u.fullname AS employee_name
          , u.mobile AS employee_phone
          , ur.fullname
          , tt.trx_name
          , s.store_name
          , s.address_line
          , t.tot_amount
          , t.qty_multiplier
          , t.dtt_trx
          , t.description
          , a.acc_type_id
          , t.account_id
          , t.store_id
          , fn_account_name_by_id(t.account_id) AS account_name
          , t.payment_method_id
          , t.ref_bank_id
          , t.ref_card_id
          , t.ref_acc_no
          , t.ref_trx_no
          , t.is_doc_attached
          , t.store_id
          ", FALSE);

        $this->db->from("transactions AS t");
        $this->db->join('transaction_details d', 'd.transaction_id = t.id_transaction');
        $this->db->join('transaction_types AS tt', 'tt.id_transaction_type = d.ref_id');
        $this->db->join('users AS u', 'u.id_user = t.ref_id');
        $this->db->join('users AS ur', 'ur.id_user = t.uid_add');
        $this->db->join('stores AS s', 's.id_store = t.store_id');
        $this->db->join('accounts AS a', 'a.id_account = t.account_id');
        $this->db->where("t.trx_with", 'employee');
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where("t.store_id IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        $this->db->where("t.status_id", 1);

        $query = $this->db->get();
        $data = $query->result_array();

        if (isset($data[0])) {
            $data[0]['documents'] = $this->listDocuments($trx_id);
            return $data[0];
        }

        return [];
    }

    public function getInvestorTrxDetails($trx_id)
    {

        $this->db->select("
            t.id_transaction AS id
          , t.trx_no
          , u.fullname AS investor_name
          , u.mobile AS investor_phone
          , ur.fullname
          , t.tot_amount
          , s.store_name
          , s.address_line
          , t.dtt_add
          , t.qty_multiplier
          , DATE(t.dtt_trx) AS transaction_date
          , t.dtt_trx
          , t.description
          , a.acc_type_id
          , t.account_id
          , t.store_id
          , fn_account_name_by_id(t.account_id) AS account_name
          , t.payment_method_id
          , t.ref_bank_id
          , t.ref_card_id
          , t.ref_acc_no
          , t.ref_trx_no
          , t.is_doc_attached", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('accounts AS a', 'a.id_account = t.account_id');
        $this->db->join("users AS u", "u.id_user = t.ref_id");
         $this->db->join("stores s", "s.id_store = t.store_id");
        $this->db->join("users AS ur", "ur.id_user = t.uid_add");
        $this->db->where('t.id_transaction', $trx_id);
        $this->db->where('t.trx_with', 'investor');
        $this->db->where("t.store_id IN (" . implode(',', $this->session->userdata['login_info']['store_ids']) . ")", NULL, FALSE);
        $this->db->where("t.status_id", 1);
        $query = $this->db->get();
        $data = $query->result_array();
        if (isset($data[0])) {
            $data[0]['documents'] = $this->listDocuments($trx_id);
            return $data[0];
        }

        return [];
    }

    public function listDocuments($trx_id)
    {
        $this->db->select("id_document, name, file, status_id", FALSE);
        $this->db->from("documents");
        $this->db->where('ref_id', $trx_id);
        $this->db->where('doc_type', 'Transaction');
        $this->db->where("status_id", 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updDocumentRecords($data, $document_data_del, $document_data)
    {
        ## DELETE IRRELEVANT DOCUMENT FILE RECORDS
        if (!empty($document_data_del)) {
//            $sql = "UPDATE documents
//                SET status_id = 2
//                , dtt_mod = '{$data['dtt_mod']}'
//                , uid_mod = {$data['uid_mod']}
//                WHERE doc_type = 'Transaction'
//                AND ref_id = {$data['id']}
//                AND id_document IN ({$document_data_del})";
//            $this->db->query($sql);
            $this->commonmodel->commonUpdateSTP('documents', $document_data, ['id_document' =>$document_data_del]);
        } else{
            foreach ($document_data as $key => $value) {
                $array2[$key] = $value;
            }
            $array2['ref_id'] = $data['id'];
            $this->commonmodel->commonInsertSTP('documents', $array2);

        }
        //$this->commonmodel->commonUpdateSTP('documents', $document_data, ['id_document' =>$document_data_del]);

        ## INSERT NEW DOCUMENT FILE RECORDS
//        if (!empty($document_data)) {
//            foreach ($document_data as $key => $value) {
//                $array2[$key] = $value;
//            }
//            $array2['ref_id'] = $data['id'];
//            $this->commonmodel->commonInsertSTP('documents', $array2);
//
//        }
    }
    public function getvalue_row($tbl, $fn, $fcon = array()) {
        $this->db->select($fn);
        $this->db->where($fcon);
        $q = $this->db->get($tbl);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function get_customer_print_invoice($id){
        $this->db->select('st.*,c.fullname,b.mobile,b.address_line,b.email,b.store_name,b.store_img,d.full_name as customer_name,d.phone as customer_mobile,d.customer_code');
        $this->db->from('sale_transactions st');
        $this->db->join('stores b', 'st.store_id=b.id_store', 'left');
        $this->db->join('users c', 'st.uid_add=c.id_user', 'left');
        $this->db->join('customers d', 'st.customer_id=d.id_customer ', 'left');
        // $this->db->where("a.dtt_add >=", $start);
        $this->db->where("st.id_sale_transaction", $id);
        $query = $this->db->get();
        //return $this->db->last_query();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;

    }
    public function getSupplierTrxPaymentGroup($trx_no)
    {
        $this->db->select("
            t.id_transaction AS id
          , GROUP_CONCAT(DISTINCT p.type_name SEPARATOR ',') AS type_name
          , sum(t.tot_amount) tot_amount
          ", FALSE);
        $this->db->from("transactions AS t");
        $this->db->join('transaction_mvt_types AS p', 'p.id_transaction_mvt_type = t.trx_mvt_type_id');
        $this->db->where("t.trx_no", $trx_no);
        $this->db->where("t.status_id", 1);
        $this->db->group_by("t.trx_no");
        $this->db->order_by("t.dtt_trx DESC, t.id_transaction DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTrxNo($id){
        $this->db->select("trx_no");
        $this->db->from("transactions");
        $this->db->where("id_transaction", $id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    public function listCheckMenu($id= NULL){
        $type_id = $this->session->userdata['login_info']['user_type_i92'];
        $user_id = $this->session->userdata['login_info']['id_user_i90'];
        if ($type_id != 3) {
            $this->db->select("page_name");
            $this->db->from("acl_user_pages");
            if($id!=''){
               $this->db->where("page_name", $id); 
            }
            $this->db->where("submodule_id", 47);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                redirect('error-page');
            }
        }
        return TRUE;
    }
}