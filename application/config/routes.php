<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['test'] = "test/index";

//Login
$route['login_form'] = "authentication/index";
$route['login_check'] = "authentication/authentication_check";
$route['dashboard'] = "dashboard/index";
$route['invoice_view_sale/(:any)'] = "dashboard/sale_invoice_view/$1";
$route['invoice_full_view_sale/(:any)'] = "dashboard/sale_print_view_full/$1";
$route['export_csv'] = "dashboard/export_csv_data";

//Logout
$route['error-page'] = "users/employees/error_msg";
$route['logout'] = "authentication/signout";

//Product Brands
$route['products/brands'] = "product_settings/brands/index";
$route['product_brands/page_data/(:any)'] = "product_settings/brands/paginate_data/$1";
$route['product_brands/delete/(:any)'] = "product_settings/brands/delete_data/$1";
$route['product_brands/edit/(:any)'] = "product_settings/brands/edit_data/$1";
$route['check_brand_name'] = "product_settings/brands/check_brand_name";
//Product Categories
$route['products/categories'] = "product_settings/categories/index";
$route['check_cagegory_name'] = "product_settings/categories/check_cagegory_name";
$route['product_category/page_data/(:any)'] = "product_settings/categories/paginate_data/$1";
$route['product_category/delete/(:any)'] = "product_settings/categories/delete_data/$1";
$route['product_category/edit/(:any)'] = "product_settings/categories/edit_data/$1";

//Products
$route['products'] = "product_settings/products/index";
$route['product/page_data/(:any)'] = "product_settings/products/paginate_data/$1";
$route['product/delete/(:any)'] = "product_settings/products/delete_data/$1";
$route['product/edit/(:any)'] = "product_settings/products/edit_data/$1";
$route['product/details/(:any)'] = "product_settings/products/details_data/$1";
$route['checkProductCode'] = "product_settings/products/check_product_code";
$route['check_product_name'] = "product_settings/products/check_product_name";
$route['products/barcode/(:any)'] = "product_settings/products/barcode_data/$1";
$route['products/get_product_qty_byBatch'] = "product_settings/products/get_product_qty_byBatch";
$route['products/get_barcode_byProduct'] = "product_settings/products/get_barcode_byProduct";
$route['products/bulk-barcode'] = "product_settings/products/bulk_barcode";
$route['products/lowStockPagination/(:any)'] = "product_settings/products/lowStockPagination/$1";
$route['products/lowStockPagi2/(:any)'] = "product_settings/products/lowStockPagi2/$1";
$route['products/low-high-stock'] = "product_settings/products/low_high_stock";
$route['product_details_by_id'] = "product_settings/products/product_details_by_id";
$route['product_stock_list'] = "product_settings/products/product_stock_list";
$route['get_product_auto_list'] = "product_settings/products/get_product_auto_list";



//Product pricing
$route['products/pricing'] = "product_settings/pricing";
$route['products/pricingPaginationData'] = "product_settings/pricing/pricingPaginationData";
$route['products/pricing_update'] = "product_settings/pricing/pricing_update";

//Product Other Configuration
$route['products/other-configuration'] = "product_settings/otherConfigurations/index";
$route['configureVat/edit_vat'] = "product_settings/otherConfigurations/edit_vat";
$route['otherConfiguration/page_data/(:any)'] = "product_settings/otherConfigurations/paginate_data/$1";
$route['otherConfiguration/edit/(:any)'] = "product_settings/otherConfigurations/edit_data/$1";
$route['unit/delete/(:any)'] = "product_settings/otherConfigurations/delete_data/$1";

//customer type
$route['customer/type'] = "customer_settings/customer/customer_type";
$route['customer/customer_type_data/(:any)'] = "customer_settings/customer/customer_type_data/$1";
$route['check_customer_type_name'] = "customer_settings/customer/check_customer_type_name";
$route['get_customers_auto'] = "customer_settings/customer/get_customers_auto";


//Customer Points
$route['customer/points'] = "customer_settings/customer_points";

// Employees
// $route['employees'] = "users/employees/index";
// $route['user-access/(:any)'] = "users/employees/user_access/$1";
// $route['employee/(:any)'] = "users/employees/employee_details/$1";
// $route['check-employee-email'] = "users/employees/check_employee_email";
// $route['check-employee-username'] = "users/employees/check_employee_username";
// $route['edit-employee-data'] = "users/employees/edit_employee_info";
// $route['add-employee-data'] = "users/employees/add_employee_info";
// $route['employee/page-data/(:any)'] = "users/employees/paginate_data/$1";
// $route['employee/edit/(:any)'] = "users/employees/edit_employee_data/$1";
// $route['employee/delete/(:any)'] = "users/employees/delete_employee_data/$1";
// $route['employees/add/add-employee-document'] = "users/employees/add_employee_document";
// $route['employees/employee-document-pagination'] = "users/employees/employee_document_pagination";
// $route['employees/update-employee-document'] = "users/employees/update_employee_document";
// $route['employees/edit-employee-doc-by-id'] = "users/employees/edit_employee_doc_by_id";
// $route['delete-employee-doc'] = "users/employees/delete_employee_document_data";
// $route['get-district'] = "users/employees/get_district";
// $route['get-city-location'] = "users/employees/get_city_location";
// $route['check-station-name'] = "users/stations/check_station_name";
// $route['get-stations-by-store'] = "users/employees/get_stations_by_store";
$route['employees'] = "users/employees/index";
$route['user-access/(:any)'] = "users/employees/user_access/$1";
$route['employee/(:any)'] = "users/employees/employee_details/$1";
$route['check_employee_email'] = "users/employees/check_employee_email";
$route['check_employee_username'] = "users/employees/check_employee_username";
$route['edit_employee_data'] = "users/employees/edit_employee_info";
$route['add_employee_data'] = "users/employees/add_employee_info";
$route['employee/page_data/(:any)'] = "users/employees/paginate_data/$1";
$route['employee/edit/(:any)'] = "users/employees/edit_employee_data/$1";
$route['employee/delete/(:any)'] = "users/employees/delete_employee_data/$1";
$route['employees/add/add_employee_document'] = "users/employees/add_employee_document";
$route['employees/employee_document_pagination'] = "users/employees/employee_document_pagination";
$route['employees/update_employee_document'] = "users/employees/update_employee_document";
$route['employees/edit_employee_doc_by_id'] = "users/employees/edit_employee_doc_by_id";
$route['delete_employee_doc'] = "users/employees/delete_employee_document_data";
$route['get_district'] = "users/employees/get_district";
$route['get_city_location'] = "users/employees/get_city_location";
$route['check_station_name'] = "users/stations/check_station_name";
$route['get_stations_by_store'] = "users/employees/get_stations_by_store";


