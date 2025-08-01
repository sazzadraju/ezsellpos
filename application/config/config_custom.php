<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['genders'] = ['m' => 'Male', 'f' => 'Female', 'o' => 'Other'];
$config['user_types'] = [1 => 'Employee', 2 => 'Investor', 3 => 'Admin'];


$config['mobile_acc_types'] = [
    1 => 'Personal',
    2 => 'Business',
    3 => 'Agent'
];

$config['promotion_types'] = [
    1 => 'Promotion on Product',
    2 => 'Promotion on Purchase',
    3 => 'Promotion on Card'
];
$config['promotion_type_sales'] = [
    1 => 'Promotion on Product',
    2 => 'Promotion on Purchase',
    3 => 'Promotion on Card',
    4 => 'Customer Discount',
    5 => 'Special Discount'
];

$config['stock_mismatch_types'] = [1 => 'Shortage', 2 => 'Excess'];
$config['blood_groups'] = ['A+','A-','AB+','AB-','B+','B-','O+','O-'];

$config['transaction_with'] = ['customer', 'supplier', 'office', 'employee', 'investor', 'sales_adjustment', 'purchase_adjustment'];
$config['trx_details_payment_types'] = [1=>'Full Payment', 2=>'Partial Payment', 3=>'Remaining Payment'];
$config['trx_type_qty_multipliers'] = [
    'customer'  => [1 => 'Receive', -1 => 'Return'],
    'supplier'  => [1 => 'Receive', -1 => 'Payment'],
    'office'    => [1 => 'Income',  -1 => 'Expense'],
    'employee'  => [1 => 'Return',  -1 => 'Payment'],
    'investor'  => [1 => 'Invest',  -1 => 'Invest Withdraw',  0 => 'Profit Withdraw'],
];
//$config['transaction_with'] = ['customer', 'supplier', 'office', 'employee', 'investor'];

$config['acc_uses'] = [
    1 => 'Office Account', // General Account
    2 => 'Shop Account',   // Payment Gateway
    3 => 'Both'
];
$config['acc_types'] = [
    1 => 'Bank Account',
    2 => 'Cash Account',
    3 => 'Mobile Bank Account',
    4 => 'Station Account'
];
$config['acc_types_add'] = [
    1 => 'Bank Account',
    2 => 'Cash Account',
    3 => 'Mobile Bank Account'
];

$config['trx_payment_portions'] = [1=>'Full', 2=>'Partial'];
$config['trx_payment_methods'] = [1=>'Cash', 2=>'Card', 3=>'Mobile Account', 4=>'Cheque', 5=>'Order Advance'];
$config['trx_payment_mehtods_by_bank'] = [2=>'Card', 4=>'Cheque'];
$config['trx_payment_mehtods_for_office'] = [4=>'Cheque'];


/* STATUSES */
$config['stock_mvt_unmatch_statuses'] = [1 => 'Shortage', 2 => 'Excess'];
$config['purchase_order_statuses'] = [1 => 'Order placed', 2 => 'Order cancelled', 3 => 'Order received'];

/* Types */
$config['bank_types'] = [1 => 'General Bank', 2 => 'Mobile Bank'];
$config['transaction_categories_types'] = [1 => 'Income', -1 => 'Expense'];

$config['datetime_viewable_format'] = 'd/m/Y g:i A';
$config['salt'] = '0WgDte8u8U';

$config['document_path'] = 'public/uploads/';
$config['document_url'] = 'public/uploads/';


$config['document_paths'] = array(
    'customer'      => 'customer_files',
    'employee'      => 'emp_documents',
    'brand'         => 'product_brands',
    'product'       => 'products',
    'stock'         => 'stock_documents',
    'supplier'      => 'supplier_files',
    'transaction'   => 'transactions',
    'user'          => 'users',
    'tailoring'     => 'tailoring',
);
$config['order_status'] = [
    1 => 'Pending',
    //2 => 'Processing',
    3 => 'Delivered',
    4 => 'Sale Return'
   // 5 => 'Canceled'
];
$config['sales_person'] = array(
    '4'      => 'Customer',
    '1'      => 'User',
    '2'      => 'Investor',
    '3'      => 'Supplier'
);
$config['message'] = [
    1 => 'Thanks for the Customer registration.',
    2 => 'Thanks for the Customer Due registration.',
    3 => 'Thanks for the Customer Transaction registration.',
    4 => 'Thanks for the Supplier Transaction registration.',
    5 => 'Thanks for the Office Transaction registration.',
    6 => 'Thanks for the Employee Transaction registration.',
    7 => 'Thanks for the Investor Transaction registration.',
    8 => 'Thanks for the fund transfer registration.',
    9 => 'Thanks for the Customer Sale registration.',
    10 => 'Thanks for the Order Placement registration.' 
];


/*
$config['document_paths'] = array(
    'customer'      => 'customer_files',
    'employee'      => 'employees',
    'brand'         => 'brands',
    'product'       => 'products',
    'stock'         => 'stocks',
    'supplier'      => 'suppliers',
    'transaction'   => 'transactions',
    'user'          => 'users',
);
*/