//customers
$route['customer'] = "customer_settings/customer/customers";
$route['create_customer_info'] = "customer_settings/customer/create_customer_info";
$route['customer/customer_info_data/(:any)'] = "customer_settings/customer/customer_info_data/$1";
$route['customer/details/(:any)'] = "customer_settings/customer/customer_details/$1";

$route['customer/csv'] = "customer_settings/csv";
$route['customer/csv/previewcsv'] = "customer_settings/csv/previewcsv";
$route['customer/csv/importcsv'] = "customer_settings/csv/importcsv";

//Supplier Settings
$route['suppliers'] = "suppliers/supplier_settings/index";
$route['check_supplier_code'] = "suppliers/supplier_settings/checkSupplierCode";
$route['suppliers/supplier_info_data/(:any)'] = "suppliers/supplier_settings/supplier_info_data/$1";
$route['create_supplier'] = "suppliers/supplier_settings/create_supplier";
$route['delete_supplier_info'] = "suppliers/supplier_settings/delete_supplier_info";
$route['editSupplierInfo'] = "suppliers/supplier_settings/editSupplierInfo";
$route['update_supplier_info'] = "suppliers/supplier_settings/update_supplier_info";
$route['supplier/get_district'] = "suppliers/supplier_settings/get_district";
$route['supplier/get_city_location'] = "suppliers/supplier_settings/get_city_location";
$route['viewSupplierAlert'] = "suppliers/supplier_settings/viewSupplierAlert";
$route['supplier_payment_alert_action'] = "suppliers/supplier_settings/supplier_payment_alert_action";

//Supplier Details
$route['supplier/(:any)'] = "suppliers/supplier_settings/supplier_details/$1";
$route['suppliers/supplier_document_pagination'] = "suppliers/supplier_settings/supplier_document_pagination";
$route['create_supplier_document'] = "suppliers/supplier_settings/create_supplier_document";
$route['edit_supplier_doc'] = "suppliers/supplier_settings/edit_supplier_doc";
$route['update_supplier_document'] = "suppliers/supplier_settings/update_supplier_document";
$route['delete_supplier_doc'] = "suppliers/supplier_settings/delete_supplier_doc";

//Stock In
$route['stock_in_list'] = "stock/stock_in/index";
$route['stock/stock_in_pagination_data/(:any)'] = "stock/stock_in/stock_in_pagination_data/$1";
$route['product_stock_in'] = "stock/stock_in/product_stock_in";
$route['stock_cart_add'] = "stock/stock_in/stock_cart_add";
$route['get_products_for_stock_in'] = "stock/stock_in/get_products";
$route['get_suppliers_for_stock_in'] = "stock/stock_in/get_suppliers";
$route['stock_in_insert'] = "stock/stock_in/stock_in_insert";
$route['stock_in_details/(:any)'] = "stock/stock_in/stock_in_details/$1";
$route['stock_insert_attributes'] = "stock/stock_in/stock_insert_attributes";
$route['get_available_products_for_stock_in'] = "stock/stock_in/get_available_stock_in_products";


//Stock Out
$route['stock_out'] = "stock/stock_out/index";
$route['stock/stock_out_pagination_data/(:any)'] = "stock/stock_out/stock_out_pagination_data/$1";
$route['product_stock_out'] = "stock/stock_out/product_stock_out";
$route['get_products_for_stock_out'] = "stock/stock_out/get_products";
$route['get_stock_out_batch_by_product_id'] = "stock/stock_out/get_stock_batch_by_product_id";
$route['get_stock_detail_data'] = "stock/stock_out/get_stock_detail_data";
$route['stock_out_insert'] = "stock/stock_out/stock_out_insert";
$route['check_invoice_no'] = "stock/stock_out/check_invoice_no";
$route['stock_out_details/(:any)'] = "stock/stock_out/stock_out_details/$1";

//Stock Reason
$route['stock-reason']="stock/stockReason/index";
$route['stock_reason/add_data']="stock/stockReason/add_data";
$route['stock_reason/page_data/(:any)'] = "stock/stockReason/paginate_data/$1";
$route['stock_reason/delete/(:any)'] = "stock/stockReason/delete_data/$1";
$route['stock_reason/edit/(:any)'] = "stock/stockReason/edit_data/$1";
$route['check_reason_name'] = "stock/stockReason/check_reason_name";
$route['stock_reason/find_qty/(:any)'] = "stock/stockReason/find_qty/$1";

//Accounting Setting
$route['account-settings/bank'] = "account_settings/bank/index";
$route['account-settings-bank/page_general'] = "account_settings/bank/page_general_data";
$route['account-settings-bank/page_general/(:any)'] = "account_settings/bank/page_general_data/$1";
$route['account-settings-bank/page_mobile'] = "account_settings/bank/page_mobile_data";
$route['account-settings-bank/page_mobile/(:any)'] = "account_settings/bank/page_mobile_data/$1";
$route['account-settings-bank/edit/(:any)'] = "account_settings/bank/edit_data/$1";
$route['account-settings-bank/delete/(:any)'] = "account_settings/bank/delete_data/$1";
$route['account-settings-bank/add_data'] = "account_settings/bank/add_data";
$route['check_bank_name'] = "account_settings/bank/check_bank_name";
$route['account-settings/card-type'] = "account_settings/card/index";
$route['account-settings/account'] = "account_settings/account/index";
$route['account-settings-account/page-bank-account'] = "account_settings/account/bank_account_page/";
$route['account-settings-account/page-bank-account/(:any)'] = "account_settings/account/bank_account_page/$1";
$route['account-settings-account/page-cash-account'] = "account_settings/account/cash_account_page/";
$route['account-settings-account/page-cash-account/(:any)'] = "account_settings/account/cash_account_page/$1";
$route['account-settings-account/page-mobile-account'] = "account_settings/account/mobile_account_page/";
$route['account-settings-account/page-mobile-account/(:any)'] = "account_settings/account/mobile_account_page/$1";
$route['account-settings-account/page-station-account'] = "account_settings/account/station_account_page/";
$route['account-settings-account/page-station-account/(:any)'] = "account_settings/account/station_account_page/$1";
$route['account-settings-account/add-account'] = "account_settings/account/add_account";
$route['account-settings-account/details/(:any)'] = "account_settings/account/details/$1";
$route['account-settings-account/edit-account-info/(:any)'] = "account_settings/account/edit_acc_info/$1";
$route['account-settings-account/delete/(:any)'] = "account_settings/account/delete/$1";
$route['account-settings/transaction-category'] = "account_settings/transaction_categories/index";
$route['account-settings/transaction-category-page/(:any)'] = "account_settings/transaction_categories/paginated_data/$1";
$route['account-settings-trx-cat/add'] = "account_settings/transaction_categories/add_data";
$route['account-settings-trx-cat/edit/(:any)'] = "account_settings/transaction_categories/edit_data/$1";
$route['account-settings-trx-cat/delete/(:any)'] = "account_settings/transaction_categories/delete_data/$1";

//Account Management
$route['account-management/transactions'] = "account_management/transaction/index";
$route['account-management/transactions/(:any)(/:num)?'] = "account_management/transaction/trx_list/$1$2";
$route['account-management/transactions/add/(:any)(/:num)?'] = "account_management/transaction/trx_add/$1$2";
$route['account-management/transactions/edit/(:any)/(:num)(/:num)?'] = "account_management/transaction/trx_edit/$1/$2$3";
$route['account-management/customer-unpaid-orders/(:num)(/:any)?'] = "account_management/transaction/customer_upaid_orders/$1$2";
$route['account-management/customer-trx-details/(:num)'] = "account_management/transaction/customer_trx_details/$1";
$route['account-management/supplier-trx-details/(:num)'] = "account_management/transaction/supplier_trx_details/$1";
$route['account-management/office-trx-details/(:num)'] = "account_management/transaction/office_trx_details/$1";
$route['account-management/employee-trx-details/(:num)'] = "account_management/transaction/employee_trx_details/$1";
$route['account-management/investor-trx-details/(:num)'] = "account_management/transaction/investor_trx_details/$1";
$route['account-management/supplier-unpaid-purchases/(:num)(/:any)?'] = "account_management/transaction/supplier_unpaid_purchases/$1$2";
$route['account-management/add-customer-trx(/:num)?'] = "account_management/transaction/add_customer_transaction$1";
$route['account-management/add-supplier-trx(/:num)?'] = "account_management/transaction/add_supplier_transaction$1";
$route['account-management/add-office-trx(/:num)?'] = "account_management/transaction/add_office_transaction$1";
$route['account-management/add-employee-trx(/:num)?'] = "account_management/transaction/add_employee_transaction$1";
$route['account-management/add-investor-trx(/:num)?'] = "account_management/transaction/add_investor_transaction$1";
$route['account-management/edit-customer-trx/(:num)'] = "account_management/transaction/edit_customer_transaction/$1";
$route['account-management/edit-supplier-trx/(:num)'] = "account_management/transaction/edit_supplier_transaction/$1";
$route['account-management/edit-office-trx/(:num)'] = "account_management/transaction/edit_office_transaction/$1";
$route['account-management/edit-employee-trx/(:num)'] = "account_management/transaction/edit_employee_transaction/$1";
$route['account-management/edit-investor-trx/(:num)'] = "account_management/transaction/edit_investor_transaction/$1";

$route['transactions/customer_print_invoice/(:num)'] = "account_management/transaction/customer_print_invoice/$1";
$route['transactions/employee_print_invoice/(:num)'] = "account_management/transaction/employee_print_invoice/$1";
$route['transactions/supplier_print_invoice/(:num)'] = "account_management/transaction/supplier_print_invoice/$1";
$route['transactions/office_print_invoice/(:num)'] = "account_management/transaction/office_print_invoice/$1";
$route['transactions/investor_print_invoice/(:num)'] = "account_management/transaction/investor_print_invoice/$1";



//$route['account-management/office-trx-chld-cats/(:num)/(:num)'] = "account_management/transaction/office_trx_chld_cats/$1/$2";
$route['account-management/fund-transfer'] = "account_management/fund_transfer/list_fund_transfers";
$route['account-management/fund-transfer-records(/:num)?'] = "account_management/fund_transfer/fund_transfer_records$1";
$route['account-management/account-current-banalce/(:num)'] = "account_management/fund_transfer/get_acc_curr_banalce/$1";
$route['account-management/add-fund-transfer'] = "account_management/fund_transfer/add";
$route['account-management/transaction-invoices'] = "account_management/transaction/list_transaction_invoices";
$route['account-management/search-transaction-invoices(/:any)?'] = "account_management/transaction/search_transaction_invoices$1";
$route['account-management/accountBalanceByID'] = "account_management/transaction/account_balance_by_id";

//Company Info
$route['company-info'] = "settings/companyInfo/index";
$route['company_info/edit_vat_reg_no'] = "settings/companyInfo/edit_vat_reg_no";
$route['company_info/edit_default_vat'] = "settings/companyInfo/edit_default_vat";
$route['company_info/update_info'] = "settings/companyInfo/update_info";

//Supplier Payment Alert
$route['supplier_payment_alert'] = "suppliers/supplier_settings/supplier_payment_alert";
$route['suppliers/supplier_payment_alert_data/(:any)'] = "suppliers/supplier_settings/supplier_payment_alert_data/$1";
$route['delete_supplier_payment_alert_info'] = "suppliers/supplier_settings/delete_supplier_payment_alert_info";


//Stock Transfer
$route['stock_transfer'] = "stock/stock_transfer/index";
$route['stock/stock_transfer_pagination_data/(:any)'] = "stock/stock_transfer/stock_transfer_pagination_data/$1";
$route['product_stock_transfer'] = "stock/stock_transfer/product_stock_transfer";
$route['get_products_for_stock_transfer'] = "stock/stock_transfer/get_products";
$route['get_stock_transfer_by_product_id'] = "stock/stock_transfer/get_stock_batch_by_product_id";
$route['get_stock_detail_data'] = "stock/stock_transfer/get_stock_detail_data";
$route['stock_transfer_insert'] = "stock/stock_transfer/stock_transfer_insert";
$route['check_invoice_no'] = "stock/stock_transfer/check_invoice_no";
$route['stock_transfer_send_details/(:any)'] = "stock/stock_transfer/stock_transfer_send_details/$1";
$route['get_products_for_stock_audit'] = "stock/stock_audit/get_products";


//Stock Recieve
$route['stock-recieve'] = "stock/stock_recieve/index";
$route['stock/stock_recieve_pagination_data/(:any)'] = "stock/stock_recieve/stock_recieve_pagination_data/$1";
$route['product_stock_recieve'] = "stock/stock_recieve/product_stock_recieve";
$route['stock_transfer_details/(:any)'] = "stock/stock_recieve/stock_transfer_details/$1";
$route['stock_transfer_view/(:any)'] = "stock/stock_recieve/stock_transfer_view/$1";
$route['stock_recieve_insert'] = "stock/stock_recieve/stock_recieve_insert";


$route['get_products_for_stock_recieve'] = "stock/stock_recieve/get_products";
$route['get_stock_batch_by_product_id'] = "stock/stock_recieve/get_stock_batch_by_product_id";
$route['get_stock_detail_data'] = "stock/stock_recieve/get_stock_detail_data";
$route['check_invoice_no'] = "stock/stock_recieve/check_invoice_no";


//Purchase Requisition
$route['requisitions'] = "purchase_settings/purchase_requisitions/index";
$route['get_products_auto'] = "purchase_settings/purchase_requisitions/get_products_auto";
$route['add-requisition'] = "purchase_settings/purchase_requisitions/add_requisition";
$route['search_add_requisition'] = "purchase_settings/purchase_requisitions/search_requisition_product_list";
$route['add_search_requisition'] = "purchase_settings/purchase_requisitions/temp_add_search_requisition";
$route['requisition/page_data/(:any)'] = "purchase_settings/purchase_requisitions/paginate_data/$1";
$route['add_requisition_data'] = "purchase_settings/purchase_requisitions/add_requisition_data";


//Purchase Order
$route['purchase-order'] = "purchase_settings/purchase_order/index";
$route['show_requisition_orders'] = "purchase_settings/purchase_order/show_requisition_orders";
$route['purchase-order/add-order'] = "purchase_settings/purchase_order/add_order";
$route['purchase_order/page_data/(:any)'] = "purchase_settings/purchase_order/paginate_data/$1";
$route['search_add_order'] = "purchase_settings/purchase_order/search_order_product_list";
$route['add_search_order'] = "purchase_settings/purchase_order/temp_add_search_order";
$route['add_order_data'] = "purchase_settings/purchase_order/add_order_data";
$route['purchase_order/details/(:any)'] = "purchase_settings/purchase_order/order_details_data/$1";
$route['purchase_insert_attributes'] = "purchase_settings/purchase_order/purchase_insert_attributes";



//Purchase Receive
$route['purchase-receive'] = "purchase_settings/purchase_receive/index";
$route['purchase-receive/add/(:any)'] = "purchase_settings/purchase_receive/add_receive/$1";
$route['add_search_receive'] = "purchase_settings/purchase_receive/temp_add_search_receive";
$route['add_receive_data'] = "purchase_settings/purchase_receive/add_receive_data";
$route['purchase_receive/page_data/(:any)'] = "purchase_settings/purchase_receive/paginate_data/$1";
$route['purchase_receive/details/(:any)'] = "purchase_settings/purchase_receive/receive_details_data/$1";
$route['barcode'] = "purchase_settings/purchase_receive/barcode";
//$route['purchase_receive/details/(:any)'] = "stock/stock_transfer/stock_transfer_send_details/$1";

//Sales Module
$route['sales'] = "sales_settings/sales/index";
$route['create_customer_info_short'] = "sales_settings/sales/create_customer_info_short";
$route['temp_add_cart_for_sales'] = "sales_settings/sales/temp_add_cart_for_sales";
$route['get_products_auto_sales'] = "sales_settings/sales/get_products_auto_sales";
$route['show_customer_for_sales'] = "sales_settings/sales/show_customer_for_sales";
$route['total_purchase_discount'] = "sales_settings/sales/total_purchase_discount";
$route['sales_add'] = "sales_settings/sales/sales_add";
$route['hold_sale_add'] = "sales_settings/sales/hold_sale_add";
$route['hold_sale_list'] = "sales_settings/sales/hold_sale_list";
$route['check_batch_product'] = "sales_settings/sales/check_batch_product";
$route['get_sales_person_auto'] = "sales_settings/sales/get_sales_person_auto";



//Sale Return
$route['sale-returns'] = "sales_settings/sale_returns/index";
$route['temp_add_return_sale'] = "sales_settings/sale_returns/temp_add_return_sale";
$route['show_sale_return_data'] = "sales_settings/sale_returns/show_sale_return_data";
$route['add_sale_return'] = "sales_settings/sale_returns/add_sale_return";
    
//Stock Audit
$route['stock_audit'] = "stock/stock_audit/index";
$route['add_stock_audit'] = "stock/stock_audit/add_stock_audit";
$route['search_audit_stock_list'] = "stock/stock_audit/search_audit_stock_list";
$route['search_stock_product'] = "stock/stock_audit/search_stock_product";
$route['add_stock_audit_data'] = "stock/stock_audit/add_stock_audit_data";
$route['stock/stock_audit_pagination_data/(:any)'] = "stock/stock_audit/stock_audit_pagination_data/$1";
$route['stock_audit/(:any)'] = "stock/stock_audit/edit_stock_audit_details/$1";
$route['update_stock_audit_data'] = "stock/stock_audit/update_stock_audit_data";
$route['stock_audit_details/(:any)'] = "stock/stock_audit/stock_audit_details/$1";


/* Ajax Requests */
$route['ajx-customers-by-key'] = "ajx/list_customers_by_search";
$route['ajx-suppliers-by-key'] = "ajx/list_suppliers_by_search";
$route['ajx-employees-by-key'] = "ajx/list_employees_by_search";
$route['ajx-investors-by-key'] = "ajx/list_investors_by_search";


//Promotion Management
$route['promotion-management'] = "promotion_management/promotion_settings/index";
$route['add_promotion'] = "promotion_management/promotion_settings/add_promotion";
$route['cat_with_subcat_list'] = "promotion_management/promotion_settings/cat_with_subcat_list";
$route['promotion_insert'] = "promotion_management/promotion_settings/promotion_insert";
$route['promotion-management/promotion_pagination_data/(:any)'] = "promotion_management/promotion_settings/promotion_pagination_data/$1";
$route['promotion_details/(:any)'] = "promotion_management/promotion_settings/promotion_details/$1";
$route['edit_promotion/(:any)'] = "promotion_management/promotion_settings/edit_promotion/$1";
$route['promotion_preview'] = "promotion_management/promotion_settings/promotion_preview";
$route['promotion-management/get_sub_cat'] = "promotion_management/promotion_settings/get_sub_cat";
$route['promotion-management/promotion_cart_details'] = "promotion_management/promotion_settings/promotion_cart_details";
$route['promotion_update'] = "promotion_management/promotion_settings/promotion_update";
$route['promotion-management/inactive_promotion'] = "promotion_management/promotion_settings/inactive_promotion";
$route['promotion-management/delete_promotion'] = "promotion_management/promotion_settings/delete_promotion";
$route['reactive_promotion/(:any)'] = "promotion_management/promotion_settings/reactive_promotion/$1";
$route['enter_reactive_promotion'] = "promotion_management/promotion_settings/enter_reactive_promotion";


////////////supplier return///////////////////////////

$route['supplier-return'] = "suppliers/supplier_return/index";
$route['supplier-return-form'] = "suppliers/supplier_return/supplier_return_form";
$route['get_supplier_return_purchase_list'] = "suppliers/supplier_return/get_supplier_return_purchase_list";
$route['supplier-return/supplier_return_pagination_data/(:any)'] = "suppliers/supplier_return/supplier_return_pagination_data/$1";
$route['get_purchase_recieve_data'] = "suppliers/supplier_return/get_purchase_recieve_data";
$route['supplier_return_insert'] = "suppliers/supplier_return/supplier_return_insert";
$route['supplier-return-details/(:any)'] = "suppliers/supplier_return/supplier_return_details/$1";

//store settings
$route['store/add'] = "store_settings/store_setup/add_store";
$route['store/details/(:any)'] = "store_settings/store_setup/details_data/$1";
$route['store/delete/(:any)'] = "store_settings/store_setup/delete_data/$1";
$route['store/edit/(:any)'] = "store_settings/store_setup/edit_data/$1";
$route['store/update/(:any)'] = "store_settings/store_setup/update_store/$1";
$route['store/page_data/(:any)'] = "store_settings/store_setup/paginate_data/$1";
$route['checkStoreName'] = "store_settings/store_setup/check_store_name";
$route['store/get_city_location'] = "store_settings/store_setup/get_city_location";
// $route['store/get_district'] = "store_settings/store_setup/get_district";

// rack settings
$route['rack-settings'] = "settings/rack/index";
$route['rack/add'] = "settings/rack/add_rack";
$route['rack/details/(:any)'] = "settings/rack/details_data/$1";
$route['rack/edit/(:any)'] = "settings/rack/edit_data/$1";
$route['rack/update/(:any)'] = "settings/rack/update_rack/$1";
$route['rack/page_data/(:any)'] = "settings/rack/paginate_data/$1";
$route['rack/delete/(:any)'] = "settings/rack/delete_data/$1";

// Store again
$route['store-settings'] = "settings/store/index";
$route['settings/store/add_data'] = "settings/rack/check_rack_name";
$route['settings/get_district'] = "settings/store/get_district";
$route['settings/get_city_location'] = "settings/store/get_city_location";
$route['store/views/(:any)'] = "settings/store/details_data/$1";

// stock report
// $route['stock-report'] = "stock/stock_report/index";
$route['stock-report'] = "reports/stock_report/index";
$route['stock_report/page_data/(:any)'] = "reports/stock_report/paginate_data/$1";
$route['stock_report/page_data2/(:any)'] = "reports/stock_report/paginate_data2/$1";
$route['stock_report/print_page/(:any)'] = "reports/stock_report/print_data/$1";

// sell return report
$route['sell-return-report'] = "reports/sell_return_report/index";
$route['sell-return-report/page_data/(:any)'] = "reports/sell_return_report/paginate_data/$1";
$route['invoice_view_sale_return/(:any)'] = "dashboard/sale_return_invoice_view/$1";

// sell report
$route['sell-report'] = "reports/sell_report/index";
$route['sell-report/page_data/(:any)'] = "reports/sell_report/paginate_data/$1";
$route['sell-report/print_page/(:any)'] = "reports/sell_report/print_data/$1";
$route['sell-report/page_data2/(:any)'] = "reports/sell_report/paginate_data2/$1";

// sell report_2
$route['date-wise-sale'] = "reports/date_wise_sale/index";
$route['date-wise-sale/page_data/(:any)'] = "reports/date_wise_sale/paginate_data/$1";
$route['date-wise-sale/print_page/(:any)'] = "reports/date_wise_sale/print_data/$1";



// Daily sell summary
$route['store-sale-summary'] = "reports/store_sale_summary/index";
$route['store-sale-summary/page_data/(:any)'] = "reports/store_sale_summary/paginate_data/$1";
$route['store-sale-summary/print-data/(:any)'] = "reports/store_sale_summary/print_data/$1";

// Purchase report
$route['purchase-report'] = "reports/purchase_report/index";
$route['purchase-report/page_data/(:any)'] = "reports/purchase_report/paginate_data/$1";
$route['purchase-report/print-data/(:any)'] = "reports/purchase-report/print_data/$1";

// Purchase report_details
$route['purchase-report-details'] = "reports/purchase_report_details/index";
$route['purchase-report-details/page_data/(:any)'] = "reports/purchase_report_details/paginate_data/$1";
$route['purchase-report-details/page_data2/(:any)'] = "reports/purchase_report_details/paginate_data2/$1";
$route['purchase-report-details/print-data/(:any)'] = "reports/purchase_report_details/print_data/$1";

// expiring_soon_products
$route['expiring-soon-products'] = "reports/expiring_soon_products/index";
$route['expiring-soon-products/page_data/(:any)'] = "reports/expiring_soon_products/expireLinkPagination/$1";
$route['expiring-soon-products/submit_page_data/(:any)'] = "reports/expiring_soon_products/expireSubmitPagination/$1";
$route['expiring-soon-products/print/(:any)'] = "reports/expiring_soon_products/paginate_data2/$1";

// Customer sell report
$route['customer-sell-report'] = "reports/customer_sell_report/index";
$route['customer-sell-report/page_data/(:any)'] = "reports/customer_sell_report/paginate_data/$1";
$route['customer-sell-report/page_data2/(:any)'] = "reports/customer_sell_report/paginate_data2/$1";
// Customer sell report summary
$route['customer-sell-report-summary'] = "reports/customer_sell_report_summary/index";
$route['customer-sell-report-summary/page_data/(:any)'] = "reports/customer_sell_report_summary/paginate_data/$1";
$route['customer-sell-report-summary/page_data2/(:any)'] = "reports/customer_sell_report_summary/paginate_data2/$1";
//Change Password
$route['change-password'] = "settings/change_password/index";
$route['settings/password_update'] = "settings/change_password/password_change";
$route['settings/password-success'] = "settings/change_password/success";

// stock in summary report
$route['stock-in-summary'] = "reports/stock_in_summary/index";
$route['stock-in-summary/page_data/(:any)'] = "reports/stock_in_summary/paginate_data/$1";
$route['stock-in-summary/print_page/(:any)'] = "reports/stock_in_summary/print_page/$1";
// $route['stock-in-summary/print_page/'] = "reports/stock_in_summary/print_data";


// Customer_transaction_report
$route['customer-transaction-report'] = "reports/customer_transaction_report/index";
$route['customer-transaction-report/page_data/(:any)'] = "reports/customer-transaction-report/paginate_data/$1";
$route['customer-transaction-report/page_data2/(:any)'] = "reports/customer-transaction-report/paginate_data2/$1";
$route['report/cus_trn_details/(:any)'] = "reports/customer-transaction-report/details_data/$1";
$route['report/customer-method-details/(:any)'] = "reports/customer-transaction-report/method_details_data/$1";
$route['customer-transaction-report/print-data/(:any)'] = "reports/customer-transaction-report/print_data/$1";
// Employee_transaction_report
$route['employee-transaction-report'] = "reports/employee_transaction_report/index";
$route['employee-transaction-report/page_data/(:any)'] = "reports/employee-transaction-report/paginate_data/$1";
$route['employee-transaction-report/page_data2/(:any)'] = "reports/employee-transaction-report/paginate_data2/$1";
$route['report/details/(:any)'] = "reports/employee-transaction-report/details_data/$1";
$route['report/method_details/(:any)'] = "reports/employee-transaction-report/method_details_data/$1";
$route['get_transaction_name'] = "reports/employee-transaction-report/get_transaction_name";

// Office transaction_report
$route['office-transaction-report'] = "reports/office_transaction_report/index";
$route['office-transaction-report/page_data/(:any)'] = "reports/office-transaction-report/paginate_data/$1";
$route['get_office_transaction_name'] = "reports/office-transaction-report/get_office_transaction_name";
$route['get_office_transaction_sub_category'] = "reports/office-transaction-report/get_office_transaction_sub_category";
$route['office-transaction-report/print-data/(:any)'] = "reports/office-transaction-report/print_data/$1";

// Investor transaction_report
$route['investor-transaction-report'] = "reports/investor_transaction_report/index";
$route['investor-transaction-report/page_data/(:any)'] = "reports/investor-transaction-report/paginate_data/$1";
$route['report/method_details/(:any)'] = "reports/investor-transaction-report/method_details_data/$1";
$route['get_investor_transaction_name'] = "reports/investor-transaction-report/get_investor_transaction_name";

// Supplier_transaction_report
$route['supplier-transaction-report'] = "reports/supplier_transaction_report/index";
$route['supplier-transaction-report/page_data/(:any)'] = "reports/supplier-transaction-report/paginate_data/$1";
$route['supplier-transaction-report/page_data2/(:any)'] = "reports/supplier-transaction-report/paginate_data2/$1";
$route['report/supplier-details/(:any)'] = "reports/supplier-transaction-report/details_data/$1";
$route['report/sepplier-method-details/(:any)'] = "reports/supplier-transaction-report/method_details_data/$1";
$route['supplier-transaction-report/print-data/(:any)'] = "reports/supplier-transaction-report/print_data/$1";

// Vat report
$route['vat-report'] = "reports/vat_report/index";
$route['vat-report/page_data/(:any)'] = "reports/vat_report/paginate_data/$1";
$route['vat-report/print_page/(:any)'] = "reports/vat_report/print_data/$1";

// profit loss
$route['profit_loss'] = "reports/profit_loss/index";
$route['profit_loss/page_data/(:any)'] = "reports/profit_loss/paginate_data/$1";
$route['profit_loss/page_data2/(:any)'] = "reports/daily_sell_summary/paginate_data2/$1";

// get_station_name
$route['get_station_name'] = "reports/customer_receivable_report/get_station_name";
// stock out  report
$route['stock-out-report'] = "reports/stock_out_report/index";
$route['stock-out-report/page-data/(:any)'] = "reports/stock_out_report/paginate_data/$1";
$route['stock-out-report/page-data2/(:any)'] = "reports/stock_out_report/paginate_data2/$1";
// $route['stock-out-report/print-page/'] = "reports/stock_out_report/print_data";
$route['stock-out-report/print-data/(:any)'] = "reports/stock_out_report/print_data/$1";

// Product sell report
$route['product-sell-report'] = "reports/product_sell_report/index";
$route['product-sell-report/page-data/(:any)'] = "reports/product-sell-report/paginate_data/$1";
$route['product-sell-report/print-data/(:any)'] = "reports/product-sell-report/print_data/$1";
// Customer Receivable report
$route['customer-receivable-report'] = "reports/customer_receivable_report/index";
$route['customer-receivable-report/page-data/(:any)'] = "reports/customer_receivable_report/paginate_data/$1";
$route['customer-receivable-report/print-data/(:any)'] = "reports/customer_receivable_report/print_data/$1";

// Supplier Payable report
$route['supplier-payable-report'] = "reports/supplier_payable_report/index";
$route['supplier-payable-report/page-data/(:any)'] = "reports/supplier_payable_report/paginate_data/$1";
$route['supplier-payable-report/print-data/(:any)'] = "reports/supplier-payable-report/print_data/$1";

// stock mismatch  report
$route['stock-mismatch-report'] = "reports/stock_mismatch_report/index";
$route['stock-mismatch-report/page-data/(:any)'] = "reports/stock_mismatch_report/paginate_data/$1";
$route['stock-mismatch-report/print-data/(:any)'] = "reports/stock_mismatch_report/print_data/$1";
$route['report/invoice-details/(:any)'] = "reports/stock_mismatch_report/details_data/$1";
// $route['stock-out-report/print-page/'] = "reports/stock_out_report/print_data";

// Subscription
$route['subscription-renew/pay-confirm/(:any)'] = "settings/subscription/pay_confirm/$1";
$route['subscription-renew(/:any)?'] = "settings/subscription/renew$1";

// delevery agents
$route['agents'] = "delivery/agents/index";
$route['agents/page_data/(:any)'] = "delivery/agents/paginate_data/$1";
$route['agents/delete/(:any)'] = "delivery/agents/delete_data/$1";
$route['agents/details/(:any)'] = "delivery/agents/details_data/$1";
$route['agents/edit/(:any)'] = "delivery/agents/edit_data/$1";

// delevery persons
$route['delivery-persons'] = "delivery/delivery_persons/index";
$route['delivery_persons/page_data/(:any)'] = "delivery/delivery_persons/paginate_data/$1";
$route['delivery_persons/delete/(:any)'] = "delivery/delivery_persons/delete_data/$1";
$route['delivery_persons/details/(:any)'] = "delivery/delivery_persons/details_data/$1";
$route['delivery_persons/edit/(:any)'] = "delivery/delivery_persons/edit_data/$1";

// delevery cost
$route['delivery-costs'] = "delivery/delivery_costs/index";
$route['delivery-costs/page-data/(:any)'] = "delivery/delivery_costs/paginate_data/$1";
$route['delivery-costs/delete/(:any)'] = "delivery/delivery_costs/delete_data/$1";
$route['delivery-costs/details/(:any)'] = "delivery/delivery_costs/details_data/$1";
$route['delivery-costs/edit/(:any)'] = "delivery/delivery_costs/edit_data/$1";

//delivery Order
$route['delivery/show_agent_staff_list'] = "sales_settings/sales/show_agent_staff_list";
$route['delivery/show_service_range'] = "sales_settings/sales/show_service_range";
$route['delivery/show_delivery_person_agent'] = "sales_settings/sales/show_delivery_person_agent";
$route['delivery/add_delivery_charge_sales'] = "sales_settings/sales/add_delivery_charge_sales";
$route['delivery/show_customer_address'] = "sales_settings/sales/show_customer_address";
$route['delivery/customer_address_add'] = "sales_settings/sales/customer_address_add";

//delivery orders
$route['delivery-orders'] = "delivery/delivery_orders/index";
$route['delivery-orders/return/(:any)'] = "delivery/delivery_orders/return_data/$1";
$route['delivery-details/(:any)'] = "delivery/delivery_orders/order_details/$1";
$route['delivery-orders/page-data/(:any)'] = "delivery/delivery_orders/paginate_data/$1";
$route['add_delivery_order_payment'] = "delivery/delivery_orders/add_delivery_order_payment";
$route['delivery-orders/print-view/(:any)'] = "dashboard/sale_print_view/$1";

$route['cod-costs'] = "delivery/cod_cost/index";
$route['cod-costs/page_data/(:any)'] = "delivery/cod_cost/paginate_data/$1";

// attributes
$route['attributes'] = "product_settings/attributes/index";
$route['attributes/page_data/(:any)'] = "product_settings/attributes/paginate_data/$1";
$route['attributes/edit/(:any)'] = "product_settings/attributes/edit_data/$1";
$route['attribute/delete/(:any)'] = "product_settings/attributes/delete_data/$1";

//Tailoring
$route['tailoring-orders'] = "tailoring/order_list";
$route['tailoring-orders/add'] = "tailoring/order";
$route['tailoring-services'] = "tailoring/index";
$route['tailoring-services/add'] = "tailoring/service_create";
$route['tailoring-pricing'] = "tailoring/pricing";


//customer ledger report
$route['customer-ledger'] = "reports/customer_ledger_report/index";
$route['customer-ledger-report/page-data'] = "reports/customer_ledger_report/paginate_data";
$route['customer-ledger-report/print-page'] = "reports/customer_ledger_report/print_data";

//supplier ledger report
$route['supplier-ledger'] = "reports/supplier_ledger_report/index";
$route['supplier-ledger-report/page-data'] = "reports/supplier_ledger_report/paginate_data";
$route['supplier-ledger-report/print-page'] = "reports/supplier_ledger_report/print_data";

// print chalan
$route['chalan'] = "sales_settings/chalan/index";
$route['temp_add_print_chalan'] = "sales_settings/chalan/temp_add_print_chalan";
$route['show_preview_chalan'] = "dashboard/show_preview_chalan_print";

//sales person
$route['sales-person'] = "sales_settings/sales_person/index";
$route['sales_person/paginate_data/(:any)'] = "sales_settings/sales_person/paginate_data/$1";

//add order
$route['add-order'] = "sales_settings/add_order/index";
$route['add-order/paginate-data/(:any)'] = "sales_settings/add_order/paginate_data/$1";
$route['add-order/add'] = "sales_settings/add_order/add_order_data";
$route['add-order/order-add-row'] = "sales_settings/add_order/add_order_row";
$route['add-order/view-details'] = "sales_settings/add_order/order_details_data";
$route['add-order/view-order-trn'] = "sales_settings/add_order/order_cancel_data";
$route['add-order/cancel-order'] = "sales_settings/add_order/cancel_order";
$route['add-order/print-invoice/(:any)'] = "sales_settings/add_order/print_invoice/$1";

//sales commission
$route['sales-commission'] = "sales_settings/sales_commission/index";
$route['sales-commission/paginate-data/(:any)'] = "sales_settings/sales_commission/paginate_data/$1";
$route['sales-commission/add'] = "sales_settings/sales_commission/add_sales_commission";
$route['salesPersonBalance'] = "sales_settings/sales_commission/sales_person_balance";
$route['add_sales_commission'] = "sales_settings/sales_commission/add_sales_commission_submit";
$route['DueSalesCommission'] = "sales_settings/sales_commission/due_sales_commission";

//new link
$route['fund_transfer_report/page_data/(:any)'] = "reports/fund_transfer/paginate_data/$1";
$route['delivery_report'] = "reports/delivery_report/index";
$route['delivery-report/page-data/(:any)'] = "reports/delivery_report/paginate_data/$1";

//Daily Monthly Summary report
$route['summary-report'] = "reports/summary_report/index";
$route['summary-report/page-data/(:any)'] = "reports/summary_report/paginate_data";
$route['summary-report/print-page'] = "reports/summary_report/print_data";
$route['summary-details/(:any)/(:any)'] = "reports/summary_report/summary_details/$1/$2";

//Best Selling Product report
$route['best-selling-products'] = "reports/best_selling_products/index";
$route['best-selling-products/page-data/(:any)'] = "reports/best_selling_products/paginate_data";
$route['best-selling-products/print-data'] = "reports/best_selling_products/print_data";

//Best Selling Customer report
$route['best-selling-customers'] = "reports/best_selling_customers/index";
$route['best-selling-customers/page-data/(:any)'] = "reports/best_selling_customers/paginate_data";
$route['best-selling-customers/print-data'] = "reports/best_selling_customers/print_data";





