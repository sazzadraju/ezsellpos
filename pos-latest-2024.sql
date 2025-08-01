/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.40 : Database - source_focus
*********************************************************************
*/

SET SESSION sql_require_primary_key = 0;
/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id_account` smallint unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Custom Name to identify Account',
  `acc_type_id` tinyint unsigned NOT NULL COMMENT '1=BankAccount,2=CashAccount,3=MobileBankAccount',
  `acc_uses_id` tinyint unsigned NOT NULL DEFAULT '3' COMMENT '1=GeneralAccount,2=PaymentGateway,3=Both',
  `bank_id` tinyint unsigned DEFAULT NULL,
  `station_id` smallint unsigned DEFAULT NULL,
  `branch_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `account_no` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional)',
  `mob_acc_type_id` tinyint unsigned DEFAULT NULL COMMENT '1=Business, 2=Personal, 3=Agent',
  `trx_charge` decimal(10,2) unsigned DEFAULT '0.00' COMMENT 'Charge per transaction',
  `initial_balance` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '(Optional)',
  `curr_balance` decimal(10,2) DEFAULT '0.00' COMMENT 'Can be Negetive value',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_account`),
  KEY `acc_type_id` (`acc_type_id`),
  KEY `acc_uses_id` (`acc_uses_id`),
  KEY `bank_id` (`bank_id`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id_bank`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `accounts` */

insert  into `accounts`(`id_account`,`account_name`,`acc_type_id`,`acc_uses_id`,`bank_id`,`station_id`,`branch_name`,`address`,`account_no`,`description`,`mob_acc_type_id`,`trx_charge`,`initial_balance`,`curr_balance`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Primary Station',4,3,NULL,1,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,'2024-09-11 11:21:03',1,NULL,NULL,1,1);

/*Table structure for table `accounts_stores` */

DROP TABLE IF EXISTS `accounts_stores`;

CREATE TABLE `accounts_stores` (
  `account_id` smallint unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  KEY `account_id` (`account_id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `accounts_stores_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id_account`),
  CONSTRAINT `accounts_stores_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `accounts_stores` */

insert  into `accounts_stores`(`account_id`,`store_id`) values (1,1);

/*Table structure for table `acl_modules` */

DROP TABLE IF EXISTS `acl_modules`;

CREATE TABLE `acl_modules` (
  `id_acl_module` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Module name',
  `mod_icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Module icon',
  `parent_id` tinyint unsigned DEFAULT NULL,
  `sort` smallint unsigned NOT NULL DEFAULT '9999',
  `rel_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Relative URL',
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  PRIMARY KEY (`id_acl_module`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Contains Modules names';

/*Data for the table `acl_modules` */

insert  into `acl_modules`(`id_acl_module`,`mod_name`,`mod_icon`,`parent_id`,`sort`,`rel_url`,`status_id`) values (1,'Users','\r\n<div class=\"material-icons\">group_add</div>',NULL,13,NULL,1),(2,'Customers','<div class=\"material-icons\">supervisor_account</div>',NULL,3,NULL,1),(3,'Products','<div class=\"material-icons\">local_mall</div>',NULL,1,NULL,1),(4,'Suppliers','<div class=\"material-icons\">account_circle</div>',NULL,4,NULL,1),(5,'Stocks','<div class=\"material-icons\">widgets</div>',NULL,2,NULL,1),(6,'Purchases','<div class=\"material-icons\">shopping_cart</div>',NULL,5,NULL,1),(7,'Accounts Settings','<div class=\"material-icons\">account_balance</div>',NULL,10,NULL,1),(8,'Accounts','<div class=\"material-icons\">account_balance_wallet</div>',NULL,9,NULL,1),(9,'Promotion Management','',NULL,7,NULL,2),(10,'Sales','<div class=\"material-icons\">shopping_basket</div>',NULL,6,NULL,1),(11,'Reports','<div class=\"material-icons\">pie_chart</div>',NULL,11,NULL,1),(12,'User List','',1,101,'employees',1),(13,'Stations',NULL,79,7901,'users/stations',1),(15,'Role Mangement',NULL,1,104,NULL,2),(16,'Customer List',NULL,2,201,'customer',1),(17,'Customer Points',NULL,2,204,'customer/points',1),(18,'Customer Type',NULL,2,203,'customer/type',1),(19,'Product List',NULL,3,300,'products',1),(20,'Categories',NULL,3,305,'products/categories',1),(21,'Brands',NULL,3,310,'products/brands',1),(22,'Units',NULL,3,315,'products/other-configuration',1),(23,'Bulk Bar Code Printer',NULL,3,305,NULL,2),(24,'VAT Configuration',NULL,3,306,NULL,2),(25,'Suppliers',NULL,4,401,'suppliers',1),(26,'Supplier Payment Alert',NULL,4,402,'supplier_payment_alert',2),(27,'Supplier Return','',4,403,'supplier-return',1),(29,'Stock In',NULL,5,502,'stock_in_list',1),(31,'Stock Out',NULL,5,504,'stock_out',1),(33,'Stock Transfer',NULL,5,506,'stock_transfer',1),(34,'Stock Audit',NULL,5,508,'stock_audit',1),(35,'Item Ledger',NULL,5,509,NULL,2),(37,'Purchase Requisition',NULL,6,610,'requisitions',1),(38,'Purchase Order',NULL,6,600,'purchase-order',1),(39,'Purchase Receive',NULL,6,605,'purchase-receive',1),(41,'Supplier Return',NULL,6,615,NULL,2),(43,'Account List',NULL,7,701,'account-settings/account',1),(44,'Bank Name',NULL,7,702,'account-settings/bank',1),(45,'Card Types',NULL,7,703,'account-settings/card-type',2),(46,'Expense Categories',NULL,7,704,'account-settings/transaction-category',1),(47,'Transactions',NULL,8,801,'account-management/transactions/customer',1),(48,'Fund Transfer',NULL,8,802,'account-management/fund-transfer',1),(49,'Account Summary',NULL,8,803,NULL,2),(53,'Promotion Management',NULL,10,1035,'promotion-management',1),(57,'Sales',NULL,10,1000,'sales',1),(58,'Sale Returns',NULL,10,1005,'sale-returns',1),(61,'Profit/Loss',NULL,11,1215,'profit_loss',1),(62,'Sell Invoices',NULL,11,1200,'sell-report',1),(65,'Best Selling Items',NULL,11,1160,NULL,2),(68,'Best Customer Report',NULL,11,1161,NULL,2),(69,'Store Sale Summary',NULL,11,1209,'store-sale-summary',1),(73,'Hour Basis Report',NULL,11,1166,NULL,2),(74,'Day Basis Report',NULL,11,1162,NULL,2),(75,'User Log',NULL,11,1163,NULL,2),(76,'Sale Return Report',NULL,11,1164,NULL,2),(77,'Sale Replace Report',NULL,11,1165,NULL,2),(78,'Stock Reasons',NULL,5,510,'stock-reason',1),(79,'Settings','<div class=\"material-icons\">tune</div>',NULL,12,NULL,1),(80,'Company Info',NULL,79,7901,'company-info',1),(81,'Stock Recieve',NULL,5,507,'stock-recieve',1),(83,'Billing',NULL,79,7902,'billing',2),(84,'Rack Settings',NULL,79,7904,'rack-settings',1),(85,'Store Settings',NULL,79,7903,'store-settings',1),(86,'Stock Report',NULL,11,1221,'stock-report',1),(87,'Purchase Reports',NULL,11,1119,'purchase-report',2),(88,'Purchase Report Details',NULL,11,1120,'purchase-report-details',2),(89,'Date Wise Sale',NULL,11,1206,'date-wise-sale',1),(90,'Expering Soon Report',NULL,11,1230,'expiring-soon-products',1),(93,'Customer Transaction Report',NULL,11,1245,'customer-transaction-report',1),(94,'Employee Transaction Report',NULL,11,1263,'employee-transaction-report',1),(95,'Investor Transaction Report',NULL,11,1269,'investor-transaction-report',1),(96,'Office Transaction Report',NULL,11,1260,'office-transaction-report',1),(97,'Stock in Summary',NULL,11,1224,'stock-in-summary',1),(98,'Supplier Transaction Report',NULL,11,1266,'supplier-transaction-report',1),(99,'Transaction Invoices',NULL,8,804,'account-management/transaction-invoices',1),(100,'Customer Receivable',NULL,11,1239,'customer-receivable-report',1),(101,'Stock Out Report',NULL,11,1227,'stock-out-report',1),(102,'Supplier Payable',NULL,11,1251,'supplier-payable-report',1),(103,'Product Sale Summary',NULL,255,1203,'product-sell-report',1),(104,'Stock Mismatch Report',NULL,11,1236,'stock-mismatch-report',1),(105,'Delivery','<div class=\"material-icons\">local_shipping</div>',NULL,8,NULL,1),(106,'Agents',NULL,105,1050,'agents',1),(107,'Delivery Persons',NULL,105,1051,'delivery-persons',1),(108,'Delivery Costs',NULL,105,1052,'delivery-costs',1),(109,'Delivery Orders',NULL,105,1053,'delivery-orders',1),(110,'Attributes',NULL,3,320,'attributes',1),(111,'Tailoring','',NULL,10,NULL,2),(112,'Tailoring Orders',NULL,111,1051,'tailoring-orders',2),(113,'Tailoring Services',NULL,111,1055,'tailoring-services',2),(114,'Tailoring Pricing',NULL,111,1060,'tailoring-pricing',2),(115,'Print Barcode/Label',NULL,3,325,'products/bulk-barcode',1),(116,'Vat Report',NULL,11,1275,'vat-report',1),(117,'COD Charge',NULL,105,1054,'cod-costs',1),(118,'Sell Return Report',NULL,11,1218,'sell-return-report',1),(119,'Customer Ledger Report',NULL,11,1242,'customer-ledger',1),(120,'Supplier Ledger Report',NULL,11,1254,'supplier-ledger',1),(121,'Product Pricing',NULL,3,330,'products/pricing',1),(122,'Print Challan',NULL,10,1010,'chalan',1),(123,'Sales Person',NULL,10,1015,'sales-person',1),(124,'Add Order',NULL,10,1020,'add-order',2),(125,'Sales Commission',NULL,10,1025,'sales-commission',1),(126,'Low/High Stock Report',NULL,11,1233,'products/low-high-stock',1),(127,'Fund Transfer Report',NULL,11,1257,'reports/fund_transfer',1),(128,'Quotation',NULL,10,1030,'quotation',1),(129,'Delivery Report',NULL,11,1272,'delivery_report',1),(130,'SMS Management','',NULL,15,NULL,2),(131,'Campaigns',NULL,130,1510,'sms/campaign',2),(132,'Audiences',NULL,130,1511,'sms/audience',2),(134,'Daily/Monthly Summary',NULL,11,1102,'summary-report',2),(135,'Top Selling Products',NULL,11,1212,'best-selling-products',1),(136,'Top Customers',NULL,11,1248,'best-selling-customers',1);

/*Table structure for table `acl_pages` */

DROP TABLE IF EXISTS `acl_pages`;

CREATE TABLE `acl_pages` (
  `id_acl_page` smallint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint unsigned NOT NULL,
  `submodule_id` tinyint unsigned NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `page_code` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `rel_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Relative URL',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'If value is 1 then shows in menu, otherwise hides from menu',
  `sort` smallint unsigned DEFAULT '9999',
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  PRIMARY KEY (`id_acl_page`),
  KEY `module_id` (`module_id`),
  KEY `submodule_id` (`submodule_id`),
  CONSTRAINT `acl_pages_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `acl_modules` (`id_acl_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Pages under module';

/*Data for the table `acl_pages` */

/*Table structure for table `acl_user_column` */

DROP TABLE IF EXISTS `acl_user_column`;

CREATE TABLE `acl_user_column` (
  `id_acl_user_column` int NOT NULL AUTO_INCREMENT,
  `acl_module_id` int DEFAULT '0',
  `menu_url` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `acl_menu_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `column_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `permission` int DEFAULT NULL COMMENT '1=yes,2=No',
  `status_id` int DEFAULT NULL COMMENT '1=active,2=inactive',
  PRIMARY KEY (`id_acl_user_column`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `acl_user_column` */

insert  into `acl_user_column`(`id_acl_user_column`,`acl_module_id`,`menu_url`,`acl_menu_name`,`column_name`,`permission`,`status_id`) values (1,19,'products','Product','Purchase Price',1,1),(2,86,'stock-report','Stock Report','Purchase Price',1,1),(3,97,'stock-in-summary','Stock in Summary','Purchase Price',1,1),(4,121,'products/pricing','Product Pricing','Purchase Price',1,1),(5,0,'stock_transfer_send_details','Stock Transfer(Details)','Purchase Price',1,1),(6,0,'product_stock_transfer','Stock Transfer','Purchase Price',1,1),(7,0,'stock_out_details','Stock Out(Details)','Purchase Price',1,1),(8,0,'product_stock_out','Stock Out','Purchase Price',1,1),(9,0,'stock_transfer_view','Stock Receive(Details)','Purchase Price',1,1),(10,0,'stock_transfer_details','Stock Receive','Purchase Price',1,1);

/*Table structure for table `acl_user_modules` */

DROP TABLE IF EXISTS `acl_user_modules`;

CREATE TABLE `acl_user_modules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint unsigned NOT NULL COMMENT '`acl_roles`.`id_acl_role`',
  `module_id` tinyint unsigned NOT NULL COMMENT '`acl_pages`.`id_acl_page`',
  `submodule_id` tinyint unsigned NOT NULL COMMENT '`acl_pages`.`id_acl_page`',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `acl_user_modules_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `acl_modules` (`id_acl_module`),
  CONSTRAINT `acl_user_modules_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=622 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Modules under user';

/*Data for the table `acl_user_modules` */

insert  into `acl_user_modules`(`id`,`user_id`,`module_id`,`submodule_id`) values (538,5,8,0),(539,5,10,0),(540,5,130,0),(541,5,2,16),(542,5,2,17),(543,5,2,18),(544,5,7,43),(545,5,7,44),(546,5,7,45),(547,5,7,46),(548,5,8,47),(549,5,8,48),(550,5,8,99),(551,5,10,57),(552,5,10,58),(553,5,10,122),(554,5,10,123),(555,5,10,124),(556,5,10,125),(557,5,10,128),(558,5,11,62),(559,5,11,69),(560,5,11,89),(561,5,11,93),(562,5,11,100),(563,5,11,101),(564,5,11,103),(565,5,11,104),(566,5,11,118),(567,5,11,119),(568,5,11,126),(569,5,11,127),(570,5,11,134),(571,5,11,135),(572,5,11,136),(573,5,130,131),(574,5,130,132),(575,6,2,0),(576,6,7,0),(577,6,8,0),(578,6,9,0),(579,6,10,0),(580,6,130,0),(581,6,2,16),(582,6,2,17),(583,6,2,18),(584,6,5,34),(585,6,7,43),(586,6,7,44),(587,6,7,45),(588,6,7,46),(589,6,8,47),(590,6,8,48),(591,6,8,99),(592,6,9,53),(593,6,10,57),(594,6,10,58),(595,6,10,122),(596,6,10,123),(597,6,10,124),(598,6,10,125),(599,6,10,128),(600,6,11,62),(601,6,11,69),(602,6,11,86),(603,6,11,89),(604,6,11,90),(605,6,11,93),(606,6,11,96),(607,6,11,97),(608,6,11,100),(609,6,11,101),(610,6,11,103),(611,6,11,118),(612,6,11,119),(613,6,11,120),(614,6,11,126),(615,6,11,127),(616,6,11,129),(617,6,11,134),(618,6,11,135),(619,6,11,136),(620,6,130,131),(621,6,130,132);

/*Table structure for table `acl_user_pages` */

DROP TABLE IF EXISTS `acl_user_pages`;

CREATE TABLE `acl_user_pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint unsigned NOT NULL,
  `submodule_id` int DEFAULT NULL,
  `page_id` smallint DEFAULT NULL,
  `page_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status_id` smallint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `page_id` (`page_name`),
  CONSTRAINT `acl_user_pages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Pages under user';

/*Data for the table `acl_user_pages` */

insert  into `acl_user_pages`(`id`,`user_id`,`submodule_id`,`page_id`,`page_name`,`status_id`) values (1,5,47,NULL,'customer',1),(2,5,47,NULL,'supplier',1),(3,5,47,NULL,'office',1),(4,5,47,NULL,'employee',1),(5,5,47,NULL,'investor',1),(6,6,47,NULL,'customer',1),(7,6,47,NULL,'office',1),(8,6,47,NULL,'employee',1);

/*Table structure for table `agents` */

DROP TABLE IF EXISTS `agents`;

CREATE TABLE `agents` (
  `id_agent` smallint unsigned NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(164) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `contact_person_name` varchar(164) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `agent_number` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'multiple numbers separated by comma',
  `contact_person_number` varchar(48) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'multiple numbers separated by comma',
  `email` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime NOT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `agents` */

/*Table structure for table `banks` */

DROP TABLE IF EXISTS `banks`;

CREATE TABLE `banks` (
  `id_bank` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_type_id` tinyint unsigned NOT NULL COMMENT '1=GeneralBank, 2=MobileBank',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_bank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `banks` */

/*Table structure for table `card_types` */

DROP TABLE IF EXISTS `card_types`;

CREATE TABLE `card_types` (
  `id_card_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `card_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_card_type`),
  UNIQUE KEY `card_name` (`card_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `card_types` */

insert  into `card_types`(`id_card_type`,`card_name`,`description`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Visa',NULL,'2017-10-07 11:42:18',1,NULL,NULL,1,1),(2,'Mastercard',NULL,'2017-10-07 11:42:18',1,NULL,NULL,1,1),(3,'Amex',NULL,'2017-10-07 11:42:18',1,NULL,NULL,1,1),(4,'Nexus',NULL,'2017-10-07 11:42:18',1,NULL,NULL,1,1);

/*Table structure for table `config_auto_increments` */

DROP TABLE IF EXISTS `config_auto_increments`;

CREATE TABLE `config_auto_increments` (
  `keyword` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `val` int NOT NULL,
  `store_id` tinyint unsigned DEFAULT NULL,
  `cat_id` smallint unsigned DEFAULT NULL,
  `subcat_id` smallint unsigned DEFAULT NULL,
  PRIMARY KEY (`keyword`),
  KEY `store_id` (`store_id`),
  KEY `cat_id` (`cat_id`),
  KEY `subcat_id` (`subcat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `config_auto_increments` */

insert  into `config_auto_increments`(`keyword`,`val`,`store_id`,`cat_id`,`subcat_id`) values ('AUDIT_NUMBER',1000,NULL,NULL,NULL),('ORDER',1000,NULL,NULL,NULL),('PURCHASE_ORDER_INVOICE',1000,NULL,NULL,NULL),('PURCHASE_RECEIVE_INVOICE',1000,NULL,NULL,NULL),('PURCHASE_REQUISITION_INVOICE',1000,NULL,NULL,NULL),('SALES_COMMISSION',1000,NULL,NULL,NULL),('STOCK_IN_BATCH',1000,NULL,NULL,NULL),('STOCK_IN_INVOICE',1000,NULL,NULL,NULL),('STOCK_OUT_INVOICE',1000,NULL,NULL,NULL),('SUPPLIER_RETURN_INVOICE',1000,NULL,NULL,NULL),('TAILORING',1000,NULL,NULL,NULL),('TRANSACTION',1000,NULL,NULL,NULL);

/*Table structure for table `configs` */

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `param_key` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `param_val` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `utilized_val` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `notes` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  PRIMARY KEY (`param_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `configs` */

/*Table structure for table `csv_report` */

DROP TABLE IF EXISTS `csv_report`;

CREATE TABLE `csv_report` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `value` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `csv_report` */

/*Table structure for table `customer_addresss` */

DROP TABLE IF EXISTS `customer_addresss`;

CREATE TABLE `customer_addresss` (
  `id_customer_address` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int unsigned DEFAULT NULL,
  `address_type` enum('Present Address','Permanent Address','Shipping Address','Billing Address') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `div_id` tinyint unsigned DEFAULT NULL COMMENT 'Division ID',
  `dist_id` tinyint unsigned DEFAULT NULL COMMENT 'District ID',
  `upz_id` smallint unsigned DEFAULT NULL COMMENT 'Upazila/Thana ID',
  `unn_id` smallint unsigned DEFAULT NULL COMMENT 'Union ID',
  `city_id` smallint unsigned DEFAULT NULL COMMENT 'City ID',
  `area_id` smallint unsigned DEFAULT NULL COMMENT 'Area ID',
  `post_code` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `addr_line_1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'House/Road/Flat/Region details',
  PRIMARY KEY (`id_customer_address`),
  UNIQUE KEY `UNQ_customer_address_type` (`customer_id`,`address_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `customer_addresss` */

/*Table structure for table `customer_documents` */

DROP TABLE IF EXISTS `customer_documents`;

CREATE TABLE `customer_documents` (
  `id_customer_document` int unsigned NOT NULL AUTO_INCREMENT,
  `cus_id` smallint DEFAULT NULL COMMENT 'Customer ID',
  `name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Document Name/Title/Initiation',
  `description` varchar(1024) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'File descriotion',
  `file` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'FileName with absoulte FilePath',
  `dtt_add` datetime DEFAULT NULL COMMENT 'Document added at',
  `uid_add` smallint unsigned DEFAULT NULL COMMENT 'Document added by',
  `dtt_mod` datetime DEFAULT NULL COMMENT 'Document modified at',
  `uid_mod` smallint unsigned DEFAULT NULL COMMENT 'Document modified by',
  `status_id` tinyint(1) DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_customer_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `customer_documents` */

/*Table structure for table `customer_points` */

DROP TABLE IF EXISTS `customer_points`;

CREATE TABLE `customer_points` (
  `id_customer_point` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int unsigned DEFAULT NULL,
  `points` decimal(10,2) NOT NULL,
  `point_type_id` tinyint NOT NULL DEFAULT '1' COMMENT '1=Sales',
  `ref_id` int unsigned DEFAULT NULL COMMENT 'SalesId for Sales',
  `usage_type_id` tinyint(1) DEFAULT NULL COMMENT '1=Earned, -1=Spent',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_customer_point`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `customer_points` */

/*Table structure for table `customer_types` */

DROP TABLE IF EXISTS `customer_types`;

CREATE TABLE `customer_types` (
  `id_customer_type` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL,
  `target_sales_volume` decimal(10,2) DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_customer_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `customer_types` */

insert  into `customer_types`(`id_customer_type`,`name`,`description`,`discount`,`target_sales_volume`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Basic',NULL,0.00,0.00,'2017-12-30 14:53:48',1,NULL,NULL,1,1);

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id_customer` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID generated automatically',
  `customer_code` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'ID given manually. It is marked as "Membership ID" in document',
  `customer_type_id` smallint unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `full_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `marital_status` enum('Married','Unmarried','Divorced','Widowed') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `spouse_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `profile_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'FileName with absoulte FilePath',
  `points` decimal(10,2) unsigned DEFAULT '0.00' COMMENT 'Total points earned by order',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT 'Total payment balance. -ve value indicates customer''s due.',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted, 3=Resigned',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_customer`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `customers` */

/*Table structure for table `delivery_cost_details` */

DROP TABLE IF EXISTS `delivery_cost_details`;

CREATE TABLE `delivery_cost_details` (
  `id_delivery_cost_details` int unsigned NOT NULL AUTO_INCREMENT,
  `delivery_cost_id` int DEFAULT NULL,
  `gm_from` int unsigned NOT NULL COMMENT 'gm=gram from',
  `gm_to` int unsigned NOT NULL COMMENT 'gm=gram to',
  `price` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id_delivery_cost_details`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `delivery_cost_details` */

/*Table structure for table `delivery_costs` */

DROP TABLE IF EXISTS `delivery_costs`;

CREATE TABLE `delivery_costs` (
  `id_delivery_cost` int unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint unsigned NOT NULL COMMENT '1=Staff,2=Agent',
  `ref_id` smallint DEFAULT NULL COMMENT '`users`.`NULL` for type_id=1. `agents`.`id_agent` for type_id=2.',
  `delivery_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  PRIMARY KEY (`id_delivery_cost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `delivery_costs` */

/*Table structure for table `delivery_orders` */

DROP TABLE IF EXISTS `delivery_orders`;

CREATE TABLE `delivery_orders` (
  `id_delivery_order` int unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int unsigned NOT NULL,
  `customer_id` int NOT NULL,
  `type_id` smallint NOT NULL COMMENT '1=Staff,2=Agent',
  `ref_id` int unsigned DEFAULT NULL COMMENT '`NULL` for type_id=1, `agents`.`id_agent` for type_id=2.',
  `person_id` int unsigned NOT NULL COMMENT '`users`.`id_user` for `type_id`=1, `delivery_persons`.`id_delivery_person` for `type_id`=2',
  `reference_num` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cost_id` int unsigned NOT NULL COMMENT '`delivery_costs`.`id_delivery_cost` for `cost_id`',
  `cost_details_id` int unsigned NOT NULL COMMENT '`delivery_cost_details`.`id_delivery_cost_details` for `cost_details_id`',
  `customer_address_id` int NOT NULL COMMENT 'Delivery Destination `customer_address`.`id_customer_address`',
  `delivery_address` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `tot_amt` decimal(10,2) NOT NULL,
  `paid_amt` decimal(10,2) DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `cod_charge` decimal(10,2) DEFAULT NULL,
  `order_status` smallint NOT NULL COMMENT '1=Painding,2=Processing,3=Delivered,4=Return,5=Canceled but sale done',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  PRIMARY KEY (`id_delivery_order`),
  KEY `sale_invoice_no` (`sale_id`),
  KEY `ref_id` (`ref_id`),
  KEY `cost_id` (`cost_id`),
  KEY `cost_details_id` (`cost_details_id`),
  CONSTRAINT `fk01_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id_sale`),
  CONSTRAINT `fk_02_cost_id` FOREIGN KEY (`cost_id`) REFERENCES `delivery_costs` (`id_delivery_cost`),
  CONSTRAINT `fk_03_cost_id` FOREIGN KEY (`cost_details_id`) REFERENCES `delivery_cost_details` (`id_delivery_cost_details`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `delivery_orders` */

/*Table structure for table `delivery_persons` */

DROP TABLE IF EXISTS `delivery_persons`;

CREATE TABLE `delivery_persons` (
  `id_delivery_person` smallint unsigned NOT NULL AUTO_INCREMENT,
  `person_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'agents delivery man name',
  `person_mobile` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'agents delivery man mobile',
  `type_id` tinyint unsigned NOT NULL COMMENT '1=Staff,2=Agent',
  `ref_id` int unsigned NOT NULL COMMENT '`users`.`id_user` for type_id=1. `agents`.`id_agent` for type_id=2.',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint(5) unsigned zerofill NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL COMMENT '1=Active,0=Inactive',
  PRIMARY KEY (`id_delivery_person`),
  KEY `ref_id` (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `delivery_persons` */

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `id_document` int unsigned NOT NULL AUTO_INCREMENT,
  `doc_type` enum('User','Supplier','Supplier Contact Person','Customer','Stock','Stock Audit','Transaction','Purchase Receive') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ref_id` smallint DEFAULT NULL COMMENT 'Reference ID. Primary Key from users, suppliers, supplier_contact_persons, customers Tables',
  `name` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Document Name/Title/Initiation',
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'File description',
  `file` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'FileName with absoulte FilePath',
  `dtt_add` datetime DEFAULT NULL COMMENT 'Datetime of added at',
  `uid_add` smallint unsigned DEFAULT NULL COMMENT 'dded by',
  `dtt_mod` datetime DEFAULT NULL COMMENT 'Datetime of last modified at',
  `uid_mod` smallint unsigned DEFAULT NULL COMMENT 'Last modified by',
  `status_id` tinyint(1) DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` tinyint unsigned DEFAULT '1',
  PRIMARY KEY (`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `documents` */

/*Table structure for table `employee_job_titles` */

DROP TABLE IF EXISTS `employee_job_titles`;

CREATE TABLE `employee_job_titles` (
  `id_employee_job_title` smallint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_employee_job_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `employee_job_titles` */

/*Table structure for table `employee_transactions` */

DROP TABLE IF EXISTS `employee_transactions`;

CREATE TABLE `employee_transactions` (
  `id_employee_transaction` int unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` smallint unsigned NOT NULL,
  `trx_type_id` tinyint unsigned NOT NULL COMMENT '`transaction_types`.`id_transaction_type`',
  `amount` decimal(10,2) unsigned NOT NULL,
  `qty_multiplier` tinyint(1) NOT NULL,
  `trx_id` int unsigned NOT NULL,
  `description` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_employee_transaction`),
  KEY `emp_id` (`emp_id`),
  KEY `trx_type_id` (`trx_type_id`),
  KEY `status_id` (`status_id`),
  KEY `trx_id` (`trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `employee_transactions` */

/*Table structure for table `fund_transfers` */

DROP TABLE IF EXISTS `fund_transfers`;

CREATE TABLE `fund_transfers` (
  `id_fund_transfer` int unsigned NOT NULL AUTO_INCREMENT,
  `acc_from_id` smallint unsigned NOT NULL,
  `acc_to_id` smallint unsigned NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `description` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1',
  `version` tinyint unsigned DEFAULT '1',
  PRIMARY KEY (`id_fund_transfer`),
  KEY `acc_from` (`acc_from_id`),
  KEY `acc_to` (`acc_to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `fund_transfers` */

/*Table structure for table `hold_sale_details` */

DROP TABLE IF EXISTS `hold_sale_details`;

CREATE TABLE `hold_sale_details` (
  `id_hold_sale_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `hold_sale_id` int unsigned NOT NULL,
  `stock_id` int unsigned NOT NULL,
  `product_id` smallint unsigned NOT NULL,
  `product_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'product_code|product_name|Cat_name|Subcat_name',
  `cat_id` smallint unsigned DEFAULT NULL,
  `subcat_id` smallint unsigned DEFAULT NULL,
  `brand_id` smallint unsigned DEFAULT NULL,
  `qty` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Quantity. can be fractional. eg, 2.528 kg Rice',
  `unit_id` tinyint unsigned NOT NULL,
  `selling_price_est` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Original Selling Price',
  `selling_price_act` decimal(10,2) DEFAULT NULL COMMENT 'Selling Price After Discount',
  `discount_rate` decimal(10,2) unsigned NOT NULL COMMENT 'Discount Rate',
  `discount_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Discount Amount',
  `vat_rate` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Vat Rate',
  `vat_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Vat Amount',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted, 3=Replaced (Old), 4=Replaced (New)',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_hold_sale_detail`,`unit_id`),
  KEY `hold_sale_id` (`hold_sale_id`),
  KEY `stock_id` (`stock_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `hold_sale_details_ibfk_1` FOREIGN KEY (`hold_sale_id`) REFERENCES `hold_sales` (`id_hold_sale`),
  CONSTRAINT `hold_sale_details_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id_stock`),
  CONSTRAINT `hold_sale_details_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `hold_sale_details` */

/*Table structure for table `hold_sales` */

DROP TABLE IF EXISTS `hold_sales`;

CREATE TABLE `hold_sales` (
  `id_hold_sale` int unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `station_id` smallint unsigned NOT NULL COMMENT '`hold_sales`.`id_station`',
  `customer_id` int unsigned DEFAULT NULL COMMENT 'set NULL if no existing customer',
  `stock_id` int unsigned DEFAULT NULL,
  `product_id` smallint unsigned DEFAULT NULL,
  `batch_no` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `qty` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Quantity. can be fractional. eg, 2.528 kg Rice',
  `dis_rate` decimal(10,2) DEFAULT NULL,
  `dis_amt` decimal(10,2) DEFAULT NULL,
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional). Note down any important comments here',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  PRIMARY KEY (`id_hold_sale`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `hold_sales` */

/*Table structure for table `investments` */

DROP TABLE IF EXISTS `investments`;

CREATE TABLE `investments` (
  `id_investment` int unsigned NOT NULL AUTO_INCREMENT,
  `investor_id` smallint unsigned DEFAULT NULL,
  `invest_type_id` tinyint unsigned NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `qty_multiplier` tinyint(1) NOT NULL,
  `description` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `trx_id` int unsigned NOT NULL,
  `dtt_invest` datetime DEFAULT NULL,
  `dtt_add` date DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_investment`),
  KEY `investor_id` (`investor_id`),
  KEY `trx_id` (`trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `investments` */

/*Table structure for table `loc_areas` */

DROP TABLE IF EXISTS `loc_areas`;

CREATE TABLE `loc_areas` (
  `id_area` smallint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` tinyint unsigned DEFAULT NULL,
  `upazila_id` smallint unsigned DEFAULT NULL,
  `city_id` smallint unsigned DEFAULT NULL,
  `area_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Area name in English',
  `area_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Area name in Bangla',
  PRIMARY KEY (`id_area`),
  KEY `district_id` (`district_id`),
  KEY `upazila_id` (`upazila_id`),
  CONSTRAINT `loc_areas_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `loc_districts` (`id_district`) ON UPDATE CASCADE,
  CONSTRAINT `loc_areas_ibfk_2` FOREIGN KEY (`upazila_id`) REFERENCES `loc_upazilas` (`id_upazila`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_areas` */

insert  into `loc_areas`(`id_area`,`district_id`,`upazila_id`,`city_id`,`area_name_en`,`area_name_bn`) values (1,12,NULL,1,'Elephant Road','à¦à¦²à¦¿à¦«à§à¦¯à¦¾à¦¨à§à¦Ÿ à¦°à§‹à¦¡'),(2,12,NULL,1,'Wari','à¦“à¦¯à¦¼à¦¾à¦°à§€'),(3,12,NULL,1,'Kawranbazar','à¦•à¦¾à¦“à¦°à¦¾à¦¨à¦¬à¦¾à¦œà¦¾à¦°'),(4,12,NULL,1,'Kafrul','à¦•à¦¾à¦«à¦°à§à¦²'),(5,12,NULL,1,'Kamrangirchar','à¦•à¦¾à¦®à¦°à¦¾à¦™à§à¦—à§€à¦°à¦šà¦°'),(6,12,NULL,1,'Keraniganj','à¦•à§‡à¦°à¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(7,12,NULL,1,'Kotowali','à¦•à§‹à¦¤à§‹à§Ÿà¦¾à¦²à§€'),(8,12,NULL,1,'Cantonment','à¦•à§à¦¯à¦¾à¦¨à§à¦Ÿà¦¨à¦®à§‡à¦¨à§à¦Ÿ'),(9,12,NULL,1,'Khilkhet','à¦–à¦¿à¦²à¦•à§à¦·à§‡à¦¤'),(10,12,NULL,1,'Khilgaon','à¦–à¦¿à¦²à¦—à¦¾à¦à¦“'),(11,12,NULL,1,'Chaukbazar','à¦šà¦•à¦¬à¦¾à¦œà¦¾à¦°'),(12,12,NULL,1,'Tongi','à¦Ÿà¦™à§à¦—à§€'),(13,12,NULL,1,'Demra','à¦¡à§‡à¦®à¦°à¦¾'),(14,12,NULL,1,'Tejgaon','à¦¤à§‡à¦œà¦—à¦¾à¦à¦“'),(15,12,NULL,1,'Dohar','à¦¦à§‹à¦¹à¦¾à¦°'),(16,12,NULL,1,'Dhamrai','à¦§à¦¾à¦®à¦°à¦¾à¦‡'),(17,12,NULL,1,'Nawabganj','à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ'),(18,12,NULL,1,'New Market','à¦¨à¦¿à¦‰à¦®à¦¾à¦°à§à¦•à§‡à¦Ÿ'),(19,12,NULL,1,'Paltan','à¦ªà¦²à§à¦Ÿà¦¨'),(20,12,NULL,1,'Purbachal','à¦ªà§‚à¦°à§à¦¬à¦¾à¦šà¦²'),(21,12,NULL,1,'Bangshal','à¦¬à¦‚à¦¶à¦¾à¦²'),(22,12,NULL,1,'Banani','à¦¬à¦¨à¦¾à¦¨à§€'),(23,12,NULL,1,'Banani DOHS','à¦¬à¦¨à¦¾à¦¨à§€ à¦¡à¦¿à¦“à¦à¦‡à¦šà¦à¦¸'),(24,12,NULL,1,'Basundhara','à¦¬à¦¸à§à¦¨à§à¦§à¦°à¦¾'),(25,12,NULL,1,'Banglamotor','à¦¬à¦¾à¦‚à¦²à¦¾à¦®à§‹à¦Ÿà¦°'),(26,12,NULL,1,'Badda','à¦¬à¦¾à¦¡à§à¦¡à¦¾'),(27,12,NULL,1,'Baridhara','à¦¬à¦¾à¦°à¦¿à¦§à¦¾à¦°à¦¾'),(28,12,NULL,1,'Basabo','à¦¬à¦¾à¦¸à¦¾à¦¬à§‹'),(29,12,NULL,1,'Mogbazar','à¦®à¦—à¦¬à¦¾à¦œà¦¾à¦°'),(30,12,NULL,1,'Motijheel','à¦®à¦¤à¦¿à¦à¦¿à¦²'),(31,12,NULL,1,'Mohakhali','à¦®à¦¹à¦¾à¦–à¦¾à¦²à§€'),(32,12,NULL,1,'Mohakhali DOHS','à¦®à¦¹à¦¾à¦–à¦¾à¦²à§€ à¦¡à¦¿à¦“à¦à¦‡à¦šà¦à¦¸'),(33,12,NULL,1,'Malibag','à¦®à¦¾à¦²à¦¿à¦¬à¦¾à¦—'),(34,12,NULL,1,'Mirpur DOHS','à¦®à¦¿à¦°à¦ªà§à¦° à¦¡à¦¿à¦“à¦à¦‡à¦šà¦à¦¸'),(35,12,NULL,1,'Jatrabari','à¦¯à¦¾à¦¤à§à¦°à¦¾à¦¬à¦¾à¦¡à¦¼à¦¿'),(36,12,NULL,1,'Ramna','à¦°à¦®à¦¨à¦¾'),(37,12,NULL,1,'Rampura','à¦°à¦¾à¦®à¦ªà§à¦°à¦¾'),(38,12,NULL,1,'Lalbag','à¦²à¦¾à¦²à¦¬à¦¾à¦—'),(39,12,NULL,1,'Shajahanpur','à¦¶à¦¾à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°'),(40,12,NULL,1,'Savar','à¦¸à¦¾à¦­à¦¾à¦°'),(41,12,NULL,1,'Sutrapur','à¦¸à§à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(42,12,NULL,1,'Hazaribagh','à¦¹à¦¾à¦œà¦¾à¦°à§€à¦¬à¦¾à¦—'),(43,61,NULL,2,'Akhalia','à¦†à¦–à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(44,61,NULL,2,'Osmani Nagar','à¦“à¦¸à¦®à¦¾à¦¨à§€ à¦¨à¦—à¦°'),(45,61,NULL,2,'Kanaighat','à¦•à¦¾à¦¨à¦¾à¦‡à¦˜à¦¾à¦Ÿ'),(46,61,NULL,2,'Kumar para','à¦•à§à¦®à¦¾à¦° à¦ªà¦¾à§œà¦¾'),(47,61,NULL,2,'Companiganj','à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(48,61,NULL,2,'Gowainghat','à¦—à§‹à¦¯à¦¼à¦¾à¦‡à¦¨à¦˜à¦¾à¦Ÿ'),(49,61,NULL,2,'Golapganj','à¦—à§‹à¦²à¦¾à¦ªà¦—à¦žà§à¦œ'),(50,61,NULL,2,'Chouhatta','à¦šà§Œà¦¹à¦¾à¦Ÿà§à¦Ÿà¦¾'),(51,61,NULL,2,'Zakiganj','à¦œà¦•à¦¿à¦—à¦žà§à¦œ'),(52,61,NULL,2,'Jaintapur','à¦œà¦¾à¦¯à¦¼à¦¨à§à¦¤à¦¿à¦¯à¦¼à¦¾à¦ªà§à¦°'),(53,61,NULL,2,'Dargah Mahalla','à¦¦à¦°à¦—à¦¾à¦¹ à¦®à¦¹à¦²à§à¦²à¦¾'),(54,61,NULL,2,'Nehari Para','à¦¨à§‡à¦¹à¦¾à¦°à¦¿ à¦ªà¦¾à¦¡à¦¼à¦¾'),(55,61,NULL,2,'Nayasarak','à¦¨à§Ÿà¦¾à¦¸à§œà¦•'),(56,61,NULL,2,'Pathan Tula','à¦ªà¦¾à¦ à¦¾à¦¨ à¦Ÿà§à¦²à¦¾'),(57,61,NULL,2,'Fenchuganj','à¦«à§‡à¦žà§à¦šà§à¦—à¦žà§à¦œ'),(58,61,NULL,2,'Bagh Bari (Baghbari)','à¦¬à¦¾à¦˜ à¦¬à¦¾à¦¡à¦¼à¦¿'),(59,61,NULL,2,'Balaganj','à¦¬à¦¾à¦²à¦¾à¦—à¦žà§à¦œ'),(60,61,NULL,2,'Bimanbondor','à¦¬à¦¿à¦®à¦¾à¦¨à¦¬à¦¨à§à¦¦à¦°'),(61,61,NULL,2,'Beanibazar','à¦¬à¦¿à¦¯à¦¼à¦¾à¦¨à§€à¦¬à¦¾à¦œà¦¾à¦°'),(62,61,NULL,2,'Bishwanath','à¦¬à¦¿à¦¶à§à¦¬à¦¨à¦¾à¦¥'),(63,61,NULL,2,'Majortila','à¦®à§‡à¦œà¦°à¦Ÿà¦¿à¦²à¦¾'),(64,61,NULL,2,'Lama Bazar','à¦²à¦¾à¦®à¦¾ à¦¬à¦¾à¦œà¦¾à¦°'),(65,61,NULL,2,'Shahporan','à¦¶à¦¾à¦¹à¦ªà¦°à¦¾à¦¨'),(66,61,NULL,2,'Shahi Eidgah','à¦¶à¦¾à¦¹à§€ à¦ˆà¦¦à¦—à¦¾à¦¹'),(67,61,NULL,2,'Shibgonj','à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ'),(68,61,NULL,2,'Subhani Ghat','à¦¸à§à¦¬à¦¹à¦¾à¦¨à¦¿à¦˜à¦¾à¦Ÿ'),(69,61,NULL,2,'Subid Bazar','à¦¸à§à¦¬à¦¿à¦¦ à¦¬à¦¾à¦œà¦¾à¦°'),(70,44,NULL,3,'Koyra ','à¦•à§Ÿà¦°à¦¾'),(71,44,NULL,3,'Koyla Ghat ','à¦•à§Ÿà¦²à¦¾à¦˜à¦¾à¦Ÿ'),(72,44,NULL,3,'Gollamari ','à¦—à§‹à¦²à§à¦²à¦¾à¦®à¦¾à¦°à¦¿'),(73,44,NULL,3,'Dumuria ','à¦¡à§à¦®à§à¦°à¦¿à¦¯à¦¼à¦¾'),(74,44,NULL,3,'Terokhada ','à¦¤à§‡à¦°à§‹à¦–à¦¾à¦¦à¦¾'),(75,44,NULL,3,'Dacope ','à¦¦à¦¾à¦•à§‹à¦ª'),(76,44,NULL,3,'Dighalia ','à¦¦à§€à¦˜à¦¾à¦²à¦¿à§Ÿà¦¾'),(77,44,NULL,3,'Paikgachha ','à¦ªà¦¾à¦‡à¦•à¦—à¦¾à¦›à¦¾'),(78,44,NULL,3,'Pabla ','à¦ªà¦¾à¦¬à¦²à¦¾'),(79,44,NULL,3,'Phultala ','à¦«à§à¦²à¦¤à¦²à¦¾'),(80,44,NULL,3,'Batighata ','à¦¬à¦¾à¦Ÿà¦¿à¦˜à¦¾à¦Ÿà¦¾'),(81,44,NULL,3,'Boyra Bazar ','à¦¬à§Ÿà¦°à¦¾ à¦¬à¦¾à¦œà¦¾à¦°'),(82,44,NULL,3,'Rayermohol ','à¦°à¦¾à§Ÿà§‡à¦°à¦®à¦¹à¦²'),(83,44,NULL,3,'Rupsa ','à¦°à§à¦ªà¦¸à¦¾'),(84,44,NULL,3,'Lobon Chora ','à¦²à¦¬à¦¨ à¦šà§œà¦¾'),(85,50,NULL,4,'Uttar Alekanda','à¦‰à¦“à¦° à¦†à¦²à§‡à¦•à¦¾à¦¨à§à¦¦à¦¾'),(86,50,NULL,4,'Kalizira','à¦•à¦¾à¦²à¦¿à¦œà¦¿à¦°à¦¾'),(87,50,NULL,4,'Kashipur Bazar','à¦•à¦¾à¦¸à¦¿à¦ªà§à¦° à¦¬à¦¾à¦œà¦¾à¦°'),(88,50,NULL,4,'Chawk Bazar','à¦šà¦• à¦¬à¦¾à¦œà¦¾à¦°'),(89,50,NULL,4,'Chand Mari','à¦šà¦¾à¦¨à§à¦¦à¦®à¦¾à¦°à¦¿'),(90,50,NULL,4,'Natun Bazar','à¦¨à¦¥à§à¦²à§à¦²à¦¾à¦¬à¦¾à¦¦'),(91,50,NULL,4,'Nobogram Road','à¦¨à¦¬à¦—à§à¦°à¦¾à¦® à¦°à§‹à¦¡'),(92,50,NULL,4,'Nazirmoholla','à¦¨à¦¾à¦œà¦¿à¦° à¦®à¦¹à¦²à§à¦²à¦¾'),(93,50,NULL,4,'Puran Bazar','à¦ªà§à¦°à¦¾à¦¨ à¦¬à¦¾à¦œà¦¾à¦°'),(94,50,NULL,4,'Beltola Feri Ghat','à¦¬à§‡à¦²à¦¤à¦²à¦¾ à¦«à§‡à¦°à¦¿ à¦˜à¦¾à¦Ÿ'),(95,50,NULL,4,'Launch Ghat','à¦²à¦žà§à¦šà§à¦˜à¦¾à¦Ÿ'),(96,50,NULL,4,'City Gate Barisal (Gorierpar)','à¦¸à¦¿à¦Ÿà¦¿à¦—à§‡à¦Ÿ (à¦—à¦‡à¦°à¦¾à¦°à¦ªà¦¾à¦°)'),(97,32,NULL,5,'Kazihata','à¦•à¦¾à¦œà§€à¦¹à¦¾à¦Ÿà¦¾'),(98,32,NULL,5,'Kadirgani','à¦•à¦¾à¦¦à¦¿à¦°à¦—à¦žà§à¦œ'),(99,32,NULL,5,'Keshabpur','à¦•à§‡à¦¶à¦¬à¦ªà§à¦°'),(100,32,NULL,5,'Chhota Banagram','à¦›à§‹à¦Ÿ à¦¬à¦¨à¦—à§à¦°à¦¾à¦®'),(101,32,NULL,5,'Nawdapara','à¦¨à¦“à¦¦à¦¾à¦ªà¦¾à§œà¦¾'),(102,32,NULL,5,'Padma Residental Area','à¦ªà¦¦à§à¦®à¦¾ à¦†à¦¬à¦¾à¦¸à¦¿à¦• à¦à¦²à¦¾à¦•à¦¾'),(103,32,NULL,5,'Baharampur','à¦¬à¦¹à¦°à¦®à¦ªà§à¦°'),(104,32,NULL,5,'Boalia','à¦¬à§‹à¦¯à¦¼à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(105,32,NULL,5,'Bosepara','à¦¬à§‹à¦¸à¦ªà¦¾à§œà¦¾'),(106,32,NULL,5,'Rajpara','à¦°à¦¾à¦œà¦ªà¦¾à§œà¦¾'),(107,32,NULL,5,'Rani Nagar','à¦°à¦¾à¦¨à§€à¦¨à¦—à¦°'),(108,32,NULL,5,'Ramchandrapur','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(109,32,NULL,5,'Shiroil','à¦¶à¦¿à¦°à§‹à¦‡à¦²'),(110,32,NULL,5,'Hatemkha','à¦¹à§‡à¦¤à§‡à¦®à¦–à¦¾à¦'),(111,32,NULL,5,'Hossainiganj','à¦¹à§‹à¦¸à¦¨à¦¿à¦—à¦žà§à¦œ'),(112,59,NULL,6,'Alamdangha','à¦†à¦²à¦® à¦¡à¦¾à¦™à§à¦—à¦¾'),(113,59,NULL,6,'College Para','à¦•à¦²à§‡à¦œà¦ªà¦¾à§œà¦¾'),(114,59,NULL,6,'Kachari Bazaar','à¦•à¦¾à¦šà¦¾à¦°à¦¿ à¦¬à¦¾à¦œà¦¾à¦°'),(115,59,NULL,6,'Modern More','à¦œà¦¾à¦¹à¦¾à¦œ à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à¦¿ à¦®à§‹à§œ'),(116,59,NULL,6,'Tajhat','à¦¤à¦¾à¦œà¦¹à¦¾à¦Ÿ'),(117,59,NULL,6,'Paglapir','à¦ªà¦¾à¦—à¦²à¦¾ à¦ªà§€à¦°'),(118,59,NULL,6,'Pourobazar','à¦ªà§Œà¦° à¦¬à¦¾à¦œà¦¾à¦°'),(119,59,NULL,6,'Bodorganj','à¦¬à¦¦à¦°à¦—à¦žà§à¦œ'),(120,59,NULL,6,'Vinno Jogot','à¦­à¦¿à¦¨à§à¦¨ à¦œà¦—à¦¤'),(121,59,NULL,6,'Mahigonj','à¦®à¦¡à¦¾à¦°à§à¦¨ à¦®à§‹à§œ'),(122,59,NULL,6,'Mithapukur','à¦®à¦¿à¦ à¦¾à¦ªà§à¦•à§à¦°'),(123,59,NULL,6,'Shathibari','à¦¶à¦ à¦¿à¦¬à¦¾à§œà§€'),(124,59,NULL,6,'Shatrasta Mor','à¦¸à¦¾à¦¤ à¦°à¦¾à¦¸à§à¦¤à¦¾ à¦®à§‹à§œ'),(125,25,NULL,7,'Anderkilla',NULL),(126,25,NULL,7,'Anwara',NULL),(127,25,NULL,7,'Baizid',NULL),(128,25,NULL,7,'Bakoliya',NULL),(129,25,NULL,7,'Bandar',NULL),(130,25,NULL,7,'Banskhali',NULL),(131,25,NULL,7,'Boalkhali',NULL),(132,25,NULL,7,'CDA Avenue',NULL),(133,25,NULL,7,'Chandanaish',NULL),(134,25,NULL,7,'Cornelhat',NULL),(135,25,NULL,7,' Double Mooring',NULL),(136,25,NULL,7,'Fatikchari',NULL),(137,25,NULL,7,'Hathazari',NULL),(138,25,NULL,7,'Jamalkhan',NULL),(139,25,NULL,7,'Karnafuly',NULL),(140,25,NULL,7,'Khulshi',NULL),(141,25,NULL,7,'Kotwali',NULL),(142,25,NULL,7,'Lalkhan Bazar',NULL),(143,25,NULL,7,'Lohagara',NULL),(144,25,NULL,7,'Mirsharai',NULL),(145,25,NULL,7,'Muradpur',NULL),(146,25,NULL,7,'Pahartali',NULL),(147,25,NULL,7,'Panchlaish',NULL),(148,25,NULL,7,'Patenga',NULL),(149,25,NULL,7,'Patiya',NULL),(150,25,NULL,7,'Rangunia',NULL),(151,25,NULL,7,'Raozan',NULL),(152,25,NULL,7,'Sandwip',NULL),(153,25,NULL,7,'Satkania',NULL),(154,25,NULL,7,'Sholashahar',NULL),(155,25,NULL,7,'Sitakunda',NULL),(156,25,NULL,7,'Cox\'s Bazar','à¦•à¦•à§à¦¸à¦¬à¦¾à¦œà¦¾à¦°'),(157,25,NULL,7,'Khagrachhari','à¦–à¦¾à¦—à¦¡à¦¼à¦¾à¦›à¦¡à¦¼à¦¿'),(158,25,NULL,7,'Bandarban','à¦¬à¦¾à¦¨à§à¦¦à¦°à¦¬à¦¾à¦¨'),(159,25,NULL,7,'Rangamati','à¦°à¦¾à¦™à¦¾à¦®à¦¾à¦Ÿà¦¿'),(160,25,NULL,7,'Lakshmipur','à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦°'),(161,25,NULL,7,'Sitakundo','à¦¸à§€à¦¤à¦¾à¦•à§à¦¨à§à¦¡'),(162,12,NULL,1,'Gulshan','à¦—à§à¦²à¦¶à¦¾à¦¨'),(163,12,NULL,1,'Mirpur','à¦®à¦¿à¦°à¦ªà§à¦°'),(164,12,NULL,1,'Dhanmondi','à¦§à¦¾à¦¨à¦®à¦¨à§à¦¡à¦¿'),(165,12,NULL,1,'Uttara','à¦‰à¦¤à§à¦¤à¦°à¦¾');

/*Table structure for table `loc_cities` */

DROP TABLE IF EXISTS `loc_cities`;

CREATE TABLE `loc_cities` (
  `id_city` smallint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` tinyint unsigned DEFAULT NULL,
  `upazila_id` smallint unsigned DEFAULT NULL,
  `city_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'City name in English',
  `city_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'City name in Bangla',
  PRIMARY KEY (`id_city`),
  KEY `district_id` (`district_id`),
  CONSTRAINT `loc_cities_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `loc_districts` (`id_district`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_cities` */

insert  into `loc_cities`(`id_city`,`district_id`,`upazila_id`,`city_name_en`,`city_name_bn`) values (1,12,NULL,'Dhaka','à¦¢à¦¾à¦•à¦¾'),(2,61,NULL,'Sylhet','à¦¸à¦¿à¦²à§‡à¦Ÿ'),(3,44,NULL,'Khulna','à¦–à§à¦²à¦¨à¦¾'),(4,50,NULL,'Barisal','à¦¬à¦°à¦¿à¦¶à¦¾à¦²'),(5,32,NULL,'Rajshahi','à¦°à¦¾à¦œà¦¶à¦¾à¦¹à§€'),(6,59,NULL,'Rangpur','à¦°à¦‚à¦ªà§à¦°'),(7,25,NULL,'Chittagong','à¦šà¦Ÿà§à¦Ÿà¦—à§à¦°à¦¾à¦®');

/*Table structure for table `loc_districts` */

DROP TABLE IF EXISTS `loc_districts`;

CREATE TABLE `loc_districts` (
  `id_district` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `division_id` tinyint unsigned NOT NULL,
  `district_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'District name in English',
  `district_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'District name in Bangla',
  PRIMARY KEY (`id_district`),
  KEY `division_id` (`division_id`),
  CONSTRAINT `loc_districts_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `loc_divisions` (`id_division`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_districts` */

insert  into `loc_districts`(`id_district`,`division_id`,`district_name_en`,`district_name_bn`) values (1,1,'Narsingdi','à¦¨à¦°à¦¸à¦¿à¦‚à¦¦à§€'),(2,1,'Gazipur','à¦—à¦¾à¦œà§€à¦ªà§à¦°'),(3,1,'Shariatpur','à¦¶à¦°à§€à¦¯à¦¼à¦¤à¦ªà§à¦°'),(4,1,'Narayanganj','à¦¨à¦¾à¦°à¦¾à§Ÿà¦£à¦—à¦žà§à¦œ'),(5,8,'Sherpur','à¦¶à§‡à¦°à¦ªà§à¦°'),(6,1,'Tangail','à¦Ÿà¦¾à¦™à§à¦—à¦¾à¦‡à¦²'),(7,8,'Mymensingh','à¦®à§Ÿà¦®à¦¨à¦¸à¦¿à¦‚à¦¹'),(8,1,'Kishoreganj','à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ'),(9,8,'Jamalpur','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(10,1,'Manikganj','à¦®à¦¾à¦¨à¦¿à¦•à¦—à¦žà§à¦œ'),(11,8,'Netrokona','à¦¨à§‡à¦¤à§à¦°à¦•à§‹à¦£à¦¾'),(12,1,'Dhaka','à¦¢à¦¾à¦•à¦¾'),(13,1,'Munshiganj','à¦®à§à¦¨à§à¦¸à¦¿à¦—à¦žà§à¦œ'),(14,1,'Rajbari','à¦°à¦¾à¦œà¦¬à¦¾à§œà§€'),(15,1,'Madaripur','à¦®à¦¾à¦¦à¦¾à¦°à§€à¦ªà§à¦°'),(16,1,'Gopalganj','à¦—à§‹à¦ªà¦¾à¦²à¦—à¦žà§à¦œ'),(17,1,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(18,2,'Comilla','à¦•à§à¦®à¦¿à¦²à§à¦²à¦¾'),(19,2,'Feni','à¦«à§‡à¦¨à§€'),(20,2,'Brahmanbaria','à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(21,2,'Rangamati','à¦°à¦¾à¦™à§à¦—à¦¾à¦®à¦¾à¦Ÿà¦¿'),(22,2,'Noakhali','à¦¨à§‹à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€'),(23,2,'Chandpur','à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(24,2,'Lakshmipur','à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦°'),(25,2,'Chittagong','à¦šà¦Ÿà§à¦Ÿà¦—à§à¦°à¦¾à¦®'),(26,2,'Coxsbazar','à¦•à¦•à§à¦¸à¦¬à¦¾à¦œà¦¾à¦°'),(27,2,'Khagrachhari','à¦–à¦¾à¦—à§œà¦¾à¦›à§œà¦¿'),(28,2,'Bandarban','à¦¬à¦¾à¦¨à§à¦¦à¦°à¦¬à¦¾à¦¨'),(29,3,'Sirajganj','à¦¸à¦¿à¦°à¦¾à¦œà¦—à¦žà§à¦œ'),(30,3,'Pabna','à¦ªà¦¾à¦¬à¦¨à¦¾'),(31,3,'Bogra','à¦¬à¦—à§à§œà¦¾'),(32,3,'Rajshahi','à¦°à¦¾à¦œà¦¶à¦¾à¦¹à§€'),(33,3,'Natore','à¦¨à¦¾à¦Ÿà§‹à¦°'),(34,3,'Joypurhat','à¦œà§Ÿà¦ªà§à¦°à¦¹à¦¾à¦Ÿ'),(35,3,'Chapainawabganj','à¦šà¦¾à¦à¦ªà¦¾à¦‡à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ'),(36,3,'Naogaon','à¦¨à¦“à¦—à¦¾à¦'),(37,4,'Jessore','à¦¯à¦¶à§‹à¦°'),(38,4,'Satkhira','à¦¸à¦¾à¦¤à¦•à§à¦·à§€à¦°à¦¾'),(39,4,'Meherpur','à¦®à§‡à¦¹à§‡à¦°à¦ªà§à¦°'),(40,4,'Narail','à¦¨à¦¡à¦¼à¦¾à¦‡à¦²'),(41,4,'Chuadanga','à¦šà§à§Ÿà¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(42,4,'Kushtia','à¦•à§à¦·à§à¦Ÿà¦¿à§Ÿà¦¾'),(43,4,'Magura','à¦®à¦¾à¦—à§à¦°à¦¾'),(44,4,'Khulna','à¦–à§à¦²à¦¨à¦¾'),(45,4,'Bagerhat','à¦¬à¦¾à¦—à§‡à¦°à¦¹à¦¾à¦Ÿ'),(46,4,'Jhenaidah','à¦à¦¿à¦¨à¦¾à¦‡à¦¦à¦¹'),(47,5,'Jhalakathi','à¦à¦¾à¦²à¦•à¦¾à¦ à¦¿'),(48,5,'Patuakhali','à¦ªà¦Ÿà§à§Ÿà¦¾à¦–à¦¾à¦²à§€'),(49,5,'Pirojpur','à¦ªà¦¿à¦°à§‹à¦œà¦ªà§à¦°'),(50,5,'Barisal','à¦¬à¦°à¦¿à¦¶à¦¾à¦²'),(51,5,'Bhola','à¦­à§‹à¦²à¦¾'),(52,5,'Barguna','à¦¬à¦°à¦—à§à¦¨à¦¾'),(53,6,'Panchagarh','à¦ªà¦žà§à¦šà¦—à¦¡à¦¼'),(54,6,'Dinajpur','à¦¦à¦¿à¦¨à¦¾à¦œà¦ªà§à¦°'),(55,6,'Lalmonirhat','à¦²à¦¾à¦²à¦®à¦¨à¦¿à¦°à¦¹à¦¾à¦Ÿ'),(56,6,'Nilphamari','à¦¨à§€à¦²à¦«à¦¾à¦®à¦¾à¦°à§€'),(57,6,'Gaibandha','à¦—à¦¾à¦‡à¦¬à¦¾à¦¨à§à¦§à¦¾'),(58,6,'Thakurgaon','à¦ à¦¾à¦•à§à¦°à¦—à¦¾à¦à¦“'),(59,6,'Rangpur','à¦°à¦‚à¦ªà§à¦°'),(60,6,'Kurigram','à¦•à§à§œà¦¿à¦—à§à¦°à¦¾à¦®'),(61,7,'Sylhet','à¦¸à¦¿à¦²à§‡à¦Ÿ'),(62,7,'Moulvibazar','à¦®à§Œà¦²à¦­à§€à¦¬à¦¾à¦œà¦¾à¦°'),(63,7,'Habiganj','à¦¹à¦¬à¦¿à¦—à¦žà§à¦œ'),(64,7,'Sunamganj','à¦¸à§à¦¨à¦¾à¦®à¦—à¦žà§à¦œ');

/*Table structure for table `loc_divisions` */

DROP TABLE IF EXISTS `loc_divisions`;

CREATE TABLE `loc_divisions` (
  `id_division` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `division_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Division Name in English',
  `division_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Division Name in Bangla',
  PRIMARY KEY (`id_division`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_divisions` */

insert  into `loc_divisions`(`id_division`,`division_name_en`,`division_name_bn`) values (1,'Dhaka','à¦¢à¦¾à¦•à¦¾'),(2,'Chittagong','à¦šà¦Ÿà§à¦Ÿà¦—à§à¦°à¦¾à¦®'),(3,'Rajshahi','à¦°à¦¾à¦œà¦¶à¦¾à¦¹à§€'),(4,'Khulna','à¦–à§à¦²à¦¨à¦¾'),(5,'Barisal','à¦¬à¦°à¦¿à¦¶à¦¾à¦²'),(6,'Rangpur','à¦°à¦‚à¦ªà§à¦°'),(7,'Sylhet','à¦¸à¦¿à¦²à§‡à¦Ÿ'),(8,'Mymensingh','à¦®à§Ÿà¦®à¦¨à¦¸à¦¿à¦‚à¦¹');

/*Table structure for table `loc_post_codes` */

DROP TABLE IF EXISTS `loc_post_codes`;

CREATE TABLE `loc_post_codes` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` smallint unsigned DEFAULT NULL,
  `thana_id` smallint unsigned DEFAULT NULL,
  `thana_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `suboffice_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `suboffice_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `postcode_en` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `postcode_bn` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `postcode_en` (`postcode_en`)
) ENGINE=InnoDB AUTO_INCREMENT=1350 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_post_codes` */

insert  into `loc_post_codes`(`id`,`district_id`,`thana_id`,`thana_name`,`suboffice_en`,`suboffice_bn`,`postcode_en`,`postcode_bn`) values (1,12,NULL,'Demra','Demra',NULL,'1360',NULL),(2,12,NULL,'Demra','Matuail',NULL,'1362',NULL),(3,12,NULL,'Demra','Sarulia',NULL,'1361',NULL),(4,12,NULL,'Dhaka Cantt.','Dhaka CantonmentTSO',NULL,'1206',NULL),(5,12,NULL,'Dhamrai','Dhamrai',NULL,'1350',NULL),(6,12,NULL,'Dhamrai','Kamalpur',NULL,'1351',NULL),(7,12,NULL,'Dhanmondi','Jigatala TSO',NULL,'1209',NULL),(8,12,NULL,'Gulshan','Banani TSO',NULL,'1213',NULL),(9,12,NULL,'Gulshan','Gulshan Model Town',NULL,'1212',NULL),(10,12,NULL,'Jatrabari','Dhania TSO',NULL,'1232',NULL),(11,12,NULL,'Joypara','Joypara',NULL,'1330',NULL),(12,12,NULL,'Joypara','Narisha',NULL,'1332',NULL),(13,12,NULL,'Joypara','Palamganj',NULL,'1331',NULL),(14,12,NULL,'Keraniganj','Ati',NULL,'1312',NULL),(15,12,NULL,'Keraniganj','Dhaka Jute Mills',NULL,'1311',NULL),(16,12,NULL,'Keraniganj','Kalatia',NULL,'1313',NULL),(17,12,NULL,'Keraniganj','Keraniganj',NULL,'1310',NULL),(18,12,NULL,'Khilgaon','KhilgaonTSO',NULL,'1219',NULL),(19,12,NULL,'Khilkhet','KhilkhetTSO',NULL,'1229',NULL),(20,12,NULL,'Lalbag','Posta TSO',NULL,'1211',NULL),(21,12,NULL,'Mirpur','Mirpur TSO',NULL,'1216',NULL),(22,12,NULL,'Mohammadpur','Mohammadpur Housing',NULL,'1207',NULL),(23,12,NULL,'Mohammadpur','Sangsad BhabanTSO',NULL,'1225',NULL),(24,12,NULL,'Motijheel','BangabhabanTSO',NULL,'1222',NULL),(25,12,NULL,'Motijheel','DilkushaTSO',NULL,'1223',NULL),(26,12,NULL,'Nawabganj','Agla',NULL,'1323',NULL),(27,12,NULL,'Nawabganj','Churain',NULL,'1325',NULL),(28,12,NULL,'Nawabganj','Daudpur',NULL,'1322',NULL),(29,12,NULL,'Nawabganj','Hasnabad',NULL,'1321',NULL),(30,12,NULL,'Nawabganj','Khalpar',NULL,'1324',NULL),(31,12,NULL,'Nawabganj','Nawabganj',NULL,'1320',NULL),(32,12,NULL,'New market','New Market TSO',NULL,'1205',NULL),(33,12,NULL,'Palton','Dhaka GPO',NULL,'1000',NULL),(34,12,NULL,'Ramna','Shantinagr TSO',NULL,'1217',NULL),(35,12,NULL,'Sabujbag','Basabo TSO',NULL,'1214',NULL),(36,12,NULL,'Savar','Amin Bazar',NULL,'1348',NULL),(37,12,NULL,'Savar','Dairy Farm',NULL,'1341',NULL),(38,12,NULL,'Savar','EPZ',NULL,'1349',NULL),(39,12,NULL,'Savar','Jahangirnagar Univer',NULL,'1342',NULL),(40,12,NULL,'Savar','Kashem Cotton Mills',NULL,'1346',NULL),(41,12,NULL,'Savar','Rajphulbaria',NULL,'1347',NULL),(42,12,NULL,'Savar','Savar',NULL,'1340',NULL),(43,12,NULL,'Savar','Savar Canttonment',NULL,'1344',NULL),(44,12,NULL,'Savar','Saver P.A.T.C',NULL,'1343',NULL),(45,12,NULL,'Savar','Shimulia',NULL,'1345',NULL),(46,12,NULL,'Sutrapur','Dhaka Sadar HO',NULL,'1100',NULL),(47,12,NULL,'Sutrapur','Gendaria TSO',NULL,'1204',NULL),(48,12,NULL,'Sutrapur','Wari TSO',NULL,'1203',NULL),(49,12,NULL,'Tejgaon','Tejgaon TSO',NULL,'1215',NULL),(50,12,NULL,'Tejgaon Industrial Area','Dhaka Politechnic',NULL,'1208',NULL),(51,12,NULL,'Uttara','Uttara Model TwonTSO',NULL,'1230',NULL),(52,17,NULL,'Alfadanga','Alfadanga',NULL,'7870',NULL),(53,17,NULL,'Bhanga','Bhanga',NULL,'7830',NULL),(54,17,NULL,'Boalmari','Boalmari',NULL,'7860',NULL),(55,17,NULL,'Boalmari','Rupatpat',NULL,'7861',NULL),(56,17,NULL,'Charbhadrasan','Charbadrashan',NULL,'7810',NULL),(57,17,NULL,'Faridpur Sadar','Ambikapur',NULL,'7802',NULL),(58,17,NULL,'Faridpur Sadar','Baitulaman Politecni',NULL,'7803',NULL),(59,17,NULL,'Faridpur Sadar','Faridpursadar',NULL,'7800',NULL),(60,17,NULL,'Faridpur Sadar','Kanaipur',NULL,'7801',NULL),(61,17,NULL,'Madukhali','Kamarkali',NULL,'7851',NULL),(62,17,NULL,'Madukhali','Madukhali',NULL,'7850',NULL),(63,17,NULL,'Nagarkanda','Nagarkanda',NULL,'7840',NULL),(64,17,NULL,'Nagarkanda','Talma',NULL,'7841',NULL),(65,17,NULL,'Sadarpur','Bishwa jaker Manjil',NULL,'7822',NULL),(66,17,NULL,'Sadarpur','Hat Krishapur',NULL,'7821',NULL),(67,17,NULL,'Sadarpur','Sadarpur',NULL,'7820',NULL),(68,17,NULL,'Shriangan','Shriangan',NULL,'7804',NULL),(69,2,NULL,'Gazipur Sadar','B.O.F',NULL,'1703',NULL),(70,2,NULL,'Gazipur Sadar','B.R.R',NULL,'1701',NULL),(71,2,NULL,'Gazipur Sadar','Chandna',NULL,'1702',NULL),(72,2,NULL,'Gazipur Sadar','Gazipur Sadar',NULL,'1700',NULL),(73,2,NULL,'Gazipur Sadar','National University',NULL,'1704',NULL),(74,2,NULL,'Kaliakaar','Kaliakaar',NULL,'1750',NULL),(75,2,NULL,'Kaliakaar','Safipur',NULL,'1751',NULL),(76,2,NULL,'Kaliganj','Kaliganj',NULL,'1720',NULL),(77,2,NULL,'Kaliganj','Pubail',NULL,'1721',NULL),(78,2,NULL,'Kaliganj','Santanpara',NULL,'1722',NULL),(79,2,NULL,'Kaliganj','Vaoal Jamalpur',NULL,'1723',NULL),(80,2,NULL,'Kapashia','kapashia',NULL,'1730',NULL),(81,2,NULL,'Monnunagar','Ershad Nagar',NULL,'1712',NULL),(82,2,NULL,'Monnunagar','Monnunagar',NULL,'1710',NULL),(83,2,NULL,'Monnunagar','Nishat Nagar',NULL,'1711',NULL),(84,2,NULL,'Sreepur','Barmi',NULL,'1743',NULL),(85,2,NULL,'Sreepur','Bashamur',NULL,'1747',NULL),(86,2,NULL,'Sreepur','Boubi',NULL,'1748',NULL),(87,2,NULL,'Sreepur','Kawraid',NULL,'1745',NULL),(88,2,NULL,'Sreepur','Satkhamair',NULL,'1744',NULL),(89,2,NULL,'Sreepur','Sreepur',NULL,'1740',NULL),(90,2,NULL,'Sripur','Rajendrapur',NULL,'1741',NULL),(91,2,NULL,'Sripur','Rajendrapur Canttome',NULL,'1742',NULL),(92,16,NULL,'Gopalganj Sadar','Barfa',NULL,'8102',NULL),(93,16,NULL,'Gopalganj Sadar','Chandradighalia',NULL,'8013',NULL),(94,16,NULL,'Gopalganj Sadar','Gopalganj Sadar',NULL,'8100',NULL),(95,16,NULL,'Gopalganj Sadar','Ulpur',NULL,'8101',NULL),(96,16,NULL,'Kashiani','Jonapur',NULL,'8133',NULL),(97,16,NULL,'Kashiani','Kashiani',NULL,'8130',NULL),(98,16,NULL,'Kashiani','Ramdia College',NULL,'8131',NULL),(99,16,NULL,'Kashiani','Ratoil',NULL,'8132',NULL),(100,16,NULL,'Kotalipara','Kotalipara',NULL,'8110',NULL),(101,16,NULL,'Maksudpur','Batkiamari',NULL,'8141',NULL),(102,16,NULL,'Maksudpur','Khandarpara',NULL,'8142',NULL),(103,16,NULL,'Maksudpur','Maksudpur',NULL,'8140',NULL),(104,16,NULL,'Tungipara','Patgati',NULL,'8121',NULL),(105,16,NULL,'Tungipara','Tungipara',NULL,'8120',NULL),(106,9,NULL,'Dewangonj','Dewangonj',NULL,'2030',NULL),(107,9,NULL,'Dewangonj','Dewangonj S. Mills',NULL,'2031',NULL),(108,9,NULL,'Islampur','Durmoot',NULL,'2021',NULL),(109,9,NULL,'Islampur','Gilabari',NULL,'2022',NULL),(110,9,NULL,'Islampur','Islampur',NULL,'2020',NULL),(111,9,NULL,'Jamalpur','Jamalpur',NULL,'2000',NULL),(112,9,NULL,'Jamalpur','Nandina',NULL,'2001',NULL),(113,9,NULL,'Jamalpur','Narundi',NULL,'2002',NULL),(114,9,NULL,'Malandah','Jamalpur',NULL,'2011',NULL),(115,9,NULL,'Malandah','Mahmoodpur',NULL,'2013',NULL),(116,9,NULL,'Malandah','Malancha',NULL,'2012',NULL),(117,9,NULL,'Malandah','Malandah',NULL,'2010',NULL),(118,9,NULL,'Mathargonj','Balijhuri',NULL,'2041',NULL),(119,9,NULL,'Mathargonj','Mathargonj',NULL,'2040',NULL),(120,9,NULL,'Shorishabari','Bausee',NULL,'2052',NULL),(121,9,NULL,'Shorishabari','Gunerbari',NULL,'2051',NULL),(122,9,NULL,'Shorishabari','Jagannath Ghat',NULL,'2053',NULL),(123,9,NULL,'Shorishabari','Jamuna Sar Karkhana',NULL,'2055',NULL),(124,9,NULL,'Shorishabari','Pingna',NULL,'2054',NULL),(125,9,NULL,'Shorishabari','Shorishabari',NULL,'2050',NULL),(126,8,NULL,'Bajitpur','Bajitpur',NULL,'2336',NULL),(127,8,NULL,'Bajitpur','Laksmipur',NULL,'2338',NULL),(128,8,NULL,'Bajitpur','Sararchar',NULL,'2337',NULL),(129,8,NULL,'Bhairob','Bhairab',NULL,'2350',NULL),(130,8,NULL,'Hossenpur','Hossenpur',NULL,'2320',NULL),(131,8,NULL,'Itna','Itna',NULL,'2390',NULL),(132,8,NULL,'Karimganj','Karimganj',NULL,'2310',NULL),(133,8,NULL,'Katiadi','Gochhihata',NULL,'2331',NULL),(134,8,NULL,'Katiadi','Katiadi',NULL,'2330',NULL),(135,8,NULL,'Kishoreganj Sadar','Kishoreganj S.Mills',NULL,'2301',NULL),(136,8,NULL,'Kishoreganj Sadar','Kishoreganj Sadar',NULL,'2300',NULL),(137,8,NULL,'Kishoreganj Sadar','Maizhati',NULL,'2302',NULL),(138,8,NULL,'Kishoreganj Sadar','Nilganj',NULL,'2303',NULL),(139,8,NULL,'Kuliarchar','Chhoysuti',NULL,'2341',NULL),(140,8,NULL,'Kuliarchar','Kuliarchar',NULL,'2340',NULL),(141,8,NULL,'Mithamoin','Abdullahpur',NULL,'2371',NULL),(142,8,NULL,'Mithamoin','MIthamoin',NULL,'2370',NULL),(143,8,NULL,'Nikli','Nikli',NULL,'2360',NULL),(144,8,NULL,'Ostagram','Ostagram',NULL,'2380',NULL),(145,8,NULL,'Pakundia','Pakundia',NULL,'2326',NULL),(146,8,NULL,'Tarial','Tarial',NULL,'2316',NULL),(147,15,NULL,'Barhamganj','Bahadurpur',NULL,'7932',NULL),(148,15,NULL,'Barhamganj','Barhamganj',NULL,'7930',NULL),(149,15,NULL,'Barhamganj','Nilaksmibandar',NULL,'7931',NULL),(150,15,NULL,'Barhamganj','Umedpur',NULL,'7933',NULL),(151,15,NULL,'kalkini','Kalkini',NULL,'7920',NULL),(152,15,NULL,'kalkini','Sahabrampur',NULL,'7921',NULL),(153,15,NULL,'Madaripur Sadar','Charmugria',NULL,'7901',NULL),(154,15,NULL,'Madaripur Sadar','Habiganj',NULL,'7903',NULL),(155,15,NULL,'Madaripur Sadar','Kulpaddi',NULL,'7902',NULL),(156,15,NULL,'Madaripur Sadar','Madaripur Sadar',NULL,'7900',NULL),(157,15,NULL,'Madaripur Sadar','Mustafapur',NULL,'7904',NULL),(158,15,NULL,'Rajoir','Khalia',NULL,'7911',NULL),(159,15,NULL,'Rajoir','Rajoir',NULL,'7910',NULL),(160,10,NULL,'Doulatpur','Doulatpur',NULL,'1860',NULL),(161,10,NULL,'Gheor','Gheor',NULL,'1840',NULL),(162,10,NULL,'Lechhraganj','Jhitka',NULL,'1831',NULL),(163,10,NULL,'Lechhraganj','Lechhraganj',NULL,'1830',NULL),(164,10,NULL,'Manikganj Sadar','Barangail',NULL,'1804',NULL),(165,10,NULL,'Manikganj Sadar','Gorpara',NULL,'1802',NULL),(166,10,NULL,'Manikganj Sadar','Mahadebpur',NULL,'1803',NULL),(167,10,NULL,'Manikganj Sadar','Manikganj Bazar',NULL,'1801',NULL),(168,10,NULL,'Manikganj Sadar','Manikganj Sadar',NULL,'1800',NULL),(169,10,NULL,'Saturia','Baliati',NULL,'1811',NULL),(170,10,NULL,'Saturia','Saturia',NULL,'1810',NULL),(171,10,NULL,'Shibloya','Aricha',NULL,'1851',NULL),(172,10,NULL,'Shibloya','Shibaloy',NULL,'1850',NULL),(173,10,NULL,'Shibloya','Tewta',NULL,'1852',NULL),(174,10,NULL,'Shibloya','Uthli',NULL,'1853',NULL),(175,10,NULL,'Singari','Baira',NULL,'1821',NULL),(176,10,NULL,'Singari','joymantop',NULL,'1822',NULL),(177,10,NULL,'Singari','Singair',NULL,'1820',NULL),(178,13,NULL,'Gajaria','Gajaria',NULL,'1510',NULL),(179,13,NULL,'Gajaria','Hossendi',NULL,'1511',NULL),(180,13,NULL,'Gajaria','Rasulpur',NULL,'1512',NULL),(181,13,NULL,'Lohajong','Gouragonj',NULL,'1334',NULL),(182,13,NULL,'Lohajong','Gouragonj',NULL,'1534',NULL),(183,13,NULL,'Lohajong','Haldia SO',NULL,'1532',NULL),(184,13,NULL,'Lohajong','Haridia',NULL,'1333',NULL),(185,13,NULL,'Lohajong','Haridia DESO',NULL,'1533',NULL),(186,13,NULL,'Lohajong','Korhati',NULL,'1531',NULL),(187,13,NULL,'Lohajong','Lohajang',NULL,'1530',NULL),(188,13,NULL,'Lohajong','Madini Mandal',NULL,'1335',NULL),(189,13,NULL,'Lohajong','Medini Mandal EDSO',NULL,'1535',NULL),(190,13,NULL,'Munshiganj Sadar','Kathakhali',NULL,'1503',NULL),(191,13,NULL,'Munshiganj Sadar','Mirkadim',NULL,'1502',NULL),(192,13,NULL,'Munshiganj Sadar','Munshiganj Sadar',NULL,'1500',NULL),(193,13,NULL,'Munshiganj Sadar','Rikabibazar',NULL,'1501',NULL),(194,13,NULL,'Sirajdikhan','Ichapur',NULL,'1542',NULL),(195,13,NULL,'Sirajdikhan','Kola',NULL,'1541',NULL),(196,13,NULL,'Sirajdikhan','Malkha Nagar',NULL,'1543',NULL),(197,13,NULL,'Sirajdikhan','Shekher Nagar',NULL,'1544',NULL),(198,13,NULL,'Sirajdikhan','Sirajdikhan',NULL,'1540',NULL),(199,13,NULL,'Srinagar','Baghra',NULL,'1557',NULL),(200,13,NULL,'Srinagar','Barikhal',NULL,'1551',NULL),(201,13,NULL,'Srinagar','Bhaggyakul',NULL,'1558',NULL),(202,13,NULL,'Srinagar','Hashara',NULL,'1553',NULL),(203,13,NULL,'Srinagar','Kolapara',NULL,'1554',NULL),(204,13,NULL,'Srinagar','Kumarbhog',NULL,'1555',NULL),(205,13,NULL,'Srinagar','Mazpara',NULL,'1552',NULL),(206,13,NULL,'Srinagar','Srinagar',NULL,'1550',NULL),(207,13,NULL,'Srinagar','Vaggyakul SO',NULL,'1556',NULL),(208,13,NULL,'Tangibari','Bajrajugini',NULL,'1523',NULL),(209,13,NULL,'Tangibari','Baligao',NULL,'1522',NULL),(210,13,NULL,'Tangibari','Betkahat',NULL,'1521',NULL),(211,13,NULL,'Tangibari','Dighirpar',NULL,'1525',NULL),(212,13,NULL,'Tangibari','Hasail',NULL,'1524',NULL),(213,13,NULL,'Tangibari','Pura',NULL,'1527',NULL),(214,13,NULL,'Tangibari','Pura EDSO',NULL,'1526',NULL),(215,13,NULL,'Tangibari','Tangibari',NULL,'1520',NULL),(216,7,NULL,'Bhaluka','Bhaluka',NULL,'2240',NULL),(217,7,NULL,'Fulbaria','Fulbaria',NULL,'2216',NULL),(218,7,NULL,'Gaforgaon','Duttarbazar',NULL,'2234',NULL),(219,7,NULL,'Gaforgaon','Gaforgaon',NULL,'2230',NULL),(220,7,NULL,'Gaforgaon','Kandipara',NULL,'2233',NULL),(221,7,NULL,'Gaforgaon','Shibganj',NULL,'2231',NULL),(222,7,NULL,'Gaforgaon','Usti',NULL,'2232',NULL),(223,7,NULL,'Gouripur','Gouripur',NULL,'2270',NULL),(224,7,NULL,'Gouripur','Ramgopalpur',NULL,'2271',NULL),(225,7,NULL,'Haluaghat','Dhara',NULL,'2261',NULL),(226,7,NULL,'Haluaghat','Haluaghat',NULL,'2260',NULL),(227,7,NULL,'Haluaghat','Munshirhat',NULL,'2262',NULL),(228,7,NULL,'Isshwargonj','Atharabari',NULL,'2282',NULL),(229,7,NULL,'Isshwargonj','Isshwargonj',NULL,'2280',NULL),(230,7,NULL,'Isshwargonj','Sohagi',NULL,'2281',NULL),(231,7,NULL,'Muktagachha','Muktagachha',NULL,'2210',NULL),(232,7,NULL,'Mymensingh Sadar','Agriculture Universi',NULL,'2202',NULL),(233,7,NULL,'Mymensingh Sadar','Biddyaganj',NULL,'2204',NULL),(234,7,NULL,'Mymensingh Sadar','Kawatkhali',NULL,'2201',NULL),(235,7,NULL,'Mymensingh Sadar','Mymensingh Sadar',NULL,'2200',NULL),(236,7,NULL,'Mymensingh Sadar','Pearpur',NULL,'2205',NULL),(237,7,NULL,'Mymensingh Sadar','Shombhuganj',NULL,'2203',NULL),(238,7,NULL,'Nandail','Gangail',NULL,'2291',NULL),(239,7,NULL,'Nandail','Nandail',NULL,'2290',NULL),(240,7,NULL,'Phulpur','Beltia',NULL,'2251',NULL),(241,7,NULL,'Phulpur','Phulpur',NULL,'2250',NULL),(242,7,NULL,'Phulpur','Tarakanda',NULL,'2252',NULL),(243,7,NULL,'Trishal','Ahmadbad',NULL,'2221',NULL),(244,7,NULL,'Trishal','Dhala',NULL,'2223',NULL),(245,7,NULL,'Trishal','Ram Amritaganj',NULL,'2222',NULL),(246,7,NULL,'Trishal','Trishal',NULL,'2220',NULL),(247,4,NULL,'Araihazar','Araihazar',NULL,'1450',NULL),(248,4,NULL,'Araihazar','Gopaldi',NULL,'1451',NULL),(249,4,NULL,'Baidder Bazar','Baidder Bazar',NULL,'1440',NULL),(250,4,NULL,'Baidder Bazar','Bara Nagar',NULL,'1441',NULL),(251,4,NULL,'Baidder Bazar','Barodi',NULL,'1442',NULL),(252,4,NULL,'Bandar','Bandar',NULL,'1410',NULL),(253,4,NULL,'Bandar','BIDS',NULL,'1413',NULL),(254,4,NULL,'Bandar','D.C Mills',NULL,'1411',NULL),(255,4,NULL,'Bandar','Madanganj',NULL,'1414',NULL),(256,4,NULL,'Bandar','Nabiganj',NULL,'1412',NULL),(257,4,NULL,'Fatullah','Fatulla Bazar',NULL,'1421',NULL),(258,4,NULL,'Fatullah','Fatullah',NULL,'1420',NULL),(259,4,NULL,'Narayanganj Sadar','Narayanganj Sadar',NULL,'1400',NULL),(260,4,NULL,'Rupganj','Bhulta',NULL,'1462',NULL),(261,4,NULL,'Rupganj','Kanchan',NULL,'1461',NULL),(262,4,NULL,'Rupganj','Murapara',NULL,'1464',NULL),(263,4,NULL,'Rupganj','Nagri',NULL,'1463',NULL),(264,4,NULL,'Rupganj','Rupganj',NULL,'1460',NULL),(265,4,NULL,'Siddirganj','Adamjeenagar',NULL,'1431',NULL),(266,4,NULL,'Siddirganj','LN Mills',NULL,'1432',NULL),(267,4,NULL,'Siddirganj','Siddirganj',NULL,'1430',NULL),(268,1,NULL,'Belabo','Belabo',NULL,'1640',NULL),(269,1,NULL,'Monohordi','Hatirdia',NULL,'1651',NULL),(270,1,NULL,'Monohordi','Katabaria',NULL,'1652',NULL),(271,1,NULL,'Monohordi','Monohordi',NULL,'1650',NULL),(272,1,NULL,'Narsingdi Sadar','Karimpur',NULL,'1605',NULL),(273,1,NULL,'Narsingdi Sadar','Madhabdi',NULL,'1604',NULL),(274,1,NULL,'Narsingdi Sadar','Narsingdi College',NULL,'1602',NULL),(275,1,NULL,'Narsingdi Sadar','Narsingdi Sadar',NULL,'1600',NULL),(276,1,NULL,'Narsingdi Sadar','Panchdona',NULL,'1603',NULL),(277,1,NULL,'Narsingdi Sadar','UMC Jute Mills',NULL,'1601',NULL),(278,1,NULL,'Palash','Char Sindhur',NULL,'1612',NULL),(279,1,NULL,'Palash','Ghorashal',NULL,'1613',NULL),(280,1,NULL,'Palash','Ghorashal Urea Facto',NULL,'1611',NULL),(281,1,NULL,'Palash','Palash',NULL,'1610',NULL),(282,1,NULL,'Raypura','Bazar Hasnabad',NULL,'1631',NULL),(283,1,NULL,'Raypura','Radhaganj bazar',NULL,'1632',NULL),(284,1,NULL,'Raypura','Raypura',NULL,'1630',NULL),(285,1,NULL,'Shibpur','Shibpur',NULL,'1620',NULL),(286,11,NULL,'Susung Durgapur','Susnng Durgapur',NULL,'2420',NULL),(287,11,NULL,'Atpara','Atpara',NULL,'2470',NULL),(288,11,NULL,'Barhatta','Barhatta',NULL,'2440',NULL),(289,11,NULL,'Dharmapasha','Dharampasha',NULL,'2450',NULL),(290,11,NULL,'Dhobaura','Dhobaura',NULL,'2416',NULL),(291,11,NULL,'Dhobaura','Sakoai',NULL,'2417',NULL),(292,11,NULL,'Kalmakanda','Kalmakanda',NULL,'2430',NULL),(293,11,NULL,'Kendua','Kendua',NULL,'2480',NULL),(294,11,NULL,'Khaliajuri','Khaliajhri',NULL,'2460',NULL),(295,11,NULL,'Khaliajuri','Shaldigha',NULL,'2462',NULL),(296,11,NULL,'Madan','Madan',NULL,'2490',NULL),(297,11,NULL,'Moddhynagar','Moddoynagar',NULL,'2456',NULL),(298,11,NULL,'Mohanganj','Mohanganj',NULL,'2446',NULL),(299,11,NULL,'Netrokona Sadar','Baikherhati',NULL,'2401',NULL),(300,11,NULL,'Netrokona Sadar','Netrokona Sadar',NULL,'2400',NULL),(301,11,NULL,'Purbadhola','Jaria Jhanjhail',NULL,'2412',NULL),(302,11,NULL,'Purbadhola','Purbadhola',NULL,'2410',NULL),(303,11,NULL,'Purbadhola','Shamgonj',NULL,'2411',NULL),(304,14,NULL,'Baliakandi','Baliakandi',NULL,'7730',NULL),(305,14,NULL,'Baliakandi','Nalia',NULL,'7731',NULL),(306,14,NULL,'Pangsha','Mrigibazar',NULL,'7723',NULL),(307,14,NULL,'Pangsha','Pangsha',NULL,'7720',NULL),(308,14,NULL,'Pangsha','Ramkol',NULL,'7721',NULL),(309,14,NULL,'Pangsha','Ratandia',NULL,'7722',NULL),(310,14,NULL,'Rajbari Sadar','Goalanda',NULL,'7710',NULL),(311,14,NULL,'Rajbari Sadar','Khankhanapur',NULL,'7711',NULL),(312,14,NULL,'Rajbari Sadar','Rajbari Sadar',NULL,'7700',NULL),(313,3,NULL,'Bhedorganj','Bhedorganj',NULL,'8030',NULL),(314,3,NULL,'Damudhya','Damudhya',NULL,'8040',NULL),(315,3,NULL,'Gosairhat','Gosairhat',NULL,'8050',NULL),(316,3,NULL,'Jajira','Jajira',NULL,'8010',NULL),(317,3,NULL,'Naria','Bhozeshwar',NULL,'8021',NULL),(318,3,NULL,'Naria','Gharisar',NULL,'8022',NULL),(319,3,NULL,'Naria','Kartikpur',NULL,'8024',NULL),(320,3,NULL,'Naria','Naria',NULL,'8020',NULL),(321,3,NULL,'Naria','Upshi',NULL,'8023',NULL),(322,3,NULL,'Shariatpur Sadar','Angaria',NULL,'8001',NULL),(323,3,NULL,'Shariatpur Sadar','Chikandi',NULL,'8002',NULL),(324,3,NULL,'Shariatpur Sadar','Shariatpur Sadar',NULL,'8000',NULL),(325,5,NULL,'Bakshigonj','Bakshigonj',NULL,'2140',NULL),(326,5,NULL,'Jhinaigati','Jhinaigati',NULL,'2120',NULL),(327,5,NULL,'Nakla','Gonopaddi',NULL,'2151',NULL),(328,5,NULL,'Nakla','Nakla',NULL,'2150',NULL),(329,5,NULL,'Nalitabari','Hatibandha',NULL,'2111',NULL),(330,5,NULL,'Nalitabari','Nalitabari',NULL,'2110',NULL),(331,5,NULL,'Sherpur Shadar','Sherpur Shadar',NULL,'2100',NULL),(332,5,NULL,'Shribardi','Shribardi',NULL,'2130',NULL),(333,6,NULL,'Basail','Basail',NULL,'1920',NULL),(334,6,NULL,'Bhuapur','Bhuapur',NULL,'1960',NULL),(335,6,NULL,'Delduar','Delduar',NULL,'1910',NULL),(336,6,NULL,'Delduar','Elasin',NULL,'1913',NULL),(337,6,NULL,'Delduar','Hinga Nagar',NULL,'1914',NULL),(338,6,NULL,'Delduar','Jangalia',NULL,'1911',NULL),(339,6,NULL,'Delduar','Lowhati',NULL,'1915',NULL),(340,6,NULL,'Delduar','Patharail',NULL,'1912',NULL),(341,6,NULL,'Ghatail','D. Pakutia',NULL,'1982',NULL),(342,6,NULL,'Ghatail','Dhalapara',NULL,'1983',NULL),(343,6,NULL,'Ghatail','Ghatial',NULL,'1980',NULL),(344,6,NULL,'Ghatail','Lohani',NULL,'1984',NULL),(345,6,NULL,'Ghatail','Zahidganj',NULL,'1981',NULL),(346,6,NULL,'Gopalpur','Gopalpur',NULL,'1990',NULL),(347,6,NULL,'Gopalpur','Hemnagar',NULL,'1992',NULL),(348,6,NULL,'Gopalpur','Jhowail',NULL,'1991',NULL),(349,6,NULL,'Kalihati','Ballabazar',NULL,'1973',NULL),(350,6,NULL,'Kalihati','Elinga',NULL,'1974',NULL),(351,6,NULL,'Kalihati','Kalihati',NULL,'1970',NULL),(352,6,NULL,'Kalihati','Nagarbari',NULL,'1977',NULL),(353,6,NULL,'Kalihati','Nagarbari SO',NULL,'1976',NULL),(354,6,NULL,'Kalihati','Nagbari',NULL,'1972',NULL),(355,6,NULL,'Kalihati','Palisha',NULL,'1975',NULL),(356,6,NULL,'Kalihati','Rajafair',NULL,'1971',NULL),(357,6,NULL,'Kashkaolia','Kashkawlia',NULL,'1930',NULL),(358,6,NULL,'Madhupur','Dhobari',NULL,'1997',NULL),(359,6,NULL,'Madhupur','Madhupur',NULL,'1996',NULL),(360,6,NULL,'Mirzapur','Gorai',NULL,'1941',NULL),(361,6,NULL,'Mirzapur','Jarmuki',NULL,'1944',NULL),(362,6,NULL,'Mirzapur','M.C. College',NULL,'1942',NULL),(363,6,NULL,'Mirzapur','Mirzapur',NULL,'1940',NULL),(364,6,NULL,'Mirzapur','Mohera',NULL,'1945',NULL),(365,6,NULL,'Mirzapur','Warri paikpara',NULL,'1943',NULL),(366,6,NULL,'Nagarpur','Dhuburia',NULL,'1937',NULL),(367,6,NULL,'Nagarpur','Nagarpur',NULL,'1936',NULL),(368,6,NULL,'Nagarpur','Salimabad',NULL,'1938',NULL),(369,6,NULL,'Sakhipur','Kochua',NULL,'1951',NULL),(370,6,NULL,'Sakhipur','Sakhipur',NULL,'1950',NULL),(371,6,NULL,'Tangail Sadar','Kagmari',NULL,'1901',NULL),(372,6,NULL,'Tangail Sadar','Korotia',NULL,'1903',NULL),(373,6,NULL,'Tangail Sadar','Purabari',NULL,'1904',NULL),(374,6,NULL,'Tangail Sadar','Santosh',NULL,'1902',NULL),(375,6,NULL,'Tangail Sadar','Tangail Sadar',NULL,'1900',NULL),(376,28,NULL,'Alikadam','Alikadam',NULL,'4650',NULL),(377,28,NULL,'Bandarban Sadar','Bandarban Sadar',NULL,'4600',NULL),(378,28,NULL,'Naikhong','Naikhong',NULL,'4660',NULL),(379,28,NULL,'Roanchhari','Roanchhari',NULL,'4610',NULL),(380,28,NULL,'Ruma','Ruma',NULL,'4620',NULL),(381,28,NULL,'Thanchi','Lama',NULL,'4641',NULL),(382,28,NULL,'Thanchi','Thanchi',NULL,'4630',NULL),(383,20,NULL,'Akhaura','Akhaura',NULL,'3450',NULL),(384,20,NULL,'Akhaura','Azampur',NULL,'3451',NULL),(385,20,NULL,'Akhaura','Gangasagar',NULL,'3452',NULL),(386,20,NULL,'Banchharampur','Banchharampur',NULL,'3420',NULL),(387,20,NULL,'Brahamanbaria Sadar','Ashuganj',NULL,'3402',NULL),(388,20,NULL,'Brahamanbaria Sadar','Ashuganj Share',NULL,'3403',NULL),(389,20,NULL,'Brahamanbaria Sadar','Brahamanbaria Sadar',NULL,'3400',NULL),(390,20,NULL,'Brahamanbaria Sadar','Poun',NULL,'3404',NULL),(391,20,NULL,'Brahamanbaria Sadar','Talshahar',NULL,'3401',NULL),(392,20,NULL,'Kasba','Chandidar',NULL,'3462',NULL),(393,20,NULL,'Kasba','Chargachh',NULL,'3463',NULL),(394,20,NULL,'Kasba','Gopinathpur',NULL,'3464',NULL),(395,20,NULL,'Kasba','Kasba',NULL,'3460',NULL),(396,20,NULL,'Kasba','Kuti',NULL,'3461',NULL),(397,20,NULL,'Nabinagar','Jibanganj',NULL,'3419',NULL),(398,20,NULL,'Nabinagar','Kaitala',NULL,'3417',NULL),(399,20,NULL,'Nabinagar','Laubfatehpur',NULL,'3411',NULL),(400,20,NULL,'Nabinagar','Nabinagar',NULL,'3410',NULL),(401,20,NULL,'Nabinagar','Rasullabad',NULL,'3412',NULL),(402,20,NULL,'Nabinagar','Ratanpur',NULL,'3414',NULL),(403,20,NULL,'Nabinagar','Salimganj',NULL,'3418',NULL),(404,20,NULL,'Nabinagar','Shahapur',NULL,'3415',NULL),(405,20,NULL,'Nabinagar','Shamgram',NULL,'3413',NULL),(406,20,NULL,'Nasirnagar','Fandauk',NULL,'3441',NULL),(407,20,NULL,'Nasirnagar','Nasirnagar',NULL,'3440',NULL),(408,20,NULL,'Sarail','Chandura',NULL,'3432',NULL),(409,20,NULL,'Sarail','Sarial',NULL,'3430',NULL),(410,20,NULL,'Sarail','Shahbajpur',NULL,'3431',NULL),(411,23,NULL,'Chandpur Sadar','Baburhat',NULL,'3602',NULL),(412,23,NULL,'Chandpur Sadar','Chandpur Sadar',NULL,'3600',NULL),(413,23,NULL,'Chandpur Sadar','Puranbazar',NULL,'3601',NULL),(414,23,NULL,'Chandpur Sadar','Sahatali',NULL,'3603',NULL),(415,23,NULL,'Faridganj','Chandra',NULL,'3651',NULL),(416,23,NULL,'Faridganj','Faridganj',NULL,'3650',NULL),(417,23,NULL,'Faridganj','Gridkaliandia',NULL,'3653',NULL),(418,23,NULL,'Faridganj','Islampur Shah Isain',NULL,'3655',NULL),(419,23,NULL,'Faridganj','Rampurbazar',NULL,'3654',NULL),(420,23,NULL,'Faridganj','Rupsha',NULL,'3652',NULL),(421,23,NULL,'Hajiganj','Bolakhal',NULL,'3611',NULL),(422,23,NULL,'Hajiganj','Hajiganj',NULL,'3610',NULL),(423,23,NULL,'Hayemchar','Gandamara',NULL,'3661',NULL),(424,23,NULL,'Hayemchar','Hayemchar',NULL,'3660',NULL),(425,23,NULL,'Kachua','Kachua',NULL,'3630',NULL),(426,23,NULL,'Kachua','Pak Shrirampur',NULL,'3631',NULL),(427,23,NULL,'Kachua','Rahima Nagar',NULL,'3632',NULL),(428,23,NULL,'Kachua','Shachar',NULL,'3633',NULL),(429,23,NULL,'Matlobganj','Kalipur',NULL,'3642',NULL),(430,23,NULL,'Matlobganj','Matlobganj',NULL,'3640',NULL),(431,23,NULL,'Matlobganj','Mohanpur',NULL,'3641',NULL),(432,23,NULL,'Shahrasti','Chotoshi',NULL,'3623',NULL),(433,23,NULL,'Shahrasti','Islamia Madrasha',NULL,'3624',NULL),(434,23,NULL,'Shahrasti','Khilabazar',NULL,'3621',NULL),(435,23,NULL,'Shahrasti','Pashchim Kherihar Al',NULL,'3622',NULL),(436,23,NULL,'Shahrasti','Shahrasti',NULL,'3620',NULL),(437,25,NULL,'Anawara','Anowara',NULL,'4376',NULL),(438,25,NULL,'Anawara','Battali',NULL,'4378',NULL),(439,25,NULL,'Anawara','Paroikora',NULL,'4377',NULL),(440,25,NULL,'Boalkhali','Boalkhali',NULL,'4366',NULL),(441,25,NULL,'Boalkhali','Charandwip',NULL,'4369',NULL),(442,25,NULL,'Boalkhali','Iqbal Park',NULL,'4365',NULL),(443,25,NULL,'Boalkhali','Kadurkhal',NULL,'4368',NULL),(444,25,NULL,'Boalkhali','Kanungopara',NULL,'4363',NULL),(445,25,NULL,'Boalkhali','Sakpura',NULL,'4367',NULL),(446,25,NULL,'Boalkhali','Saroatoli',NULL,'4364',NULL),(447,25,NULL,'Chittagong Sadar','Al- Amin Baria Madra',NULL,'4221',NULL),(448,25,NULL,'Chittagong Sadar','Amin Jute Mills',NULL,'4211',NULL),(449,25,NULL,'Chittagong Sadar','Anandabazar',NULL,'4215',NULL),(450,25,NULL,'Chittagong Sadar','Bayezid Bostami',NULL,'4210',NULL),(451,25,NULL,'Chittagong Sadar','Chandgaon',NULL,'4212',NULL),(452,25,NULL,'Chittagong Sadar','Chawkbazar',NULL,'4203',NULL),(453,25,NULL,'Chittagong Sadar','Chitt. Cantonment',NULL,'4220',NULL),(454,25,NULL,'Chittagong Sadar','Chitt. Customs Acca',NULL,'4219',NULL),(455,25,NULL,'Chittagong Sadar','Chitt. Politechnic In',NULL,'4209',NULL),(456,25,NULL,'Chittagong Sadar','Chitt. Sailers Colon',NULL,'4218',NULL),(457,25,NULL,'Chittagong Sadar','Chittagong Airport',NULL,'4205',NULL),(458,25,NULL,'Chittagong Sadar','Chittagong Bandar',NULL,'4100',NULL),(459,25,NULL,'Chittagong Sadar','Chittagong GPO',NULL,'4000',NULL),(460,25,NULL,'Chittagong Sadar','Export Processing',NULL,'4223',NULL),(461,25,NULL,'Chittagong Sadar','Firozshah',NULL,'4207',NULL),(462,25,NULL,'Chittagong Sadar','Halishahar',NULL,'4216',NULL),(463,25,NULL,'Chittagong Sadar','Halishshar',NULL,'4225',NULL),(464,25,NULL,'Chittagong Sadar','Jalalabad',NULL,'4214',NULL),(465,25,NULL,'Chittagong Sadar','Jaldia Merine Accade',NULL,'4206',NULL),(466,25,NULL,'Chittagong Sadar','Middle Patenga',NULL,'4222',NULL),(467,25,NULL,'Chittagong Sadar','Mohard',NULL,'4208',NULL),(468,25,NULL,'Chittagong Sadar','North Halishahar',NULL,'4226',NULL),(469,25,NULL,'Chittagong Sadar','North Katuli',NULL,'4217',NULL),(470,25,NULL,'Chittagong Sadar','Pahartoli',NULL,'4202',NULL),(471,25,NULL,'Chittagong Sadar','Patenga',NULL,'4204',NULL),(472,25,NULL,'Chittagong Sadar','Rampura TSO',NULL,'4224',NULL),(473,25,NULL,'Chittagong Sadar','Wazedia',NULL,'4213',NULL),(474,25,NULL,'East Joara','Barma',NULL,'4383',NULL),(475,25,NULL,'East Joara','Dohazari',NULL,'4382',NULL),(476,25,NULL,'East Joara','East Joara',NULL,'4380',NULL),(477,25,NULL,'East Joara','Gachbaria',NULL,'4381',NULL),(478,25,NULL,'Fatikchhari','Bhandar Sharif',NULL,'4352',NULL),(479,25,NULL,'Fatikchhari','Fatikchhari',NULL,'4350',NULL),(480,25,NULL,'Fatikchhari','Harualchhari',NULL,'4354',NULL),(481,25,NULL,'Fatikchhari','Najirhat',NULL,'4353',NULL),(482,25,NULL,'Fatikchhari','Nanupur',NULL,'4351',NULL),(483,25,NULL,'Fatikchhari','Narayanhat',NULL,'4355',NULL),(484,25,NULL,'Hathazari','Chitt.University',NULL,'4331',NULL),(485,25,NULL,'Hathazari','Fatahabad',NULL,'4335',NULL),(486,25,NULL,'Hathazari','Gorduara',NULL,'4332',NULL),(487,25,NULL,'Hathazari','Hathazari',NULL,'4330',NULL),(488,25,NULL,'Hathazari','Katirhat',NULL,'4333',NULL),(489,25,NULL,'Hathazari','Madrasa',NULL,'4339',NULL),(490,25,NULL,'Hathazari','Mirzapur',NULL,'4334',NULL),(491,25,NULL,'Hathazari','Nuralibari',NULL,'4337',NULL),(492,25,NULL,'Hathazari','Yunus Nagar',NULL,'4338',NULL),(493,25,NULL,'Jaldi','Banigram',NULL,'4393',NULL),(494,25,NULL,'Jaldi','Gunagari',NULL,'4392',NULL),(495,25,NULL,'Jaldi','Jaldi',NULL,'4390',NULL),(496,25,NULL,'Jaldi','Khan Bahadur',NULL,'4391',NULL),(497,25,NULL,'Lohagara','Chunti',NULL,'4398',NULL),(498,25,NULL,'Lohagara','Lohagara',NULL,'4396',NULL),(499,25,NULL,'Lohagara','Padua',NULL,'4397',NULL),(500,25,NULL,'Mirsharai','Abutorab',NULL,'4321',NULL),(501,25,NULL,'Mirsharai','Azampur',NULL,'4325',NULL),(502,25,NULL,'Mirsharai','Bharawazhat',NULL,'4323',NULL),(503,25,NULL,'Mirsharai','Darrogahat',NULL,'4322',NULL),(504,25,NULL,'Mirsharai','Joarganj',NULL,'4324',NULL),(505,25,NULL,'Mirsharai','Korerhat',NULL,'4327',NULL),(506,25,NULL,'Mirsharai','Mirsharai',NULL,'4320',NULL),(507,25,NULL,'Mirsharai','Mohazanhat',NULL,'4328',NULL),(508,25,NULL,'Patiya','Budhpara',NULL,'4371',NULL),(509,25,NULL,'Patiya','Patiya Head Office',NULL,'4370',NULL),(510,25,NULL,'Rangunia','Dhamair',NULL,'4361',NULL),(511,25,NULL,'Rangunia','Rangunia',NULL,'4360',NULL),(512,25,NULL,'Rouzan','B.I.T Post Office',NULL,'4349',NULL),(513,25,NULL,'Rouzan','Beenajuri',NULL,'4341',NULL),(514,25,NULL,'Rouzan','Dewanpur',NULL,'4347',NULL),(515,25,NULL,'Rouzan','Fatepur',NULL,'4345',NULL),(516,25,NULL,'Rouzan','Gahira',NULL,'4343',NULL),(517,25,NULL,'Rouzan','Guzra Noapara',NULL,'4346',NULL),(518,25,NULL,'Rouzan','jagannath Hat',NULL,'4344',NULL),(519,25,NULL,'Rouzan','Kundeshwari',NULL,'4342',NULL),(520,25,NULL,'Rouzan','Mohamuni',NULL,'4348',NULL),(521,25,NULL,'Rouzan','Rouzan',NULL,'4340',NULL),(522,25,NULL,'Sandwip','Sandwip',NULL,'4300',NULL),(523,25,NULL,'Sandwip','Shiberhat',NULL,'4301',NULL),(524,25,NULL,'Sandwip','Urirchar',NULL,'4302',NULL),(525,25,NULL,'Satkania','Baitul Ijjat',NULL,'4387',NULL),(526,25,NULL,'Satkania','Bazalia',NULL,'4388',NULL),(527,25,NULL,'Satkania','Satkania',NULL,'4386',NULL),(528,25,NULL,'Sitakunda','Barabkunda',NULL,'4312',NULL),(529,25,NULL,'Sitakunda','Baroidhala',NULL,'4311',NULL),(530,25,NULL,'Sitakunda','Bawashbaria',NULL,'4313',NULL),(531,25,NULL,'Sitakunda','Bhatiari',NULL,'4315',NULL),(532,25,NULL,'Sitakunda','Fouzdarhat',NULL,'4316',NULL),(533,25,NULL,'Sitakunda','Jafrabad',NULL,'4317',NULL),(534,25,NULL,'Sitakunda','Kumira',NULL,'4314',NULL),(535,25,NULL,'Sitakunda','Sitakunda',NULL,'4310',NULL),(536,18,NULL,'Barura','Barura',NULL,'3560',NULL),(537,18,NULL,'Barura','Murdafarganj',NULL,'3562',NULL),(538,18,NULL,'Barura','Poyalgachha',NULL,'3561',NULL),(539,18,NULL,'Brahmanpara','Brahmanpara',NULL,'3526',NULL),(540,18,NULL,'Burichang','Burichang',NULL,'3520',NULL),(541,18,NULL,'Burichang','Maynamoti bazar',NULL,'3521',NULL),(542,18,NULL,'Chandina','Chandia',NULL,'3510',NULL),(543,18,NULL,'Chandina','Madhaiabazar',NULL,'3511',NULL),(544,18,NULL,'Chouddagram','Batisa',NULL,'3551',NULL),(545,18,NULL,'Chouddagram','Chiora',NULL,'3552',NULL),(546,18,NULL,'Chouddagram','Chouddagram',NULL,'3550',NULL),(547,18,NULL,'Comilla Sadar','Comilla Contoment',NULL,'3501',NULL),(548,18,NULL,'Comilla Sadar','Comilla Sadar',NULL,'3500',NULL),(549,18,NULL,'Comilla Sadar','Courtbari',NULL,'3503',NULL),(550,18,NULL,'Comilla Sadar','Halimanagar',NULL,'3502',NULL),(551,18,NULL,'Comilla Sadar','Suaganj',NULL,'3504',NULL),(552,18,NULL,'Daudkandi','Dashpara',NULL,'3518',NULL),(553,18,NULL,'Daudkandi','Daudkandi',NULL,'3516',NULL),(554,18,NULL,'Daudkandi','Eliotganj',NULL,'3519',NULL),(555,18,NULL,'Daudkandi','Gouripur',NULL,'3517',NULL),(556,18,NULL,'Davidhar','Barashalghar',NULL,'3532',NULL),(557,18,NULL,'Davidhar','Davidhar',NULL,'3530',NULL),(558,18,NULL,'Davidhar','Dhamtee',NULL,'3533',NULL),(559,18,NULL,'Davidhar','Gangamandal',NULL,'3531',NULL),(560,18,NULL,'Homna','Homna',NULL,'3546',NULL),(561,18,NULL,'Laksam','Bipulasar',NULL,'3572',NULL),(562,18,NULL,'Laksam','Laksam',NULL,'3570',NULL),(563,18,NULL,'Laksam','Lakshamanpur',NULL,'3571',NULL),(564,18,NULL,'Langalkot','Chhariabazar',NULL,'3582',NULL),(565,18,NULL,'Langalkot','Dhalua',NULL,'3581',NULL),(566,18,NULL,'Langalkot','Gunabati',NULL,'3583',NULL),(567,18,NULL,'Langalkot','Langalkot',NULL,'3580',NULL),(568,18,NULL,'Muradnagar','Bangra',NULL,'3543',NULL),(569,18,NULL,'Muradnagar','Companyganj',NULL,'3542',NULL),(570,18,NULL,'Muradnagar','Muradnagar',NULL,'3540',NULL),(571,18,NULL,'Muradnagar','Pantibazar',NULL,'3545',NULL),(572,18,NULL,'Muradnagar','Ramchandarpur',NULL,'3541',NULL),(573,18,NULL,'Muradnagar','Sonakanda',NULL,'3544',NULL),(574,26,NULL,'Chiringga','Badarkali',NULL,'4742',NULL),(575,26,NULL,'Chiringga','Chiringga',NULL,'4740',NULL),(576,26,NULL,'Chiringga','Chiringga S.O',NULL,'4741',NULL),(577,26,NULL,'Chiringga','Malumghat',NULL,'4743',NULL),(578,26,NULL,'Coxs Bazar Sadar','Coxs Bazar Sadar',NULL,'4700',NULL),(579,26,NULL,'Coxs Bazar Sadar','Eidga',NULL,'4702',NULL),(580,26,NULL,'Coxs Bazar Sadar','Zhilanja',NULL,'4701',NULL),(581,26,NULL,'Gorakghat','Gorakghat',NULL,'4710',NULL),(582,26,NULL,'Kutubdia','Kutubdia',NULL,'4720',NULL),(583,26,NULL,'Ramu','Ramu',NULL,'4730',NULL),(584,26,NULL,'Teknaf','Hnila',NULL,'4761',NULL),(585,26,NULL,'Teknaf','St.Martin',NULL,'4762',NULL),(586,26,NULL,'Teknaf','Teknaf',NULL,'4760',NULL),(587,26,NULL,'Ukhia','Ukhia',NULL,'4750',NULL),(588,19,NULL,'Chhagalnaia','Chhagalnaia',NULL,'3910',NULL),(589,19,NULL,'Chhagalnaia','Daraga Hat',NULL,'3912',NULL),(590,19,NULL,'Chhagalnaia','Maharajganj',NULL,'3911',NULL),(591,19,NULL,'Chhagalnaia','Puabashimulia',NULL,'3913',NULL),(592,19,NULL,'Dagonbhuia','Chhilonia',NULL,'3922',NULL),(593,19,NULL,'Dagonbhuia','Dagondhuia',NULL,'3920',NULL),(594,19,NULL,'Dagonbhuia','Dudmukha',NULL,'3921',NULL),(595,19,NULL,'Dagonbhuia','Rajapur',NULL,'3923',NULL),(596,19,NULL,'Feni Sadar','Fazilpur',NULL,'3901',NULL),(597,19,NULL,'Feni Sadar','Feni Sadar',NULL,'3900',NULL),(598,19,NULL,'Feni Sadar','Laskarhat',NULL,'3903',NULL),(599,19,NULL,'Feni Sadar','Sharshadie',NULL,'3902',NULL),(600,19,NULL,'Pashurampur','Fulgazi',NULL,'3942',NULL),(601,19,NULL,'Pashurampur','Munshirhat',NULL,'3943',NULL),(602,19,NULL,'Pashurampur','Pashurampur',NULL,'3940',NULL),(603,19,NULL,'Pashurampur','Shuarbazar',NULL,'3941',NULL),(604,19,NULL,'Sonagazi','Ahmadpur',NULL,'3932',NULL),(605,19,NULL,'Sonagazi','Kazirhat',NULL,'3933',NULL),(606,19,NULL,'Sonagazi','Motiganj',NULL,'3931',NULL),(607,19,NULL,'Sonagazi','Sonagazi',NULL,'3930',NULL),(608,27,NULL,'Diginala','Diginala',NULL,'4420',NULL),(609,27,NULL,'Khagrachhari Sadar','Khagrachhari Sadar',NULL,'4400',NULL),(610,27,NULL,'Laxmichhari','Laxmichhari',NULL,'4470',NULL),(611,27,NULL,'Mahalchhari','Mahalchhari',NULL,'4430',NULL),(612,27,NULL,'Manikchhari','Manikchhari',NULL,'4460',NULL),(613,27,NULL,'Matiranga','Matiranga',NULL,'4450',NULL),(614,27,NULL,'Panchhari','Panchhari',NULL,'4410',NULL),(615,27,NULL,'Ramghar Head Office','Ramghar Head Office',NULL,'4440',NULL),(616,24,NULL,'Char Alexgander','Char Alexgander',NULL,'3730',NULL),(617,24,NULL,'Char Alexgander','Hajirghat',NULL,'3731',NULL),(618,24,NULL,'Char Alexgander','Ramgatirhat',NULL,'3732',NULL),(619,24,NULL,'Lakshimpur Sadar','Amani Lakshimpur',NULL,'3709',NULL),(620,24,NULL,'Lakshimpur Sadar','Bhabaniganj',NULL,'3702',NULL),(621,24,NULL,'Lakshimpur Sadar','Chandraganj',NULL,'3708',NULL),(622,24,NULL,'Lakshimpur Sadar','Choupalli',NULL,'3707',NULL),(623,24,NULL,'Lakshimpur Sadar','Dalal Bazar',NULL,'3701',NULL),(624,24,NULL,'Lakshimpur Sadar','Duttapara',NULL,'3706',NULL),(625,24,NULL,'Lakshimpur Sadar','Keramatganj',NULL,'3704',NULL),(626,24,NULL,'Lakshimpur Sadar','Lakshimpur Sadar',NULL,'3700',NULL),(627,24,NULL,'Lakshimpur Sadar','Mandari',NULL,'3703',NULL),(628,24,NULL,'Lakshimpur Sadar','Rupchara',NULL,'3705',NULL),(629,24,NULL,'Ramganj','Alipur',NULL,'3721',NULL),(630,24,NULL,'Ramganj','Dolta',NULL,'3725',NULL),(631,24,NULL,'Ramganj','Kanchanpur',NULL,'3723',NULL),(632,24,NULL,'Ramganj','Naagmud',NULL,'3724',NULL),(633,24,NULL,'Ramganj','Panpara',NULL,'3722',NULL),(634,24,NULL,'Ramganj','Ramganj',NULL,'3720',NULL),(635,24,NULL,'Raypur','Bhuabari',NULL,'3714',NULL),(636,24,NULL,'Raypur','Haydarganj',NULL,'3713',NULL),(637,24,NULL,'Raypur','Nagerdighirpar',NULL,'3712',NULL),(638,24,NULL,'Raypur','Rakhallia',NULL,'3711',NULL),(639,24,NULL,'Raypur','Raypur',NULL,'3710',NULL),(640,22,NULL,'Basurhat','Basur Hat',NULL,'3850',NULL),(641,22,NULL,'Basurhat','Charhajari',NULL,'3851',NULL),(642,22,NULL,'Begumganj','Alaiarpur',NULL,'3831',NULL),(643,22,NULL,'Begumganj','Amisha Para',NULL,'3847',NULL),(644,22,NULL,'Begumganj','Banglabazar',NULL,'3822',NULL),(645,22,NULL,'Begumganj','Bazra',NULL,'3824',NULL),(646,22,NULL,'Begumganj','Begumganj',NULL,'3820',NULL),(647,22,NULL,'Begumganj','Bhabani Jibanpur',NULL,'3837',NULL),(648,22,NULL,'Begumganj','Choumohani',NULL,'3821',NULL),(649,22,NULL,'Begumganj','Dauti',NULL,'3843',NULL),(650,22,NULL,'Begumganj','Durgapur',NULL,'3848',NULL),(651,22,NULL,'Begumganj','Gopalpur',NULL,'3828',NULL),(652,22,NULL,'Begumganj','Jamidar Hat',NULL,'3825',NULL),(653,22,NULL,'Begumganj','Joyag',NULL,'3844',NULL),(654,22,NULL,'Begumganj','Joynarayanpur',NULL,'3829',NULL),(655,22,NULL,'Begumganj','Khalafat Bazar',NULL,'3833',NULL),(656,22,NULL,'Begumganj','Khalishpur',NULL,'3842',NULL),(657,22,NULL,'Begumganj','Maheshganj',NULL,'3838',NULL),(658,22,NULL,'Begumganj','Mir Owarishpur',NULL,'3823',NULL),(659,22,NULL,'Begumganj','Nadona',NULL,'3839',NULL),(660,22,NULL,'Begumganj','Nandiapara',NULL,'3841',NULL),(661,22,NULL,'Begumganj','Oachhekpur',NULL,'3835',NULL),(662,22,NULL,'Begumganj','Rajganj',NULL,'3834',NULL),(663,22,NULL,'Begumganj','Sonaimuri',NULL,'3827',NULL),(664,22,NULL,'Begumganj','Tangirpar',NULL,'3832',NULL),(665,22,NULL,'Begumganj','Thanar Hat',NULL,'3845',NULL),(666,22,NULL,'Chatkhil','Bansa Bazar',NULL,'3879',NULL),(667,22,NULL,'Chatkhil','Bodalcourt',NULL,'3873',NULL),(668,22,NULL,'Chatkhil','Chatkhil',NULL,'3870',NULL),(669,22,NULL,'Chatkhil','Dosh Gharia',NULL,'3878',NULL),(670,22,NULL,'Chatkhil','Karihati',NULL,'3877',NULL),(671,22,NULL,'Chatkhil','Khilpara',NULL,'3872',NULL),(672,22,NULL,'Chatkhil','Palla',NULL,'3871',NULL),(673,22,NULL,'Chatkhil','Rezzakpur',NULL,'3874',NULL),(674,22,NULL,'Chatkhil','Sahapur',NULL,'3881',NULL),(675,22,NULL,'Chatkhil','Sampara',NULL,'3882',NULL),(676,22,NULL,'Chatkhil','Shingbahura',NULL,'3883',NULL),(677,22,NULL,'Chatkhil','Solla',NULL,'3875',NULL),(678,22,NULL,'Hatiya','Afazia',NULL,'3891',NULL),(679,22,NULL,'Hatiya','Hatiya',NULL,'3890',NULL),(680,22,NULL,'Hatiya','Tamoraddi',NULL,'3892',NULL),(681,22,NULL,'Noakhali Sadar','Chaprashir Hat',NULL,'3811',NULL),(682,22,NULL,'Noakhali Sadar','Char Jabbar',NULL,'3812',NULL),(683,22,NULL,'Noakhali Sadar','Charam Tua',NULL,'3809',NULL),(684,22,NULL,'Noakhali Sadar','Din Monir Hat',NULL,'3803',NULL),(685,22,NULL,'Noakhali Sadar','Kabirhat',NULL,'3807',NULL),(686,22,NULL,'Noakhali Sadar','Khalifar Hat',NULL,'3808',NULL),(687,22,NULL,'Noakhali Sadar','Mriddarhat',NULL,'3806',NULL),(688,22,NULL,'Noakhali Sadar','Noakhali College',NULL,'3801',NULL),(689,22,NULL,'Noakhali Sadar','Noakhali Sadar',NULL,'3800',NULL),(690,22,NULL,'Noakhali Sadar','Pak Kishoreganj',NULL,'3804',NULL),(691,22,NULL,'Noakhali Sadar','Sonapur',NULL,'3802',NULL),(692,22,NULL,'Senbag','Beezbag',NULL,'3862',NULL),(693,22,NULL,'Senbag','Chatarpaia',NULL,'3864',NULL),(694,22,NULL,'Senbag','Kallyandi',NULL,'3861',NULL),(695,22,NULL,'Senbag','Kankirhat',NULL,'3863',NULL),(696,22,NULL,'Senbag','Senbag',NULL,'3860',NULL),(697,22,NULL,'Senbag','T.P. Lamua',NULL,'3865',NULL),(698,21,NULL,'Barakal','Barakal',NULL,'4570',NULL),(699,21,NULL,'Bilaichhari','Bilaichhari',NULL,'4550',NULL),(700,21,NULL,'Jarachhari','Jarachhari',NULL,'4560',NULL),(701,21,NULL,'Kalampati','Betbunia',NULL,'4511',NULL),(702,21,NULL,'Kalampati','Kalampati',NULL,'4510',NULL),(703,21,NULL,'kaptai','Chandraghona',NULL,'4531',NULL),(704,21,NULL,'kaptai','Kaptai',NULL,'4530',NULL),(705,21,NULL,'kaptai','Kaptai Nuton Bazar',NULL,'4533',NULL),(706,21,NULL,'kaptai','Kaptai Project',NULL,'4532',NULL),(707,21,NULL,'Longachh','Longachh',NULL,'4580',NULL),(708,21,NULL,'Marishya','Marishya',NULL,'4590',NULL),(709,21,NULL,'Naniachhar','Nanichhar',NULL,'4520',NULL),(710,21,NULL,'Rajsthali','Rajsthali',NULL,'4540',NULL),(711,21,NULL,'Rangamati Sadar','Rangamati Sadar',NULL,'4500',NULL),(712,45,NULL,'Bagerhat Sadar','Bagerhat Sadar',NULL,'9300',NULL),(713,45,NULL,'Bagerhat Sadar','P.C College',NULL,'9301',NULL),(714,45,NULL,'Bagerhat Sadar','Rangdia',NULL,'9302',NULL),(715,45,NULL,'Chalna Ankorage','Chalna Ankorage',NULL,'9350',NULL),(716,45,NULL,'Chalna Ankorage','Mongla Port',NULL,'9351',NULL),(717,45,NULL,'Chitalmari','Barabaria',NULL,'9361',NULL),(718,45,NULL,'Chitalmari','Chitalmari',NULL,'9360',NULL),(719,45,NULL,'Fakirhat','Bhanganpar Bazar',NULL,'9372',NULL),(720,45,NULL,'Fakirhat','Fakirhat',NULL,'9370',NULL),(721,45,NULL,'Fakirhat','Mansa',NULL,'9371',NULL),(722,45,NULL,'Kachua UPO','Kachua',NULL,'9310',NULL),(723,45,NULL,'Kachua UPO','Sonarkola',NULL,'9311',NULL),(724,45,NULL,'Mollahat','Charkulia',NULL,'9383',NULL),(725,45,NULL,'Mollahat','Dariala',NULL,'9382',NULL),(726,45,NULL,'Mollahat','Kahalpur',NULL,'9381',NULL),(727,45,NULL,'Mollahat','Mollahat',NULL,'9380',NULL),(728,45,NULL,'Mollahat','Nagarkandi',NULL,'9384',NULL),(729,45,NULL,'Mollahat','Pak Gangni',NULL,'9385',NULL),(730,45,NULL,'Morelganj','Morelganj',NULL,'9320',NULL),(731,45,NULL,'Morelganj','Sannasi Bazar',NULL,'9321',NULL),(732,45,NULL,'Morelganj','Telisatee',NULL,'9322',NULL),(733,45,NULL,'Rampal','Foylahat',NULL,'9341',NULL),(734,45,NULL,'Rampal','Gourambha',NULL,'9343',NULL),(735,45,NULL,'Rampal','Rampal',NULL,'9340',NULL),(736,45,NULL,'Rampal','Sonatunia',NULL,'9342',NULL),(737,45,NULL,'Rayenda','Rayenda',NULL,'9330',NULL),(738,41,NULL,'Alamdanga','Alamdanga',NULL,'7210',NULL),(739,41,NULL,'Alamdanga','Hardi',NULL,'7211',NULL),(740,41,NULL,'Chuadanga Sadar','Chuadanga Sadar',NULL,'7200',NULL),(741,41,NULL,'Chuadanga Sadar','Munshiganj',NULL,'7201',NULL),(742,41,NULL,'Damurhuda','Andulbaria',NULL,'7222',NULL),(743,41,NULL,'Damurhuda','Damurhuda',NULL,'7220',NULL),(744,41,NULL,'Damurhuda','Darshana',NULL,'7221',NULL),(745,41,NULL,'Doulatganj','Doulatganj',NULL,'7230',NULL),(746,37,NULL,'Bagharpara','Bagharpara',NULL,'7470',NULL),(747,37,NULL,'Bagharpara','Gouranagar',NULL,'7471',NULL),(748,37,NULL,'Chaugachha','Chougachha',NULL,'7410',NULL),(749,37,NULL,'Jessore Sadar','Basundia',NULL,'7406',NULL),(750,37,NULL,'Jessore Sadar','Chanchra',NULL,'7402',NULL),(751,37,NULL,'Jessore Sadar','Churamankathi',NULL,'7407',NULL),(752,37,NULL,'Jessore Sadar','Jessore Airbach',NULL,'7404',NULL),(753,37,NULL,'Jessore Sadar','Jessore canttonment',NULL,'7403',NULL),(754,37,NULL,'Jessore Sadar','Jessore Sadar',NULL,'7400',NULL),(755,37,NULL,'Jessore Sadar','Jessore Upa-Shahar',NULL,'7401',NULL),(756,37,NULL,'Jessore Sadar','Rupdia',NULL,'7405',NULL),(757,37,NULL,'Jhikargachha','Jhikargachha',NULL,'7420',NULL),(758,37,NULL,'Keshabpur','Keshobpur',NULL,'7450',NULL),(759,37,NULL,'Monirampur','Monirampur',NULL,'7440',NULL),(760,37,NULL,'Noapara','Bhugilhat',NULL,'7462',NULL),(761,37,NULL,'Noapara','Noapara',NULL,'7460',NULL),(762,37,NULL,'Noapara','Rajghat',NULL,'7461',NULL),(763,37,NULL,'Sarsa','Bag Achra',NULL,'7433',NULL),(764,37,NULL,'Sarsa','Benapole',NULL,'7431',NULL),(765,37,NULL,'Sarsa','Jadabpur',NULL,'7432',NULL),(766,37,NULL,'Sarsa','Sarsa',NULL,'7430',NULL),(767,46,NULL,'Harinakundu','Harinakundu',NULL,'7310',NULL),(768,46,NULL,'Jhenaidah Sadar','Jhenaidah Cadet College',NULL,'7301',NULL),(769,46,NULL,'Jhenaidah Sadar','Jhenaidah Sadar',NULL,'7300',NULL),(770,46,NULL,'Kotchandpur','Kotchandpur',NULL,'7330',NULL),(771,46,NULL,'Maheshpur','Maheshpur',NULL,'7340',NULL),(772,46,NULL,'Naldanga','Hatbar Bazar',NULL,'7351',NULL),(773,46,NULL,'Naldanga','Naldanga',NULL,'7350',NULL),(774,46,NULL,'Shailakupa','Kumiradaha',NULL,'7321',NULL),(775,46,NULL,'Shailakupa','Shailakupa',NULL,'7320',NULL),(776,44,NULL,'Alaipur','Alaipur',NULL,'9240',NULL),(777,44,NULL,'Alaipur','Belphulia',NULL,'9242',NULL),(778,44,NULL,'Alaipur','Rupsha',NULL,'9241',NULL),(779,44,NULL,'Batiaghat','Batiaghat',NULL,'9260',NULL),(780,44,NULL,'Batiaghat','Surkalee',NULL,'9261',NULL),(781,44,NULL,'Chalna Bazar','Bajua',NULL,'9272',NULL),(782,44,NULL,'Chalna Bazar','Chalna Bazar',NULL,'9270',NULL),(783,44,NULL,'Chalna Bazar','Dakup',NULL,'9271',NULL),(784,44,NULL,'Chalna Bazar','Nalian',NULL,'9273',NULL),(785,44,NULL,'Digalia','Chandni Mahal',NULL,'9221',NULL),(786,44,NULL,'Digalia','Digalia',NULL,'9220',NULL),(787,44,NULL,'Digalia','Gazirhat',NULL,'9224',NULL),(788,44,NULL,'Digalia','Ghoshghati',NULL,'9223',NULL),(789,44,NULL,'Digalia','Senhati',NULL,'9222',NULL),(790,44,NULL,'Khulna Sadar','Atra Shilpa Area',NULL,'9207',NULL),(791,44,NULL,'Khulna Sadar','BIT Khulna',NULL,'9203',NULL),(792,44,NULL,'Khulna Sadar','Doulatpur',NULL,'9202',NULL),(793,44,NULL,'Khulna Sadar','Jahanabad Canttonmen',NULL,'9205',NULL),(794,44,NULL,'Khulna Sadar','Khula Sadar',NULL,'9100',NULL),(795,44,NULL,'Khulna Sadar','Khulna G.P.O',NULL,'9000',NULL),(796,44,NULL,'Khulna Sadar','Khulna Shipyard',NULL,'9201',NULL),(797,44,NULL,'Khulna Sadar','Khulna University',NULL,'9208',NULL),(798,44,NULL,'Khulna Sadar','Siramani',NULL,'9204',NULL),(799,44,NULL,'Khulna Sadar','Sonali Jute Mills',NULL,'9206',NULL),(800,44,NULL,'Madinabad','Amadee',NULL,'9291',NULL),(801,44,NULL,'Madinabad','Madinabad',NULL,'9290',NULL),(802,44,NULL,'Paikgachha','Chandkhali',NULL,'9284',NULL),(803,44,NULL,'Paikgachha','Garaikhali',NULL,'9285',NULL),(804,44,NULL,'Paikgachha','Godaipur',NULL,'9281',NULL),(805,44,NULL,'Paikgachha','Kapilmoni',NULL,'9282',NULL),(806,44,NULL,'Paikgachha','Katipara',NULL,'9283',NULL),(807,44,NULL,'Paikgachha','Paikgachha',NULL,'9280',NULL),(808,44,NULL,'Phultala','Phultala',NULL,'9210',NULL),(809,44,NULL,'Sajiara','Chuknagar',NULL,'9252',NULL),(810,44,NULL,'Sajiara','Ghonabanda',NULL,'9251',NULL),(811,44,NULL,'Sajiara','Sajiara',NULL,'9250',NULL),(812,44,NULL,'Sajiara','Shahapur',NULL,'9253',NULL),(813,44,NULL,'Terakhada','Pak Barasat',NULL,'9231',NULL),(814,44,NULL,'Terakhada','Terakhada',NULL,'9230',NULL),(815,42,NULL,'Bheramara','Allardarga',NULL,'7042',NULL),(816,42,NULL,'Bheramara','Bheramara',NULL,'7040',NULL),(817,42,NULL,'Bheramara','Ganges Bheramara',NULL,'7041',NULL),(818,42,NULL,'Janipur','Janipur',NULL,'7020',NULL),(819,42,NULL,'Janipur','Khoksa',NULL,'7021',NULL),(820,42,NULL,'Kumarkhali','Kumarkhali',NULL,'7010',NULL),(821,42,NULL,'Kumarkhali','Panti',NULL,'7011',NULL),(822,42,NULL,'Kushtia Sadar','Islami University',NULL,'7003',NULL),(823,42,NULL,'Kushtia Sadar','Jagati',NULL,'7002',NULL),(824,42,NULL,'Kushtia Sadar','Kushtia Mohini',NULL,'7001',NULL),(825,42,NULL,'Kushtia Sadar','Kushtia Sadar',NULL,'7000',NULL),(826,42,NULL,'Mirpur','Amla Sadarpur',NULL,'7032',NULL),(827,42,NULL,'Mirpur','Mirpur',NULL,'7030',NULL),(828,42,NULL,'Mirpur','Poradaha',NULL,'7031',NULL),(829,42,NULL,'Rafayetpur','Khasmathurapur',NULL,'7052',NULL),(830,42,NULL,'Rafayetpur','Rafayetpur',NULL,'7050',NULL),(831,42,NULL,'Rafayetpur','Taragunia',NULL,'7051',NULL),(832,43,NULL,'Arpara','Arpara',NULL,'7620',NULL),(833,43,NULL,'Magura Sadar','Magura Sadar',NULL,'7600',NULL),(834,43,NULL,'Mohammadpur','Binodpur',NULL,'7631',NULL),(835,43,NULL,'Mohammadpur','Mohammadpur',NULL,'7630',NULL),(836,43,NULL,'Mohammadpur','Nahata',NULL,'7632',NULL),(837,43,NULL,'Shripur','Langalbadh',NULL,'7611',NULL),(838,43,NULL,'Shripur','Nachol',NULL,'7612',NULL),(839,43,NULL,'Shripur','Shripur',NULL,'7610',NULL),(840,39,NULL,'Gangni','Gangni',NULL,'7110',NULL),(841,39,NULL,'Meherpur Sadar','Amjhupi',NULL,'7101',NULL),(842,39,NULL,'Meherpur Sadar','Amjhupi',NULL,'7152',NULL),(843,39,NULL,'Meherpur Sadar','Meherpur Sadar',NULL,'7100',NULL),(844,39,NULL,'Meherpur Sadar','Mujib Nagar Complex',NULL,'7102',NULL),(845,40,NULL,'Kalia','Kalia',NULL,'7520',NULL),(846,40,NULL,'Laxmipasha','Baradia',NULL,'7514',NULL),(847,40,NULL,'Laxmipasha','Itna',NULL,'7512',NULL),(848,40,NULL,'Laxmipasha','Laxmipasha',NULL,'7510',NULL),(849,40,NULL,'Laxmipasha','Lohagora',NULL,'7511',NULL),(850,40,NULL,'Laxmipasha','Naldi',NULL,'7513',NULL),(851,40,NULL,'Mohajan','Mohajan',NULL,'7521',NULL),(852,40,NULL,'Narail Sadar','Narail Sadar',NULL,'7500',NULL),(853,40,NULL,'Narail Sadar','Ratanganj',NULL,'7501',NULL),(854,38,NULL,'Ashashuni','Ashashuni',NULL,'9460',NULL),(855,38,NULL,'Ashashuni','Baradal',NULL,'9461',NULL),(856,38,NULL,'Debbhata','Debbhata',NULL,'9430',NULL),(857,38,NULL,'Debbhata','Gurugram',NULL,'9431',NULL),(858,38,NULL,'kalaroa','Chandanpur',NULL,'9415',NULL),(859,38,NULL,'kalaroa','Hamidpur',NULL,'9413',NULL),(860,38,NULL,'kalaroa','Jhaudanga',NULL,'9412',NULL),(861,38,NULL,'kalaroa','kalaroa',NULL,'9410',NULL),(862,38,NULL,'kalaroa','Khordo',NULL,'9414',NULL),(863,38,NULL,'kalaroa','Murarikati',NULL,'9411',NULL),(864,38,NULL,'Kaliganj UPO','Kaliganj UPO',NULL,'9440',NULL),(865,38,NULL,'Kaliganj UPO','Nalta Mubaroknagar',NULL,'9441',NULL),(866,38,NULL,'Kaliganj UPO','Ratanpur',NULL,'9442',NULL),(867,38,NULL,'Nakipur','Buri Goalini',NULL,'9453',NULL),(868,38,NULL,'Nakipur','Gabura',NULL,'9454',NULL),(869,38,NULL,'Nakipur','Habinagar',NULL,'9455',NULL),(870,38,NULL,'Nakipur','Nakipur',NULL,'9450',NULL),(871,38,NULL,'Nakipur','Naobeki',NULL,'9452',NULL),(872,38,NULL,'Nakipur','Noornagar',NULL,'9451',NULL),(873,38,NULL,'Satkhira Sadar','Budhhat',NULL,'9403',NULL),(874,38,NULL,'Satkhira Sadar','Gunakar kati',NULL,'9402',NULL),(875,38,NULL,'Satkhira Sadar','Satkhira Islamia Acc',NULL,'9401',NULL),(876,38,NULL,'Satkhira Sadar','Satkhira Sadar',NULL,'9400',NULL),(877,38,NULL,'Taala','Patkelghata',NULL,'9421',NULL),(878,38,NULL,'Taala','Taala',NULL,'9420',NULL),(879,63,NULL,'Azmireeganj','Azmireeganj',NULL,'3360',NULL),(880,63,NULL,'Bahubal','Bahubal',NULL,'3310',NULL),(881,63,NULL,'Baniachang','Baniachang',NULL,'3350',NULL),(882,63,NULL,'Baniachang','Jatrapasha',NULL,'3351',NULL),(883,63,NULL,'Baniachang','Kadirganj',NULL,'3352',NULL),(884,63,NULL,'Chunarughat','Chandpurbagan',NULL,'3321',NULL),(885,63,NULL,'Chunarughat','Chunarughat',NULL,'3320',NULL),(886,63,NULL,'Chunarughat','Narapati',NULL,'3322',NULL),(887,63,NULL,'Habiganj Sadar','Gopaya',NULL,'3302',NULL),(888,63,NULL,'Habiganj Sadar','Habiganj Sadar',NULL,'3300',NULL),(889,63,NULL,'Habiganj Sadar','Shaestaganj',NULL,'3301',NULL),(890,63,NULL,'Kalauk','Kalauk',NULL,'3340',NULL),(891,63,NULL,'Kalauk','Lakhai',NULL,'3341',NULL),(892,63,NULL,'Madhabpur','Itakhola',NULL,'3331',NULL),(893,63,NULL,'Madhabpur','Madhabpur',NULL,'3330',NULL),(894,63,NULL,'Madhabpur','Saihamnagar',NULL,'3333',NULL),(895,63,NULL,'Madhabpur','Shahajibazar',NULL,'3332',NULL),(896,63,NULL,'Nabiganj','Digalbak',NULL,'3373',NULL),(897,63,NULL,'Nabiganj','Golduba',NULL,'3372',NULL),(898,63,NULL,'Nabiganj','Goplarbazar',NULL,'3371',NULL),(899,63,NULL,'Nabiganj','Inathganj',NULL,'3374',NULL),(900,63,NULL,'Nabiganj','Nabiganj',NULL,'3370',NULL),(901,62,NULL,'Baralekha','Baralekha',NULL,'3250',NULL),(902,62,NULL,'Baralekha','Dhakkhinbag',NULL,'3252',NULL),(903,62,NULL,'Baralekha','Juri',NULL,'3251',NULL),(904,62,NULL,'Baralekha','Purbashahabajpur',NULL,'3253',NULL),(905,62,NULL,'Kamalganj','Kamalganj',NULL,'3220',NULL),(906,62,NULL,'Kamalganj','Keramatnaga',NULL,'3221',NULL),(907,62,NULL,'Kamalganj','Munshibazar',NULL,'3224',NULL),(908,62,NULL,'Kamalganj','Patrakhola',NULL,'3222',NULL),(909,62,NULL,'Kamalganj','Shamsher Nagar',NULL,'3223',NULL),(910,62,NULL,'Kulaura','Baramchal',NULL,'3237',NULL),(911,62,NULL,'Kulaura','Kajaldhara',NULL,'3234',NULL),(912,62,NULL,'Kulaura','Karimpur',NULL,'3235',NULL),(913,62,NULL,'Kulaura','Kulaura',NULL,'3230',NULL),(914,62,NULL,'Kulaura','Langla',NULL,'3232',NULL),(915,62,NULL,'Kulaura','Prithimpasha',NULL,'3233',NULL),(916,62,NULL,'Kulaura','Tillagaon',NULL,'3231',NULL),(917,62,NULL,'Moulvibazar Sadar','Afrozganj',NULL,'3203',NULL),(918,62,NULL,'Moulvibazar Sadar','Barakapan',NULL,'3201',NULL),(919,62,NULL,'Moulvibazar Sadar','Monumukh',NULL,'3202',NULL),(920,62,NULL,'Moulvibazar Sadar','Moulvibazar Sadar',NULL,'3200',NULL),(921,62,NULL,'Rajnagar','Rajnagar',NULL,'3240',NULL),(922,62,NULL,'Srimangal','Kalighat',NULL,'3212',NULL),(923,62,NULL,'Srimangal','Khejurichhara',NULL,'3213',NULL),(924,62,NULL,'Srimangal','Narain Chora',NULL,'3211',NULL),(925,62,NULL,'Srimangal','Satgaon',NULL,'3214',NULL),(926,62,NULL,'Srimangal','Srimangal',NULL,'3210',NULL),(927,64,NULL,'Bishamsarpur','Bishamsapur',NULL,'3010',NULL),(928,64,NULL,'Chhatak','Chhatak',NULL,'3080',NULL),(929,64,NULL,'Chhatak','Chhatak Cement Facto',NULL,'3081',NULL),(930,64,NULL,'Chhatak','Chhatak Paper Mills',NULL,'3082',NULL),(931,64,NULL,'Chhatak','Chourangi Bazar',NULL,'3893',NULL),(932,64,NULL,'Chhatak','Gabindaganj',NULL,'3083',NULL),(933,64,NULL,'Chhatak','Gabindaganj Natun Ba',NULL,'3084',NULL),(934,64,NULL,'Chhatak','Islamabad',NULL,'3088',NULL),(935,64,NULL,'Chhatak','jahidpur',NULL,'3087',NULL),(936,64,NULL,'Chhatak','Khurma',NULL,'3085',NULL),(937,64,NULL,'Chhatak','Moinpur',NULL,'3086',NULL),(938,64,NULL,'Dhirai Chandpur','Dhirai Chandpur',NULL,'3040',NULL),(939,64,NULL,'Dhirai Chandpur','Jagdal',NULL,'3041',NULL),(940,64,NULL,'Duara bazar','Duara bazar',NULL,'3070',NULL),(941,64,NULL,'Ghungiar','Ghungiar',NULL,'3050',NULL),(942,64,NULL,'Jagnnathpur','Atuajan',NULL,'3062',NULL),(943,64,NULL,'Jagnnathpur','Hasan Fatemapur',NULL,'3063',NULL),(944,64,NULL,'Jagnnathpur','Jagnnathpur',NULL,'3060',NULL),(945,64,NULL,'Jagnnathpur','Rasulganj',NULL,'3064',NULL),(946,64,NULL,'Jagnnathpur','Shiramsi',NULL,'3065',NULL),(947,64,NULL,'Jagnnathpur','Syedpur',NULL,'3061',NULL),(948,64,NULL,'Sachna','Sachna',NULL,'3020',NULL),(949,64,NULL,'Sunamganj Sadar','Pagla',NULL,'3001',NULL),(950,64,NULL,'Sunamganj Sadar','Patharia',NULL,'3002',NULL),(951,64,NULL,'Sunamganj Sadar','Sunamganj Sadar',NULL,'3000',NULL),(952,64,NULL,'Tahirpur','Tahirpur',NULL,'3030',NULL),(953,61,NULL,'Balaganj','Balaganj',NULL,'3120',NULL),(954,61,NULL,'Balaganj','Begumpur',NULL,'3125',NULL),(955,61,NULL,'Balaganj','Brahman Shashon',NULL,'3122',NULL),(956,61,NULL,'Balaganj','Gaharpur',NULL,'3128',NULL),(957,61,NULL,'Balaganj','Goala Bazar',NULL,'3124',NULL),(958,61,NULL,'Balaganj','Karua',NULL,'3121',NULL),(959,61,NULL,'Balaganj','Kathal Khair',NULL,'3127',NULL),(960,61,NULL,'Balaganj','Natun Bazar',NULL,'3129',NULL),(961,61,NULL,'Balaganj','Omarpur',NULL,'3126',NULL),(962,61,NULL,'Balaganj','Tajpur',NULL,'3123',NULL),(963,61,NULL,'Bianibazar','Bianibazar',NULL,'3170',NULL),(964,61,NULL,'Bianibazar','Churkai',NULL,'3175',NULL),(965,61,NULL,'Bianibazar','jaldup',NULL,'3171',NULL),(966,61,NULL,'Bianibazar','Kurar bazar',NULL,'3173',NULL),(967,61,NULL,'Bianibazar','Mathiura',NULL,'3172',NULL),(968,61,NULL,'Bianibazar','Salia bazar',NULL,'3174',NULL),(969,61,NULL,'Bishwanath','Bishwanath',NULL,'3130',NULL),(970,61,NULL,'Bishwanath','Dashghar',NULL,'3131',NULL),(971,61,NULL,'Bishwanath','Deokalas',NULL,'3133',NULL),(972,61,NULL,'Bishwanath','Doulathpur',NULL,'3132',NULL),(973,61,NULL,'Bishwanath','Singer kanch',NULL,'3134',NULL),(974,61,NULL,'Fenchuganj','Fenchuganj',NULL,'3116',NULL),(975,61,NULL,'Fenchuganj','Fenchuganj SareKarkh',NULL,'3117',NULL),(976,61,NULL,'Goainhat','Chiknagul',NULL,'3152',NULL),(977,61,NULL,'Goainhat','Goainhat',NULL,'3150',NULL),(978,61,NULL,'Goainhat','Jaflong',NULL,'3151',NULL),(979,61,NULL,'Gopalganj','banigram',NULL,'3164',NULL),(980,61,NULL,'Gopalganj','Chandanpur',NULL,'3165',NULL),(981,61,NULL,'Gopalganj','Dakkhin Bhadashore',NULL,'3162',NULL),(982,61,NULL,'Gopalganj','Dhaka Dakkhin',NULL,'3161',NULL),(983,61,NULL,'Gopalganj','Gopalgannj',NULL,'3160',NULL),(984,61,NULL,'Gopalganj','Ranaping',NULL,'3163',NULL),(985,61,NULL,'Jaintapur','Jainthapur',NULL,'3156',NULL),(986,61,NULL,'Jakiganj','Ichhamati',NULL,'3191',NULL),(987,61,NULL,'Jakiganj','Jakiganj',NULL,'3190',NULL),(988,61,NULL,'Kanaighat','Chatulbazar',NULL,'3181',NULL),(989,61,NULL,'Kanaighat','Gachbari',NULL,'3183',NULL),(990,61,NULL,'Kanaighat','Kanaighat',NULL,'3180',NULL),(991,61,NULL,'Kanaighat','Manikganj',NULL,'3182',NULL),(992,61,NULL,'Kompanyganj','Kompanyganj',NULL,'3140',NULL),(993,61,NULL,'Sylhet Sadar','Birahimpur',NULL,'3106',NULL),(994,61,NULL,'Sylhet Sadar','Jalalabad',NULL,'3107',NULL),(995,61,NULL,'Sylhet Sadar','Jalalabad Cantoment',NULL,'3104',NULL),(996,61,NULL,'Sylhet Sadar','Kadamtali',NULL,'3111',NULL),(997,61,NULL,'Sylhet Sadar','Kamalbazer',NULL,'3112',NULL),(998,61,NULL,'Sylhet Sadar','Khadimnagar',NULL,'3103',NULL),(999,61,NULL,'Sylhet Sadar','Lalbazar',NULL,'3113',NULL),(1000,61,NULL,'Sylhet Sadar','Mogla',NULL,'3108',NULL),(1001,61,NULL,'Sylhet Sadar','Ranga Hajiganj',NULL,'3109',NULL),(1002,61,NULL,'Sylhet Sadar','Shahajalal Science &',NULL,'3114',NULL),(1003,61,NULL,'Sylhet Sadar','Silam',NULL,'3105',NULL),(1004,61,NULL,'Sylhet Sadar','Sylhe Sadar',NULL,'3100',NULL),(1005,61,NULL,'Sylhet Sadar','Sylhet Biman Bondar',NULL,'3102',NULL),(1006,61,NULL,'Sylhet Sadar','Sylhet Cadet Col',NULL,'3101',NULL),(1007,52,NULL,'Amtali','Amtali',NULL,'8710',NULL),(1008,52,NULL,'Bamna','Bamna',NULL,'8730',NULL),(1009,52,NULL,'Barguna Sadar','Barguna Sadar',NULL,'8700',NULL),(1010,52,NULL,'Barguna Sadar','Nali Bandar',NULL,'8701',NULL),(1011,52,NULL,'Betagi','Betagi',NULL,'8740',NULL),(1012,52,NULL,'Betagi','Darul Ulam',NULL,'8741',NULL),(1013,52,NULL,'Patharghata','Kakchira',NULL,'8721',NULL),(1014,52,NULL,'Patharghata','Patharghata',NULL,'8720',NULL),(1015,50,NULL,'Agailzhara','Agailzhara',NULL,'8240',NULL),(1016,50,NULL,'Agailzhara','Gaila',NULL,'8241',NULL),(1017,50,NULL,'Agailzhara','Paisarhat',NULL,'8242',NULL),(1018,50,NULL,'Babuganj','Babuganj',NULL,'8210',NULL),(1019,50,NULL,'Babuganj','Barisal Cadet',NULL,'8216',NULL),(1020,50,NULL,'Babuganj','Chandpasha',NULL,'8212',NULL),(1021,50,NULL,'Babuganj','Madhabpasha',NULL,'8213',NULL),(1022,50,NULL,'Babuganj','Nizamuddin College',NULL,'8215',NULL),(1023,50,NULL,'Babuganj','Rahamatpur',NULL,'8211',NULL),(1024,50,NULL,'Babuganj','Thakur Mallik',NULL,'8214',NULL),(1025,50,NULL,'Barajalia','Barajalia',NULL,'8260',NULL),(1026,50,NULL,'Barajalia','Osman Manjil',NULL,'8261',NULL),(1027,50,NULL,'Barisal Sadar','Barisal Sadar',NULL,'8200',NULL),(1028,50,NULL,'Barisal Sadar','Bukhainagar',NULL,'8201',NULL),(1029,50,NULL,'Barisal Sadar','Jaguarhat',NULL,'8206',NULL),(1030,50,NULL,'Barisal Sadar','Kashipur',NULL,'8205',NULL),(1031,50,NULL,'Barisal Sadar','Patang',NULL,'8204',NULL),(1032,50,NULL,'Barisal Sadar','Saheberhat',NULL,'8202',NULL),(1033,50,NULL,'Barisal Sadar','Sugandia',NULL,'8203',NULL),(1034,50,NULL,'Gouranadi','Batajor',NULL,'8233',NULL),(1035,50,NULL,'Gouranadi','Gouranadi',NULL,'8230',NULL),(1036,50,NULL,'Gouranadi','Kashemabad',NULL,'8232',NULL),(1037,50,NULL,'Gouranadi','Tarki Bandar',NULL,'8231',NULL),(1038,50,NULL,'Mahendiganj','Langutia',NULL,'8274',NULL),(1039,50,NULL,'Mahendiganj','Laskarpur',NULL,'8271',NULL),(1040,50,NULL,'Mahendiganj','Mahendiganj',NULL,'8270',NULL),(1041,50,NULL,'Mahendiganj','Nalgora',NULL,'8273',NULL),(1042,50,NULL,'Mahendiganj','Ulania',NULL,'8272',NULL),(1043,50,NULL,'Muladi','Charkalekhan',NULL,'8252',NULL),(1044,50,NULL,'Muladi','Kazirchar',NULL,'8251',NULL),(1045,50,NULL,'Muladi','Muladi',NULL,'8250',NULL),(1046,50,NULL,'Sahebganj','Charamandi',NULL,'8281',NULL),(1047,50,NULL,'Sahebganj','kalaskati',NULL,'8284',NULL),(1048,50,NULL,'Sahebganj','Padri Shibpur',NULL,'8282',NULL),(1049,50,NULL,'Sahebganj','Sahebganj',NULL,'8280',NULL),(1050,50,NULL,'Sahebganj','Shialguni',NULL,'8283',NULL),(1051,50,NULL,'Uzirpur','Dakuarhat',NULL,'8223',NULL),(1052,50,NULL,'Uzirpur','Dhamura',NULL,'8221',NULL),(1053,50,NULL,'Uzirpur','Jugirkanda',NULL,'8222',NULL),(1054,50,NULL,'Uzirpur','Shikarpur',NULL,'8224',NULL),(1055,50,NULL,'Uzirpur','Uzirpur',NULL,'8220',NULL),(1056,51,NULL,'Bhola Sadar','Bhola Sadar',NULL,'8300',NULL),(1057,51,NULL,'Bhola Sadar','Joynagar',NULL,'8301',NULL),(1058,51,NULL,'Borhanuddin UPO','Borhanuddin UPO',NULL,'8320',NULL),(1059,51,NULL,'Borhanuddin UPO','Mirzakalu',NULL,'8321',NULL),(1060,51,NULL,'Charfashion','Charfashion',NULL,'8340',NULL),(1061,51,NULL,'Charfashion','Dularhat',NULL,'8341',NULL),(1062,51,NULL,'Charfashion','Keramatganj',NULL,'8342',NULL),(1063,51,NULL,'Doulatkhan','Doulatkhan',NULL,'8310',NULL),(1064,51,NULL,'Doulatkhan','Hajipur',NULL,'8311',NULL),(1065,51,NULL,'Hajirhat','Hajirhat',NULL,'8360',NULL),(1066,51,NULL,'Hatshoshiganj','Hatshoshiganj',NULL,'8350',NULL),(1067,51,NULL,'Lalmohan UPO','Daurihat',NULL,'8331',NULL),(1068,51,NULL,'Lalmohan UPO','Gazaria',NULL,'8332',NULL),(1069,51,NULL,'Lalmohan UPO','Lalmohan UPO',NULL,'8330',NULL),(1070,47,NULL,'Jhalakathi Sadar','Baukathi',NULL,'8402',NULL),(1071,47,NULL,'Jhalakathi Sadar','Gabha',NULL,'8403',NULL),(1072,47,NULL,'Jhalakathi Sadar','Jhalakathi Sadar',NULL,'8400',NULL),(1073,47,NULL,'Jhalakathi Sadar','Nabagram',NULL,'8401',NULL),(1074,47,NULL,'Jhalakathi Sadar','Shekherhat',NULL,'8404',NULL),(1075,47,NULL,'Kathalia','Amua',NULL,'8431',NULL),(1076,47,NULL,'Kathalia','Kathalia',NULL,'8430',NULL),(1077,47,NULL,'Kathalia','Niamatee',NULL,'8432',NULL),(1078,47,NULL,'Kathalia','Shoulajalia',NULL,'8433',NULL),(1079,47,NULL,'Nalchhiti','Beerkathi',NULL,'8421',NULL),(1080,47,NULL,'Nalchhiti','Nalchhiti',NULL,'8420',NULL),(1081,47,NULL,'Rajapur','Rajapur',NULL,'8410',NULL),(1082,48,NULL,'Bauphal','Bagabandar',NULL,'8621',NULL),(1083,48,NULL,'Bauphal','Bauphal',NULL,'8620',NULL),(1084,48,NULL,'Bauphal','Birpasha',NULL,'8622',NULL),(1085,48,NULL,'Bauphal','Kalaia',NULL,'8624',NULL),(1086,48,NULL,'Bauphal','Kalishari',NULL,'8623',NULL),(1087,48,NULL,'Dashmina','Dashmina',NULL,'8630',NULL),(1088,48,NULL,'Galachipa','Galachipa',NULL,'8640',NULL),(1089,48,NULL,'Galachipa','Gazipur Bandar',NULL,'8641',NULL),(1090,48,NULL,'Khepupara','Khepupara',NULL,'8650',NULL),(1091,48,NULL,'Khepupara','Mahipur',NULL,'8651',NULL),(1092,48,NULL,'Patuakhali Sadar','Dumkee',NULL,'8602',NULL),(1093,48,NULL,'Patuakhali Sadar','Moukaran',NULL,'8601',NULL),(1094,48,NULL,'Patuakhali Sadar','Patuakhali Sadar',NULL,'8600',NULL),(1095,48,NULL,'Patuakhali Sadar','Rahimabad',NULL,'8603',NULL),(1096,48,NULL,'Subidkhali','Subidkhali',NULL,'8610',NULL),(1097,49,NULL,'Banaripara','Banaripara',NULL,'8530',NULL),(1098,49,NULL,'Banaripara','Chakhar',NULL,'8531',NULL),(1099,49,NULL,'Bhandaria','Bhandaria',NULL,'8550',NULL),(1100,49,NULL,'Bhandaria','Dhaoa',NULL,'8552',NULL),(1101,49,NULL,'Bhandaria','Kanudashkathi',NULL,'8551',NULL),(1102,49,NULL,'kaukhali','Jolagati',NULL,'8513',NULL),(1103,49,NULL,'kaukhali','Joykul',NULL,'8512',NULL),(1104,49,NULL,'kaukhali','Kaukhali',NULL,'8510',NULL),(1105,49,NULL,'kaukhali','Keundia',NULL,'8511',NULL),(1106,49,NULL,'Mathbaria','Betmor Natun Hat',NULL,'8565',NULL),(1107,49,NULL,'Mathbaria','Gulishakhali',NULL,'8563',NULL),(1108,49,NULL,'Mathbaria','Halta',NULL,'8562',NULL),(1109,49,NULL,'Mathbaria','Mathbaria',NULL,'8560',NULL),(1110,49,NULL,'Mathbaria','Shilarganj',NULL,'8566',NULL),(1111,49,NULL,'Mathbaria','Tiarkhali',NULL,'8564',NULL),(1112,49,NULL,'Mathbaria','Tushkhali',NULL,'8561',NULL),(1113,49,NULL,'Nazirpur','Nazirpur',NULL,'8540',NULL),(1114,49,NULL,'Nazirpur','Sriramkathi',NULL,'8541',NULL),(1115,49,NULL,'Pirojpur Sadar','Hularhat',NULL,'8501',NULL),(1116,49,NULL,'Pirojpur Sadar','Parerhat',NULL,'8502',NULL),(1117,49,NULL,'Pirojpur Sadar','Pirojpur Sadar',NULL,'8500',NULL),(1118,49,NULL,'Swarupkathi','Darus Sunnat',NULL,'8521',NULL),(1119,49,NULL,'Swarupkathi','Jalabari',NULL,'8523',NULL),(1120,49,NULL,'Swarupkathi','Kaurikhara',NULL,'8522',NULL),(1121,49,NULL,'Swarupkathi','Swarupkathi',NULL,'8520',NULL),(1122,31,NULL,'Alamdighi','Adamdighi',NULL,'5890',NULL),(1123,31,NULL,'Alamdighi','Nasharatpur',NULL,'5892',NULL),(1124,31,NULL,'Alamdighi','Santahar',NULL,'5891',NULL),(1125,31,NULL,'Bogra Sadar','Bogra Canttonment',NULL,'5801',NULL),(1126,31,NULL,'Bogra Sadar','Bogra Sadar',NULL,'5800',NULL),(1127,31,NULL,'Dhunat','Dhunat',NULL,'5850',NULL),(1128,31,NULL,'Dhunat','Gosaibari',NULL,'5851',NULL),(1129,31,NULL,'Dupchachia','Dupchachia',NULL,'5880',NULL),(1130,31,NULL,'Dupchachia','Talora',NULL,'5881',NULL),(1131,31,NULL,'Gabtoli','Gabtoli',NULL,'5820',NULL),(1132,31,NULL,'Gabtoli','Sukhanpukur',NULL,'5821',NULL),(1133,31,NULL,'Kahalu','Kahalu',NULL,'5870',NULL),(1134,31,NULL,'Nandigram','Nandigram',NULL,'5860',NULL),(1135,31,NULL,'Sariakandi','Chandan Baisha',NULL,'5831',NULL),(1136,31,NULL,'Sariakandi','Sariakandi',NULL,'5830',NULL),(1137,31,NULL,'Sherpur','Chandaikona',NULL,'5841',NULL),(1138,31,NULL,'Sherpur','Palli Unnyan Accadem',NULL,'5842',NULL),(1139,31,NULL,'Sherpur','Sherpur',NULL,'5840',NULL),(1140,31,NULL,'Shibganj','Shibganj',NULL,'5810',NULL),(1141,31,NULL,'Sonatola','Sonatola',NULL,'5826',NULL),(1142,35,NULL,'Bholahat','Bholahat',NULL,'6330',NULL),(1143,35,NULL,'Chapainawabganj Sadar','Amnura',NULL,'6303',NULL),(1144,35,NULL,'Chapainawabganj Sadar','Chapinawbganj Sadar',NULL,'6300',NULL),(1145,35,NULL,'Chapainawabganj Sadar','Rajarampur',NULL,'6301',NULL),(1146,35,NULL,'Chapainawabganj Sadar','Ramchandrapur',NULL,'6302',NULL),(1147,35,NULL,'Nachol','Mandumala',NULL,'6311',NULL),(1148,35,NULL,'Nachol','Nachol',NULL,'6310',NULL),(1149,35,NULL,'Rohanpur','Gomashtapur',NULL,'6321',NULL),(1150,35,NULL,'Rohanpur','Rohanpur',NULL,'6320',NULL),(1151,35,NULL,'Shibganj U.P.O','Kansart',NULL,'6341',NULL),(1152,35,NULL,'Shibganj U.P.O','Manaksha',NULL,'6342',NULL),(1153,35,NULL,'Shibganj U.P.O','Shibganj U.P.O',NULL,'6340',NULL),(1154,34,NULL,'Akkelpur','Akklepur',NULL,'5940',NULL),(1155,34,NULL,'Akkelpur','jamalganj',NULL,'5941',NULL),(1156,34,NULL,'Akkelpur','Tilakpur',NULL,'5942',NULL),(1157,34,NULL,'Joypurhat Sadar','Joypurhat Sadar',NULL,'5900',NULL),(1158,34,NULL,'kalai','kalai',NULL,'5930',NULL),(1159,34,NULL,'Khetlal','Khetlal',NULL,'5920',NULL),(1160,34,NULL,'panchbibi','Panchbibi',NULL,'5910',NULL),(1161,36,NULL,'Ahsanganj','Ahsanganj',NULL,'6596',NULL),(1162,36,NULL,'Ahsanganj','Bandai',NULL,'6597',NULL),(1163,36,NULL,'Badalgachhi','Badalgachhi',NULL,'6570',NULL),(1164,36,NULL,'Dhamuirhat','Dhamuirhat',NULL,'6580',NULL),(1165,36,NULL,'Mahadebpur','Mahadebpur',NULL,'6530',NULL),(1166,36,NULL,'Naogaon Sadar','Naogaon Sadar',NULL,'6500',NULL),(1167,36,NULL,'Niamatpur','Niamatpur',NULL,'6520',NULL),(1168,36,NULL,'Nitpur','Nitpur',NULL,'6550',NULL),(1169,36,NULL,'Nitpur','Panguria',NULL,'6552',NULL),(1170,36,NULL,'Nitpur','Porsa',NULL,'6551',NULL),(1171,36,NULL,'Patnitala','Patnitala',NULL,'6540',NULL),(1172,36,NULL,'Prasadpur','Balihar',NULL,'6512',NULL),(1173,36,NULL,'Prasadpur','Manda',NULL,'6511',NULL),(1174,36,NULL,'Prasadpur','Prasadpur',NULL,'6510',NULL),(1175,36,NULL,'Raninagar','Kashimpur',NULL,'6591',NULL),(1176,36,NULL,'Raninagar','Raninagar',NULL,'6590',NULL),(1177,36,NULL,'Sapahar','Moduhil',NULL,'6561',NULL),(1178,36,NULL,'Sapahar','Sapahar',NULL,'6560',NULL),(1179,33,NULL,'Gopalpur UPO','Abdulpur',NULL,'6422',NULL),(1180,33,NULL,'Gopalpur UPO','Gopalpur U.P.O',NULL,'6420',NULL),(1181,33,NULL,'Gopalpur UPO','Lalpur S.O',NULL,'6421',NULL),(1182,33,NULL,'Harua','Baraigram',NULL,'6432',NULL),(1183,33,NULL,'Harua','Dayarampur',NULL,'6431',NULL),(1184,33,NULL,'Harua','Harua',NULL,'6430',NULL),(1185,33,NULL,'Hatgurudaspur','Hatgurudaspur',NULL,'6440',NULL),(1186,33,NULL,'Laxman','Laxman',NULL,'6410',NULL),(1187,33,NULL,'Natore Sadar','Baiddyabal Gharia',NULL,'6402',NULL),(1188,33,NULL,'Natore Sadar','Digapatia',NULL,'6401',NULL),(1189,33,NULL,'Natore Sadar','Madhnagar',NULL,'6403',NULL),(1190,33,NULL,'Natore Sadar','Natore Sadar',NULL,'6400',NULL),(1191,33,NULL,'Singra','Singra',NULL,'6450',NULL),(1192,30,NULL,'Banwarinagar','Banwarinagar',NULL,'6650',NULL),(1193,30,NULL,'Bera','Bera',NULL,'6680',NULL),(1194,30,NULL,'Bera','Kashinathpur',NULL,'6682',NULL),(1195,30,NULL,'Bera','Nakalia',NULL,'6681',NULL),(1196,30,NULL,'Bera','Puran Bharenga',NULL,'6683',NULL),(1197,30,NULL,'Bhangura','Bhangura',NULL,'6640',NULL),(1198,30,NULL,'Chatmohar','Chatmohar',NULL,'6630',NULL),(1199,30,NULL,'Debottar','Debottar',NULL,'6610',NULL),(1200,30,NULL,'Ishwardi','Dhapari',NULL,'6621',NULL),(1201,30,NULL,'Ishwardi','Ishwardi',NULL,'6620',NULL),(1202,30,NULL,'Ishwardi','Pakshi',NULL,'6622',NULL),(1203,30,NULL,'Ishwardi','Rajapur',NULL,'6623',NULL),(1204,30,NULL,'Pabna Sadar','Hamayetpur',NULL,'6602',NULL),(1205,30,NULL,'Pabna Sadar','Kaliko Cotton Mills',NULL,'6601',NULL),(1206,30,NULL,'Pabna Sadar','Pabna Sadar',NULL,'6600',NULL),(1207,30,NULL,'Sathia','Sathia',NULL,'6670',NULL),(1208,30,NULL,'Sujanagar','Sagarkandi',NULL,'6661',NULL),(1209,30,NULL,'Sujanagar','Sujanagar',NULL,'6660',NULL),(1210,32,NULL,'Bagha','Arani',NULL,'6281',NULL),(1211,32,NULL,'Bagha','Bagha',NULL,'6280',NULL),(1212,32,NULL,'Bhabaniganj','Bhabaniganj',NULL,'6250',NULL),(1213,32,NULL,'Bhabaniganj','Taharpur',NULL,'6251',NULL),(1214,32,NULL,'Charghat','Charghat',NULL,'6270',NULL),(1215,32,NULL,'Charghat','Sarda',NULL,'6271',NULL),(1216,32,NULL,'Durgapur','Durgapur',NULL,'6240',NULL),(1217,32,NULL,'Godagari','Godagari',NULL,'6290',NULL),(1218,32,NULL,'Godagari','Premtoli',NULL,'6291',NULL),(1219,32,NULL,'Khod Mohanpur','Khodmohanpur',NULL,'6220',NULL),(1220,32,NULL,'Lalitganj','Lalitganj',NULL,'6210',NULL),(1221,32,NULL,'Lalitganj','Rajshahi Sugar Mills',NULL,'6211',NULL),(1222,32,NULL,'Lalitganj','Shyampur',NULL,'6212',NULL),(1223,32,NULL,'Putia','Putia',NULL,'6260',NULL),(1224,32,NULL,'Rajshahi Sadar','Binodpur Bazar',NULL,'6206',NULL),(1225,32,NULL,'Rajshahi Sadar','Ghuramara',NULL,'6100',NULL),(1226,32,NULL,'Rajshahi Sadar','Kazla',NULL,'6204',NULL),(1227,32,NULL,'Rajshahi Sadar','Rajshahi Canttonment',NULL,'6202',NULL),(1228,32,NULL,'Rajshahi Sadar','Rajshahi Court',NULL,'6201',NULL),(1229,32,NULL,'Rajshahi Sadar','Rajshahi Sadar',NULL,'6000',NULL),(1230,32,NULL,'Rajshahi Sadar','Rajshahi University',NULL,'6205',NULL),(1231,32,NULL,'Rajshahi Sadar','Sapura',NULL,'6203',NULL),(1232,32,NULL,'Tanor','Tanor',NULL,'6230',NULL),(1233,29,NULL,'Baiddya Jam Toil','Baiddya Jam Toil',NULL,'6730',NULL),(1234,29,NULL,'Belkuchi','Belkuchi',NULL,'6740',NULL),(1235,29,NULL,'Belkuchi','Enayetpur',NULL,'6751',NULL),(1236,29,NULL,'Belkuchi','Rajapur',NULL,'6742',NULL),(1237,29,NULL,'Belkuchi','Sohagpur',NULL,'6741',NULL),(1238,29,NULL,'Belkuchi','Sthal',NULL,'6752',NULL),(1239,29,NULL,'Dhangora','Dhangora',NULL,'6720',NULL),(1240,29,NULL,'Dhangora','Malonga',NULL,'6721',NULL),(1241,29,NULL,'Kazipur','Gandail',NULL,'6712',NULL),(1242,29,NULL,'Kazipur','Kazipur',NULL,'6710',NULL),(1243,29,NULL,'Kazipur','Shuvgachha',NULL,'6711',NULL),(1244,29,NULL,'Shahjadpur','Jamirta',NULL,'6772',NULL),(1245,29,NULL,'Shahjadpur','Kaijuri',NULL,'6773',NULL),(1246,29,NULL,'Shahjadpur','Porjana',NULL,'6771',NULL),(1247,29,NULL,'Shahjadpur','Shahjadpur',NULL,'6770',NULL),(1248,29,NULL,'Sirajganj Sadar','Raipur',NULL,'6701',NULL),(1249,29,NULL,'Sirajganj Sadar','Rashidabad',NULL,'6702',NULL),(1250,29,NULL,'Sirajganj Sadar','Sirajganj Sadar',NULL,'6700',NULL),(1251,29,NULL,'Tarash','Tarash',NULL,'6780',NULL),(1252,29,NULL,'Ullapara','Lahiri Mohanpur',NULL,'6762',NULL),(1253,29,NULL,'Ullapara','Salap',NULL,'6763',NULL),(1254,29,NULL,'Ullapara','Ullapara',NULL,'6760',NULL),(1255,29,NULL,'Ullapara','Ullapara R.S',NULL,'6761',NULL),(1256,54,NULL,'Bangla Hili','Bangla Hili',NULL,'5270',NULL),(1257,54,NULL,'Biral','Biral',NULL,'5210',NULL),(1258,54,NULL,'Birampur','Birampur',NULL,'5266',NULL),(1259,54,NULL,'Birganj','Birganj',NULL,'5220',NULL),(1260,54,NULL,'Chrirbandar','Chrirbandar',NULL,'5240',NULL),(1261,54,NULL,'Chrirbandar','Ranirbandar',NULL,'5241',NULL),(1262,54,NULL,'Dinajpur Sadar','Dinajpur Rajbari',NULL,'5201',NULL),(1263,54,NULL,'Dinajpur Sadar','Dinajpur Sadar',NULL,'5200',NULL),(1264,54,NULL,'Khansama','Khansama',NULL,'5230',NULL),(1265,54,NULL,'Khansama','Pakarhat',NULL,'5231',NULL),(1266,54,NULL,'Maharajganj','Maharajganj',NULL,'5226',NULL),(1267,54,NULL,'Nababganj','Daudpur',NULL,'5281',NULL),(1268,54,NULL,'Nababganj','Gopalpur',NULL,'5282',NULL),(1269,54,NULL,'Nababganj','Nababganj',NULL,'5280',NULL),(1270,54,NULL,'Osmanpur','Ghoraghat',NULL,'5291',NULL),(1271,54,NULL,'Osmanpur','Osmanpur',NULL,'5290',NULL),(1272,54,NULL,'Parbatipur','Parbatipur',NULL,'5250',NULL),(1273,54,NULL,'Phulbari','Phulbari',NULL,'5260',NULL),(1274,54,NULL,'Setabganj','Setabganj',NULL,'5216',NULL),(1275,57,NULL,'Bonarpara','Bonarpara',NULL,'5750',NULL),(1276,57,NULL,'Bonarpara','saghata',NULL,'5751',NULL),(1277,57,NULL,'Gaibandha Sadar','Gaibandha Sadar',NULL,'5700',NULL),(1278,57,NULL,'Gobindaganj','Gobindhaganj',NULL,'5740',NULL),(1279,57,NULL,'Gobindaganj','Mahimaganj',NULL,'5741',NULL),(1280,57,NULL,'Palashbari','Palashbari',NULL,'5730',NULL),(1281,57,NULL,'Phulchhari','Bharatkhali',NULL,'5761',NULL),(1282,57,NULL,'Phulchhari','Phulchhari',NULL,'5760',NULL),(1283,57,NULL,'Saadullapur','Naldanga',NULL,'5711',NULL),(1284,57,NULL,'Saadullapur','Saadullapur',NULL,'5710',NULL),(1285,57,NULL,'Sundarganj','Bamandanga',NULL,'5721',NULL),(1286,57,NULL,'Sundarganj','Sundarganj',NULL,'5720',NULL),(1287,60,NULL,'Bhurungamari','Bhurungamari',NULL,'5670',NULL),(1288,60,NULL,'Chilmari','Chilmari',NULL,'5630',NULL),(1289,60,NULL,'Chilmari','Jorgachh',NULL,'5631',NULL),(1290,60,NULL,'Kurigram Sadar','Kurigram Sadar',NULL,'5600',NULL),(1291,60,NULL,'Kurigram Sadar','Pandul',NULL,'5601',NULL),(1292,60,NULL,'Kurigram Sadar','Phulbari',NULL,'5680',NULL),(1293,60,NULL,'Nageshwar','Nageshwar',NULL,'5660',NULL),(1294,60,NULL,'Rajarhat','Nazimkhan',NULL,'5611',NULL),(1295,60,NULL,'Rajarhat','Rajarhat',NULL,'5610',NULL),(1296,60,NULL,'Rajibpur','Rajibpur',NULL,'5650',NULL),(1297,60,NULL,'Roumari','Roumari',NULL,'5640',NULL),(1298,60,NULL,'Ulipur','Bazarhat',NULL,'5621',NULL),(1299,60,NULL,'Ulipur','Ulipur',NULL,'5620',NULL),(1300,55,NULL,'Aditmari','Aditmari',NULL,'5510',NULL),(1301,55,NULL,'Hatibandha','Hatibandha',NULL,'5530',NULL),(1302,55,NULL,'Lalmonirhat Sadar','Kulaghat SO',NULL,'5502',NULL),(1303,55,NULL,'Lalmonirhat Sadar','Lalmonirhat Sadar',NULL,'5500',NULL),(1304,55,NULL,'Lalmonirhat Sadar','Moghalhat',NULL,'5501',NULL),(1305,55,NULL,'Patgram','Baura',NULL,'5541',NULL),(1306,55,NULL,'Patgram','Burimari',NULL,'5542',NULL),(1307,55,NULL,'Patgram','Patgram',NULL,'5540',NULL),(1308,55,NULL,'Tushbhandar','Tushbhandar',NULL,'5520',NULL),(1309,56,NULL,'Dimla','Dimla',NULL,'5350',NULL),(1310,56,NULL,'Dimla','Ghaga Kharibari',NULL,'5351',NULL),(1311,56,NULL,'Domar','Chilahati',NULL,'5341',NULL),(1312,56,NULL,'Domar','Domar',NULL,'5340',NULL),(1313,56,NULL,'Jaldhaka','Jaldhaka',NULL,'5330',NULL),(1314,56,NULL,'Kishoriganj','Kishoriganj',NULL,'5320',NULL),(1315,56,NULL,'Nilphamari Sadar','Nilphamari Sadar',NULL,'5300',NULL),(1316,56,NULL,'Nilphamari Sadar','Nilphamari Sugar Mil',NULL,'5301',NULL),(1317,56,NULL,'Syedpur','Syedpur',NULL,'5310',NULL),(1318,56,NULL,'Syedpur','Syedpur Upashahar',NULL,'5311',NULL),(1319,53,NULL,'Boda','Boda',NULL,'5010',NULL),(1320,53,NULL,'Chotto Dab','Chotto Dab',NULL,'5040',NULL),(1321,53,NULL,'Chotto Dab','Mirjapur',NULL,'5041',NULL),(1322,53,NULL,'Dabiganj','Dabiganj',NULL,'5020',NULL),(1323,53,NULL,'Panchagra Sadar','Panchagar Sadar',NULL,'5000',NULL),(1324,53,NULL,'Tetulia','Tetulia',NULL,'5030',NULL),(1325,59,NULL,'Badarganj','Badarganj',NULL,'5430',NULL),(1326,59,NULL,'Badarganj','Shyampur',NULL,'5431',NULL),(1327,59,NULL,'Gangachara','Gangachara',NULL,'5410',NULL),(1328,59,NULL,'Kaunia','Haragachh',NULL,'5441',NULL),(1329,59,NULL,'Kaunia','Kaunia',NULL,'5440',NULL),(1330,59,NULL,'Mithapukur','Mithapukur',NULL,'5460',NULL),(1331,59,NULL,'Pirgachha','Pirgachha',NULL,'5450',NULL),(1332,59,NULL,'Rangpur Sadar','Alamnagar',NULL,'5402',NULL),(1333,59,NULL,'Rangpur Sadar','Mahiganj',NULL,'5403',NULL),(1334,59,NULL,'Rangpur Sadar','Rangpur Cadet Colleg',NULL,'5404',NULL),(1335,59,NULL,'Rangpur Sadar','Rangpur Carmiecal Col',NULL,'5405',NULL),(1336,59,NULL,'Rangpur Sadar','Rangpur Sadar',NULL,'5400',NULL),(1337,59,NULL,'Rangpur Sadar','Rangpur Upa-Shahar',NULL,'5401',NULL),(1338,59,NULL,'Taraganj','Taraganj',NULL,'5420',NULL),(1339,58,NULL,'Baliadangi','Baliadangi',NULL,'5140',NULL),(1340,58,NULL,'Baliadangi','Lahiri',NULL,'5141',NULL),(1341,58,NULL,'Jibanpur','Jibanpur',NULL,'5130',NULL),(1342,58,NULL,'Pirganj','Pirganj',NULL,'5110',NULL),(1343,58,NULL,'Pirganj','Pirganj',NULL,'5470',NULL),(1344,58,NULL,'Rani Sankail','Nekmarad',NULL,'5121',NULL),(1345,58,NULL,'Rani Sankail','Rani Sankail',NULL,'5120',NULL),(1346,58,NULL,'Thakurgaon Sadar','Ruhia',NULL,'5103',NULL),(1347,58,NULL,'Thakurgaon Sadar','Shibganj',NULL,'5102',NULL),(1348,58,NULL,'Thakurgaon Sadar','Thakurgaon Road',NULL,'5101',NULL),(1349,58,NULL,'Thakurgaon Sadar','Thakurgaon Sadar',NULL,'5100',NULL);

/*Table structure for table `loc_unions` */

DROP TABLE IF EXISTS `loc_unions`;

CREATE TABLE `loc_unions` (
  `id_union` smallint unsigned NOT NULL AUTO_INCREMENT,
  `upazila_id` smallint unsigned NOT NULL,
  `union_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Union name in English',
  `union_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Union name in Bangla',
  PRIMARY KEY (`id_union`),
  KEY `upazila_id` (`upazila_id`),
  CONSTRAINT `loc_unions_ibfk_1` FOREIGN KEY (`upazila_id`) REFERENCES `loc_upazilas` (`id_upazila`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4475 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_unions` */

insert  into `loc_unions`(`id_union`,`upazila_id`,`union_name_en`,`union_name_bn`) values (1,122,'Barkamta','à¦¬à¦°à¦•à¦¾à¦®à¦¤à¦¾'),(2,122,'Boroshalghor','à¦¬à¦¡à¦¼à¦¶à¦¾à¦²à¦˜à¦°'),(3,122,'Dhampti','à¦§à¦¾à¦®à¦¤à§€'),(4,122,'Elahabad','à¦à¦²à¦¾à¦¹à¦¾à¦¬à¦¾à¦¦'),(5,122,'Fatehabad','à¦«à¦¤à§‡à¦¹à¦¾à¦¬à¦¾à¦¦'),(6,122,'Gunaighornorth','à¦—à§à¦¨à¦¾à¦‡à¦˜à¦° (à¦‰à¦¤à§à¦¤à¦°)'),(7,122,'Gunaighorsouth','à¦—à§à¦¨à¦¾à¦‡à¦˜à¦° (à¦¦à¦•à§à¦·à¦¿à¦£)'),(8,122,'Jafargonj','à¦œà¦¾à¦«à¦°à¦—à¦žà§à¦œ'),(9,122,'Mohanpur','à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(10,122,'Rajameher','à¦°à¦¾à¦œà¦¾à¦®à§‡à¦¹à¦¾à¦°'),(11,122,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(12,122,'Subil','à¦¸à§à¦¬à¦¿à¦²'),(13,122,'Sultanpur','à¦¸à§à¦²à¦¤à¦¾à¦¨à¦ªà§à¦°'),(14,122,'Vani','à¦­à¦¾à¦¨à§€'),(15,122,'Yousufpur','à¦‡à¦‰à¦¸à§à¦«à¦ªà§à¦°'),(16,287,'Bhojgati','à¦­à§‹à¦œà¦—à¦¾à¦¤à¦¿'),(17,287,'Chaluahati','à¦šà¦¾à¦²à§à¦¯à¦¼à¦¾à¦¹à¦¾à¦Ÿà¦¿'),(18,287,'Dhakuria','à¦¢à¦¾à¦•à§à¦°à¦¿à¦¯à¦¼à¦¾'),(19,287,'Durbadanga','à¦¦à§à¦°à§à¦¬à¦¾à¦¡à¦¾à¦‚à¦—à¦¾'),(20,287,'Haridaskati','à¦¹à¦°à¦¿à¦¦à¦¾à¦¸à¦•à¦¾à¦Ÿà¦¿'),(21,287,'Hariharnagar','à¦¹à¦°à¦¿à¦¹à¦°à¦¨à¦—à¦°'),(22,287,'Jhanpa','à¦à¦¾à¦à¦ªà¦¾'),(23,287,'Kashimnagar','à¦•à¦¾à¦¶à¦¿à¦®à¦¨à¦—à¦°'),(24,287,'Khanpur','à¦–à¦¾à¦¨à¦ªà§à¦°'),(25,287,'Khedapara','à¦–à§‡à¦¦à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(26,287,'Kultia','à¦•à§à¦²à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(27,287,'Manirampur','à¦®à¦¨à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(28,287,'Manoharpur','à¦®à¦¨à§‹à¦¹à¦°à¦ªà§à¦°'),(29,287,'Maswimnagar','à¦®à¦¶à§à¦®à¦¿à¦®à¦¨à¦—à¦°'),(30,287,'Nehalpur','à¦¨à§‡à¦¹à¦¾à¦²à¦ªà§à¦°'),(31,287,'Rohita','à¦°à§‹à¦¹à¦¿à¦¤à¦¾'),(32,287,'Shyamkur','à¦¶à§à¦¯à¦¾à¦®à¦•à§à¦¡à¦¼'),(33,1,'Amlaba','à¦†à¦®à¦²à¦¾à¦¬'),(34,1,'Bajnaba','à¦¬à¦¾à¦œà¦¨à¦¾à¦¬'),(35,1,'Belabo','à¦¬à§‡à¦²à¦¾à¦¬'),(36,1,'Binnabayd','à¦¬à¦¿à¦¨à§à¦¨à¦¾à¦¬à¦¾à¦‡à¦¦'),(37,1,'Charuzilab','à¦šà¦°à¦‰à¦œà¦¿à¦²à¦¾à¦¬'),(38,1,'Diara','à¦¦à§‡à§Ÿà¦¾à¦°à¦¾'),(39,1,'Naraynpur','à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦ªà§à¦°'),(40,1,'Patuli','à¦ªà¦¾à¦Ÿà§à¦²à§€'),(41,1,'Sallabad','à¦¸à¦²à§à¦²à¦¾à¦¬à¦¾à¦¦'),(42,2,'Barachapa','à¦¬à§œà¦šà¦¾à¦ªà¦¾'),(43,2,'Chalakchar','à¦šà¦¾à¦²à¦¾à¦•à¦šà¦°'),(44,2,'Chandanbari','à¦šà¦¨à§à¦¦à¦¨à¦¬à¦¾à§œà§€'),(45,2,'Charmandalia','à¦šà¦°à¦®à¦¾à¦¨à§à¦¦à¦¾à¦²à¦¿à§Ÿà¦¾'),(46,2,'Dawlatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(47,2,'Ekduaria','à¦à¦•à¦¦à§à§Ÿà¦¾à¦°à¦¿à§Ÿà¦¾'),(48,2,'Gotashia','à¦—à§‹à¦¤à¦¾à¦¶à¦¿à§Ÿà¦¾'),(49,2,'Kanchikata','à¦•à¦¾à¦šà¦¿à¦•à¦¾à¦Ÿà¦¾'),(50,2,'Khidirpur','à¦–à¦¿à¦¦à¦¿à¦°à¦ªà§à¦°'),(51,2,'Krisnopur','à¦•à§ƒà¦·à§à¦£à¦ªà§à¦° '),(52,2,'Labutala','à¦²à§‡à¦¬à§à¦¤à¦²à¦¾'),(53,2,'Shukundi','à¦¶à§à¦•à§à¦¨à§à¦¦à¦¿'),(54,3,'Alokbali','à¦†à¦²à§‹à¦•à¦¬à¦¾à¦²à§€'),(55,3,'Amdia','à¦†à¦®à¦¦à¦¿à§Ÿà¦¾ à§¨'),(56,3,'Chardighaldi','à¦šà¦°à¦¦à¦¿à¦˜à¦²à¦¦à§€'),(57,3,'Chinishpur',''),(58,3,'Hajipur',''),(59,3,'Karimpur','à¦•à¦°à¦¿à¦®à¦ªà§à¦°'),(60,3,'Khathalia','à¦•à¦¾à¦ à¦¾à¦²à¦¿à§Ÿà¦¾'),(61,3,'Mahishasura','à¦®à¦¹à¦¿à¦·à¦¾à¦¶à§à§œà¦¾'),(62,3,'Meherpara','à¦®à§‡à¦¹à§‡à§œà¦ªà¦¾à§œà¦¾'),(63,3,'Nazarpur','à¦¨à¦œà¦°à¦ªà§à¦°'),(64,3,'Nuralapur','à¦¨à§‚à¦°à¦¾à¦²à¦¾à¦ªà§à¦°'),(65,3,'Paikarchar','à¦ªà¦¾à¦‡à¦•à¦¾à¦°à¦šà¦°'),(66,3,'Panchdona','à¦ªà¦¾à¦à¦šà¦¦à§‹à¦¨à¦¾'),(67,3,'Silmandi','à¦¶à¦¿à¦²à¦®à¦¾à¦¨à§à¦¦à§€'),(68,4,'Charsindur','à¦šà¦°à¦¸à¦¿à¦¨à§à¦¦à§à¦°'),(69,4,'Danga','à¦¡à¦¾à¦‚à¦™à§à¦—à¦¾'),(70,4,'Gazaria','à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾'),(71,4,'Jinardi','à¦œà¦¿à¦¨à¦¾à¦°à¦¦à§€'),(72,5,'Adiabad','à¦†à¦¦à¦¿à§Ÿà¦¾à¦¬à¦¾à¦¦'),(73,5,'Alipura','à¦…à¦²à¦¿à¦ªà§à¦°à¦¾'),(74,5,'Amirganj','à¦†à¦®à¦¿à¦°à¦—à¦žà§à¦œ'),(75,5,'Banshgari','à¦¬à¦¾à¦à¦¶à¦—à¦¾à§œà§€'),(76,5,'Chanderkandi','à¦šà¦¾à¦¨à§à¦¦à§‡à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(77,5,'Chanpur','à¦šà¦¾à¦¨à¦ªà§à¦°'),(78,5,'Chararalia','à¦šà¦°à¦†à§œà¦¾à¦²à¦¿à§Ÿà¦¾'),(79,5,'Charmadhua','à¦šà¦°à¦®à¦§à§à§Ÿà¦¾'),(80,5,'Charsubuddi','à¦šà¦°à¦¸à§à¦¬à§à¦¦à§à¦¦à¦¿'),(81,5,'Daukarchar',''),(82,5,'Hairmara','à¦¹à¦¾à¦‡à¦°à¦®à¦¾à¦°à¦¾'),(83,5,'Maheshpur','à¦®à¦¹à§‡à¦·à¦ªà§à¦°'),(84,5,'Marjal2','à¦®à¦°à¦œà¦¾à¦²'),(85,5,'Mirzanagar','à¦®à¦¿à¦°à§à¦œà¦¾à¦¨à¦—à¦°'),(86,5,'Mirzarchar','à¦®à¦¿à¦°à§à¦œà¦¾à¦°à¦šà¦°'),(87,5,'Musapur','à¦®à§à¦›à¦¾à¦ªà§à¦°'),(88,5,'Nilakhya','à¦¨à¦¿à¦²à¦•à§à¦·à§à¦¯à¦¾'),(89,5,'Palashtali','à¦ªà¦²à¦¾à¦¶à¦¤à¦²à§€'),(90,5,'Paratali','à¦ªà¦¾à§œà¦¾à¦¤à¦²à§€'),(91,5,'Roypura','à¦°à¦¾à§Ÿà¦ªà§à¦°à¦¾'),(92,5,'Sreenagar','à¦¶à§à¦°à§€à¦¨à¦—à¦°'),(93,5,'Uttarbakharnagar','à¦‰à¦¤à§à¦¤à¦° à¦¬à¦¾à¦–à¦°à¦¨à¦—à¦°'),(94,123,'Adda','à¦†à¦¡à§à¦¡à¦¾'),(95,123,'Adra','à¦†à¦¦à§à¦°à¦¾'),(96,123,'Aganagar','à¦†à¦—à¦¾à¦¨à¦—à¦°'),(97,123,'Bhabanipur','à¦­à¦¬à¦¾à¦¨à§€à¦ªà§à¦°'),(98,123,'Bhaukshar','à¦­à¦¾à¦‰à¦•à¦¸à¦¾à¦°'),(99,123,'Chitodda','à¦šà¦¿à¦¤à¦¡à§à¦¡à¦¾'),(100,123,'Galimpur','à¦—à¦¾à¦²à¦¿à¦®à¦ªà§à¦°'),(101,123,'Jhalam','à¦à¦²à¦®'),(102,123,'Khoshbasnorth','à¦–à§‹à¦¶à¦¬à¦¾à¦¸ (à¦‰:)'),(103,123,'Khoshbassouth','à¦–à§‹à¦¶à¦¬à¦¾à¦¸ (à¦¦:)'),(104,123,'Laxmipur','à¦²à¦•à§à¦·à§€à¦ªà§à¦°'),(105,123,'Payalgacha','à¦ªà¦¯à¦¼à¦¾à¦²à¦—à¦¾à¦›à¦¾'),(106,123,'Shakpur','à¦¶à¦¾à¦•à¦ªà§à¦°'),(107,123,'Shilmurinorth','à¦¶à¦¿à¦²à¦®à§à¦¡à¦¼à¦¿ (à¦‰:)'),(108,123,'Shilmurisouth','à¦¶à¦¿à¦²à¦®à§à¦¡à¦¼à¦¿ (à¦¦:)'),(109,124,'Brahmanparasadar','à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦¨à¦ªà¦¾à¦¡à¦¼à¦¾ à¦¸à¦¦à¦°'),(110,124,'Chandla','à¦šà¦¾à¦¨à§à¦¦à¦²à¦¾'),(111,124,'Dulalpurup2','à¦¦à§à¦²à¦¾à¦²à¦ªà§à¦° (à§¨)'),(112,124,'Madhabpur','à¦®à¦¾à¦§à¦¬à¦ªà§à¦°'),(113,124,'Malapara','à¦®à¦¾à¦²à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(114,124,'Shahebabad','à¦¸à¦¾à¦¹à§‡à¦¬à¦¾à¦¬à¦¾à¦¦'),(115,124,'Shashidal','à¦¶à¦¶à§€à¦¦à¦²'),(116,124,'Shidli','à¦¶à¦¿à¦¦à¦²à¦¾à¦‡'),(117,125,'Barera','à¦¬à¦¾à¦¡à¦¼à§‡à¦°à¦¾'),(118,125,'Bataghashi','à¦¬à¦¾à¦¤à¦¾à¦˜à¦¾à¦¸à¦¿'),(119,125,'Borcarai','à¦¬à¦°à¦•à¦°à¦‡'),(120,125,'Borcoit','à¦¬à¦°à¦•à¦‡à¦Ÿ'),(121,125,'Dollainowabpur','à¦¦à§‹à¦²à§à¦²à¦¾à¦‡ à¦¨à¦¬à¦¾à¦¬à¦ªà§à¦°'),(122,125,'Etberpur','à¦à¦¤à¦¬à¦¾à¦°à¦ªà§à¦°'),(123,125,'Gollai','à¦—à¦²à§à¦²à¦¾à¦‡'),(124,125,'Joag','à¦œà§‹à¦¯à¦¼à¦¾à¦—'),(125,125,'Keronkhal','à¦•à§‡à¦°à¦£à¦–à¦¾à¦²'),(126,125,'Madhaiya','à¦®à¦¾à¦§à¦¾à¦‡à¦¯à¦¼à¦¾'),(127,125,'Maijkhar','à¦®à¦¾à¦‡à¦œà¦–à¦¾à¦°'),(128,125,'Mohichial','à¦®à¦¹à¦¿à¦šà¦¾à¦‡à¦²'),(129,125,'Shuhilpur','à¦¸à§à¦¹à¦¿à¦²à¦ªà§à¦°'),(130,126,'Alkara','à§§à§¨à¦¨à¦‚ à¦†à¦²à¦•à¦°à¦¾'),(131,126,'Batisha','à§­à¦¨à¦‚ à¦¬à¦¾à¦¤à¦¿à¦¸à¦¾'),(132,126,'Cheora','à§¯à¦¨à¦‚ à¦šà¦¿à¦“à¦¡à¦¼à¦¾'),(133,126,'Ghulpasha','à§«à¦¨à¦‚ à¦˜à§‹à¦²à¦ªà¦¾à¦¶à¦¾'),(134,126,'Goonabati','à§§à§§ à¦¨à¦‚ à¦—à§à¦¨à¦¬à¦¤à§€'),(135,126,'Jagannatdighi','à§§à§¦ à¦¨à¦‚ à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦¦à¦¿à¦˜à§€'),(136,126,'Kalikapur','à§¨à¦¨à¦‚ à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(137,126,'Kankapait','à§®à¦¨à¦‚ à¦•à¦¨à¦•à¦¾à¦ªà§ˆà¦¤'),(138,126,'Kashinagar','à¦•à¦¾à¦¶à¦¿à¦¨à¦—à¦°'),(139,126,'Moonshirhat','à§¬à¦¨à¦‚ à¦®à§à¦¨à§à¦¸à§€à¦°à¦¹à¦¾à¦Ÿ'),(140,126,'Shuvapur','à§ªà¦¨à¦‚ à¦¶à§à¦­à¦ªà§à¦°'),(141,126,'Sreepur','à¦¶à§à¦°à§€à¦ªà§à¦°'),(142,127,'Baroparaup2','à¦¬à¦¾à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(143,127,'Betessor','à¦¬à¦¿à¦Ÿà§‡à¦¶à§à¦¬à¦°'),(144,127,'Daudkandinorth','à¦¦à¦¾à¦‰à¦¦à¦•à¦¾à¦¨à§à¦¦à¦¿ (à¦‰à¦¤à§à¦¤à¦°)'),(145,127,'Doulotpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(146,127,'Eliotgonjnorth','à¦‡à¦²à¦¿à¦¯à¦¼à¦Ÿà¦—à¦žà§à¦œ (à¦‰à¦¤à§à¦¤à¦°)'),(147,127,'Eliotgonjsouth','à¦‡à¦²à¦¿à¦¯à¦¼à¦Ÿà¦—à¦žà§à¦œ (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(148,127,'Goalmari','à¦—à§‹à¦¯à¦¼à¦¾à¦²à¦®à¦¾à¦°à§€'),(149,127,'Gouripur','à¦—à§Œà¦°à§€à¦ªà§à¦°'),(150,127,'Maruka','à¦®à¦¾à¦°à§à¦•à¦¾'),(151,127,'Mohammadpureast','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦° (à¦ªà§à¦°à§à¦¬)'),(152,127,'Mohammadpurwest','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦° (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(153,127,'Passgaciawest','à¦ªà¦¾à¦šà¦à¦—à¦¾à¦›à¦¿à¦¯à¦¼à¦¾ (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(154,127,'Podua','à¦ªà¦¦à§à¦¯à¦¼à¦¾'),(155,127,'Sundolpur','à¦¸à§à¦¨à§à¦¦à¦²à¦ªà§à¦°'),(156,127,'Zinglatoli','à¦œà¦¿à¦‚à¦²à¦¾à¦¤à¦²à§€'),(157,128,'Asadpur','à¦†à¦›à¦¾à¦¦à¦ªà§à¦°'),(158,128,'Chanderchor','à¦šà¦¾à¦¨à§à¦¦à§‡à¦°à¦šà¦°'),(159,128,'Dulalpurup1','à¦¦à§à¦²à¦¾à¦²à¦ªà§à¦°'),(160,128,'Gagutiea','à¦˜à¦¾à¦—à§à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(161,128,'Garmora','à¦˜à¦¾à¦°à¦®à§‹à¦¡à¦¼à¦¾'),(162,128,'Joypur','à¦œà¦¯à¦¼à¦ªà§à¦°'),(163,128,'Mathabanga','à¦®à¦¾à¦¥à¦¾à¦­à¦¾à¦™à§à¦—à¦¾'),(164,128,'Nilokhi','à¦¨à¦¿à¦²à¦–à§€'),(165,128,'Vashania','à¦­à¦¾à¦·à¦¾à¦¨à¦¿à¦¯à¦¼à¦¾'),(166,129,'Azgora','à¦†à¦œà¦—à¦°à¦¾ '),(167,129,'Bakoi','à¦¬à¦¾à¦•à¦‡'),(168,129,'Gobindapur','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦° (2)'),(169,129,'Kandirpar','à¦•à¦¾à¦¨à§à¦¦à¦¿à¦°à¦ªà¦¾à¦¡à¦¼'),(170,129,'Laksampurba','à¦²à¦¾à¦•à¦¸à¦¾à¦® à¦ªà§à¦°à§à¦¬ '),(171,129,'Mudafargonj','à¦®à§à¦¦à¦¾à¦«à¦«à¦° à¦—à¦žà§à¦œ'),(172,129,'Uttarda','à¦‰à¦¤à§à¦¤à¦°à¦¦à¦¾'),(173,130,'Akubpur','à§¨à¦¨à¦‚ à¦†à¦•à§à¦¬à¦ªà§à¦°'),(174,130,'Andicot','à§©à¦¨à¦‚ à¦†à¦¨à§à¦¦à¦¿à¦•à§‹à¦Ÿ'),(175,130,'Babutipara','à§¨à§§à¦¨à¦‚ à¦¬à¦¾à¦¬à§à¦Ÿà¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(176,130,'Bangaraeast','à§¬à¦¨à¦‚ à¦¬à¦¾à¦™à§à¦—à¦°à¦¾ (à¦ªà§‚à¦°à§à¦¬)'),(177,130,'Bangarawest','à§­à¦¨à¦‚ à¦¬à¦¾à¦™à§à¦—à¦°à¦¾ (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(178,130,'Camalla','à§¯à¦¨à¦‚ à¦•à¦¾à¦®à¦¾à¦²à§à¦²à¦¾'),(179,130,'Chapitala','à§®à¦¨à¦‚ à¦šà¦¾à¦ªà¦¿à¦¤à¦²à¦¾'),(180,130,'Damgar','à§§à§ªà¦¨à¦‚ à¦§à¦¾à¦®à¦˜à¦°'),(181,130,'Darura','à§§à§­à¦¨à¦‚ à¦¦à¦¾à¦°à§‹à¦°à¦¾'),(182,130,'Jahapur','à§§à§«à¦¨à¦‚ à¦œà¦¾à¦¹à¦¾à¦ªà§à¦°'),(183,130,'Jatrapur','à§§à§¦à¦¨à¦‚ à¦¯à¦¾à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(184,130,'Muradnagarsadar','à§§à§§ à¦¨à¦‚ à¦®à§à¦°à¦¾à¦¦à¦¨à¦—à¦° à¦¸à¦¦à¦°'),(185,130,'Nobipureast','à§§à§¨à¦¨à¦‚ à¦¨à¦¬à§€à¦ªà§à¦° (à¦ªà§à¦°à§à¦¬)'),(186,130,'Nobipurwest','à§§à§©à¦¨à¦‚ à¦¨à¦¬à§€à¦ªà§à¦° (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(187,130,'Paharpur','à§§à§®à¦¨à¦‚ à¦ªà¦¾à¦¹à¦¾à¦¡à¦¼à¦ªà§à¦°'),(188,130,'Purbadaireast','à§ªà¦¨à¦‚ à¦ªà§à¦°à§à¦¬à¦§à§ˆà¦‡à¦° (à¦ªà§à¦°à§à¦¬)'),(189,130,'Purbadairwest','à§«à¦¨à¦‚ à¦ªà§à¦°à§à¦¬à¦§à§ˆà¦‡à¦° (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(190,130,'Ramachandrapurnorth','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦° à¦‰à¦¤à§à¦¤à¦°'),(191,130,'Ramachandrapursouth','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦° à¦¦à¦•à§à¦·à¦¿à¦¨'),(192,130,'Salikandi','à§§à§¬à¦¨à¦‚ à¦›à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(193,130,'Sreekil','à§§à¦¨à¦‚ à¦¶à§à¦°à§€à¦•à¦¾à¦‡à¦²'),(194,130,'Tanki','à§¨à§¨à¦¨à¦‚ à¦Ÿà¦¨à¦•à§€'),(195,131,'Adra','à¦†à¦¦à§à¦°à¦¾'),(196,131,'Bangadda','à¦¬à¦¾à¦™à§à¦—à¦¡à§à¦¡à¦¾'),(197,131,'Boxgonj','à¦¬à¦•à§à¦¸à¦—à¦žà§à¦œ'),(198,131,'Dhalua','à¦¢à¦¾à¦²à§à¦¯à¦¼à¦¾'),(199,131,'Doulkha','à¦¦à§Œà¦²à¦–à¦¾à¦à¦¡à¦¼'),(200,131,'Heshakhal','à¦¹à§‡à¦¸à¦¾à¦–à¦¾à¦²'),(201,131,'Judda','à¦œà§‹à¦¡à§à¦¡à¦¾'),(202,131,'Makrabpur','à¦®à¦•à§à¦°à¦¬à¦ªà§à¦°'),(203,131,'Mokara','à¦®à§‹à¦•à¦°à¦¾'),(204,131,'Paria','à¦ªà§‡à¦°à¦¿à¦¯à¦¼à¦¾'),(205,131,'Raykot','à¦°à¦¾à¦¯à¦¼à¦•à§‹à¦Ÿ'),(206,131,'Satbaria','à¦¸à¦¾à¦¤à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(207,132,'Amratoli','à¦†à¦®à¦¡à¦¼à¦¾à¦¤à¦²à§€'),(208,132,'Durgapurnorth','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦° (à¦‰à¦¤à§à¦¤à¦°)'),(209,132,'Durgapursouth','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦° (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(210,132,'Jagannatpur','à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(211,132,'Kalirbazer','à¦•à¦¾à¦²à§€à¦° à¦¬à¦¾à¦œà¦¾à¦°'),(212,132,'Panchthubi','à¦ªà¦¾à¦à¦šà¦¥à§à¦¬à§€'),(213,133,'Barakanda','à§«à¦¨à¦‚ à¦¬à¦¡à¦¼à¦•à¦¾à¦¨à§à¦¦à¦¾'),(214,133,'Chalibanga','à§¨à¦¨à¦‚ à¦šà¦¾à¦²à¦¿à¦­à¦¾à¦™à§à¦—à¦¾'),(215,133,'Chandanpur','à¦šà¦¨à§à¦¦à¦¨à¦ªà§à¦°'),(216,133,'Govindapurup1','à§¬à¦¨à¦‚ à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(217,133,'Luterchar','à§­à¦¨à¦‚ à¦²à§à¦Ÿà§‡à¦°à¦šà¦°'),(218,133,'Manikarchar','à§ªà¦¨à¦‚ à¦®à¦¾à¦¨à¦¿à¦•à¦¾à¦°à¦šà¦°'),(219,133,'Radanagar','à§©à¦¨à¦‚ à¦°à¦¾à¦§à¦¾à¦¨à¦—à¦°'),(220,133,'Vaorkhola','à§®à¦¨à¦‚ à¦­à¦¾à¦“à¦°à¦–à§‹à¦²à¦¾'),(221,134,'Baishgaon','à¦¬à¦¾à¦‡à¦¶à¦—à¦¾à¦à¦“'),(222,134,'Bipulashar','à¦¬à¦¿à¦ªà§à¦²à¦¾à¦¸à¦¾à¦°'),(223,134,'Hasnabad','à¦¹à¦¾à¦¸à¦¨à¦¾à¦¬à¦¾à¦¦'),(224,134,'Jholamnorth','à§ªà¦¨à¦‚ à¦à¦²à¦® à¦‰à¦¤à§à¦¤à¦°'),(225,134,'Jholamsouth','à§«à¦¨à¦‚ à¦à¦²à¦® à¦¦à¦•à§à¦·à¦¿à¦¨'),(226,134,'Khela','à¦–à¦¿à¦²à¦¾'),(227,134,'Lokkhanpur','à¦²à¦•à§à¦·à¦¨à¦ªà§à¦°'),(228,134,'Moishatua','à¦®à§ˆà¦¶à¦¾à¦¤à§à¦¯à¦¼à¦¾'),(229,134,'Natherpetua','à¦¨à¦¾à¦¥à§‡à¦°à¦ªà§‡à¦Ÿà§à¦¯à¦¼à¦¾'),(230,134,'Shoroshpur','à¦¸à¦°à¦¸à¦ªà§à¦°'),(231,134,'Uttarhowla','à¦‰à¦¤à§à¦¤à¦° à¦¹à¦¾à¦“à¦²à¦¾'),(232,135,'Bagmaranorth','à¦¬à¦¾à¦—à¦®à¦¾à¦°à¦¾ (à¦‰à¦¤à§à¦¤à¦°)'),(233,135,'Bagmarasouth','à¦¬à¦¾à¦—à¦®à¦¾à¦°à¦¾ (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(234,135,'Baroparaup1','à¦¬à¦¾à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(235,135,'Belgornorth','à¦¬à§‡à¦²à¦˜à¦° (à¦‰à¦¤à§à¦¤à¦°)'),(236,135,'Belgorsouth','à¦¬à§‡à¦²à¦˜à¦° (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(237,135,'Bhuloinnorth','à¦­à§‚à¦²à¦‡à¦¨ (à¦‰à¦¤à§à¦¤à¦°)'),(238,135,'Bhuloinsouth','à¦­à§‚à¦²à¦‡à¦¨ (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(239,135,'Bijoypur','à¦¬à¦¿à¦œà¦¯à¦¼à¦ªà§à¦°'),(240,135,'Chuwara','à¦šà§Œà¦¯à¦¼à¦¾à¦°à¦¾'),(241,135,'Goliara','à¦—à¦²à¦¿à¦¯à¦¼à¦¾à¦°à¦¾'),(242,135,'Jorkanoneast','à¦œà§‹à¦¡à¦¼à¦•à¦¾à¦¨à¦¨ (à¦ªà§à¦°à§à¦¬)'),(243,135,'Jorkanonwest','à¦œà§‹à¦¡à¦¼à¦•à¦¾à¦¨à¦¨ (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(244,135,'Perulnorth','à¦ªà§‡à¦°à§à¦² (à¦‰à¦¤à§à¦¤à¦°)'),(245,135,'Perulsouth','à¦ªà§‡à¦°à§à¦² (à¦¦à¦•à§à¦·à¦¿à¦¨)'),(246,136,'Balorampur','à§©à¦¨à¦‚ à¦¬à¦²à¦°à¦¾à¦®à¦ªà§à¦°'),(247,136,'Jagatpur','à§¨à¦¨à¦‚ à¦œà¦—à¦¤à¦ªà§à¦°'),(248,136,'Kalakandi','à§«à¦¨à¦‚ à¦•à¦²à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(249,136,'Karikandi','à§ªà¦¨à¦‚ à¦•à¦¡à¦¼à¦¿à¦•à¦¾à¦¨à§à¦¦à¦¿'),(250,136,'Majidpur','à§¯à¦¨à¦‚ à¦®à¦œà¦¿à¦¦à¦ªà§à¦°'),(251,136,'Narayandia','à§­à¦¨à¦‚ à¦¨à¦¾à¦°à¦¾à¦¨à§à¦¦à¦¿à¦¯à¦¼à¦¾'),(252,136,'Satani','à§§à¦¨à¦‚ à¦¸à¦¾à¦¤à¦¾à¦¨à§€'),(253,136,'Vitikandi','à§¬à¦¨à¦‚ à¦­à¦¿à¦Ÿà¦¿à¦•à¦¾à¦¨à§à¦¦à¦¿'),(254,136,'Zearkandi','à§®à¦¨à¦‚ à¦œà¦¿à¦¯à¦¼à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(255,288,'Baghutia','à¦¬à¦¾à¦˜à§à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(256,288,'Chalishia','à¦šà¦²à¦¿à¦¶à¦¿à¦¯à¦¼à¦¾'),(257,288,'Payra','à¦ªà¦¾à¦¯à¦¼à¦°à¦¾'),(258,288,'Prambag','à¦ªà§à¦°à§‡à¦®à¦¬à¦¾à¦—'),(259,288,'Siddhipasha','à¦¸à¦¿à¦¦à§à¦¦à¦¿à¦ªà¦¾à¦¶à¦¾'),(260,288,'Sreedharpur','à¦¶à§à¦°à§€à¦§à¦°à¦ªà§à¦°'),(261,288,'Subharara','à¦¶à§à¦­à¦°à¦¾à¦¡à¦¼à¦¾'),(262,288,'Sundoli','à¦¸à§à¦¨à§à¦¦à¦²à§€'),(263,289,'Bandabilla','à¦¬à¦¨à§à¦¦à¦¬à¦¿à¦²à¦¾'),(264,289,'Basuari','à¦¬à¦¾à¦¸à§à¦¯à¦¼à¦¾à¦¡à¦¼à§€'),(265,289,'Darajhat','à¦¦à¦°à¦¾à¦œà¦¹à¦¾à¦Ÿ'),(266,289,'Dhalgram','à¦§à¦²à¦—à§à¦°à¦¾à¦®'),(267,289,'Dohakula','à¦¦à§‹à¦¹à¦¾à¦•à§à¦²à¦¾'),(268,289,'Jaharpur','à¦œà¦¹à§à¦°à¦ªà§à¦°'),(269,289,'Jamdia','à¦œà¦¾à¦®à¦¦à¦¿à¦¯à¦¼à¦¾'),(270,289,'Narikelbaria','à¦¨à¦¾à¦°à¦¿à¦•à§‡à¦²à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(271,289,'Roypur','à¦°à¦¾à¦¯à¦¼à¦ªà§à¦°'),(272,290,'Chougachhaup5','à¦šà§Œà¦—à¦¾à¦›à¦¾'),(273,290,'Dhulianiup4','à¦§à§à¦²à¦¿à¦¯à¦¼à¦¾à¦¨à§€'),(274,290,'Fulsaraup1','à¦«à§à¦²à¦¸à¦¾à¦°à¦¾'),(275,290,'Hakimpurup8','à¦¹à¦¾à¦•à¦¿à¦®à¦ªà§à¦°'),(276,290,'Jagadishpurup6','à¦œà¦—à¦¦à§€à¦¶à¦ªà§à¦°'),(277,290,'Narayanpurup10','à¦¨à¦¾à¦°à¦¾à¦¯à¦¼à¦¨à¦ªà§à¦°'),(278,290,'Pashapoleup2','à¦ªà¦¾à¦¶à¦¾à¦ªà§‹à¦²'),(279,290,'Patibilaup7','à¦ªà¦¾à¦¤à¦¿à¦¬à¦¿à¦²à¦¾'),(280,290,'Singhajhuliup3','à¦¸à¦¿à¦‚à¦¹à¦à§à¦²à¦¿'),(281,290,'Sukpukhuriaup11','à¦¸à§à¦–à¦ªà§à¦•à§à¦°à¦¿à¦¯à¦¼à¦¾'),(282,290,'Swarupdahaup9','à¦¸à¦°à§à¦ªà¦¦à¦¾à¦¹'),(283,291,'Bankra','à¦¬à¦¾à¦à¦•à¦¡à¦¼à¦¾'),(284,291,'Gadkhali','à¦—à¦¦à¦–à¦¾à¦²à§€'),(285,291,'Ganganandapur','à¦—à¦‚à¦—à¦¾à¦¨à¦¨à§à¦¦à¦ªà§à¦°'),(286,291,'Hajirbaghup9','à¦¹à¦¾à¦œà¦¿à¦°à¦¬à¦¾à¦—'),(287,291,'Jhikargachha','à¦à¦¿à¦•à¦°à¦—à¦¾à¦›à¦¾'),(288,291,'Magura','à¦®à¦¾à¦—à§à¦°à¦¾'),(289,291,'Nabharan','à¦¨à¦¾à¦­à¦¾à¦°à¦¨'),(290,291,'Nibaskhola','à¦¨à¦¿à¦°à§à¦¬à¦¾à¦¸à¦–à§‹à¦²à¦¾'),(291,291,'Panisara','à¦ªà¦¾à¦¨à¦¿à¦¸à¦¾à¦°à¦¾'),(292,291,'Shankarpurup10','à¦¶à¦‚à¦•à¦°à¦ªà§à¦°'),(293,291,'Shimuliaup3','à¦¶à¦¿à¦®à§à¦²à¦¿à¦¯à¦¼à¦¾'),(294,292,'Bidyanandakatiup4','à¦¬à¦¿à¦¦à§à¦¯à¦¾à¦¨à¦¨à§à¦¦à¦•à¦¾à¦Ÿà¦¿'),(295,292,'Gaurighonaup9','à¦—à§Œà¦°à¦¿à¦˜à§‹à¦¨à¦¾'),(296,292,'Keshabpurup6','à¦•à§‡à¦¶à¦¬à¦ªà§à¦°'),(297,292,'Majidpurup3','à¦®à¦œà¦¿à¦¦à¦ªà§à¦°'),(298,292,'Mongolkotup5','à¦®à¦™à§à¦—à¦²à¦•à§‹à¦°à§à¦Ÿ'),(299,292,'Panjiaup7','à¦ªà¦¾à¦œà¦¿à¦¯à¦¼à¦¾'),(300,292,'Sagardariup2','à¦¸à¦¾à¦—à¦°à¦¦à¦¾à¦¡à¦¼à§€'),(301,292,'Sufalakatiup8','à¦¸à§à¦«à¦²à¦¾à¦•à¦¾à¦Ÿà¦¿'),(302,292,'Trimohiniup1','à¦¤à§à¦°à¦¿à¦®à§‹à¦¹à¦¿à¦¨à§€'),(303,10,'Arabpurup9','à¦†à¦°à¦¬à¦ªà§à¦°'),(304,10,'Basundia','à¦¬à¦¸à§à¦¨à§à¦¦à¦¿à¦¯à¦¼à¦¾'),(305,10,'Chanchra','à¦šà¦¾à¦à¦šà¦¡à¦¼à¦¾'),(306,10,'Churamankati','à¦šà§‚à¦¡à¦¼à¦¾à¦®à¦¨à¦•à¦¾à¦Ÿà¦¿'),(307,10,'Dearamodel','à¦¦à§‡à§Ÿà¦¾à¦°à¦¾ à¦®à¦¡à§‡à¦²'),(308,10,'Fathehpur','à¦«à¦¤à§‡à¦ªà§à¦°'),(309,10,'Haibatpur','à¦¹à§ˆà¦¬à¦¤à¦ªà§à¦°'),(310,10,'Ichhali','à¦‡à¦›à¦¾à¦²à§€'),(311,10,'Kachuaup13','à¦•à¦šà§à¦¯à¦¼à¦¾'),(312,10,'Kashimpurup6','à¦•à¦¾à¦¶à¦¿à¦®à¦ªà§à¦°'),(313,10,'Lebutala','à¦²à§‡à¦¬à§à¦¤à¦²à¦¾'),(314,10,'Narendrapur','à¦¨à¦°à§‡à¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(315,10,'Noaparaup4','à¦¨à¦“à¦¯à¦¼à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(316,10,'Ramnagar','à¦°à¦¾à¦®à¦¨à¦—à¦°'),(317,10,'Upasahar','à¦‰à¦ªà¦¶à¦¹à¦°'),(318,294,'Bagachraup8','à¦¬à¦¾à¦—à¦†à¦šà¦¡à¦¼à¦¾'),(319,294,'Bahadurpurup3','à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦°'),(320,294,'Benapoleup4','à¦¬à§‡à¦¨à¦¾à¦ªà§‹à¦²'),(321,294,'Dihiup1','à¦¡à¦¿à¦¹à¦¿'),(322,294,'Gogaup6','à¦—à§‹à¦—à¦¾'),(323,294,'Kaybaup7','à¦•à¦¾à¦¯à¦¼à¦¬à¦¾'),(324,294,'Lakshmanpurup2','à¦²à¦•à§à¦·à¦£à¦ªà§à¦°'),(325,294,'Nizampurup11','à¦¨à¦¿à¦œà¦¾à¦®à¦ªà§à¦°'),(326,294,'Putkhaliup5','à¦ªà§à¦Ÿà¦–à¦¾à¦²à§€'),(327,294,'Sharshaup10','à¦¶à¦¾à¦°à§à¦¶à¦¾'),(328,294,'Ulshiup9','à¦‰à¦²à¦¶à§€'),(329,295,'Anulia','à¦†à¦¨à§à¦²à¦¿à¦¯à¦¼à¦¾'),(330,295,'Assasuni','à¦†à¦¶à¦¾à¦¶à§à¦¨à¦¿'),(331,295,'Baradal','à¦¬à¦¡à¦¼à¦¦à¦²'),(332,295,'Budhhata','à¦¬à§à¦§à¦¹à¦¾à¦Ÿà¦¾'),(333,295,'Durgapur','à¦¦à¦°à¦—à¦¾à¦¹à¦ªà§à¦°'),(334,295,'Kadakati','à¦•à¦¾à¦¦à¦¾à¦•à¦¾à¦Ÿà¦¿'),(335,295,'Khajra','à¦–à¦¾à¦œà¦°à¦¾'),(336,295,'Kulla','à¦•à§à¦²à§à¦¯à¦¾'),(337,295,'Pratapnagar','à¦ªà§à¦°à¦¤à¦¾à¦ªà¦¨à¦—à¦°'),(338,295,'Sobhnali','à¦¶à§‹à¦­à¦¨à¦¾à¦²à§€'),(339,295,'Sreeula','à¦¶à§à¦°à§€à¦‰à¦²à¦¾'),(340,296,'Debhata','à¦¦à§‡à¦¬à¦¹à¦¾à¦Ÿà¦¾'),(341,296,'Kulia','à¦•à§à¦²à¦¿à¦¯à¦¼à¦¾'),(342,296,'Noapara','à¦¨à¦“à¦¯à¦¼à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(343,296,'Parulia','à¦ªà¦¾à¦°à§à¦²à¦¿à¦¯à¦¼à¦¾'),(344,296,'Sakhipur','à¦¸à¦–à¦¿à¦ªà§à¦°'),(345,297,'Chandanpur','à¦šà¦¨à§à¦¦à¦¨à¦ªà§à¦°'),(346,297,'Deara','à¦¦à§‡à§Ÿà¦¾à¦°à¦¾'),(347,297,'Helatala','à¦¹à§‡à¦²à¦¾à¦¤à¦²à¦¾'),(348,297,'Jallabad','à¦œà¦¾à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦¦'),(349,297,'Jogikhali','à¦¯à§à¦—à¦¿à¦–à¦¾à¦²à§€'),(350,297,'Joynagar','à¦œà§Ÿà¦¨à¦—à¦°'),(351,297,'Kaila','à¦•à¦¯à¦¼à¦²à¦¾'),(352,297,'Keragachhi','à¦•à§‡à¦à¦¡à¦¼à¦¾à¦—à¦¾à¦›à¦¿'),(353,297,'Keralkata','à¦•à§‡à¦°à¦¾à¦²à¦•à¦¾à¦¤à¦¾'),(354,297,'Kushadanga','à¦•à§à¦¶à§‹à¦¡à¦¾à¦‚à¦—à¦¾'),(355,297,'Langaljhara','à¦²à¦¾à¦™à§à¦—à¦²à¦à¦¾à¦¡à¦¼à¦¾'),(356,297,'Sonabaria','à¦¸à§‹à¦¨à¦¾à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(357,7,'Bahadursadi','à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦¶à¦¾à¦¦à§€'),(358,7,'Baktarpur','à¦¬à¦•à§à¦¤à¦¾à¦°à¦ªà§à¦°'),(359,7,'Jamalpurnew','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(360,7,'Jangalia','à¦œà¦¾à¦™à§à¦—à¦¾à¦²à¦¿à§Ÿà¦¾'),(361,7,'Moktarpur','à¦®à§‹à¦•à§à¦¤à¦¾à¦°à¦ªà§à¦°'),(362,7,'Nagari','à¦¨à¦¾à¦—à¦°à§€'),(363,7,'Tumulia','à¦¤à§à¦®à§à¦²à¦¿à§Ÿà¦¾'),(364,298,'Agardari','à¦†à¦—à¦°à¦¦à¦¾à¦¡à¦¼à§€'),(365,298,'Alipur','à¦†à¦²à¦¿à¦ªà§à¦°'),(366,298,'Baikari','à¦¬à§ˆà¦•à¦¾à¦°à§€'),(367,298,'Balli','à¦¬à¦²à§à¦²à§€'),(368,298,'Banshdaha','à¦¬à¦¾à¦à¦¶à¦¦à¦¹'),(369,298,'Bhomra','à¦­à§‹à¦®à¦°à¦¾'),(370,298,'Brahmarajpur','à¦¬à§à¦°à¦•à§à¦·à§à¦®à¦°à¦¾à¦œà¦ªà§à¦°'),(371,298,'Dhulihar','à¦§à§à¦²à¦¿à¦¹à¦°'),(372,298,'Fingri','à¦«à¦¿à¦‚à¦¡à¦¼à¦¿'),(373,298,'Ghona','à¦˜à§‹à¦¨à¦¾'),(374,298,'Jhaudanga','à¦à¦¾à¦‰à¦¡à¦¾à¦™à§à¦—à¦¾'),(375,298,'Kuskhali','à¦•à§à¦¶à¦–à¦¾à¦²à§€'),(376,298,'Labsa','à¦²à¦¾à¦¬à¦¸à¦¾'),(377,298,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(378,299,'Atulia','à¦†à¦Ÿà§à¦²à¦¿à¦¯à¦¼à¦¾'),(379,299,'Bhurulia','à¦­à§à¦°à§à¦²à¦¿à¦¯à¦¼à¦¾'),(380,299,'Burigoalini','à¦¬à§à¦¡à¦¼à¦¿à¦—à§‹à¦¯à¦¼à¦¾à¦²à¦¿à¦¨à§€'),(381,299,'Gabura','à¦—à¦¾à¦¬à§à¦°à¦¾'),(382,299,'Ishwaripur','à¦ˆà¦¶à§à¦¬à¦°à§€à¦ªà§à¦°'),(383,299,'Kaikhali','à¦•à§ˆà¦–à¦¾à¦²à§€'),(384,299,'Kashimari','à¦•à¦¾à¦¶à¦¿à¦®à¦¾à¦¡à¦¼à§€'),(385,299,'Munshiganj','à¦®à§à¦¨à§à¦¸à§€à¦—à¦œà§à¦ž'),(386,299,'Nurnagar','à¦¨à§à¦°à¦¨à¦—à¦°'),(387,299,'Padmapukur','à¦ªà¦¦à§à¦®à¦ªà§à¦•à§à¦°'),(388,299,'Ramjannagar','à¦°à¦®à¦œà¦¾à¦¨à¦¨à¦—à¦°'),(389,299,'Shyamnagar','à¦¶à§à¦¯à¦¾à¦®à¦¨à¦—à¦°'),(390,300,'Dhandiaup1','à¦§à¦¾à¦¨à¦¦à¦¿à¦¯à¦¼à¦¾'),(391,300,'Islamkatiup7','à¦‡à¦¸à¦²à¦¾à¦®à¦•à¦¾à¦Ÿà¦¿'),(392,300,'Jalalpurup11','à¦œà¦¾à¦²à¦¾à¦²à¦ªà§à¦°'),(393,300,'Khalilnagarup12','à¦–à¦²à¦¿à¦²à¦¨à¦—à¦°'),(394,300,'Khalishkhaliup9','à¦–à¦²à¦¿à¦¶à¦–à¦¾à¦²à§€'),(395,300,'Khesraup10','à¦–à§‡à¦¶à¦°à¦¾'),(396,300,'Kumiraup4','à¦•à§à¦®à¦¿à¦°à¦¾'),(397,300,'Maguraup8','à¦®à¦¾à¦—à§à¦°à¦¾'),(398,300,'Nagarghataup1','à¦¨à¦—à¦°à¦˜à¦¾à¦Ÿà¦¾'),(399,300,'Saruliaup3','à¦¸à¦°à§à¦²à¦¿à¦¯à¦¼à¦¾'),(400,300,'Talaup6','à¦¤à¦¾à¦²à¦¾'),(401,300,'Tentuliaup5','à¦¤à§‡à¦¤à§à¦²à¦¿à¦¯à¦¼à¦¾'),(402,10,'Basanda','à¦¬à¦¾à¦¸à¦¨à§à¦¡à¦¾'),(403,10,'Binoykati','à¦¬à¦¿à¦¨à§Ÿà¦•à¦¾à¦ à§€'),(404,10,'Gabharamchandrapur','à¦—à¦¾à¦­à¦¾à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(405,10,'Gabkhandhansiri','à¦—à¦¾à¦¬à¦–à¦¾à¦¨ à¦§à¦¾à¦¨à¦¸à¦¿à¦à§œà¦¿'),(406,10,'Keora','à¦•à§‡à¦“à§œà¦¾'),(407,10,'Kirtipasha','à¦•à§€à¦°à§à¦¤à¦¿à¦ªà¦¾à¦¶à¦¾'),(408,10,'Nabagram','à¦¨à¦¬à¦—à§à¦°à¦¾à¦®'),(409,10,'Nathullabad','à¦¨à¦¥à§à¦²à¦²à§à¦²à¦¾à¦¬à¦¾à¦¦'),(410,10,'Ponabalia','à¦ªà§‹à¦¨à¦¾à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾'),(411,10,'Sekherhat','à¦¶à§‡à¦–à§‡à¦°à¦¹à¦¾à¦Ÿ'),(412,347,'Amua','à¦†à¦®à§à§Ÿà¦¾'),(413,347,'Awrabunia','à¦†à¦“à¦°à¦¾à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(414,347,'Chenchrirampur','à¦šà§‡à¦à¦šà¦°à§€à¦°à¦¾à¦®à¦ªà§à¦°'),(415,347,'Kanthalia','à¦•à¦¾à¦ à¦¾à¦²à¦¿à§Ÿà¦¾'),(416,347,'Patikhalghata','à¦ªà¦¾à¦Ÿà¦¿à¦–à¦¾à¦²à¦˜à¦¾à¦Ÿà¦¾'),(417,348,'Bharabpasha','à¦­à§ˆà¦°à¦¬à¦ªà¦¾à¦¶à¦¾'),(418,348,'Dapdapia','à¦¦à¦ªà¦¦à¦ªà¦¿à§Ÿà¦¾'),(419,348,'Kulkathi','à¦•à§à¦²à¦•à¦¾à¦ à§€'),(420,348,'Kusanghal','à¦•à§à¦¶à¦™à§à¦—à¦²'),(421,348,'Magar','à¦®à¦—à¦°'),(422,348,'Mollahat','à¦®à§‹à¦²à§à¦²à¦¾à¦°à¦¹à¦¾à¦Ÿ'),(423,348,'Nachanmohal','à¦¨à¦¾à¦šà¦¨à¦®à¦¹à¦²'),(424,348,'Ranapasha','à¦°à¦¾à¦¨à¦¾à¦ªà¦¾à¦¶à¦¾'),(425,348,'Siddhakati','à¦¸à¦¿à¦¦à§à¦§à¦•à¦¾à¦ à§€'),(426,348,'Subidpur','à¦¸à§à¦¬à¦¿à¦¦à¦ªà§à¦°'),(427,137,'Bakshimul','à¦¬à¦¾à¦•à¦¶à§€à¦®à§‚à¦²'),(428,137,'Burichangsadar','à¦¬à§à¦¡à¦¼à¦¿à¦šà¦‚ à¦¸à¦¦à¦°'),(429,137,'Mokam','à¦®à§‹à¦•à¦¾à¦®'),(430,137,'Moynamoti','à¦®à¦¯à¦¼à¦¨à¦¾à¦®à¦¤à¦¿'),(431,137,'Pirjatrapur','à¦ªà§€à¦°à¦¯à¦¾à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(432,137,'Rajapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦°'),(433,137,'Sholonal','à¦·à§‹à¦²à¦¨à¦²'),(434,137,'Varella','à¦­à¦¾à¦°à§‡à¦²à§à¦²à¦¾'),(435,6,'Ayubpur','à¦†à§Ÿà§à¦¬à¦ªà§à¦°'),(436,6,'Baghabo','à¦¬à¦¾à¦˜à¦¾à¦¬'),(437,6,'Chakradha','à¦šà¦•à§à¦°à¦§à¦¾'),(438,6,'Dulalpur','à¦¦à§à¦²à¦¾à¦²à¦ªà§à¦°'),(439,6,'Joshar','à¦¯à§‹à¦¶à¦°'),(440,6,'Joynagar','à¦œà§Ÿà¦¨à¦—à¦°'),(441,6,'Masimpur','à¦®à¦¾à¦›à¦¿à¦®à¦ªà§à¦°'),(442,6,'Putia','à¦ªà§à¦Ÿà¦¿à§Ÿà¦¾'),(443,6,'Sadharchar','à¦¸à¦¾à¦§à¦¾à¦°à¦šà¦°'),(444,444,'Balaganj','à¦¬à¦¾à¦²à¦¾à¦—à¦žà§à¦œ'),(445,444,'Boaljur','à¦¬à§‹à§Ÿà¦¾à¦²à¦œà§à¦°'),(446,444,'Burungabazar','à¦¬à§à¦°à§à¦™à§à¦—à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(447,444,'Dewanbazar','à¦¦à§‡à¦“à§Ÿà¦¾à¦¨ à¦¬à¦¾à¦œà¦¾à¦°'),(448,444,'Doyamir','à¦¦à§Ÿà¦¾à¦®à§€à¦°'),(449,444,'Eastgouripur','à¦ªà§‚à¦°à§à¦¬ à¦—à§Œà¦°à§€à¦ªà§à¦°'),(450,444,'Eastpoilanpur','à¦ªà§‚à¦°à§à¦¬ à¦ªà§ˆà¦²à¦¨à¦ªà§à¦°'),(451,444,'Goalabazar','à¦—à§‹à§Ÿà¦¾à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(452,444,'Sadipur','à¦¸à¦¾à¦¦à¦¿à¦°à¦ªà§à¦°'),(453,444,'Tazpur','à¦¤à¦¾à¦œà¦ªà§à¦°'),(454,444,'Umorpur','à¦‰à¦®à¦°à¦ªà§à¦°'),(455,444,'Usmanpur','à¦‰à¦¸à¦®à¦¾à¦¨à¦ªà§à¦°'),(456,444,'Westgouripur','à¦ªà¦¶à§à¦šà¦¿à¦® à¦—à§Œà¦°à§€à¦ªà§à¦°'),(457,444,'Westpoilanpur','à¦ªà¦¶à§à¦šà¦¿à¦® à¦ªà§ˆà¦²à¦¨à¦ªà§à¦°'),(458,445,'Alinagar','à¦†à¦²à§€à¦¨à¦—à¦° '),(459,445,'Charkhai','à¦šà¦°à¦–à¦¾à¦‡'),(460,445,'Dubag','à¦¦à§à¦¬à¦¾à¦—'),(461,445,'Kurarbazar','à¦•à§à§œà¦¾à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(462,445,'Lauta','à¦²à¦¾à¦‰à¦¤à¦¾'),(463,445,'Mathiura','à¦®à¦¾à¦¥à¦¿à¦‰à¦°à¦¾'),(464,445,'Mullapur','à¦®à§‹à¦²à§à¦²à¦¾à¦ªà§à¦°'),(465,445,'Muria','à¦®à§à§œà¦¿à§Ÿà¦¾'),(466,445,'Sheola','à¦¶à§‡à¦“à¦²à¦¾'),(467,445,'Tilpara','à¦¤à¦¿à¦²à¦ªà¦¾à§œà¦¾'),(468,446,'Alankari','à¦…à¦²à¦‚à¦•à¦¾à¦°à§€'),(469,446,'Bishwanath','à¦¬à¦¿à¦¶à§à¦¬à¦¨à¦¾à¦¥'),(470,446,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(471,446,'Dewkalash','à¦¦à§‡à¦“à¦•à¦²à¦¸'),(472,446,'Doshghar','à¦¦à¦¶à¦˜à¦°'),(473,446,'Khajanchi','à¦–à¦¾à¦œà¦¾à¦žà§à¦šà§€'),(474,446,'Lamakazi','à¦²à¦¾à¦®à¦¾à¦•à¦¾à¦œà§€'),(475,446,'Rampasha','à¦°à¦¾à¦®à¦ªà¦¾à¦¶à¦¾'),(476,164,'Dakkinronikhai','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦°à¦¨à¦¿à¦–à¦¾à¦‡'),(477,164,'Isakalas','à¦‡à¦¸à¦¾à¦•à¦²à¦¸'),(478,164,'Islampurpaschim','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦° à¦ªà¦¶à§à¦šà¦¿à¦®'),(479,164,'Islampurpurba','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦° à¦ªà§‚à¦°à§à¦¬'),(480,164,'Telikhal','à¦¤à§‡à¦²à¦¿à¦–à¦¾à¦²'),(481,164,'Uttorronikhai','à¦‰à¦¤à§à¦¤à¦° à¦°à¦¨à¦¿à¦–à¦¾à¦‡'),(482,448,'1nofenchuganj','à¦«à§‡à¦žà§à¦šà§à¦—à¦žà§à¦œ '),(483,448,'Ghilachora','à¦˜à¦¿à¦²à¦¾à¦›à§œà¦¾'),(484,448,'Maijgaon','à¦®à¦¾à¦‡à¦œà¦—à¦¾à¦à¦“'),(485,448,'Uttarfenchuganj','à¦‰à¦¤à§à¦¤à¦° à¦«à§‡à¦žà§à¦šà§à¦—à¦žà§à¦œ'),(486,448,'Uttarkushiara','à¦‰à¦¤à§à¦¤à¦° à¦•à§à¦¶à¦¿à§Ÿà¦¾à¦°à¦¾'),(487,449,'Bhadeshwar','à¦­à¦¾à¦¦à§‡à¦¶à§à¦¬à¦°'),(488,449,'Budhbaribazar','à¦¬à§à¦§à¦¬à¦¾à¦°à§€à¦¬à¦¾à¦œà¦¾à¦°'),(489,449,'Dhakadakshin','à¦¢à¦¾à¦•à¦¾à¦¦à¦•à§à¦·à¦¿à¦¨'),(490,449,'Fulbari','à¦«à§à¦²à¦¬à¦¾à§œà§€'),(491,449,'Golapganj','à¦—à§‹à¦²à¦¾à¦ªà¦—à¦žà§à¦œ'),(492,449,'Lakshanaband','à¦²à¦•à§à¦·à¦¨à¦¾à¦¬à¦¨à§à¦¦'),(493,449,'Lakshmipasha','à¦²à¦•à§à¦·à§à¦®à§€à¦ªà¦¾à¦¶à¦¾'),(494,449,'Sharifganj','à¦¶à¦°à¦¿à¦«à¦—à¦žà§à¦œ'),(495,449,'Uttarbadepasha','à¦‰à¦¤à§à¦¤à¦° à¦¬à¦¾à¦¦à§‡à¦ªà¦¾à¦¶à¦¾'),(496,449,'Westamura','à¦ªà¦¶à§à¦šà¦¿à¦® à¦†à¦®à§à¦°à¦¾'),(497,450,'Alirgaon','à¦†à¦²à§€à¦°à¦—à¦¾à¦à¦“'),(498,450,'Daubari','à¦¡à§Œà¦¬à¦¾à§œà§€'),(499,450,'Fothepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(500,450,'Lengura','à¦²à§‡à¦™à§à¦—à§à§œà¦¾'),(501,450,'Nandirgaon','à¦¨à¦¨à§à¦¦à¦¿à¦°à¦—à¦¾à¦à¦“'),(502,450,'Paschimjaflong','à¦ªà¦¶à§à¦šà¦¿à¦® à¦œà¦¾à¦«à¦²à¦‚'),(503,450,'Purbajaflong','à¦ªà§‚à¦°à§à¦¬ à¦œà¦¾à¦«à¦²à¦‚'),(504,450,'Rustampur','à¦°à§à¦¸à§à¦¤à¦®à¦ªà§à¦°'),(505,450,'Towakul','à¦¤à§‹à§Ÿà¦¾à¦•à§à¦²'),(506,451,'Charikatha','à¦šà¦¾à¦°à¦¿à¦•à¦¾à¦Ÿà¦¾'),(507,451,'Chiknagul','à¦šà¦¿à¦•à¦¨à¦¾à¦—à§à¦²'),(508,451,'Darbast','à¦¦à¦°à¦¬à¦¸à§à¦¤'),(509,451,'Fatehpur','à§« à¦¨à¦‚ à¦«à¦¤à§‡à¦ªà§à¦°'),(510,451,'Jaintapur','à¦œà§ˆà¦¨à§à¦¤à¦¾à¦ªà§à¦°'),(511,451,'Nijpat','à¦¨à¦¿à¦œà¦ªà¦¾à¦Ÿ'),(512,452,'Barachotul','à¦¬à§œà¦šà¦¤à§à¦²'),(513,452,'Dakhinbanigram','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦¬à¦¾à¦¨à¦¿à¦—à§à¦°à¦¾à¦®'),(514,452,'Digirparpurbo','à¦¦à¦¿à¦˜à¦¿à¦°à¦ªà¦¾à¦° à¦ªà§‚à¦°à§à¦¬ '),(515,452,'Jinghabari','à¦à¦¿à¦™à§à¦—à¦¾à¦¬à¦¾à§œà§€'),(516,452,'Kanaighat','à¦•à¦¾à¦¨à¦¾à¦‡à¦˜à¦¾à¦Ÿ'),(517,452,'Lakshiprashadpashim','à¦²à¦•à§à¦·à§€à¦ªà§à¦°à¦¾à¦¸à¦¾à¦¦ à¦ªà¦¶à§à¦šà¦¿à¦®'),(518,452,'Lakshiprashadpurbo','à¦²à¦•à§à¦·à§€à¦ªà§à¦°à¦¾à¦¸à¦¾à¦¦ à¦ªà§‚à¦°à§à¦¬'),(519,452,'Rajagonj','à¦°à¦¾à¦œà¦¾à¦—à¦žà§à¦œ'),(520,452,'Satbakh','à¦¸à¦¾à¦¤à¦¬à¦¾à¦•'),(521,453,'Hatkhula','à¦¹à¦¾à¦Ÿà¦–à§‹à¦²à¦¾'),(522,453,'Jalalabad','à¦œà¦¾à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦¦'),(523,453,'Kandigaon','à¦•à¦¾à¦¨à§à¦¦à¦¿à¦—à¦¾à¦“'),(524,453,'Khadimnagar','à¦–à¦¾à¦¦à¦¿à¦®à¦¨à¦—à¦°'),(525,453,'Khadimpara','à¦–à¦¾à¦¦à¦¿à¦®à¦ªà¦¾à§œà¦¾'),(526,453,'Mugolgaon','à¦®à§‹à¦—à¦²à¦—à¦¾à¦“'),(527,453,'Tukerbazar','à¦Ÿà§à¦•à§‡à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(528,453,'Tultikor','à¦Ÿà§à¦²à¦Ÿà¦¿à¦•à¦°'),(529,454,'Barohal','à¦¬à¦¾à¦°à¦¹à¦¾à¦²'),(530,454,'Barothakuri','à¦¬à¦¾à¦°à¦ à¦¾à¦•à§à¦°à§€'),(531,454,'Birorsri','à¦¬à¦¿à¦°à¦¶à§à¦°à§€'),(532,454,'Kajalshah','à¦•à¦¾à¦œà¦²à¦¶à¦¾à¦°'),(533,454,'Kaskanakpur','à¦•à¦¸à¦•à¦¨à¦•à¦ªà§à¦°'),(534,454,'Kolachora','à¦•à¦²à¦¾à¦›à§œà¦¾'),(535,454,'Manikpur','à¦®à¦¾à¦¨à¦¿à¦•à¦ªà§à¦°'),(536,454,'Sultanpur','à¦¸à§à¦²à¦¤à¦¾à¦¨à¦ªà§à¦° '),(537,454,'Zakiganj','à¦œà¦•à¦¿à¦—à¦žà§à¦œ'),(538,456,'Baralekha','à¦¬à§œà¦²à§‡à¦–à¦¾'),(539,456,'Borni','à¦¬à¦°à§à¦£à¦¿'),(540,456,'Dakshinbhagdakshin','à¦¦à¦•à§à¦·à¦¿à¦£à¦­à¦¾à¦— (à¦¦à¦•à§à¦·à¦¿à¦£)'),(541,456,'Dakshinbhaguttar','à¦¦à¦•à§à¦·à¦¿à¦£à¦­à¦¾à¦— (à¦‰à¦¤à§à¦¤à¦°)'),(542,456,'Dasherbazar','à¦¦à¦¾à¦¸à§‡à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(543,456,'Nizbahadurpur','à¦¨à¦¿à¦œà¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦°'),(544,456,'Shahbajpurdakshin','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¶à¦¾à¦¹à¦¬à¦¾à¦œà¦ªà§à¦°'),(545,456,'Shahbajpuruttar','à¦‰à¦¤à§à¦¤à¦° à¦¶à¦¾à¦¹à¦¬à¦¾à¦œà¦ªà§à¦°'),(546,456,'Sujanagar','à¦¸à§à¦œà¦¾à¦¨à¦—à¦°'),(547,456,'Talimpur','à¦¤à¦¾à¦²à¦¿à¦®à¦ªà§à¦°'),(548,457,'Adampur','à¦†à¦¦à¦®à¦ªà§à¦°'),(549,457,'Alinagar','à¦†à¦²à§€ à¦¨à¦—à¦°'),(550,457,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(551,457,'Kamalgonj','à¦•à¦®à¦²à¦—à¦žà§à¦œ'),(552,457,'Madhabpur','à¦®à¦¾à¦§à¦¬à¦ªà§à¦°'),(553,457,'Munshibazarup3','à§©à¦¨à¦‚ à¦®à§à¦¨à§à¦¸à¦¿à¦¬à¦¾à¦œà¦¾à¦°'),(554,457,'Patanushar','à¦ªà¦¤à¦¨à¦Šà¦·à¦¾à¦°'),(555,457,'Rahimpur','à¦°à¦¹à¦¿à¦®à¦ªà§à¦°'),(556,457,'Shamshernagar','à¦¶à¦®à¦¶à§‡à¦°à¦¨à¦—à¦°'),(557,458,'Baramchal','à¦¬à¦°à¦®à¦šà¦¾à¦²'),(558,458,'Bhatera','à¦­à¦¾à¦Ÿà§‡à¦°à¦¾'),(559,458,'Bhukshimail','à¦­à§‚à¦•à¦¶à¦¿à¦®à¦‡à¦²'),(560,458,'Brammanbazar','à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦¬à¦¾à¦œà¦¾à¦°'),(561,458,'Hazipur','à¦¹à¦¾à¦œà§€à¦ªà§à¦°'),(562,458,'Joychandi','à¦œà§Ÿà¦šà¦¨à§à¦¡à¦¿'),(563,458,'Kadipur','à¦•à¦¾à¦¦à¦¿à¦ªà§à¦°'),(564,458,'Kormodha','à¦•à¦°à§à¦®à¦§à¦¾'),(565,458,'Kulaura','à¦•à§à¦²à¦¾à¦‰à§œà¦¾'),(566,458,'Prithimpassa','à¦ªà§ƒà¦¥à¦¿à¦®à¦ªà¦¾à¦¶à¦¾'),(567,458,'Rauthgaon','à¦°à¦¾à¦‰à§Žà¦—à¦¾à¦à¦“'),(568,458,'Sharifpur','à¦¶à¦°à§€à¦«à¦ªà§à¦°'),(569,458,'Tilagaon','à¦Ÿà¦¿à¦²à¦¾à¦—à¦¾à¦à¦“'),(570,459,'Akhailkura','à¦†à¦–à¦¾à¦‡à¦²à¦•à§à§œà¦¾'),(571,459,'Amtail','à¦†à¦®à¦¤à§ˆà¦²'),(572,459,'Chadnighat','à¦šà¦¾à¦à¦¦à¦¨à§€à¦˜à¦¾à¦Ÿ'),(573,459,'Ekatuna','à¦à¦•à¦¾à¦Ÿà§à¦¨à¦¾'),(574,459,'Giasnagar','à¦—à¦¿à§Ÿà¦¾à¦¸à¦¨à¦—à¦°'),(575,459,'Kamalpur','à¦•à¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(576,459,'Khalilpur','à¦–à¦²à¦¿à¦²à¦ªà§à¦°'),(577,459,'Konokpur','à¦•à¦¨à¦•à¦ªà§à¦°'),(578,459,'Monumukh','à¦®à¦¨à§à¦®à§à¦–'),(579,459,'Mostafapur','à¦®à§‹à¦¸à§à¦¤à¦«à¦¾à¦ªà§à¦°'),(580,459,'Nazirabad','à¦¨à¦¾à¦œà¦¿à¦°à¦¾à¦¬à¦¾à¦¦'),(581,459,'Uparkagabala','à¦†à¦ªà¦¾à¦° à¦•à¦¾à¦—à¦¾à¦¬à¦²à¦¾'),(582,460,'Fotepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(583,460,'Kamarchak','à¦•à¦¾à¦®à¦¾à¦°à¦šà¦¾à¦•'),(584,460,'Munsibazar','à§¦à§©à¦¨à¦‚ à¦®à§à¦¨à§à¦¸à¦¿à¦¬à¦¾à¦œà¦¾à¦°'),(585,460,'Munsurnagar','à¦®à¦¨à¦¸à§à¦°à¦¨à¦—à¦° '),(586,460,'Panchgaon','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦à¦“'),(587,460,'Rajnagar','à¦°à¦¾à¦œà¦¨à¦—à¦°'),(588,460,'Tengra','à¦Ÿà§‡à¦‚à¦°à¦¾'),(589,460,'Uttorbhag','à¦‰à¦¤à§à¦¤à¦°à¦­à¦¾à¦—'),(590,461,'Ashidron','à¦†à¦¶à¦¿à¦¦à§à¦°à§‹à¦¨'),(591,461,'Bhunabir','à¦­à§‚à¦¨à¦¬à§€à¦°'),(592,461,'Kalapur','à¦•à¦¾à¦²à¦¾à¦ªà§à¦° '),(593,461,'Kalighat','à¦•à¦¾à¦²à§€à¦˜à¦¾à¦Ÿ'),(594,461,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(595,461,'Rajghat','à¦°à¦¾à¦œà¦˜à¦¾à¦Ÿ'),(596,461,'Satgaon','à¦¸à¦¾à¦¤à¦—à¦¾à¦à¦“'),(597,461,'Sindurkhan','à¦¸à¦¿à¦¨à§à¦¦à§à¦°à¦–à¦¾à¦¨'),(598,461,'Sreemangal','à¦¶à§à¦°à§€à¦®à¦™à§à¦—à¦²'),(599,462,'Eastjuri','à¦ªà§à¦°à§à¦¬ à¦œà§à§œà§€'),(600,462,'Fultola','à¦«à§à¦²à¦¤à¦²à¦¾'),(601,462,'Gualbari','à¦—à§‹à§Ÿà¦¾à¦²à¦¬à¦¾à§œà§€'),(602,462,'Jafornagar','à¦œà¦¾à§Ÿà¦«à¦°à¦¨à¦—à¦°'),(603,462,'Sagornal','à¦¸à¦¾à¦—à¦°à¦¨à¦¾à¦²'),(604,462,'Westjuri','à¦ªà¦¶à§à¦šà¦¿à¦® à¦œà§à§œà§€'),(605,386,'Amarkhana','à¦…à¦®à¦°à¦–à¦¾à¦¨à¦¾'),(606,386,'Chaklahat','à¦šà¦¾à¦•à¦²à¦¾à¦¹à¦¾à¦Ÿ'),(607,386,'Dhakkamara','à¦§à¦¾à¦•à§à¦•à¦¾à¦®à¦¾à¦°à¦¾'),(608,386,'Garinabari','à¦—à¦°à¦¿à¦¨à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(609,386,'Hafizabad','à¦¹à¦¾à¦«à¦¿à¦œà¦¾à¦¬à¦¾à¦¦'),(610,386,'Haribhasa','à¦¹à¦¾à¦¡à¦¼à¦¿à¦­à¦¾à¦¸à¦¾'),(611,386,'Kamatkajoldighi','à¦•à¦¾à¦®à¦¾à¦¤ à¦•à¦¾à¦œà¦² à¦¦à§€à¦˜à¦¿'),(612,386,'Magura','à¦®à¦¾à¦—à§à¦°à¦¾'),(613,386,'Panchagarhsadar','à¦ªà¦žà§à¦šà¦—à¦¡à¦¼ à¦¸à¦¦à¦°'),(614,386,'Satmara','à¦¸à¦¾à¦¤à¦®à§‡à¦°à¦¾'),(615,387,'Chengthihazradanga','à¦šà§‡à¦‚à¦ à§€ à¦¹à¦¾à¦œà¦°à¦¾ à¦¡à¦¾à¦™à§à¦—à¦¾'),(616,387,'Chilahati','à¦šà¦¿à¦²à¦¾à¦¹à¦¾à¦Ÿà¦¿'),(617,387,'Dandopal','à¦¦à¦¨à§à¦¡à¦ªà¦¾à¦²'),(618,387,'Debiduba','à¦¦à§‡à¦¬à§€à¦¡à§à¦¬à¦¾'),(619,387,'Debiganjsadar','à¦¦à§‡à¦¬à§€à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(620,387,'Pamuli','à¦ªà¦¾à¦®à§à¦²à§€'),(621,387,'Shaldanga','à¦¶à¦¾à¦²à¦¡à¦¾à¦™à§à¦—à¦¾'),(622,387,'Sonaharmollikadaha','à¦¸à§‹à¦¨à¦¾à¦¹à¦¾à¦° à¦®à¦²à§à¦²à¦¿à¦•à¦¾à¦¦à¦¹'),(623,387,'Sundardighi','à¦¸à§à¦¨à§à¦¦à¦°à¦¦à¦¿à¦˜à§€'),(624,387,'Tepriganj','à¦Ÿà§‡à¦ªà§à¦°à§€à¦—à¦žà§à¦œ'),(625,8,'Atabaha','à¦†à¦Ÿà¦¾à¦¬à¦¹'),(626,8,'Boali','à¦¬à§‹à§Ÿà¦¾à¦²à§€'),(627,8,'Chapair','à¦šà¦¾à¦ªà¦¾à¦‡à¦°'),(628,8,'Dhaliora','à¦¢à¦¾à¦²à¦œà§‹à§œà¦¾'),(629,8,'Fulbaria','à¦«à§à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(630,8,'Madhyapara','à¦®à¦§à§à¦¯à¦ªà¦¾à§œà¦¾'),(631,8,'Mouchak','à¦®à§Œà¦šà¦¾à¦•'),(632,8,'Srifaltali','à¦¶à§à¦°à§€à¦«à¦²à¦¤à¦²à§€'),(633,8,'Sutrapur','à¦¸à§‚à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(634,388,'Banghari','à¦¬à§‡à¦‚à¦¹à¦¾à¦°à§€'),(635,388,'Boda','à¦¬à§‹à¦¦à¦¾'),(636,388,'Boroshoshi','à¦¬à¦¡à¦¼à¦¶à¦¶à§€'),(637,388,'Chandanbari','à¦šà¦¨à§à¦¦à¦¨à¦¬à¦¾à¦¡à¦¼à§€'),(638,388,'Jholaishalshiri','à¦à¦²à¦‡à¦¶à¦¾à¦² à¦¶à¦¿à¦°à¦¿'),(639,388,'Kajoldighikaligonj','à¦•à¦¾à¦œà¦²à¦¦à§€à¦˜à¦¿ à¦•à¦¾à¦²à¦¿à¦—à¦žà§à¦œ'),(640,388,'Mareabamonhat','à¦®à¦¾à¦¡à¦¼à§‡à¦¯à¦¼à¦¾ à¦¬à¦¾à¦®à¦¨à¦¹à¦¾à¦Ÿ'),(641,388,'Moidandighi','à¦®à¦¯à¦¼à¦¦à¦¾à¦¨ à¦¦à§€à¦˜à¦¿'),(642,388,'Pachpir','à¦ªà¦¾à¦šà¦ªà§€à¦°'),(643,388,'Sakoa','à¦¸à¦¾à¦•à§‹à¦¯à¦¼à¦¾'),(644,389,'Alowakhowa','à¦†à¦²à§‹à¦¯à¦¼à¦¾à¦–à§‹à¦¯à¦¼à¦¾'),(645,389,'Balarampur','à¦¬à¦²à¦°à¦¾à¦®à¦ªà§à¦°'),(646,389,'Dhamor','à¦§à¦¾à¦®à§‹à¦°'),(647,389,'Mirgapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(648,389,'Radhanagar','à¦°à¦¾à¦§à¦¾à¦¨à¦—à¦°'),(649,389,'Toria','à¦¤à§‹à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(650,390,'Banglabandha','à¦¬à¦¾à¦‚à¦²à¦¾à¦¬à¦¾à¦¨à§à¦§à¦¾'),(651,390,'Bhojoanpur','à¦­à¦œà¦¨à¦ªà§à¦°'),(652,390,'Bhojoanpur','à¦­à¦œà¦¨à¦ªà§à¦°'),(653,390,'Buraburi','à¦¬à§à¦¡à¦¼à¦¾à¦¬à§à¦¡à¦¼à§€'),(654,390,'Debnagar','à¦¦à§‡à¦¬à¦¨à¦—à¦°'),(655,390,'Salbahan','à¦¶à¦¾à¦²à¦¬à¦¾à¦¹à¦¾à¦¨'),(656,390,'Tentulia','à¦¤à§‡à¦¤à§à¦²à¦¿à¦¯à¦¼à¦¾'),(657,390,'Timaihat','à¦¤à¦¿à¦®à¦¾à¦‡à¦¹à¦¾à¦Ÿ'),(658,9,'Barishaba','à¦¬à¦¾à¦°à¦¿à¦·à¦¾à¦¬'),(659,9,'Chandpur','à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(660,9,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(661,9,'Ghagotia','à¦˜à¦¾à¦—à¦Ÿà¦¿à§Ÿà¦¾'),(662,9,'Kapasia','à¦•à¦¾à¦ªà¦¾à¦¸à¦¿à§Ÿà¦¾'),(663,9,'Karihata','à¦•à§œà¦¿à¦¹à¦¾à¦¤à¦¾'),(664,9,'Rayed','à¦°à¦¾à§Ÿà§‡à¦¦'),(665,9,'Sinhasree','à¦¸à¦¿à¦‚à¦¹à¦¶à§à¦°à§€'),(666,9,'Sonmania','à¦¸à¦¨à¦®à¦¾à¦¨à¦¿à§Ÿà¦¾'),(667,9,'Targoan','à¦¤à¦°à¦—à¦¾à¦à¦“'),(668,9,'Tokh','à¦Ÿà§‹à¦•'),(669,10,'Baria','à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(670,10,'Basan','à¦¬à¦¾à¦¸à¦¨'),(671,10,'Gachha','à¦—à¦¾à¦›à¦¾'),(672,10,'Kashimpur','à¦•à¦¾à¦¶à¦¿à¦®à¦ªà§à¦°'),(673,10,'Kayaltia','à¦•à¦¾à¦‰à¦²à¦¤à¦¿à§Ÿà¦¾'),(674,10,'Konabari','à¦•à§‹à¦¨à¦¾à¦¬à¦¾à§œà§€'),(675,10,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(676,10,'Pubail','à¦ªà§‚à¦¬à¦¾à¦‡à¦²'),(677,11,'Barmi','à¦¬à¦°à¦®à§€'),(678,11,'Gazipur','à¦—à¦¾à¦œà§€à¦ªà§à¦°'),(679,11,'Gosinga','à¦—à§‹à¦¸à¦¿à¦‚à¦—à¦¾'),(680,11,'Kaoraid','à¦•à¦¾à¦“à¦°à¦¾à¦‡à¦¦'),(681,11,'Maona','à¦®à¦¾à¦“à¦¨à¦¾'),(682,11,'Prahladpur','à¦ªà§à¦°à¦¹à¦²à¦¾à¦¦à¦ªà§à¦°'),(683,11,'Rajabari','à¦°à¦¾à¦œà¦¾à¦¬à¦¾à§œà§€'),(684,11,'Telihati','à¦¤à§‡à¦²à¦¿à¦¹à¦¾à¦Ÿà§€'),(685,221,'Baradhul','à¦¬à§œà¦§à§à¦²'),(686,221,'Belkuchisadar','à¦¬à§‡à¦²à¦•à§à¦šà¦¿ à¦¸à¦¦à¦°'),(687,221,'Bhangabari','à¦­à¦¾à¦™à§à¦—à¦¾à¦¬à¦¾à§œà§€'),(688,221,'Dhukuriabera','à¦§à§à¦•à§à¦°à¦¿à§Ÿà¦¾ à¦¬à§‡à§œà¦¾'),(689,221,'Doulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(690,221,'Rajapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦°'),(691,222,'Baghutia','à¦¬à¦¾à¦˜à§à¦Ÿà¦¿à§Ÿà¦¾'),(692,222,'Gharjan','à¦˜à§‹à¦°à¦œà¦¾à¦¨'),(693,222,'Khaskaulia','à¦–à¦¾à¦¸à¦•à¦¾à¦‰à¦²à¦¿à§Ÿà¦¾'),(694,222,'Khaspukuria','à¦–à¦¾à¦¸à¦ªà§à¦•à§à¦°à¦¿à§Ÿà¦¾'),(695,222,'Omarpur','à¦‰à¦®à¦¾à¦°à¦ªà§à¦°'),(696,222,'Sadiachandpur','à¦¸à¦¦à¦¿à§Ÿà¦¾ à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(697,222,'Sthal','à¦¸à§à¦¥à¦²'),(698,223,'Bhadraghat','à¦­à¦¦à§à¦°à¦˜à¦¾à¦Ÿ'),(699,223,'Jamtail','à¦œà¦¾à¦®à¦¤à§ˆà¦²'),(700,223,'Jhawail','à¦à¦¾à¦à¦²'),(701,223,'Roydaulatpur','à¦°à¦¾à§Ÿà¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(702,224,'Chalitadangha','à¦šà¦¾à¦²à¦¿à¦¤à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(703,224,'Chargirish','à¦šà¦°à¦—à¦¿à¦°à¦¿à¦¶'),(704,224,'Gandail','à¦—à¦¾à¦¨à§à¦§à¦¾à¦‡à¦²'),(705,224,'Kazipursadar','à¦•à¦¾à¦œà¦¿à¦ªà§à¦° à¦¸à¦¦à¦°'),(706,224,'Khasrajbari','à¦–à¦¾à¦¸à¦°à¦¾à¦œà¦¬à¦¾à§œà§€'),(707,224,'Maijbari','à¦®à¦¾à¦‡à¦œà¦¬à¦¾à§œà§€'),(708,224,'Monsurnagar','à¦®à¦¨à¦¸à§à¦° à¦¨à¦—à¦°'),(709,224,'Natuarpara','à¦¨à¦¾à¦Ÿà§à§Ÿà¦¾à¦°à¦ªà¦¾à§œà¦¾'),(710,224,'Nishchintapur','à¦¨à¦¿à¦¶à§à¦šà¦¿à¦¨à§à¦¤à¦ªà§à¦°'),(711,224,'Sonamukhi','à¦¸à§‹à¦¨à¦¾à¦®à§à¦–à§€'),(712,224,'Subhagacha','à¦¶à§à¦­à¦—à¦¾à¦›à¦¾'),(713,224,'Tekani','à¦¤à§‡à¦•à¦¾à¦¨à§€'),(714,225,'Brommogacha','à¦¬à§à¦°à¦¹à§à¦®à¦—à¦¾à¦›à¦¾'),(715,225,'Chandaikona','à¦šà¦¾à¦¨à§à¦¦à¦¾à¦‡à¦•à§‹à¦¨à¦¾'),(716,225,'Dhamainagar','à¦§à¦¾à¦®à¦¾à¦‡à¦¨à¦—à¦°'),(717,225,'Dhangora','à¦§à¦¾à¦¨à¦—à§œà¦¾'),(718,225,'Dhubil','à¦§à§à¦¬à¦¿à¦²'),(719,225,'Ghurka','à¦˜à§à§œà¦•à¦¾'),(720,225,'Nalka','à¦¨à¦²à¦•à¦¾'),(721,225,'Pangashi','à¦ªà¦¾à¦™à§à¦—à¦¾à¦¸à§€'),(722,225,'Sonakhara','à¦¸à§‹à¦¨à¦¾à¦–à¦¾à§œà¦¾'),(723,226,'Beltail','à¦¬à§‡à¦²à¦¤à§ˆà¦²'),(724,226,'Gala','à¦—à¦¾à¦²à¦¾'),(725,226,'Garadah','à¦—à¦¾à§œà¦¾à¦¦à¦¹'),(726,226,'Habibullahnagar','à¦¹à¦¾à¦¬à¦¿à¦¬à§à¦²à§à¦²à¦¾à¦¹ à¦¨à¦—à¦°'),(727,226,'Jalalpur','à¦œà¦¾à¦²à¦¾à¦²à¦ªà§à¦°'),(728,226,'Kayempure','à¦•à¦¾à§Ÿà§‡à¦®à¦ªà§à¦°'),(729,226,'Khukni','à¦–à§à¦•à¦¨à§€'),(730,226,'Koizuri','à¦•à§ˆà¦œà§à¦°à§€'),(731,226,'Narina','à¦¨à¦°à¦¿à¦¨à¦¾'),(732,226,'Porzona','à¦ªà§‹à¦°à¦œà¦¨à¦¾'),(733,226,'Potazia','à¦ªà§‹à¦¤à¦¾à¦œà¦¿à§Ÿà¦¾'),(734,226,'Rupbati','à¦°à§‚à¦ªà¦¬à¦¾à¦Ÿà¦¿'),(735,226,'Sonatoni','à¦¸à§‹à¦¨à¦¾à¦¤à¦¨à§€'),(736,227,'Bagbati','à¦¬à¦¾à¦—à¦¬à¦¾à¦Ÿà¦¿'),(737,227,'Bohuli','à¦¬à¦¹à§à¦²à§€'),(738,227,'Kaliahoripur','à¦•à¦¾à¦²à¦¿à§Ÿà¦¾à¦¹à¦°à¦¿à¦ªà§à¦°'),(739,227,'Khokshabari','à¦–à§‹à¦•à¦¶à¦¾à¦¬à¦¾à§œà§€'),(740,227,'Kowakhola','à¦•à¦¾à¦“à§Ÿà¦¾à¦–à§‹à¦²à¦¾'),(741,227,'Mesra','à¦®à§‡à¦›à§œà¦¾'),(742,227,'Ratankandi','à¦°à¦¤à¦¨à¦•à¦¾à¦¨à§à¦¦à¦¿'),(743,227,'Sheyalkol','à¦¶à¦¿à§Ÿà¦¾à¦²à¦•à§‹à¦²'),(744,227,'Songacha','à¦›à§‹à¦¨à¦—à¦¾à¦›à¦¾'),(745,227,'Soydabad','à¦¸à§Ÿà¦¦à¦¾à¦¬à¦¾à¦¦'),(746,228,'Baruhas','à¦¬à¦¾à¦°à§à¦¹à¦¾à¦¸'),(747,228,'Deshigram','à¦¦à§‡à¦¶à§€à¦—à§à¦°à¦¾à¦®'),(748,228,'Madhainagar','à¦®à¦¾à¦§à¦¾à¦‡à¦¨à¦—à¦°'),(749,228,'Magurabinod','à¦®à¦¾à¦—à§à§œà¦¾ à¦¬à¦¿à¦¨à§‹à¦¦'),(750,228,'Naogaon','à¦¨à¦“à¦—à¦¾à¦'),(751,228,'Soguna','à¦¸à¦—à§à¦¨à¦¾'),(752,228,'Talam','à¦¤à¦¾à¦²à¦®'),(753,228,'Tarashsadar','à¦¤à¦¾à§œà¦¾à¦¶ à¦¸à¦¦à¦°'),(754,229,'Bangala','à¦¬à¦¾à¦™à§à¦—à¦¾à¦²à¦¾'),(755,229,'Borohor','à¦¬à§œà¦¹à¦°'),(756,229,'Boropangashi','à¦¬à§œà¦ªà¦¾à¦™à§à¦—à¦¾à¦¸à§€'),(757,229,'Durganagar','à¦¦à§à¦°à§à¦—à¦¾ à¦¨à¦—à¦°'),(758,229,'Hatikumrul','à¦¹à¦Ÿà¦¿à¦•à§à¦®à¦°à§à¦²'),(759,229,'Mohonpur','à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(760,229,'Ponchocroshi','à¦ªà¦žà§à¦šà¦•à§à¦°à§‹à¦¶à§€'),(761,229,'Purnimagati','à¦ªà§‚à¦°à§à¦£à¦¿à¦®à¦¾à¦—à¦¾à¦¤à§€'),(762,229,'Ramkrisnopur','à¦°à¦¾à¦®à¦•à§ƒà¦·à§à¦£à¦ªà§à¦°'),(763,229,'Salanga','à¦¸à¦²à¦™à§à¦—à¦¾'),(764,229,'Salo','à¦¸à¦²à¦ª'),(765,229,'Udhunia','à¦‰à¦§à§à¦¨à¦¿à§Ÿà¦¾'),(766,229,'Ullaparasadar','à¦‰à¦²à§à¦²à¦¾à¦ªà¦¾à§œà¦¾ à¦¸à¦¦à¦°'),(767,455,'Boroikandi','à¦¬à§œà¦‡à¦•à¦¾à¦¨à§à¦¦à¦¿'),(768,455,'Daudpur','à¦¦à¦¾à¦‰à¦¦à¦ªà§à¦°'),(769,455,'Jalalpur','à¦œà¦¾à¦²à¦¾à¦²à¦ªà§à¦°'),(770,455,'Kamalbazar','à¦•à¦¾à¦®à¦¾à¦²à¦¬à¦¾à¦œà¦¾à¦°'),(771,455,'Kuchai','à¦•à§à¦šà¦¾à¦‡'),(772,455,'Lalabazar','à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(773,455,'Moglabazar','à¦®à§‹à¦—à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(774,455,'Mollargaon','à¦®à§‹à¦²à§à¦²à¦¾à¦°à¦—à¦¾à¦à¦“'),(775,455,'Silam','à¦¸à¦¿à¦²à¦¾à¦®'),(776,455,'Tetli','à¦¤à§‡à¦¤à¦²à§€'),(777,349,'Adabaria','à¦†à¦¦à¦¾à¦¬à¦¾à¦°à¦¿à§Ÿà¦¾ '),(778,349,'Bauphal','à¦¬à¦¾à¦‰à¦«à¦²'),(779,349,'Boga','à¦¬à¦—à¦¾'),(780,349,'Daspara','à¦¦à¦¾à¦¸ à¦ªà¦¾à§œà¦¾'),(781,349,'Dhulia','à¦§à§à¦²à¦¿à¦¯à¦¼à¦¾'),(782,349,'Kachipara','à¦•à¦¾à¦›à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(783,349,'Kalaiya','à¦•à¦¾à¦²à¦¾à¦‡à§Ÿà¦¾'),(784,349,'Kalisuri','à¦•à¦¾à¦²à¦¿à¦¶à§à¦°à§€'),(785,349,'Kanakdia','à¦•à¦¨à¦•à¦¦à¦¿à¦¯à¦¼à¦¾'),(786,349,'Keshabpur','à¦•à§‡à¦¶à¦¬à¦ªà§à¦°'),(787,349,'Madanpura','à¦®à¦¦à¦¨à¦ªà§à¦°à¦¾'),(788,349,'Najirpur','à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°'),(789,349,'Nawmala','à¦¨à¦“à¦®à¦¾à¦²à¦¾'),(790,349,'Shurjamoni','à¦¸à§‚à¦°à§à¦¯à§à¦¯à¦®à¦¨à¦¿'),(791,7,'Bharasimla','à¦­à¦¾à¦¡à¦¼à¦¾à¦¶à¦¿à¦®à¦²à¦¾'),(792,7,'Bishnupur','à¦¬à¦¿à¦·à§à¦£à§à¦ªà§à¦°'),(793,7,'Champaphul','à¦šà¦¾à¦®à§à¦ªà¦¾à¦«à§à¦²'),(794,7,'Dakshinsreepur','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¶à§à¦°à§€à¦ªà§à¦°'),(795,7,'Dhalbaria','à¦§à¦²à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(796,7,'Krishnanagar','à¦•à§ƒà¦·à§à¦£à¦¨à¦—à¦°'),(797,7,'Kushlia','à¦•à§à¦¶à§à¦²à¦¿à¦¯à¦¼à¦¾'),(798,7,'Mathureshpur','à¦®à¦¥à§à¦°à§‡à¦¶à¦ªà§à¦°'),(799,7,'Mautala','à¦®à§Œà¦¤à¦²à¦¾'),(800,7,'Nalta','à¦¨à¦²à¦¤à¦¾'),(801,7,'Ratanpur','à¦°à¦¤à¦¨à¦ªà§à¦°'),(802,7,'Tarali','à¦¤à¦¾à¦°à¦¾à¦²à§€'),(803,308,'Alukdia','à¦†à¦²à§à¦•à¦¦à¦¿à¦¯à¦¼à¦¾'),(804,308,'Begumpur','à¦¬à§‡à¦—à¦®à¦ªà§à¦°'),(805,308,'Kutubpur','à¦•à§à¦¤à§à¦¬à¦ªà§à¦°'),(806,308,'Mominpur','à¦®à§‹à¦®à¦¿à¦¨à¦ªà§à¦°'),(807,308,'Padmabila','à¦ªà¦¦à§à¦®à¦¬à¦¿à¦²à¦¾'),(808,308,'Shankarchandra','à¦¶à¦‚à¦•à¦°à¦šà¦¨à§à¦¦à§à¦°'),(809,308,'Titudah','à¦¤à¦¿à¦¤à§à¦¦à¦¾à¦¹'),(810,309,'Ailhash','à¦†à¦‡à¦²à¦¹à¦¾à¦à¦¸'),(811,309,'Baradi','à¦¬à¦¾à¦¡à¦¼à¦¾à¦¦à§€'),(812,309,'Belgachi','à¦¬à§‡à¦²à¦—à¦¾à¦›à¦¿'),(813,309,'Bhangbaria','à¦­à¦¾à¦‚à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(814,309,'Chitla','à¦šà¦¿à§Žà¦²à¦¾'),(815,309,'Dauki','à¦¡à¦¾à¦‰à¦•à§€'),(816,309,'Gangni','à¦—à¦¾à¦‚à¦¨à§€'),(817,309,'Hardi','à¦¹à¦¾à¦°à¦¦à§€'),(818,309,'Jamjami','à¦œà¦¾à¦®à¦œà¦¾à¦®à¦¿'),(819,309,'Jehala','à¦œà§‡à¦¹à¦¾à¦²à¦¾'),(820,309,'Kalidashpur','à¦•à¦¾à¦²à¦¿à¦¦à¦¾à¦¸à¦ªà§à¦°'),(821,309,'Kashkorara','à¦–à¦¾à¦¸à¦•à¦°à¦°à¦¾'),(822,309,'Khadimpur','à¦–à¦¾à¦¦à¦¿à¦®à¦ªà§à¦°'),(823,309,'Kumari','à¦•à§à¦®à¦¾à¦°à§€'),(824,309,'Nagdah','à¦¨à¦¾à¦—à¦¦à¦¾à¦¹'),(825,310,'Damurhuda','à¦¦à¦¾à¦®à§à¦¡à¦¼à¦¹à§à¦¦à¦¾'),(826,310,'Hawli','à¦¹à¦¾à¦“à¦²à§€'),(827,310,'Juranpur','à¦œà§à¦¡à¦¼à¦¾à¦¨à¦ªà§à¦°'),(828,310,'Karpashdanga','à¦•à¦¾à¦°à§à¦ªà¦¾à¦¸à¦¡à¦¾à¦™à§à¦—à¦¾'),(829,310,'Kurulgachhi','à¦•à§à¦¡à¦¼à¦¾à¦²à¦—à¦¾à¦›à§€'),(830,310,'Natipota','à¦¨à¦¤à¦¿à¦ªà§‹à¦¤à¦¾'),(831,310,'Perkrishnopurmadna','à¦ªà¦¾à¦°à¦•à§ƒà¦·à§à¦£à¦ªà§à¦° à¦®à¦¦à¦¨à¦¾'),(832,311,'Andulbaria','à¦†à¦¨à§à¦¦à§à¦²à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(833,311,'Banka','à¦¬à¦¾à¦à¦•à¦¾'),(834,311,'Hasadah','à¦¹à¦¾à¦¸à¦¾à¦¦à¦¾à¦¹'),(835,311,'Raypur','à¦°à¦¾à¦¯à¦¼à¦ªà§à¦°'),(836,311,'Shimanto','à¦¸à§€à¦®à¦¾à¦¨à§à¦¤'),(837,311,'Uthali','à¦‰à¦¥à¦²à§€'),(838,302,'Bagowan','à¦¬à¦¾à¦—à§‹à¦¯à¦¼à¦¾à¦¨'),(839,302,'Dariapur','à¦¦à¦¾à¦°à¦¿à¦¯à¦¼à¦¾à¦ªà§à¦°'),(840,302,'Mohajanpur','à¦®à¦¹à¦¾à¦œà¦¨à¦ªà§à¦°'),(841,302,'Monakhali','à¦®à§‹à¦¨à¦¾à¦–à¦¾à¦²à§€'),(842,303,'Amdah','à¦†à¦®à¦¦à¦¹'),(843,303,'Amjhupi','à¦†à¦®à¦à§à¦ªà¦¿'),(844,303,'Buripota','à¦¬à§à¦¡à¦¼à¦¿à¦ªà§‹à¦¤à¦¾'),(845,303,'Kutubpur','à¦•à¦¤à§à¦¬à¦ªà§à¦°'),(846,303,'Pirojpur','à¦ªà¦¿à¦°à§‹à¦œà¦ªà§à¦°'),(847,304,'Bamondi','à¦¬à¦¾à¦®à¦¨à§à¦¦à§€'),(848,304,'Dhankolla','à¦§à¦¾à¦¨à¦–à§‹à¦²à¦¾'),(849,304,'Kathuli','à¦•à¦¾à¦¥à§à¦²à§€'),(850,304,'Kazipur','à¦•à¦¾à¦œà¦¿à¦ªà§à¦°'),(851,304,'Motmura','à¦®à¦Ÿà¦®à§à¦¡à¦¼à¦¾'),(852,304,'Raipur','à¦°à¦¾à¦¯à¦¼à¦ªà§à¦°'),(853,304,'Shaharbati','à¦¸à¦¾à¦¹à¦¾à¦°à¦¬à¦¾à¦Ÿà§€'),(854,304,'Sholotaka','à¦·à§‹à¦²à¦Ÿà¦¾à¦•à¦¾'),(855,304,'Tentulbaria','à¦¤à§‡à¦à¦¤à§à¦²à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(856,305,'Auria','à¦†à¦‰à§œà¦¿à§Ÿà¦¾ '),(857,305,'Bashgram','à¦¬à¦¾à¦¶à¦—à§à¦°à¦¾à¦® '),(858,305,'Bhadrabila','à¦­à¦¦à§à¦°à¦¬à¦¿à¦²à¦¾ '),(859,305,'Bisali','à¦¬à¦¿à¦›à¦¾à¦²à§€ '),(860,305,'Chandiborpur','à¦šà¦¨à§à¦¡à¦¿à¦¬à¦°à¦ªà§à¦° '),(861,305,'Habokhali','à¦¹à¦¬à¦–à¦¾à¦²à§€ '),(862,305,'Kalora','à¦•à¦²à§‹à§œà¦¾ '),(863,305,'Maijpara','à¦®à¦¾à¦‡à¦œà¦ªà¦¾à§œà¦¾ '),(864,305,'Mulia','à¦®à§à¦²à¦¿à§Ÿà¦¾'),(865,305,'Shahabad','à¦¶à¦¾à¦¹à¦¾à¦¬à¦¾à¦¦ '),(866,305,'Sheikhati','à¦¸à§‡à¦–à¦¹à¦¾à¦Ÿà§€ '),(867,305,'Singasholpur','à¦¸à¦¿à¦™à§à¦—à¦¾à¦¶à§‹à¦²à¦ªà§à¦° '),(868,305,'Tularampur','à¦¤à§à¦²à¦¾à¦°à¦¾à¦®à¦ªà§à¦° '),(869,194,'Digholiaup1','à¦¦à¦¿à¦˜à¦²à¦¿à§Ÿà¦¾ '),(870,194,'Itna','à¦‡à¦¤à¦¨à¦¾ '),(871,194,'Joypur','à¦œà§Ÿà¦ªà§à¦° '),(872,194,'Kashipur','à¦•à¦¾à¦¶à¦¿à¦ªà§à¦° '),(873,194,'Kotakol','à¦•à§‹à¦Ÿà¦¾à¦•à§‹à¦² '),(874,194,'Lahuria','à¦²à¦¾à¦¹à§à§œà¦¿à§Ÿà¦¾ '),(875,194,'Lakshmipasha','à¦²à¦•à§à¦·à§€à¦ªà¦¾à¦¶à¦¾ '),(876,194,'Lohagora','à¦²à§‹à¦¹à¦¾à¦—à§œà¦¾ '),(877,194,'Mallikpur','à¦®à¦²à§à¦²à¦¿à¦•à¦ªà§à¦° '),(878,194,'Naldi','à¦¨à¦²à¦¦à§€ '),(879,194,'Noagram','à¦¨à§‹à§Ÿà¦¾à¦—à§à¦°à¦¾à¦® '),(880,194,'Salnagar','à¦¶à¦¾à¦²à¦¨à¦—à¦° '),(881,307,'Babrahasla','à¦¬à¦¾à¦¬à¦°à¦¾-à¦¹à¦¾à¦šà¦²à¦¾ '),(882,307,'Baioshona','à¦¬à¦¾à¦à¦¸à§‹à¦¨à¦¾ '),(883,307,'Boronaleliasabad','à¦¬à§œà¦¨à¦¾à¦²-à¦‡à¦²à¦¿à§Ÿà¦¾à¦›à¦¾à¦¬à¦¾à¦¦ '),(884,307,'Chacuri','à¦šà¦¾à¦šà§à§œà§€ '),(885,307,'Hamidpur','à¦¹à¦¾à¦®à¦¿à¦¦à¦ªà§à¦° '),(886,307,'Jaynagor','à¦œà§Ÿà¦¨à¦—à¦° '),(887,307,'Kalabaria','à¦•à¦²à¦¾à¦¬à¦¾à§œà§€à§Ÿà¦¾ '),(888,307,'Khashial','à¦–à¦¾à¦¸à¦¿à§Ÿà¦¾à¦² '),(889,307,'Mauli','à¦®à¦¾à¦‰à¦²à§€ '),(890,307,'Pahordanga','à¦ªà¦¹à¦°à¦¡à¦¾à¦™à§à¦—à¦¾ '),(891,307,'Panchgram','à¦ªà¦¾à¦à¦šà¦—à§à¦°à¦¾à¦®'),(892,307,'Peroli','à¦ªà§‡à§œà¦²à§€ '),(893,307,'Purulia','à¦ªà§à¦°à§à¦²à¦¿à§Ÿà¦¾ '),(894,307,'Salamabad','à¦¸à¦¾à¦²à¦¾à¦®à¦¾à¦¬à¦¾à¦¦ '),(895,312,'10noujangram','à§§à§¦ à¦¨à¦‚ à¦‰à¦œà¦¾à¦¨à¦—à§à¦°à¦¾à¦® à¦‡à¦‰à¦¨à¦¿à¦¯à¦¨'),(896,312,'11noabdulpur','à§§à§§ à¦¨à¦‚ à¦†à¦¬à§à¦¦à¦¾à¦²à¦ªà§à¦° '),(897,312,'12noharinarayanpur','à§§à§¨ à¦¨à¦‚ à¦¹à¦°à¦¿à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦ªà§à¦°'),(898,312,'13nomonohardia','à§§à§© à¦¨à¦‚ à¦®à¦¨à§‹à¦¹à¦°à¦¦à¦¿à§Ÿà¦¾'),(899,312,'14nogoswamidurgapur','à§§à§ª à¦¨à¦‚ à¦—à§‹à¦¸à§à¦¬à¦¾à¦®à§€ à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(900,312,'1nohatashharipur','à§§ à¦¨à¦‚ à¦¹à¦¾à¦Ÿà¦¶ à¦¹à¦°à¦¿à¦ªà§à¦° '),(901,312,'2nobarkhada','à§¨ à¦¨à¦‚ à¦¬à¦¾à¦°à¦–à¦¾à¦¦à¦¾ '),(902,312,'3nomazampur','à§© à¦¨à¦‚ à¦®à¦œà¦®à¦ªà§à¦° '),(903,312,'4nobottail','à§ª à¦¨à¦‚ à¦¬à¦Ÿà¦¤à§ˆà¦²'),(904,312,'5noalampur','à§« à¦¨à¦‚ à¦†à¦²à¦¾à¦®à¦ªà§à¦°'),(905,312,'6noziaraakhi','à§¬ à¦¨à¦‚ à¦œà¦¿à§Ÿà¦¾à¦°à¦¾à¦–à§€'),(906,312,'7noailchara','à§­ à¦¨à¦‚ à¦†à¦‡à¦²à¦šà¦¾à¦°à¦¾'),(907,312,'8nopatikabari','à§® à¦¨à¦‚ à¦ªà¦¾à¦Ÿà¦¿à¦•à¦¾à¦¬à¦¾à§œà§€ '),(908,312,'9nojhaudia','à§¯ à¦¨à¦‚ à¦à¦¾à¦‰à¦¦à¦¿à§Ÿà¦¾ '),(909,313,'10nopanti','à§§à§¦ à¦¨à¦‚ à¦ªà¦¾à¦¨à§à¦Ÿà¦¿'),(910,313,'11nocharsadipur','à§§à§§ à¦¨à¦‚ à¦šà¦°à¦¸à¦¾à¦¦à§€à¦ªà§à¦°'),(911,313,'1nokaya','à§§ à¦¨à¦‚ à¦•à§Ÿà¦¾ '),(912,313,'2noshelaidah','à§¨ à¦¨à¦‚ à¦¶à¦¿à¦²à¦¾à¦‡à¦¦à¦¹'),(913,313,'3nojagonnathpur','à§© à¦¨à¦‚ à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦ªà§à¦° '),(914,313,'4nosadki','à§ª à¦¨à¦‚ à¦¸à¦¦à¦•à§€ '),(915,313,'5nonandolalpur','à§« à¦¨à¦‚ à¦¨à¦¨à§à¦¦à¦²à¦¾à¦²à¦ªà§à¦°'),(916,313,'6nochapra','à§¬ à¦¨à¦‚ à¦šà¦¾à¦ªà§œà¦¾'),(917,313,'7nobagulat','à§­ à¦¨à¦‚ à¦¬à¦¾à¦—à§à¦²à¦¾à¦Ÿ'),(918,313,'8nojaduboyra','à§® à¦¨à¦‚ à¦¯à¦¦à§à¦¬à§Ÿà¦°à¦¾'),(919,313,'9nochadpur','à§¯ à¦¨à¦‚ à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(920,314,'1nokhoksa','à§§ à¦¨à¦‚ à¦–à§‹à¦•à¦¸à¦¾'),(921,314,'2noosmanpur','à§¨ à¦¨à¦‚ à¦“à¦¸à¦®à¦¾à¦¨à¦ªà§à¦°'),(922,314,'3nobethbaria','à§© à¦¨à¦‚ à¦¬à§‡à¦¤à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(923,314,'4nojanipur','à§ª à¦¨à¦‚ à¦œà¦¾à¦¨à¦¿à¦ªà§à¦°'),(924,314,'5noshimulia','à§« à¦¨à¦‚ à¦¶à¦¿à¦®à§à¦²à¦¿à§Ÿà¦¾'),(925,314,'6noshomospur','à§¬ à¦¨à¦‚ à¦¶à§‹à¦®à¦¸à¦ªà§à¦°'),(926,314,'8nojoyntihazra','à§® à¦¨à¦‚ à¦œà§Ÿà¦¨à§à¦¤à§€à¦¹à¦¾à¦œà¦°à¦¾ '),(927,314,'9noambaria','à§¯ à¦¨à¦‚ à¦†à¦®à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(928,314,'Gopgram7','à§­ à¦¨à¦‚ à¦—à§‹à¦ªà¦—à§à¦°à¦¾à¦®'),(929,315,'11nomalihad','à§§à§§ à¦¨à¦‚ à¦®à¦¾à¦²à¦¿à¦¹à¦¾à¦¦'),(930,315,'Ambaria','à¦†à¦®à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(931,315,'Amla','à¦†à¦®à¦²à¦¾ '),(932,315,'Bahalbaria','à¦¬à¦¹à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(933,315,'Baruipara','à¦¬à¦¾à¦°à§à¦‡à¦ªà¦¾à§œà¦¾ '),(934,315,'Chhatian','à¦›à¦¾à¦¤à¦¿à§Ÿà¦¾à¦¨'),(935,315,'Chithalia','à¦šà¦¿à¦¥à¦²à¦¿à§Ÿà¦¾'),(936,315,'Dhubail','à¦§à§‚à¦¬à¦‡à¦²'),(937,315,'Fulbaria','à¦«à§à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(938,315,'Kursha','à¦•à§à¦°à§à¦¶à¦¾'),(939,315,'Poradaha','à¦ªà§‹à§œà¦¾à¦¦à¦¹'),(940,315,'Sadarpur','à¦¸à¦¦à¦°à¦ªà§à¦°'),(941,315,'Talbaria','à¦¤à¦¾à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(942,316,'5noramkrishnopur','à§« à¦¨à¦‚ à¦°à¦¾à¦®à¦•à§ƒà¦·à§à¦£à¦ªà§à¦°'),(943,316,'9norefaitpur','à§¯ à¦¨à¦‚ à¦°à¦¿à¦«à¦¾à¦‡à¦¤à¦ªà§à¦° '),(944,316,'Adabaria','à¦†à¦¦à¦¾à¦¬à¦¾à§œà§€à§Ÿà¦¾ '),(945,316,'Aria','à¦†à§œà¦¿à§Ÿà¦¾'),(946,316,'Boalia','à¦¬à§‹à§Ÿà¦¾à¦²à¦¿à§Ÿà¦¾'),(947,316,'Chilmary','à¦šà¦¿à¦²à¦®à¦¾à¦°à§€'),(948,316,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦° '),(949,316,'Hogolbaria','à¦¹à§‹à¦—à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(950,316,'Khalishakundi','à¦–à¦²à¦¿à¦¶à¦¾à¦•à§à¦¨à§à¦¡à¦¿ '),(951,316,'Moricha','à¦®à¦°à¦¿à¦šà¦¾ '),(952,316,'Mothurapur','à¦®à¦¥à§à¦°à¦¾à¦ªà§à¦° '),(953,316,'Philipnagor','à¦«à¦¿à¦²à¦¿à¦ªà¦¨à¦—à¦° '),(954,316,'Piarpur','à¦ªà¦¿à§Ÿà¦¾à¦°à¦ªà§à¦° '),(955,316,'Pragpur','à¦ªà§à¦°à¦¾à¦—à¦ªà§à¦°'),(956,317,'1nobahadurpur','à§§ à¦¨à¦‚ à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦° '),(957,317,'2nomukarimpur','à§¨ à¦¨à¦‚ à¦®à§‹à¦•à¦¾à¦°à¦¿à¦®à¦ªà§à¦° '),(958,317,'3nobahirchar','à§© à¦¨à¦‚ à¦¬à¦¾à¦¹à¦¿à¦°à¦šà¦°'),(959,317,'4nochandgram','à¦šà¦¾à¦à¦¦à¦—à§à¦°à¦¾à¦®'),(960,317,'5nodharampur','à§« à¦¨à¦‚ à¦§à¦°à¦®à¦ªà§à¦° '),(961,317,'6nojuniadah','à§¬ à¦¨à¦‚ à¦œà§à¦¨à¦¿à§Ÿà¦¾à¦¦à¦¹ '),(962,318,'Arpara','à¦†à§œà¦ªà¦¾à§œà¦¾ '),(963,318,'Bunagati','à¦¬à§à¦¨à¦¾à¦—à¦¾à¦¤à§€ '),(964,318,'Dhaneshwargati','à¦§à¦¨à§‡à¦¶à§à¦¬à¦°à¦—à¦¾à¦¤à§€ '),(965,318,'Gongarampur','à¦—à¦™à§à¦—à¦¾à¦°à¦¾à¦®à¦ªà§à¦° '),(966,318,'Shalikha','à¦¶à¦¾à¦²à¦¿à¦–à¦¾ '),(967,318,'Shatakhali','à¦¶à¦¤à¦–à¦¾à¦²à§€ '),(968,318,'Talkhari','à¦¤à¦¾à¦²à¦–à§œà¦¿ '),(969,11,'Amalshar','à¦†à¦®à¦²à¦¸à¦¾à¦°'),(970,11,'Dariapur','à¦¦à§à¦¬à¦¾à¦°à¦¿à§Ÿà¦¾à¦ªà§à¦° '),(971,11,'Goyespur','à¦—à§Ÿà§‡à¦¶à¦ªà§à¦° '),(972,11,'Kadirpara','à¦•à¦¾à¦¦à¦¿à¦°à¦ªà¦¾à§œà¦¾  '),(973,11,'Nakol','à¦¨à¦¾à¦•à§‹à¦² '),(974,11,'Shobdalpur','à¦¸à¦¬à§à¦¦à¦¾à¦²à¦ªà§à¦° '),(975,11,'Sreekol','à¦¶à§à¦°à§€à¦•à§‹à¦² '),(976,11,'Sreepur','à¦¶à§à¦°à§€à¦ªà§à¦° '),(977,320,'Atharokhada','à¦†à¦ à¦¾à¦°à¦–à¦¾à¦¦à¦¾ '),(978,320,'Baroilpolita','à¦¬à§‡à¦°à¦‡à¦² à¦ªà¦²à¦¿à¦¤à¦¾ '),(979,320,'Bogia','à¦¬à¦—à¦¿à§Ÿà¦¾ '),(980,320,'Chawlia','à¦šà¦¾à¦‰à¦²à¦¿à§Ÿà¦¾ '),(981,320,'Gopalgram','à¦—à§‹à¦ªà¦¾à¦²à¦—à§à¦°à¦¾à¦® '),(982,320,'Hazipur','à¦¹à¦¾à¦œà§€à¦ªà§à¦°'),(983,320,'Hazrapur','à¦¹à¦¾à¦œà¦°à¦¾à¦ªà§à¦° '),(984,320,'Jagdal','à¦œà¦—à¦¦à¦² '),(985,320,'Kosundi','à¦•à¦›à§à¦¨à§à¦¦à§€ '),(986,320,'Kuchiamora','à¦•à§à¦šà¦¿à§Ÿà¦¾à¦®à§‹ '),(987,320,'Moghi','à¦®à¦˜à§€'),(988,320,'Raghobdair','à¦°à¦¾à¦˜à¦¬à¦¦à¦¾à¦‡à§œ '),(989,320,'Satrijitpur','à¦¶à¦¤à§à¦°à§à¦œà¦¿à§Žà¦ªà§à¦° '),(990,321,'Babukhali','à¦¬à¦¾à¦¬à§à¦–à¦¾à¦²à§€ '),(991,321,'Balidia','à¦¬à¦¾à¦²à¦¿à¦¦à¦¿à§Ÿà¦¾ '),(992,321,'Binodpur','à¦¬à¦¿à¦¨à§‹à¦¦à¦ªà§à¦° '),(993,321,'Digha','à¦¦à§€à¦˜à¦¾ '),(994,321,'Mohammadpur','à¦®à¦¹à¦®à§à¦®à¦¦à¦ªà§à¦° '),(995,321,'Nohata','à¦¨à¦¹à¦¾à¦Ÿà¦¾ '),(996,321,'Palashbaria','à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€à§Ÿà¦¾ '),(997,321,'Rajapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦° '),(998,260,'Barahorispur','à§§à§¦ à¦¨à¦‚ à¦¬à¦¡à¦¼à¦¹à¦°à¦¿à¦¶à¦ªà§à¦°'),(999,260,'Biprobelghoria','à§¦à§« à¦¨à¦‚ à¦¬à¦¿à¦ªà§à¦°à¦¬à§‡à¦²à¦˜à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(1000,260,'Brahmapur','à§§ à¦¨à¦‚  à¦¬à§à¦°à¦¹à§à¦®à¦ªà§à¦°'),(1001,260,'Chhatni','à§¦à§¬ à¦¨à¦‚ à¦›à¦¾à¦¤à¦¨à§€'),(1002,260,'Dighapatia','à§¦à§® à¦¨à¦‚ à¦¦à¦¿à¦˜à¦¾à¦ªà¦¤à¦¿à¦¯à¦¼à¦¾'),(1003,260,'Halsa','à§§à§¨ à¦¨à¦‚ à¦¹à¦¾à¦²à¦¸à¦¾'),(1004,260,'Kaphuria','à§§à§§ à¦¨à¦‚ à¦•à¦¾à¦«à§à¦°à¦¿à¦¯à¦¼à¦¾'),(1005,260,'Khajura','à§¦à§© à¦¨à¦‚ à¦–à¦¾à¦œà§à¦°à¦¾'),(1006,260,'Luxmipurkholabaria','à§¦à§¯ à¦¨à¦‚ à¦²à¦•à§à¦·à§€à¦ªà§à¦° à¦–à§‹à¦²à¦¾à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(1007,260,'Madhnagar','à§¦à§¨ à¦¨à¦‚ à¦®à¦¾à¦§à¦¨à¦—à¦°'),(1008,260,'Piprul','à§¦à§ª à¦¨à¦‚ à¦ªà¦¿à¦ªà¦°à§à¦²'),(1009,260,'Tebaria','à§¦à§­ à¦¨à¦‚ à¦¤à§‡à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(1010,261,'Chamari','à§¦à§« à¦¨à¦‚ à¦šà¦¾à¦®à¦¾à¦°à§€'),(1011,261,'Chaugram','à§§à§¦ à¦¨à¦‚ à¦šà§Œà¦—à§à¦°à¦¾à¦®'),(1012,261,'Chhatardighi','à§§à§§ à¦¨à¦‚ à¦›à¦¾à¦¤à¦¾à¦°à¦¦à¦¿à¦˜à§€'),(1013,261,'Dahia','à§¦à§¨ à¦¨à¦‚ à¦¡à¦¾à¦¹à¦¿à¦¯à¦¼à¦¾'),(1014,261,'Hatiandaha','à§¦à§¬ à¦¨à¦‚ à¦¹à¦¾à¦¤à¦¿à¦¯à¦¼à¦¾à¦¨à¦¦à¦¹'),(1015,261,'Italy','à§¦à§© à¦¨à¦‚ à¦‡à¦Ÿà¦¾à¦²à§€'),(1016,261,'Kalam','à§¦à§ª à¦¨à¦‚ à¦•à¦²à¦®'),(1017,261,'Lalore','à§¦à§­ à¦¨à¦‚ à¦²à¦¾à¦²à§‹à¦°'),(1018,261,'Ramanandakhajura','à§§à§¨ à¦¨à¦‚ à¦°à¦¾à¦®à¦¾à¦¨à§à¦¦à¦–à¦¾à¦œà§à¦°à¦¾'),(1019,261,'Sherkole','à§¦à§® à¦¨à¦‚ à¦¶à§‡à¦°à¦•à§‹à¦²'),(1020,261,'Sukash','à§¦à§§ à¦¨à¦‚ à¦¶à§à¦•à¦¾à¦¶'),(1021,261,'Tajpur','à§¦à§¯ à¦¨à¦‚ à¦¤à¦¾à¦œà¦ªà§à¦°'),(1022,262,'Baraigram','à§¦à§¨ à¦¨à¦‚ à¦¬à¦¡à¦¼à¦¾à¦‡à¦—à§à¦°à¦¾à¦®'),(1023,262,'Chandai','à§¦à§­ à¦¨à¦‚ à¦šà¦¾à¦¨à§à¦¦à¦¾à¦‡'),(1024,262,'Gopalpur','à§¦à§¬ à¦¨à¦‚ à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(1025,262,'Joari','à§¦à§§ à¦¨à¦‚ à¦œà§‹à¦¯à¦¼à¦¾à¦¡à¦¼à§€'),(1026,262,'Majgoan','à§¦à§« à¦¨à¦‚ à¦®à¦¾à¦à¦—à¦¾à¦“'),(1027,262,'Nagor','à§¦à§ª à¦¨à¦‚ à¦¨à¦—à¦°'),(1028,262,'Zonail','à§¦à§© à¦¨à¦‚ à¦œà§‹à¦¨à¦¾à¦‡à¦²'),(1029,263,'Bagatipara','à§¦à§© à¦¨à¦‚ à¦¬à¦¾à¦—à¦¾à¦¤à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(1030,263,'Dayarampur','à§¦à§ª à¦¨à¦‚ à¦¦à¦¯à¦¼à¦¾à¦°à¦¾à¦®à¦ªà§à¦°'),(1031,263,'Faguardiar','à§¦à§« à¦¨à¦‚ à¦«à¦¾à¦—à§à¦¯à¦¼à¦¾à¦°à¦¦à¦¿à¦¯à¦¼à¦¾à¦¡à¦¼'),(1032,263,'Jamnagor','à§¦à§¨ à¦¨à¦‚ à¦œà¦¾à¦®à¦¨à¦—à¦°'),(1033,263,'Panka','à§¦à§§ à¦¨à¦‚ à¦ªà¦¾à¦à¦•à¦¾'),(1034,264,'Arbab','à§¦à§ª à¦¨à¦‚ à¦†à¦¡à¦¼à¦¬à¦¾à¦¬'),(1035,264,'Arjunpur','à§¦à§¯ à¦¨à¦‚ à¦…à¦°à§à¦œà§à¦¨à¦ªà§à¦° à¦¬à¦°à¦®à¦¹à¦¾à¦Ÿà§€'),(1036,264,'Bilmaria','à§¦à§« à¦¨à¦‚ à¦¬à¦¿à¦²à¦®à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(1037,264,'Chongdhupoil','à§¦à§© à¦¨à¦‚ à¦šà¦‚à¦§à§à¦ªà¦‡à¦²'),(1038,264,'Duaria','à§¦à§¬ à¦¨à¦‚ à¦¦à§à¦¯à¦¼à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(1039,264,'Durduria','à§¦à§® à¦¨à¦‚ à¦¦à§à¦¡à¦¼à¦¦à§à¦°à¦¿à¦¯à¦¼à¦¾'),(1040,264,'Iswardi','à§¦à§¨ à¦¨à¦‚ à¦ˆà¦¶à§à¦¬à¦°à¦¦à§€'),(1041,264,'Kadimchilan','à§§à§¦ à¦¨à¦‚ à¦•à¦¦à¦¿à¦®à¦šà¦¿à¦²à¦¾à¦¨ '),(1042,264,'Lalpur','à§¦à§§ à¦¨à¦‚ à¦²à¦¾à¦²à¦ªà§à¦°'),(1043,264,'Oalia','à§¦à§­ à¦¨à¦‚ à¦“à¦¯à¦¼à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(1044,265,'Biaghat','à§¦à§¨ à¦¨à¦‚ à¦¬à¦¿à¦¯à¦¼à¦¾à¦˜à¦¾à¦Ÿ'),(1045,265,'Chapila','à§¦à§¬ à¦¨à¦‚ à¦šà¦¾à¦ªà¦¿à¦²à¦¾'),(1046,265,'Dharabarisha','à§¦à§« à¦¨à¦‚ à¦§à¦¾à¦°à¦¾à¦¬à¦¾à¦°à¦¿à¦·à¦¾'),(1047,265,'Khubjipur','à§¦à§© à¦¨à¦‚ à¦–à§à¦¬à¦œà§€à¦ªà§à¦°'),(1048,265,'Moshindha','à§¦à§ª à¦¨à¦‚ à¦®à¦¸à¦¿à¦¨à§à¦¦à¦¾'),(1049,265,'Nazirpur','à§¦à§§ à¦¨à¦‚ à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°'),(1050,230,'Ahammadpur','à¦†à¦¹à¦®à§à¦®à¦¦à¦ªà§à¦°'),(1051,230,'Dulai','à¦¦à§à¦²à¦¾à¦‡'),(1052,230,'Hatkhali','à¦¹à¦¾à¦Ÿà¦–à¦¾à¦²à§€'),(1053,230,'Manikhat','à¦®à¦¾à¦¨à¦¿à¦•à¦¹à¦¾à¦Ÿ'),(1054,230,'Nazirganj','à¦¨à¦¾à¦œà¦¿à¦°à¦—à¦žà§à¦œ'),(1055,230,'Raninagar','à¦°à¦¾à¦£à§€à¦¨à¦—à¦°'),(1056,230,'Sagorkandi','à¦¸à¦¾à¦—à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1057,230,'Satbaria','à¦¸à¦¾à¦¤à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(1058,230,'Tantibonda','à¦¤à¦¾à¦à¦¤à¦¿à¦¬à¦¨à§à¦¦'),(1059,230,'Vaina','à¦­à¦¾à§Ÿà¦¨à¦¾'),(1060,231,'Dashuria','à¦¦à¦¾à¦¶à§à¦°à¦¿à§Ÿà¦¾'),(1061,231,'Luxmikunda','à¦²à¦•à§à¦·à§€à¦•à§à¦¨à§à¦¡à¦¾'),(1062,231,'Muladuli','à¦®à§à¦²à¦¾à¦¡à§à¦²à¦¿'),(1063,231,'Pakshi','à¦ªà¦¾à¦•à¦¶à§€'),(1064,231,'Sahapur','à¦¸à¦¾à¦¹à¦¾à¦ªà§à¦°'),(1065,231,'Sara','à¦¸à¦¾à¦à§œà¦¾'),(1066,231,'Silimpur','à¦›à¦²à¦¿à¦®à¦ªà§à¦°'),(1067,232,'Ashtamanisha','à¦…à¦·à§à¦Ÿà¦®à¦£à¦¿à¦·à¦¾'),(1068,232,'Bhangura','à¦­à¦¾à¦™à§à¦—à§à§œà¦¾'),(1069,232,'Dilpasar','à¦¦à¦¿à¦²à¦ªà¦¾à¦¶à¦¾à¦°'),(1070,232,'Khanmarich','à¦–à¦¾à¦¨à¦®à¦°à¦¿à¦š'),(1071,232,'Parbhangura','à¦ªà¦¾à¦°à¦­à¦¾à¦™à§à¦—à§à§œà¦¾'),(1072,233,'Ataikula','à¦†à¦¤à¦¾à¦‡à¦•à§à¦²à¦¾'),(1073,233,'Bharara','à¦­à¦¾à¦à§œà¦¾à¦°à¦¾'),(1074,233,'Chartarapur','à¦šà¦°à¦¤à¦¾à¦°à¦¾à¦ªà§à¦°'),(1075,233,'Dapunia','à¦¦à¦¾à¦ªà§à¦¨à¦¿à§Ÿà¦¾'),(1076,233,'Dogachi','à¦¦à§‹à¦—à¦¾à¦›à§€'),(1077,233,'Gayeshpur','à¦—à§Ÿà§‡à¦¶à¦ªà§à¦°'),(1078,233,'Hemayetpur','à¦¹à§‡à¦®à¦¾à§Ÿà§‡à¦¤à¦ªà§à¦°'),(1079,233,'Malanchi','à¦®à¦¾à¦²à¦žà§à¦šà¦¿'),(1080,233,'Maligachha','à¦®à¦¾à¦²à¦¿à¦—à¦¾à¦›à¦¾'),(1081,233,'Sadullahpur','à¦¸à¦¾à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦°'),(1082,234,'Chakla','à¦šà¦¾à¦•à¦²à¦¾'),(1083,234,'Dhalarchar','à¦¢à¦¾à¦²à¦¾à¦° à¦šà¦°'),(1084,234,'Haturianakalia','à¦¹à¦¾à¦Ÿà§à¦°à¦¿à§Ÿà¦¾ à¦¨à¦¾à¦•à¦¾à¦²à¦¿à§Ÿà¦¾'),(1085,234,'Jatsakhini','à¦œà¦¾à¦¤à¦¸à¦¾à¦–à¦¿à¦¨à¦¿'),(1086,234,'Koitola','à¦•à§ˆà¦Ÿà§‹à¦²à¦¾'),(1087,234,'Masumdia','à¦®à¦¾à¦¸à§à¦®à¦¦à¦¿à§Ÿà¦¾'),(1088,234,'Notunvarenga','à¦¨à¦¤à§à¦¨ à¦­à¦¾à¦°à§‡à¦™à§à¦—à¦¾'),(1089,234,'Puranvarenga','à¦ªà§à¦°à¦¾à¦¨ à¦­à¦¾à¦°à§‡à¦™à§à¦—à¦¾'),(1090,234,'Ruppur','à¦°à§‚à¦ªà¦ªà§à¦°'),(1091,235,'Chandba','à¦šà¦¾à¦à¦¦à¦­à¦¾'),(1092,235,'Debottar','à¦¦à§‡à¦¬à§‹à¦¤à§à¦¤à¦°'),(1093,235,'Ekdanta','à¦à¦•à¦¦à¦¨à§à¦¤'),(1094,235,'Laxshmipur','à¦²à¦•à§à¦·à§€à¦ªà§à¦°'),(1095,235,'Majhpara','à¦®à¦¾à¦œà¦ªà¦¾à§œà¦¾'),(1096,236,'Bilchalan','à¦¬à¦¿à¦²à¦šà¦²à¦¨'),(1097,236,'Chhaikola','à¦›à¦¾à¦‡à¦•à§‹à¦²à¦¾'),(1098,236,'Danthiabamangram','à¦¦à¦¾à¦¤à¦¿à§Ÿà¦¾ à¦¬à¦¾à¦®à¦¨à¦—à§à¦°à¦¾à¦®'),(1099,236,'Failjana','à¦«à§ˆà¦²à¦œà¦¾à¦¨à¦¾'),(1100,236,'Gunaigachha','à¦—à§à¦¨à¦¾à¦‡à¦—à¦¾à¦›à¦¾'),(1101,236,'Handial','à¦¹à¦¾à¦¨à§à¦¡à¦¿à§Ÿà¦¾à¦²'),(1102,236,'Haripur','à¦¹à¦°à¦¿à¦ªà§à¦°'),(1103,236,'Mothurapur','à¦®à¦¥à§à¦°à¦¾à¦ªà§à¦°'),(1104,236,'Mulgram','à¦®à§à¦²à¦—à§à¦°à¦¾à¦®'),(1105,236,'Nimaichara','à¦¨à¦¿à¦®à¦¾à¦‡à¦šà§œà¦¾'),(1106,236,'Parshadanga','à¦ªà¦¾à¦°à§à¦¶à§à¦¬à¦¡à¦¾à¦™à§à¦—à¦¾'),(1107,237,'Bhulbaria','à¦­à§à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(1108,237,'Dhopadaha','à¦§à§‹à¦ªà¦¾à¦¦à¦¹'),(1109,237,'Dhulauri','à¦§à§à¦²à¦¾à¦‰à§œà¦¿'),(1110,237,'Gaurigram','à¦—à§Œà¦°à§€à¦—à§à¦°à¦¾à¦®'),(1111,237,'Karamja','à¦•à¦°à¦®à¦œà¦¾'),(1112,237,'Kashinathpur','à¦•à¦¾à¦¶à¦¿à¦¨à¦¾à¦¥à¦ªà§à¦°'),(1113,237,'Khetupara','à¦•à§à¦·à§‡à¦¤à§à¦ªà¦¾à§œà¦¾'),(1114,237,'Nagdemra','à¦¨à¦¾à¦—à¦¡à§‡à¦®à§œà¦¾'),(1115,237,'Nandanpur','à¦¨à¦¨à§à¦¦à¦¨à¦ªà§à¦°'),(1116,237,'Rataiqula','à¦†à¦°-à¦†à¦¤à¦¾à¦‡à¦•à§à¦²à¦¾'),(1117,238,'Banwarinagar','à¦¬à¦¨à¦“à§Ÿà¦¾à¦°à§€à¦¨à¦—à¦°'),(1118,238,'Brilahiribari','à¦¬à§ƒà¦²à¦¾à¦¹à¦¿à§œà§€à¦¬à¦¾à§œà§€'),(1119,238,'Demra','à¦¡à§‡à¦®à§œà¦¾'),(1120,238,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(1121,238,'Hadal','à¦¹à¦¾à¦¦à¦²'),(1122,238,'Pungali','à¦ªà§à¦™à§à¦—à§à¦²à¦¿'),(1123,409,'Bangalipur','à§© à¦¨à¦‚ à¦¬à¦¾à¦™à§à¦—à¦¾à¦²à§€à¦ªà§à¦° '),(1124,409,'Botlagari','à§ªà¦¨à¦‚ à¦¬à§‹à¦¤à¦²à¦¾à¦—à¦¾à§œà§€ '),(1125,409,'Kamarpukur','à¦•à¦¾à¦®à¦¾à¦°à¦ªà§à¦•à§à¦° à¦‡à¦‰à¦¾à¦¨à¦¯à¦¼à¦¨'),(1126,409,'Kasirambelpukur','à§¨à¦¨à¦‚ à¦•à¦¾à¦¶à¦¿à¦°à¦¾à¦®à¦¬à§‡à¦²à¦ªà§à¦•à§à¦° '),(1127,409,'Khatamadhupur','à§« à¦¨à¦‚ à¦–à¦¾à¦¤à¦¾ à¦®à¦§à§à¦ªà§à¦°'),(1128,410,'Bamunia','à§«à¦¨à¦‚ à¦¬à¦¾à¦®à§à¦¨à§€à¦¯à¦¼à¦¾'),(1129,410,'Bhogdaburi','à§§à¦¨à¦‚ à¦­à§‹à¦—à¦¡à¦¾à¦¬à§à¦¡à¦¼à§€'),(1130,410,'Boragari','à§­à¦¨à¦‚ à¦¬à§‹à¦¡à¦¼à¦¾à¦—à¦¾à¦¡à¦¼à§€'),(1131,410,'Domar','à§®à¦¨à¦‚ à¦¡à§‹à¦®à¦¾à¦°'),(1132,410,'Gomnati','à§©à¦¨à¦‚ à¦—à§‹à¦®à¦¨à¦¾à¦¤à¦¿'),(1133,410,'Harinchara','à§§à§¦ à¦¨à¦‚ à¦¹à¦°à¦¿à¦£à¦šà¦°à¦¾'),(1134,410,'Jorabari','à§ªà¦¨à¦‚ à¦œà§‹à¦¡à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1135,410,'Ketkibari','à§¨à¦¨à¦‚ à¦•à§‡à¦¤à¦•à§€à¦¬à¦¾à¦¡à¦¼à§€'),(1136,410,'Pangamotukpur','à§¬à¦¨à¦‚ à¦ªà¦¾à¦‚à¦—à¦¾ à¦®à¦Ÿà¦•à¦ªà§à¦°'),(1137,410,'Sonarayup2','à§¯à¦¨à¦‚ à¦¸à§‹à¦¨à¦¾à¦°à¦¾à¦¯à¦¼'),(1138,411,'Balapara','à§¨à¦¨à¦‚ à¦¬à¦¾à¦²à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(1139,411,'Dimlasadar','à§©à¦¨à¦‚ à¦¡à¦¿à¦®à¦²à¦¾ à¦¸à¦¦à¦°'),(1140,411,'Gayabari','à§«à¦¨à¦‚ à¦—à¦¯à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1141,411,'Jhunagachhchapani','à§®à¦¨à¦‚ à¦à§à¦¨à¦¾à¦—à¦¾à¦› à¦šà¦¾à¦ªà¦¾à¦¨à§€'),(1142,411,'Khalishachapani','à§­à¦¨à¦‚ à¦–à¦¾à¦²à¦¿à¦¶à¦¾ à¦šà¦¾à¦ªà¦¾à¦¨à§€'),(1143,411,'Khogakharibari','à§ªà¦¨à¦‚ à¦–à¦—à¦¾ à¦–à¦¡à¦¼à¦¿à¦¬à¦¾à¦¡à¦¼à§€'),(1144,411,'Noutara','à§¬à¦¨à¦‚ à¦¨à¦¾à¦‰à¦¤à¦¾à¦°à¦¾'),(1145,411,'Paschimchhatnay','à§§à¦¨à¦‚ à¦ªà¦¶à§à¦šà¦¿à¦® à¦›à¦¾à¦¤à¦¨à¦¾à¦‡'),(1146,411,'Purbachhatnay','à§§à§¦ à¦¨à¦‚ à¦ªà§à¦°à§à¦¬ à¦›à¦¾à¦¤à¦¨à¦¾à¦‡'),(1147,411,'Tepakhribari','à§¯à¦¨à¦‚ à¦Ÿà§‡à¦ªà¦¾ à¦–à¦°à§€à¦¬à¦¾à¦¡à¦¼à§€'),(1148,412,'Balagram','à§© à¦¨à¦‚ à¦¬à¦¾à¦²à¦¾à¦—à§à¦°à¦¾à¦®'),(1149,412,'Dharmapal','à§«à¦¨à¦‚ à¦§à¦°à§à¦®à¦ªà¦¾à¦²'),(1150,412,'Douabari','à§§ à¦¨à¦‚ à¦¡à¦¾à¦‰à¦¯à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1151,412,'Golmunda','à§¨ à¦¨à¦‚ à¦—à§‹à¦²à¦®à§à¦¨à§à¦¡à¦¾'),(1152,412,'Golna','à§ª à¦¨à¦‚ à¦—à§‹à¦²à¦¨à¦¾'),(1153,412,'Kaimari','à§§à§§à¦¨à¦‚ à¦•à§ˆà¦®à¦¾à¦°à§€ '),(1154,412,'Kathali','à§®à¦¨à¦‚ à¦•à¦¾à¦ à¦¾à¦²à§€ '),(1155,412,'Khutamara','à§¯à¦¨à¦‚ à¦–à§à¦Ÿà¦¾à¦®à¦¾à¦°à¦¾ '),(1156,412,'Mirganj','à§­à¦¨à¦‚ à¦®à§€à¦°à¦—à¦žà§à¦œ'),(1157,412,'Shaulmari','à§§à§¦ à¦¨à¦‚ à¦¶à§Œà¦²à¦®à¦¾à¦°à§€'),(1158,412,'Simulbari','à§¬à¦¨à¦‚ à¦¶à¦¿à¦®à§à¦²à¦¬à¦¾à¦¡à¦¼à§€'),(1159,413,'Bahagili','à§©à¦¨à¦‚ à¦¬à¦¾à¦¹à¦¾à¦—à¦¿à¦²à¦¿'),(1160,413,'Barabhita','à§§à¦¨à¦‚ à¦¬à¦¡à¦¼à¦­à¦¿à¦Ÿà¦¾'),(1161,413,'Chandkhana','à§«à¦¨à¦‚ à¦šà¦¾à¦à¦¦à¦–à¦¾à¦¨à¦¾'),(1162,413,'Garagram','à§®à¦¨à¦‚ à¦—à¦¾à¦¡à¦¼à¦¾à¦—à§à¦°à¦¾à¦®'),(1163,413,'Kishoreganj','à§¬à¦¨à¦‚ à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ'),(1164,413,'Magura','à§¯à¦¨à¦‚ à¦®à¦¾à¦—à§à¦°à¦¾'),(1165,413,'Nitai','à§©à¦¨à¦‚ à¦¨à¦¿à¦¤à¦¾à¦‡'),(1166,413,'Putimari','à§¨à¦¨à¦‚ à¦ªà§à¦Ÿà¦¿à¦®à¦¾à¦°à§€'),(1167,413,'Ranachandi','à§­à¦¨à¦‚ à¦°à¦¨à¦šà¦¨à§à¦¡à¦¿'),(1168,414,'Chaorabargacha','à§§à¦¨à¦‚ à¦šà¦“à¦¡à¦¼à¦¾ à¦¬à¦¡à¦¼à¦—à¦¾à¦›à¦¾'),(1169,414,'Chaprasarnjami','à§§à§ª à¦¨à¦‚ à¦šà¦¾à¦ªà§œà¦¾'),(1170,414,'Charaikhola','à§§à§© à¦¨à¦‚ à¦šà§œà¦¾à¦‡à¦–à§‹à¦²à¦¾ '),(1171,414,'Gorgram','à§¨à¦¨à¦‚ à¦—à§‹à¦¡à¦¼à¦—à§à¦°à¦¾à¦®'),(1172,414,'Itakhola','à§¯ à¦¨à¦‚ à¦‡à¦Ÿà¦¾à¦–à§‹à¦²à¦¾ '),(1173,414,'Kachukata','à§­à¦¨à¦‚ à¦•à¦šà§à¦•à¦¾à¦Ÿà¦¾'),(1174,414,'Khoksabari','à§©à¦¨à¦‚ à¦–à§‹à¦•à¦¸à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1175,414,'Kundapukur','à§§à§¦ à¦¨à¦‚ à¦•à§à¦¨à§à¦¦à¦ªà§à¦•à§à¦° '),(1176,414,'Lakshmicha','à§§à§« à¦¨à¦‚ à¦²à¦•à§à¦·à§à¦®à§€à¦šà¦¾à¦ª'),(1177,414,'Palasbari','à§ªà¦¨à¦‚ à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à¦¡à¦¼à§€'),(1178,414,'Panchapukur','à§® à¦¨à¦‚ à¦ªà¦žà§à¦šà¦ªà§à¦•à§à¦° '),(1179,414,'Ramnagar','à§¬à¦¨à¦‚ à¦°à¦¾à¦®à¦¨à¦—à¦°'),(1180,414,'Sonaray','à§§à§§ à¦¨à¦‚ à¦¸à§‹à¦¨à¦¾à¦°à¦¾à§Ÿ'),(1181,414,'Songalsi','à§§à§¨ à¦¨à¦‚ à¦¸à¦‚à¦—à¦²à¦¶à§€'),(1182,414,'Tupamari','à¦Ÿà§à¦ªà¦¾à¦®à¦¾à¦°à§€'),(1183,10,'Barobari','à¦¬à§œà¦¬à¦¾à§œà§€'),(1184,10,'Gokunda','à¦—à§‹à¦•à§à¦¨à§à¦¡à¦¾ '),(1185,10,'Harati','à¦¹à¦¾à¦°à¦¾à¦Ÿà¦¿ '),(1186,10,'Khuniagachh','à¦–à§à¦¨à¦¿à§Ÿà¦¾à¦—à¦¾à¦› '),(1187,10,'Kulaghat','à¦•à§à¦²à¦¾à¦˜à¦¾à¦Ÿ '),(1188,10,'Mogolhat','à¦®à§‹à¦—à¦²à¦¹à¦¾à¦Ÿ'),(1189,10,'Mohendranagar','à¦®à¦¹à§‡à¦¨à§à¦¦à§à¦°à¦¨à¦—à¦° '),(1190,10,'Panchagram','à¦ªà¦žà§à¦šà¦—à§à¦°à¦¾à¦® '),(1191,10,'Rajpur','à¦°à¦¾à¦œà¦ªà§à¦° '),(1192,7,'Bhotmari','à¦­à§‹à¦Ÿà¦®à¦¾à¦°à§€ '),(1193,7,'Cholbola','à¦šà¦²à¦¬à¦²à¦¾ '),(1194,7,'Chondropur','à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦° '),(1195,7,'Dologram','à¦¦à¦²à¦—à§à¦°à¦¾à¦® '),(1196,7,'Goral','à¦—à§‹à§œà¦² '),(1197,7,'Kakina','à¦•à¦¾à¦•à¦¿à¦¨à¦¾ '),(1198,7,'Modati','à¦®à¦¦à¦¾à¦¤à§€ '),(1199,7,'Tushbhandar','à¦¤à§à¦·à¦­à¦¾à¦¨à§à¦¡à¦¾à¦° '),(1200,406,'Barokhata','à¦¬à§œà¦–à¦¾à¦¤à¦¾ '),(1201,406,'Dawabari','à¦¡à¦¾à¦‰à§Ÿà¦¾à¦¬à¦¾à§œà§€ '),(1202,406,'Fakirpara','à¦«à¦•à¦¿à¦°à¦ªà¦¾à§œà¦¾ '),(1203,406,'Goddimari','à¦—à¦¡à§à¦¡à¦¿à¦®à¦¾à¦°à§€ '),(1204,406,'Gotamari','à¦—à§‹à¦¤à¦¾à¦®à¦¾à¦°à§€ '),(1205,406,'Nowdabas','à¦¨à¦“à¦¦à¦¾à¦¬à¦¾à¦¸ '),(1206,406,'Paticapara','à¦ªà¦¾à¦Ÿà¦¿à¦•à¦¾à¦ªà¦¾à§œà¦¾ '),(1207,406,'Shaniajan','à¦¸à¦¾à¦¨à¦¿à§Ÿà¦¾à¦œà¦¾à¦¨ '),(1208,406,'Sindurna','à¦¸à¦¿à¦¨à§à¦¦à§à¦°à§à¦£à¦¾ '),(1209,406,'Singimari','à¦¸à¦¿à¦‚à¦—à§€à¦®à¦¾à¦°à§€ '),(1210,406,'Tongvhanga','à¦Ÿà¦‚à¦­à¦¾à¦™à§à¦—à¦¾'),(1211,406,'Vhelaguri','à¦­à§‡à¦²à¦¾à¦—à§à§œà¦¿ '),(1212,407,'Baura','à¦¬à¦¾à¦‰à§œà¦¾ '),(1213,407,'Burimari','à¦¬à§à§œà¦¿à¦®à¦¾à¦°à§€ '),(1214,407,'Dahagram','à¦¦à¦¹à¦—à§à¦°à¦¾à¦® '),(1215,407,'Jagatber','à¦œà¦—à¦¤à¦¬à§‡à§œ '),(1216,407,'Jongra','à¦œà§‹à¦‚à§œà¦¾ '),(1217,407,'Kuchlibari','à¦•à§à¦šà¦²à¦¿à¦¬à¦¾à§œà§€ '),(1218,407,'Patgram','à¦ªà¦¾à¦Ÿà¦—à§à¦°à¦¾à¦® '),(1219,407,'Sreerampur','à¦¶à§à¦°à§€à¦°à¦¾à¦®à¦ªà§à¦° '),(1220,91,'Bhaduria','à¦­à¦¾à¦¦à§à¦°à¦¿à§Ÿà¦¾'),(1221,91,'Binodnagar','à¦¬à¦¿à¦¨à§‹à¦¦à¦¨à¦—à¦°'),(1222,91,'Daudpur','à¦¦à¦¾à¦‰à¦¦à¦ªà§à¦°'),(1223,91,'Golapgonj','à¦—à§‹à¦²à¦¾à¦ªà¦—à¦žà§à¦œ'),(1224,91,'Joypur','à¦œà§Ÿà¦ªà§à¦°'),(1225,91,'Kushdaha','à¦•à§à¦¶à¦¦à¦¹'),(1226,91,'Mahmudpur','à¦®à¦¾à¦¹à¦¾à¦®à§à¦¦à¦ªà§à¦°'),(1227,91,'Putimara','à¦ªà§à¦Ÿà¦¿à¦®à¦¾à¦°à¦¾'),(1228,91,'Shalkhuria','à¦¶à¦¾à¦²à¦–à§à¦°à¦¿à§Ÿà¦¾'),(1229,392,'Bhognagar','à¦­à§‹à¦—à¦¨à¦—à¦°'),(1230,392,'Mohammadpur','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦°'),(1231,392,'Mohonpur','à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(1232,392,'Moricha','à¦®à¦°à¦¿à¦šà¦¾'),(1233,392,'Nijpara','à¦¨à¦¿à¦œà¦ªà¦¾à§œà¦¾'),(1234,392,'Paltapur','à¦ªà¦¾à¦²à§à¦Ÿà¦¾à¦ªà§à¦°'),(1235,392,'Polashbariup2','à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€'),(1236,392,'Sator','à¦¸à¦¾à¦¤à§‹à¦°'),(1237,392,'Shatagram','à¦¶à¦¤à¦—à§à¦°à¦¾à¦®'),(1238,392,'Shibrampur','à¦¶à¦¿à¦¬à¦°à¦¾à¦®à¦ªà§à¦°'),(1239,392,'Sujalpur','à¦¸à§à¦œà¦¾à¦²à¦ªà§à¦°'),(1240,393,'Bulakipur','à¦¬à§à¦²à¦¾à¦•à§€à¦ªà§à¦°'),(1241,393,'Ghoraghat','à¦˜à§‹à§œà¦¾à¦˜à¦¾à¦Ÿ'),(1242,393,'Palsha','à¦ªà¦¾à¦²à¦¶à¦¾'),(1243,393,'Singra','à¦¸à¦¿à¦‚à§œà¦¾'),(1244,394,'Binail','à¦¬à¦¿à¦¨à¦¾à¦‡à¦²'),(1245,394,'Dior','à¦¦à¦¿à¦“à§œ'),(1246,394,'Jatbani','à¦œà§‹à¦¤à¦¬à¦¾à¦¨à§€'),(1247,394,'Katla','à¦•à¦¾à¦Ÿà¦²à¦¾'),(1248,394,'Khanpur','à¦–à¦¾à¦¨à¦ªà§à¦°'),(1249,394,'Mukundopur','à¦®à§à¦•à§à¦¨à§à¦¦à¦ªà§à¦°'),(1250,394,'Poliproyagpur','à¦ªà¦²à¦¿à¦ªà§à¦°à§Ÿà¦¾à¦—à¦ªà§à¦°'),(1251,395,'Belaichandi','à¦¬à§‡à¦²à¦¾à¦‡à¦šà¦¨à§à¦¡à¦¿'),(1252,395,'Chandipur','à¦šà¦¨à§à¦¡à§€à¦ªà§à¦°'),(1253,395,'Habra','à¦¹à¦¾à¦¬à§œà¦¾'),(1254,395,'Hamidpur','à¦¹à¦¾à¦®à¦¿à¦¦à¦ªà§à¦°'),(1255,395,'Harirampur','à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(1256,395,'Mominpur','à¦®à§‹à¦®à¦¿à¦¨à¦ªà§à¦°'),(1257,395,'Monmothopur','à¦®à¦¨à§à¦®à¦¥à¦ªà§à¦°'),(1258,395,'Mostofapur','à¦®à§‹à¦¸à§à¦¤à¦«à¦¾à¦ªà§à¦°'),(1259,395,'Polashbariup4','à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€'),(1260,395,'Rampur','à¦°à¦¾à¦®à¦ªà§à¦°'),(1261,396,'Atgaon','à¦†à¦Ÿà¦—à¦¾à¦à¦“'),(1262,396,'Eshania','à¦ˆà¦¶à¦¾à¦¨à¦¿à§Ÿà¦¾'),(1263,396,'Murshidhat','à¦®à§à¦°à§à¦¶à¦¿à¦¦à¦¹à¦¾à¦Ÿ'),(1264,396,'Nafanagar','à¦¨à¦¾à¦«à¦¾à¦¨à¦—à¦°'),(1265,396,'Rongaon','à¦°à¦¨à¦—à¦¾à¦à¦“'),(1266,396,'Shatail','à¦›à¦¾à¦¤à¦‡à¦²'),(1267,397,'Dabor','à¦¡à¦¾à¦¬à§‹à¦°'),(1268,397,'Mukundapur','à¦®à§à¦•à§à¦¨à§à¦¦à¦ªà§à¦°'),(1269,397,'Ramchandrapur','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(1270,397,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(1271,397,'Sundarpur','à¦¸à§à¦¨à§à¦¦à¦°à¦ªà§à¦°'),(1272,397,'Targao','à¦¤à¦¾à¦°à¦—à¦¾à¦à¦“'),(1273,398,'Aladipur','à¦†à¦²à¦¾à¦¦à¦¿à¦ªà§à¦°'),(1274,398,'Aloary','à¦à¦²à§à§Ÿà¦¾à§œà§€'),(1275,398,'Bethdighi','à¦¬à§‡à¦¤à¦¦à¦¿à¦˜à§€'),(1276,398,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(1277,398,'Kagihal','à¦•à¦¾à¦œà§€à¦¹à¦¾à¦²'),(1278,398,'Khairbari','à¦–à§Ÿà§‡à¦°à¦¬à¦¾à§œà§€'),(1279,398,'Shibnagor','à¦¶à¦¿à¦¬à¦¨à¦—à¦°'),(1280,399,'Askorpur','à¦†à¦¸à§à¦•à¦°à¦ªà§à¦°'),(1281,399,'Auliapur','à¦†à¦‰à¦²à¦¿à§Ÿà¦¾à¦ªà§à¦°'),(1282,399,'Chealgazi','à¦šà§‡à¦¹à§‡à¦²à¦—à¦¾à¦œà§€'),(1283,399,'Fazilpur','à¦«à¦¾à¦œà¦¿à¦²à¦ªà§à¦°'),(1284,399,'Kamalpur','à¦•à¦®à¦²à¦ªà§à¦°'),(1285,399,'Sankarpur','à¦¶à¦‚à¦•à¦°à¦ªà§à¦°'),(1286,399,'Shashora','à¦¶à¦¶à¦°à¦¾'),(1287,399,'Shekpura','à¦¶à§‡à¦–à¦ªà§à¦°à¦¾'),(1288,399,'Sundorbon','à¦¸à§à¦¨à§à¦¦à¦°à¦¬à¦¨'),(1289,399,'Uthrail','à¦‰à¦¥à¦°à¦¾à¦‡à¦²'),(1290,400,'Alihat','à¦†à¦²à§€à¦¹à¦¾à¦Ÿ'),(1291,400,'Boalder','à¦¬à§‹à§Ÿà¦¾à¦²à¦¦à¦¾à¦°'),(1292,400,'Khattamadobpara','à¦–à¦Ÿà§à¦Ÿà¦¾à¦®à¦¾à¦§à¦¬à¦ªà¦¾à§œà¦¾'),(1293,401,'Alokjhari','à¦†à¦²à§‹à¦•à¦à¦¾à§œà§€'),(1294,401,'Angarpara','à¦†à¦™à§à¦—à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(1295,401,'Bhabki','à¦­à¦¾à¦¬à¦•à§€'),(1296,401,'Bherbheri','à¦­à§‡à§œà¦­à§‡à§œà§€'),(1297,401,'Goaldihi','à¦—à§‹à§Ÿà¦¾à¦²à¦¡à¦¿à¦¹à¦¿'),(1298,401,'Khamarpara','à¦–à¦¾à¦®à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(1299,402,'Azimpur','à¦†à¦œà¦¿à¦®à¦ªà§à¦°'),(1300,402,'Bhandra','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦¾'),(1301,402,'Bijora','à¦¬à¦¿à¦œà§‹à§œà¦¾'),(1302,402,'Birol','à¦¬à¦¿à¦°à¦²'),(1303,402,'Dhamoir','à¦§à¦¾à¦®à¦‡à¦°'),(1304,402,'Dharmapur','à¦§à¦°à§à¦®à¦ªà§à¦°'),(1305,402,'Farakkabad','à¦«à¦°à¦¾à¦•à§à¦•à¦¾à¦¬à¦¾à¦¦'),(1306,402,'Mongalpur','à¦®à¦™à§à¦—à¦²à¦ªà§à¦°'),(1307,402,'Ranipukur','à¦°à¦¾à¦£à§€à¦ªà§à¦•à§à¦°'),(1308,402,'Shohorgram','à¦¶à¦¹à¦°à¦—à§à¦°à¦¾à¦®'),(1309,415,'Bongram','à¦¬à¦¨à¦—à§à¦°à¦¾à¦®'),(1310,415,'Damodorpur','à¦¦à¦¾à¦®à§‹à¦¦à¦°à¦ªà§à¦°'),(1311,415,'Dhaperhat','à¦§à¦¾à¦ªà§‡à¦°à¦¹à¦¾à¦Ÿ'),(1312,415,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(1313,415,'Idilpur','à¦‡à¦¦à¦¿à¦²à¦ªà§à¦°'),(1314,415,'Jamalpur','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(1315,415,'Kamarpara','à¦•à¦¾à¦®à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(1316,415,'Khodkomor','à¦–à§‹à¦¦à¦•à§‹à¦®à¦°à¦ªà§à¦°'),(1317,415,'Noldanga','à¦¨à¦²à¦¡à¦¾à¦™à§à¦—à¦¾'),(1318,415,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(1319,415,'Vatgram','à¦­à¦¾à¦¤à¦—à§à¦°à¦¾à¦®'),(1320,416,'Badiakhali','à¦¬à¦¾à¦¦à¦¿à§Ÿà¦¾à¦–à¦¾à¦²à§€'),(1321,416,'Ballamjhar','à¦¬à¦²à§à¦²à¦®à¦à¦¾à§œ'),(1322,416,'Boali','à¦¬à§‹à§Ÿà¦¾à¦²à§€'),(1323,416,'Ghagoa','à¦˜à¦¾à¦—à§‹à§Ÿà¦¾'),(1324,416,'Gidari','à¦—à¦¿à¦¦à¦¾à¦°à§€'),(1325,416,'Kamarjani','à¦•à¦¾à¦®à¦¾à¦°à¦œà¦¾à¦¨à¦¿'),(1326,416,'Kholahati','à¦–à§‹à¦²à¦¾à¦¹à¦¾à¦Ÿà§€'),(1327,416,'Kuptola','à¦•à§à¦ªà¦¤à¦²à¦¾'),(1328,416,'Laxmipur','à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦°'),(1329,416,'Malibari','à¦®à¦¾à¦²à§€à¦¬à¦¾à§œà§€'),(1330,416,'Mollarchar','à¦®à§‹à¦²à§à¦²à¦¾à¦°à¦šà¦°'),(1331,416,'Ramchandrapur','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(1332,416,'Shahapara','à¦¸à¦¾à¦¹à¦¾à¦ªà¦¾à§œà¦¾'),(1333,417,'Barisal','à¦¬à¦°à¦¿à¦¶à¦¾à¦²'),(1334,417,'Betkapa','à¦¬à§‡à¦¤à¦•à¦¾à¦ªà¦¾'),(1335,417,'Harinathpur','à¦¹à¦°à¦¿à¦£à¦¾à¦¥à¦ªà§à¦°'),(1336,417,'Hosenpur','à¦¹à§‹à¦¸à§‡à¦¨à¦ªà§à¦°'),(1337,417,'Kishoregari','à¦•à¦¿à¦¶à§‹à¦°à¦—à¦¾à§œà§€'),(1338,417,'Mohdipur','à¦®à¦¹à¦¦à§€à¦ªà§à¦°'),(1339,417,'Monohorpur','à¦®à¦¨à§‹à¦¹à¦°à¦ªà§à¦°'),(1340,417,'Palashbari','à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€'),(1341,417,'Pobnapur','à¦ªà¦¬à¦¨à¦¾à¦ªà§à¦°'),(1342,418,'Bonarpara','à¦¬à§‹à¦¨à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(1343,418,'Ghuridah','à¦˜à§à¦°à¦¿à¦¦à¦¹'),(1344,418,'Holdia','à¦¹à¦²à¦¦à¦¿à§Ÿà¦¾'),(1345,418,'Jumarbari','à¦œà§à¦®à¦¾à¦°à¦¬à¦¾à§œà§€'),(1346,418,'Kachua','à¦•à¦šà§à§Ÿà¦¾'),(1347,418,'Kamalerpara','à¦•à¦¾à¦®à¦¾à¦²à§‡à¦°à¦ªà¦¾à§œà¦¾'),(1348,418,'Muktinagar','à¦®à§à¦•à§à¦¤à¦¿à¦¨à¦—à¦°'),(1349,418,'Padumsahar','à¦ªà¦¦à§à¦®à¦¶à¦¹à¦°'),(1350,418,'Saghata','à¦¸à¦¾à¦˜à¦¾à¦Ÿà¦¾'),(1351,418,'Varotkhali','à¦­à¦°à¦¤à¦–à¦¾à¦²à§€'),(1352,239,'Birkedar','à¦¬à§€à¦°à¦•à§‡à¦¦à¦¾à¦°'),(1353,239,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(1354,239,'Jamgaon','à¦œà¦¾à¦®à¦—à§à¦°à¦¾à¦®'),(1355,239,'Kahaloo','à¦•à¦¾à¦¹à¦¾à¦²à§'),(1356,239,'Kalai','à¦•à¦¾à¦²à¦¾à¦‡'),(1357,239,'Malancha','à¦®à¦¾à¦²à¦žà§à¦šà¦¾'),(1358,239,'Murail','à¦®à§à¦°à¦‡à¦²'),(1359,239,'Narhatta','à¦¨à¦¾à¦°à¦¹à¦Ÿà§à¦Ÿ'),(1360,239,'Paikar','à¦ªà¦¾à¦‡à¦•à§œ'),(1361,10,'Erulia','à¦à¦°à§à¦²à¦¿à§Ÿà¦¾'),(1362,10,'Fapore','à¦«à¦¾à¦à¦ªà§‹à¦°'),(1363,10,'Gokul','à¦—à§‹à¦•à§à¦²'),(1364,10,'Lahiripara','à¦²à¦¾à¦¹à¦¿à§œà§€à¦ªà¦¾à§œà¦¾'),(1365,10,'Namuja','à¦¨à¦¾à¦®à§à¦œà¦¾'),(1366,10,'Nishindara','à¦¨à¦¿à¦¶à¦¿à¦¨à§à¦¦à¦¾à¦°à¦¾'),(1367,10,'Noongola','à¦¨à§à¦¨à¦—à§‹à¦²à¦¾'),(1368,10,'Rajapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦°'),(1369,10,'Sekherkola','à¦¶à§‡à¦–à§‡à¦°à¦•à§‹à¦²à¦¾'),(1370,10,'Shabgram','à¦¸à¦¾à¦¬à¦—à§à¦°à¦¾à¦®'),(1371,10,'Shakharia','à¦¶à¦¾à¦–à¦¾à¦°à¦¿à§Ÿà¦¾'),(1372,419,'Dorbosto','à¦¦à¦°à¦¬à¦¸à§à¦¤'),(1373,419,'Gumaniganj','à¦—à§à¦®à¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(1374,419,'Harirampur','à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(1375,419,'Kamardoho','à¦•à¦¾à¦®à¦¾à¦°à¦¦à¦¹'),(1376,419,'Kamdia','à¦•à¦¾à¦®à¦¦à¦¿à§Ÿà¦¾'),(1377,419,'Katabari','à¦•à¦¾à¦Ÿà¦¾à¦¬à¦¾à§œà§€'),(1378,419,'Kochasahar','à¦•à§‹à¦šà¦¾à¦¶à¦¹à¦°'),(1379,419,'Mahimaganj','à¦®à¦¹à¦¿à¦®à¦¾à¦—à¦žà§à¦œ'),(1380,419,'Nakai','à¦¨à¦¾à¦•à¦¾à¦‡'),(1381,419,'Phulbari','à¦«à§à¦²à¦¬à¦¾à§œà§€'),(1382,419,'Rajahar','à¦°à¦¾à¦œà¦¾à¦¹à¦¾à¦°'),(1383,419,'Rakhalburuj','à¦°à¦¾à¦–à¦¾à¦²à¦¬à§à¦°à§à¦œ'),(1384,419,'Sapmara','à¦¸à¦¾à¦ªà¦®à¦¾à¦°à¦¾'),(1385,419,'Shakhahar','à¦¶à¦¾à¦–à¦¾à¦¹à¦¾à¦°'),(1386,419,'Shalmara','à¦¶à¦¾à¦²à¦®à¦¾à¦°à¦¾'),(1387,419,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(1388,419,'Talukkanupur','à¦¤à¦¾à¦²à§à¦•à¦•à¦¾à¦¨à§à¦ªà§à¦°'),(1389,420,'Bamondanga','à¦¬à¦¾à¦®à¦¨à¦¡à¦¾à¦™à§à¦—à¦¾'),(1390,420,'Belka','à¦¬à§‡à¦²à¦•à¦¾'),(1391,420,'Chandipur','à¦šà¦¨à§à¦¡à¦¿à¦ªà§à¦°'),(1392,420,'Chaporhati','à¦›à¦¾à¦ªà¦°à¦¹à¦¾à¦Ÿà§€'),(1393,420,'Dhopadanga','à¦§à§‹à¦ªà¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(1394,420,'Dohbond','à¦¦à¦¹à¦¬à¦¨à§à¦¦'),(1395,420,'Haripur','à¦¹à¦°à¦¿à¦ªà§à¦°'),(1396,420,'Kapasia','à¦•à¦¾à¦ªà¦¾à¦¸à¦¿à§Ÿà¦¾'),(1397,420,'Konchibari','à¦•à¦žà§à¦šà¦¿à¦¬à¦¾à§œà§€'),(1398,420,'Ramjibon','à¦°à¦¾à¦®à¦œà§€à¦¬à¦¨'),(1399,420,'Shantiram','à¦¶à¦¾à¦¨à§à¦¤à¦¿à¦°à¦¾à¦®'),(1400,420,'Sonaroy','à¦¸à§‹à¦¨à¦¾à¦°à¦¾à§Ÿ'),(1401,420,'Sorbanondo','à¦¸à¦°à§à¦¬à¦¾à¦¨à¦¨à§à¦¦'),(1402,420,'Sreepur','à¦¶à§à¦°à§€à¦ªà§à¦°'),(1403,420,'Tarapur','à¦¤à¦¾à¦°à¦¾à¦ªà§à¦°'),(1404,421,'Erendabari','à¦à¦°à§‡à¦¨à§à¦¡à¦¾à¦¬à¦¾à§œà§€'),(1405,421,'Fazlupur','à¦«à¦œà¦²à§à¦ªà§à¦°'),(1406,421,'Gazaria','à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾'),(1407,421,'Kanchipara','à¦•à¦žà§à¦šà¦¿à¦ªà¦¾à§œà¦¾'),(1408,421,'Phulchari','à¦«à§à¦²à¦›à§œà¦¿'),(1409,421,'Udakhali','à¦‰à¦¦à¦¾à¦–à¦¾à¦²à§€'),(1410,421,'Uria','à¦‰à§œà¦¿à§Ÿà¦¾'),(1411,241,'Bhelabari','à¦­à§‡à¦²à¦¾à¦¬à¦¾à§œà§€'),(1412,241,'Bohail','à¦¬à§‹à¦¹à¦¾à¦‡à¦²'),(1413,241,'Chaluabari','à¦šà¦¾à¦²à§à§Ÿà¦¾à¦¬à¦¾à§œà§€'),(1414,241,'Chandanbaisha','à¦šà¦¨à§à¦¦à¦¨à¦¬à¦¾à¦‡à¦¶à¦¾'),(1415,241,'Hatfulbari','à¦¹à¦¾à¦Ÿà¦«à§à¦²à¦¬à¦¾à§œà§€'),(1416,241,'Hatsherpur','à¦¹à¦¾à¦Ÿà¦¶à§‡à¦°à¦ªà§à¦°'),(1417,241,'Kamalpur','à¦•à¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(1418,241,'Karnibari','à¦•à¦°à§à¦£à¦¿à¦¬à¦¾à§œà§€'),(1419,241,'Kazla','à¦•à¦¾à¦œà¦²à¦¾'),(1420,241,'Kutubpur','à¦•à§à¦¤à§à¦¬à¦ªà§à¦°'),(1421,241,'Narchi','à¦¨à¦¾à¦°à¦šà§€'),(1422,241,'Sariakandisadar','à¦¸à¦¾à¦°à¦¿à§Ÿà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿ à¦¸à¦¦à¦°'),(1423,242,'Amrul','à¦†à¦®à¦°à§à¦²'),(1424,242,'Aria','à¦†à§œà¦¿à§Ÿà¦¾'),(1425,242,'Asekpur','à¦†à¦¶à§‡à¦•à¦ªà§à¦°'),(1426,242,'Chopinagar','à¦šà§‹à¦ªà¦¿à¦¨à¦—à¦°'),(1427,242,'Gohail','à¦—à§‹à¦¹à¦¾à¦‡à¦²'),(1428,242,'Kharna','à¦–à¦°à¦¨à¦¾'),(1429,242,'Khottapara','à¦–à§‹à¦Ÿà§à¦Ÿà¦¾à¦ªà¦¾à§œà¦¾'),(1430,242,'Madla','à¦®à¦¾à¦¦à¦²à¦¾'),(1431,242,'Majhira','à¦®à¦¾à¦à¦¿à§œà¦¾'),(1432,243,'Chamrul','à¦šà¦¾à¦®à¦°à§à¦²'),(1433,243,'Dupchanchia','à¦¦à§à¦ªà¦šà¦¾à¦à¦šà¦¿à§Ÿà¦¾'),(1434,243,'Gobindapur','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(1435,243,'Gunahar','à¦—à§à¦¨à¦¾à¦¹à¦¾à¦°'),(1436,243,'Talora','à¦¤à¦¾à¦²à§‹à§œà¦¾'),(1437,243,'Zianagar','à¦œà¦¿à§Ÿà¦¾à¦¨à¦—à¦°'),(1438,244,'Adamdighi','à¦†à¦¦à¦®à¦¦à¦¿à¦˜à¦¿'),(1439,244,'Chapapur','à¦šà¦¾à¦à¦ªà¦¾à¦ªà§à¦°'),(1440,244,'Chhatiangram','à¦›à¦¾à¦¤à¦¿à§Ÿà¦¾à¦¨à¦—à§à¦°à¦¾à¦®'),(1441,244,'Kundagram','à¦•à§à¦¨à§à¦¦à¦—à§à¦°à¦¾à¦®'),(1442,244,'Nasaratpur','à¦¨à¦¶à¦°à¦¤à¦ªà§à¦°'),(1443,244,'Shantahar','à¦¸à¦¾à¦¨à§à¦¤à¦¾à¦¹à¦¾à¦°'),(1444,245,'Bhatgram','à§«à¦¨à¦‚ à¦­à¦¾à¦Ÿà¦—à§à¦°à¦¾à¦®'),(1445,245,'Bhatra','à§©à¦¨à¦‚ à¦­à¦¾à¦Ÿà¦°à¦¾'),(1446,245,'Burail','à§§à¦¨à¦‚ à¦¬à§à§œà¦‡à¦²'),(1447,245,'Nandigram','à§¨à¦¨à¦‚ à¦¨à¦¨à§à¦¦à¦¿à¦—à§à¦°à¦¾à¦®'),(1448,245,'Thaltamajhgram','à§ªà¦¨à¦‚ à¦¥à¦¾à¦²à¦¤à¦¾ à¦®à¦¾à¦à¦—à§à¦°à¦¾à¦®'),(1449,246,'Balua','à¦¬à¦¾à¦²à§à§Ÿà¦¾'),(1450,246,'Digdair','à¦¦à¦¿à¦—à¦¦à¦¾à¦‡à§œ'),(1451,246,'Madhupur','à¦®à¦§à§à¦ªà§à¦°'),(1452,246,'Pakulla','à¦ªà¦¾à¦•à§à¦²à§à¦²à§à¦¯à¦¾'),(1453,246,'Sonatala','à¦¸à§‹à¦¨à¦¾à¦¤à¦²à¦¾'),(1454,246,'Tekanichukinagar','à¦¤à§‡à¦•à¦¾à¦¨à§€ à¦šà§à¦•à¦¾à¦‡à¦¨à¦—à¦°'),(1455,246,'Zorgacha','à¦œà§‹à§œà¦—à¦¾à¦›à¦¾'),(1456,247,'Bhandarbari','à§«à¦¨à¦‚ à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦¬à¦¾à§œà§€'),(1457,247,'Chikashi','à§©à¦¨à¦‚ à¦šà¦¿à¦•à¦¾à¦¶à§€'),(1458,247,'Chowkibari','à§®à¦¨à¦‚ à¦šà§Œà¦•à¦¿à¦¬à¦¾à§œà§€'),(1459,247,'Dhunatsadar','à§¬à¦¨à¦‚ à¦§à§à¦¨à¦Ÿ à¦¸à¦¦à¦°'),(1460,247,'Elangi','à§­à¦¨à¦‚ à¦à¦²à¦¾à¦™à§à¦—à§€'),(1461,247,'Gopalnagar','à§§à§¦à¦¨à¦‚ à¦—à§‹à¦ªà¦¾à¦²à¦¨à¦—à¦°'),(1462,247,'Gossainbari','à§ªà¦¨à¦‚ à¦—à§‹à¦¸à¦¾à¦‡à¦¬à¦¾à§œà§€'),(1463,247,'Kalerpara','à§¨à¦¨à¦‚ à¦•à¦¾à¦²à§‡à¦°à¦ªà¦¾à§œà¦¾'),(1464,247,'Mothurapur','à§¯à¦¨à¦‚ à¦®à¦¥à§à¦°à¦¾à¦ªà§à¦°'),(1465,247,'Nimgachi','à§§à¦¨à¦‚ à¦¨à¦¿à¦®à¦—à¦¾à¦›à¦¿'),(1466,248,'Baliadighi','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾ à¦¦à¦¿à¦˜à§€'),(1467,248,'Dakshinpara','à¦¦à¦•à§à¦·à¦¿à¦£à¦ªà¦¾à§œà¦¾'),(1468,248,'Durgahata','à¦¦à§à¦°à§à¦—à¦¾à¦¹à¦¾à¦Ÿà¦¾'),(1469,248,'Gabtali','à¦—à¦¾à¦¬à¦¤à¦²à¦¿'),(1470,248,'Kagail','à¦•à¦¾à¦—à¦‡à¦²'),(1471,248,'Mahishaban','à¦®à¦¹à¦¿à¦·à¦¾à¦¬à¦¾à¦¨'),(1472,248,'Naruamala','à¦¨à¦¾à§œà§à§Ÿà¦¾à¦®à¦¾à¦²à¦¾'),(1473,248,'Nasipur','à¦¨à¦¶à¦¿à¦ªà§à¦°'),(1474,248,'Nepaltali','à¦¨à§‡à¦ªà¦¾à¦²à¦¤à¦²à§€'),(1475,248,'Rameshwarpur','à¦°à¦¾à¦®à§‡à¦¶à§à¦¬à¦°à¦ªà§à¦°'),(1476,248,'Sonarai','à¦¸à§‹à¦¨à¦¾à¦°à¦¾à§Ÿ'),(1477,249,'Bhabanipur','à§­à¦¨à¦‚ à¦­à¦¬à¦¾à¦¨à§€à¦ªà§à¦°'),(1478,249,'Bishalpur','à§¬à¦¨à¦‚ à¦¬à¦¿à¦¶à¦¾à¦²à¦ªà§à¦°'),(1479,249,'Garidaha','à§¨à¦¨à¦‚ à¦—à¦¾à§œà¦¿à¦¦à¦¹'),(1480,249,'Khamarkandi','à§©à¦¨à¦‚ à¦–à¦¾à¦®à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1481,249,'Khanpur','à§ªà¦¨à¦‚ à¦–à¦¾à¦¨à¦ªà§à¦°'),(1482,249,'Kusumbi','à§§à¦¨à¦‚ à¦•à§à¦¸à§à¦®à§à¦¬à§€'),(1483,249,'Mirzapur','à§«à¦¨à¦‚ à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(1484,249,'Shahbondegi','à§§à§¦à¦¨à¦‚ à¦¶à¦¾à¦¹à¦¬à¦¨à§à¦¦à§‡à¦—à§€'),(1485,249,'Shimabari','à§¯à¦¨à¦‚ à¦¸à§€à¦®à¦¾à¦¬à¦¾à§œà¦¿'),(1486,249,'Sughat','à§®à¦¨à¦‚ à¦¸à§à¦˜à¦¾à¦Ÿ'),(1487,250,'Atmul','à§©à¦¨à¦‚ à¦†à¦Ÿà¦®à§‚à¦²'),(1488,250,'Bihar','à§­à¦¨à¦‚ à¦¬à¦¿à¦¹à¦¾à¦°'),(1489,250,'Buriganj','à§¬à¦¨à¦‚ à¦¬à§à§œà¦¿à¦—à¦žà§à¦œ'),(1490,250,'Deuly','à§¯à¦¨à¦‚ à¦¦à§‡à¦‰à¦²à¦¿'),(1491,250,'Kichok','à§¨à¦¨à¦‚ à¦•à¦¿à¦šà¦• '),(1492,250,'Majhihatta','à§«à¦¨à¦‚ à¦®à¦¾à¦à¦¿à¦¹à¦Ÿà§à¦Ÿ'),(1493,250,'Moidanhatta','à§§à¦¨à¦‚ à¦®à§Ÿà¦¦à¦¾à¦¨à¦¹à¦¾à¦Ÿà§à¦Ÿà¦¾'),(1494,250,'Mokamtala','à§§à§§à¦¨à¦‚ à¦®à§‹à¦•à¦¾à¦®à¦¤à¦²à¦¾ '),(1495,250,'Pirob','à§ªà¦¨à¦‚ à¦ªà¦¿à¦°à¦¬'),(1496,250,'Raynagar','à§§à§¨à¦¨à¦‚ à¦°à¦¾à§Ÿà¦¨à¦—à¦°'),(1497,250,'Sayedpur','à§§à§¦à¦¨à¦‚ à¦¸à§ˆà§Ÿà¦¦à¦ªà§à¦°'),(1498,250,'Shibganj','à§®à¦¨à¦‚ à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ'),(1499,403,'Abdulpur','à¦†à¦¬à§à¦¦à§à¦²à¦ªà§à¦°'),(1500,403,'Alokdihi','à¦†à¦²à§‹à¦•à¦¡à¦¿à¦¹à¦¿'),(1501,403,'Amarpur','à¦…à¦®à¦°à¦ªà§à¦°'),(1502,403,'Auliapukur','à¦†à¦‰à¦²à¦¿à§Ÿà¦¾à¦ªà§à¦•à§à¦°'),(1503,403,'Fatejangpur','à¦«à¦¤à§‡à¦œà¦‚à¦ªà§à¦°'),(1504,403,'Isobpur','à¦‡à¦¸à¦¬à¦ªà§à¦°'),(1505,403,'Nashratpur','à¦¨à¦¶à¦°à¦¤à¦ªà§à¦°'),(1506,403,'Punotti','à¦ªà§à¦¨à¦Ÿà§à¦Ÿà¦¿'),(1507,403,'Saitara','à¦¸à¦¾à¦‡à¦¤à¦¾à¦°à¦¾'),(1508,403,'Satnala','à¦¸à¦¾à¦¤à¦¨à¦¾à¦²à¦¾'),(1509,403,'Tetulia','à¦¤à§‡à¦¤à§à¦²à¦¿à§Ÿà¦¾'),(1510,403,'Viail','à¦­à¦¿à§Ÿà¦¾à¦‡à¦²'),(1511,171,'Algidurgapurnorth','à¦†à¦²à¦—à§€ à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(1512,171,'Algidurgapursouth','à¦†à¦²à¦—à§€ à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°à¦¦à¦•à§à¦·à¦¿à¦£'),(1513,171,'Charbhairabi',''),(1514,171,'Gazipur','à¦—à¦¾à¦œà§€à¦ªà§à¦°'),(1515,171,'Haimchar','à¦¹à¦¾à¦‡à¦®à¦šà¦°'),(1516,171,'Nilkamal','à¦¨à§€à¦²à¦•à¦®à¦²'),(1517,172,'Ashrafpur',''),(1518,172,'Bitara','à¦¬à¦¿à¦¤à¦¾à¦°à¦¾'),(1519,172,'Gohatnorth','à¦—à§‹à¦¹à¦¾à¦Ÿ'),(1520,172,'Gohatsouth','à¦—à§‹à¦¹à¦¾à¦Ÿ'),(1521,172,'Kachuanorth','à¦•à¦šà§à¦¯à¦¼à¦¾'),(1522,172,'Kachuasouth','à¦•à¦šà§à¦¯à¦¼à¦¾'),(1523,172,'Kadla',''),(1524,172,'Koroia',''),(1525,172,'Pathair','à¦ªà¦¾à¦¥à§ˆà¦°'),(1526,172,'Sachar','à¦¸à¦¾à¦šà¦¾à¦°'),(1527,172,'Shohodebpureast','à¦¸à¦¹à¦¦à§‡à¦¬à¦ªà§à¦°'),(1528,172,'Shohodebpurwest','à¦¸à¦¹à¦¦à§‡à¦¬à¦ªà§à¦°'),(1529,173,'Chitoshieast','à¦šà¦¿à¦¤à¦·à§€'),(1530,173,'Chitoshiwest','à¦šà¦¿à¦¤à¦·à§€'),(1531,173,'Mehernorth','à¦®à§‡à¦¹à§‡à¦°'),(1532,173,'Mehersouth','à¦®à§‡à¦¹à§‡à¦°'),(1533,173,'Raysreenorth','à¦°à¦¾à¦¯à¦¼à¦¶à§à¦°à§€'),(1534,173,'Raysreesouth','à¦°à¦¾à¦¯à¦¼à¦¶à§à¦°à§€'),(1535,173,'Suchiparanorth','à¦¸à§à¦šà¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(1536,173,'Suchiparasouth','à¦¸à§à¦šà¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(1537,173,'Tamtanorth','à¦Ÿà¦¾à¦®à¦Ÿà¦¾ à¦‰à¦¤à§à¦¤à¦°'),(1538,173,'Tamtasouth','à¦Ÿà¦¾à¦®à¦Ÿà¦¾ à¦¦à¦•à§à¦·à¦¿à¦£'),(1539,18,'Bishnandi','à¦¬à¦¿à¦¶à¦¨à¦¨à§à¦¦à§€'),(1540,18,'Brahammandi','à¦¬à§à¦°à¦¾â€à¦¹à§à¦®à¦¨à§à¦¦à§€'),(1541,18,'Duptara','à¦¦à§à¦ªà§à¦¤à¦¾à¦°à¦¾'),(1542,18,'Fatepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(1543,18,'Highjadi','à¦¹à¦¾à¦‡à¦œà¦¾à¦¦à§€'),(1544,18,'KagkandaUP','à¦–à¦¾à¦—à¦•à¦¾à¦¨à§à¦¦à¦¾'),(1545,18,'Kalapaharia','à¦•à¦¾à¦²à¦¾à¦ªà¦¾à¦¹à¦¾à§œà¦¿à§Ÿà¦¾'),(1546,18,'Mahmudpur','à¦®à¦¾à¦¹à¦®à§à¦¦à¦ªà§à¦°'),(1547,18,'Satgram','à¦¸à¦¾à¦¤à¦—à§à¦°à¦¾à¦®'),(1548,18,'Uchitpura','à¦‰à¦šà¦¿à§Žà¦ªà§à¦°à¦¾'),(1549,10,'Aptabnagar','à¦†à¦ªà§à¦¤à¦¾à¦¬à¦¨à¦—à¦°'),(1550,10,'Gourarang','à¦—à§Œà¦°à¦¾à¦°à¦‚'),(1551,10,'Jahangirnagar','à¦œà¦¾à¦¹à¦¾à¦™à§à¦—à§€à¦°à¦¨à¦—à¦° '),(1552,10,'Kathair','à¦•à¦¾à¦ à¦‡à¦° '),(1553,10,'Laxmansree','à¦²à¦•à§à¦·à¦£à¦¶à§à¦°à§€ '),(1554,10,'Mohonpur','à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(1555,10,'Mollapara','à¦®à§‹à¦²à§à¦²à¦¾à¦ªà¦¾à§œà¦¾ '),(1556,10,'Rangarchar','à¦°à¦‚à¦—à¦¾à¦°à¦šà¦°'),(1557,10,'Surma','à¦¸à§à¦°à¦®à¦¾'),(1558,19,'Alirtek','à¦†à¦²à¦¿à¦°à¦Ÿà§‡à¦•'),(1559,19,'Baktaboli','à¦¬à¦•à§à¦¤à¦¾à¦¬à¦²à§€'),(1560,19,'Enayetnagor','à¦à¦¨à¦¾à§Ÿà§‡à¦¤ à¦¨à¦—à¦°'),(1561,19,'Gognagar',''),(1562,19,'Kashipur',''),(1563,19,'Kutubpur','à¦•à§à¦¤à§à¦¬à¦ªà§à¦°'),(1564,20,'Bholobo','à¦­à§‹à¦²à¦¾à¦¬'),(1565,20,'Bhulta','à¦­à§‚à¦²à¦¤à¦¾'),(1566,20,'Daudpur','à¦¦à¦¾à¦‰à¦¦à¦ªà§à¦°'),(1567,20,'Golakandail','à¦—à§‹à¦²à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾à¦‡à¦²'),(1568,20,'Kayetpara','à¦•à¦¾à§Ÿà§‡à¦¤à¦ªà¦¾à§œà¦¾'),(1569,20,'Murapara','à¦®à§à§œà¦¾à¦ªà¦¾à§œà¦¾'),(1570,20,'Rupganj','à¦°à§‚à¦ªà¦—à¦žà§à¦œ'),(1571,21,'Baidyerbazar','à¦¬à§ˆà¦¦à§à¦¯à§‡à¦°à¦¬à¦¾à¦œà¦¾à¦° '),(1572,21,'Baradi','à¦¬à¦¾à¦°à¦¦à§€ '),(1573,21,'Jampur','à¦œà¦¾à¦®à¦ªà§à¦° '),(1574,21,'Kanchpur','à¦•à¦¾à¦šà¦ªà§à¦° '),(1575,21,'Mograpara','à¦®à§‹à¦—à¦°à¦¾à¦ªà¦¾à§œà¦¾ '),(1576,21,'Noagaon','à¦¨à§‹à§Ÿà¦¾à¦—à¦¾à¦à¦“ '),(1577,21,'Pirojpur','à¦ªà¦¿à¦°à§‹à¦œà¦ªà§à¦° '),(1578,21,'Sadipur','à¦¸à¦¾à¦¦à§€à¦ªà§à¦° '),(1579,21,'Shambhupura','à¦¶à¦®à§à¦­à§à¦ªà§à¦°à¦¾ '),(1580,21,'Sonmandi','à¦¸à¦¨à¦®à¦¾à¦¨à§à¦¦à¦¿ '),(1581,408,'Bhadai','à¦­à¦¾à¦¦à¦¾à¦‡ '),(1582,408,'Bhelabari','à¦­à§‡à¦²à¦¾à¦¬à¦¾à§œà§€'),(1583,408,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(1584,408,'Kamlabari','à¦•à¦®à¦²à¦¾à¦¬à¦¾à§œà§€'),(1585,408,'Mohishkhocha','à¦®à¦¹à¦¿à¦·à¦–à§‹à¦šà¦¾ '),(1586,408,'Palashi','à¦ªà¦²à¦¾à¦¶à§€ '),(1587,408,'Saptibari','à¦¸à¦¾à¦ªà§à¦Ÿà¦¿à¦¬à¦¾à§œà§€'),(1588,408,'Sarpukur','à¦¸à¦¾à¦°à¦ªà§à¦•à§à¦°'),(1589,271,'Alatuli','à¦†à¦²à¦¾à¦¤à§à¦²à§€'),(1590,271,'Baliadanga','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(1591,271,'Baroghoria','à¦¬à¦¾à¦°à¦˜à¦°à¦¿à§Ÿà¦¾'),(1592,271,'Charaunupnagar','à¦šà¦°à¦…à¦¨à§à¦ªà¦¨à¦—à¦°'),(1593,271,'Charbagdanga','à¦šà¦°à¦¬à¦¾à¦—à¦¡à¦¾à¦™à§à¦—à¦¾'),(1594,271,'Debinagar','à¦¦à§‡à¦¬à§€à¦¨à¦—à¦°'),(1595,271,'Gobratola','à¦—à§‹à¦¬à¦°à¦¾à¦¤à¦²à¦¾'),(1596,271,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(1597,271,'Jhilim','à¦à¦¿à¦²à¦¿à¦®'),(1598,271,'Moharajpur','à¦®à¦¹à¦¾à¦°à¦¾à¦œà¦ªà§à¦°'),(1599,271,'Narayanpur','à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦ªà§à¦°'),(1600,271,'Ranihati','à¦°à¦¾à¦¨à§€à¦¹à¦¾à¦Ÿà¦¿'),(1601,271,'Shahjahanpur','à¦¶à¦¾à¦¹à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°'),(1602,271,'Sundarpur','à¦¸à§à¦¨à§à¦¦à¦°à¦ªà§à¦°'),(1603,272,'Alinagar','à¦†à¦²à§€à¦¨à¦—à¦°'),(1604,272,'Bangabari','à¦¬à¦¾à¦™à§à¦—à¦¾à¦¬à¦¾à§œà§€'),(1605,272,'Boalia','à¦¬à§‹à§Ÿà¦¾à¦²à¦¿à§Ÿà¦¾'),(1606,272,'Chowdala','à¦šà§Œà¦¡à¦¾à¦²à¦¾'),(1607,272,'Gomostapur','à¦—à§‹à¦®à¦¸à§à¦¤à¦¾à¦ªà§à¦°'),(1608,272,'Parbotipur','à¦ªà¦¾à¦°à§à¦¬à¦¤à§€à¦ªà§à¦°'),(1609,272,'Radhanagar','à¦°à¦¾à¦§à¦¾à¦¨à¦—à¦°'),(1610,272,'Rahanpur','à¦°à¦¹à¦¨à¦ªà§à¦°'),(1611,273,'Fhotepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(1612,273,'Kosba','à¦•à¦¸à¦¬à¦¾'),(1613,273,'Nachol','à¦¨à¦¾à¦šà§‹à¦²'),(1614,273,'Nezampur','à¦¨à§‡à¦œà¦¾à¦®à¦ªà§à¦°'),(1615,274,'Bholahat','à¦­à§‹à¦²à¦¾à¦¹à¦¾à¦Ÿ'),(1616,274,'Daldoli','à¦¦à¦²à¦¦à¦²à§€'),(1617,274,'Gohalbari','à¦—à§‹à¦¹à¦¾à¦²à¦¬à¦¾à§œà§€'),(1618,274,'Jambaria','à¦œà¦¾à¦®à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(1619,250,'Binodpur','à¦¬à¦¿à¦¨à§‹à¦¦à¦ªà§à¦°'),(1620,250,'Chakkirti','à¦šà¦•à¦•à¦¿à¦°à§à¦¤à§€'),(1621,250,'Chhatrajitpur','à¦›à¦¤à§à¦°à¦¾à¦œà¦¿à¦¤à¦ªà§à¦°'),(1622,250,'Daipukuria','à¦¦à¦¾à¦‡à¦ªà§à¦•à§à¦°à¦¿à§Ÿà¦¾'),(1623,250,'Dhainagar','à¦§à¦¾à¦‡à¦¨à¦—à¦°'),(1624,250,'Durlovpur','à¦¦à§à¦°à§à¦²à¦­à¦ªà§à¦°'),(1625,250,'Ghorapakhia','à¦˜à§‹à§œà¦¾à¦ªà¦¾à¦–à¦¿à§Ÿà¦¾'),(1626,250,'Kansat','à¦•à¦¾à¦¨à¦¸à¦¾à¦Ÿ'),(1627,250,'Mobarakpur','à¦®à§‹à¦¬à¦¾à¦°à¦•à¦ªà§à¦°'),(1628,250,'Monakasha','à¦®à¦¨à¦¾à¦•à¦·à¦¾'),(1629,250,'Noyalavanga','à¦¨à§Ÿà¦¾à¦²à¦¾à¦­à¦¾à¦™à§à¦—à¦¾'),(1630,250,'Panka','à¦ªà¦¾à¦à¦•à¦¾'),(1631,250,'Shahabajpur','à¦¶à¦¾à¦¹à¦¾à¦¬à¦¾à¦œà¦ªà§à¦°'),(1632,250,'Shyampur','à¦¶à§à¦¯à¦¾à¦®à¦ªà§à¦°'),(1633,250,'Ujirpur','à¦‰à¦œà¦¿à¦°à¦ªà§à¦°'),(1634,422,'Ahcha','à¦†à¦•à¦šà¦¾'),(1635,422,'Akhanagar','à¦†à¦–à¦¾à¦¨à¦—à¦°'),(1636,422,'Auliapur','à¦†à¦‰à¦²à¦¿à§Ÿà¦¾à¦ªà§à¦°'),(1637,422,'Balia','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾'),(1638,422,'Baragaon','à¦¬à§œà¦—à¦¾à¦à¦“'),(1639,422,'Begunbari','à¦¬à§‡à¦—à§à¦¨à¦¬à¦¾à§œà§€'),(1640,422,'Chilarang','à¦šà¦¿à¦²à¦¾à¦°à¦‚'),(1641,422,'Debipur','à¦¦à§‡à¦¬à§€à¦ªà§à¦°'),(1642,422,'Dholarhat','à¦¢à§‹à¦²à¦¾à¦°à¦¹à¦¾à¦Ÿ'),(1643,422,'Gareya','à¦—à§œà§‡à§Ÿà¦¾'),(1644,422,'Jagannathpur','à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(1645,422,'Jamalpur','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(1646,422,'Mohammadpur','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦°'),(1647,422,'Nargun','à¦¨à¦¾à¦°à¦—à§à¦¨'),(1648,422,'Rahimanpur','à¦°à¦¹à¦¿à¦®à¦¾à¦¨à¦ªà§à¦°'),(1649,422,'Rajagaon','à¦°à¦¾à¦œà¦¾à¦—à¦¾à¦à¦“'),(1650,422,'Roypur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(1651,422,'Ruhea','à¦°à§à¦¹à¦¿à§Ÿà¦¾'),(1652,422,'Ruhiapashchim','à¦°à§à¦¹à¦¿à§Ÿà¦¾ à¦ªà¦¶à§à¦šà¦¿à¦®'),(1653,422,'Salandar','à¦¸à¦¾à¦²à¦¨à§à¦¦à¦°'),(1654,422,'Sukhanpukhari','à¦¶à§à¦–à¦¾à¦¨à¦ªà§à¦•à§à¦°à§€'),(1655,423,'Bairchuna','à¦¬à§ˆà¦°à¦šà§à¦¨à¦¾'),(1656,423,'Bhomradaha','à¦­à§‹à¦®à¦°à¦¾à¦¦à¦¹'),(1657,423,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(1658,423,'Hajipur','à¦¹à¦¾à¦œà§€à¦ªà§à¦°'),(1659,423,'Jabarhat','à¦œà¦¾à¦¬à¦°à¦¹à¦¾à¦Ÿ'),(1660,423,'Khangaon','à¦–à¦¨à¦—à¦¾à¦à¦“'),(1661,423,'Kosharaniganj','à¦•à§‹à¦·à¦¾à¦°à¦¾à¦£à§€à¦—à¦žà§à¦œ'),(1662,423,'Pirganj','à¦ªà§€à¦°à¦—à¦žà§à¦œ'),(1663,423,'Saidpur','à¦¸à§ˆà§Ÿà¦¦à¦ªà§à¦°'),(1664,423,'Sengaon','à¦¸à§‡à¦¨à¦—à¦¾à¦à¦“'),(1665,424,'Bachor','à¦¬à¦¾à¦šà§‹à¦°'),(1666,424,'Dhormogarh','à¦§à¦°à§à¦®à¦—à§œ'),(1667,424,'Hosengaon','à¦¹à§‹à¦¸à§‡à¦¨à¦—à¦¾à¦à¦“'),(1668,424,'Kashipur','à¦•à¦¾à¦¶à¦¿à¦ªà§à¦°'),(1669,424,'Lehemba','à¦²à§‡à¦¹à§‡à¦®à§à¦¬à¦¾'),(1670,424,'Nekmorod','à¦¨à§‡à¦•à¦®à¦°à¦¦'),(1671,424,'Nonduar','à¦¨à¦¨à§à¦¦à§à§Ÿà¦¾à¦°'),(1672,424,'Ratore','à¦°à¦¾à¦¤à§‹à¦°'),(1673,425,'Amgaon','à¦†à¦®à¦—à¦¾à¦à¦“'),(1674,425,'Bakua','à¦¬à¦•à§à§Ÿà¦¾'),(1675,425,'Bhaturia','à¦­à¦¾à¦¤à§à¦°à¦¿à§Ÿà¦¾'),(1676,425,'Dangipara','à¦¡à¦¾à¦™à§à¦—à§€à¦ªà¦¾à§œà¦¾'),(1677,425,'Gedura','à¦—à§‡à¦¦à§à§œà¦¾'),(1678,425,'Haripur','à¦¹à¦°à¦¿à¦ªà§à¦°'),(1679,426,'Amjankhore','à¦†à¦®à¦œà¦¾à¦¨à¦–à§‹à¦°'),(1680,426,'Borobari','à¦¬à§œà¦¬à¦¾à§œà§€'),(1681,426,'Boropalashbari','à¦¬à§œà¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€'),(1682,426,'Charol','à¦šà¦¾à¦°à§‹à¦²'),(1683,426,'Dhontola','à¦§à¦¨à¦¤à¦²à¦¾'),(1684,426,'Duosuo','à¦¦à§à¦“à¦¸à§à¦“'),(1685,426,'Paria','à¦ªà¦¾à§œà¦¿à§Ÿà¦¾'),(1686,426,'Vanor','à¦­à¦¾à¦¨à§‹à¦°'),(1687,427,'Chandanpat','à¦šà¦¨à§à¦¦à¦¨à¦ªà¦¾à¦Ÿ '),(1688,427,'Dorshona','à¦¦à¦°à§à¦¶à¦¾à¦¨à¦¾ '),(1689,427,'Horidebpur','à¦¹à¦°à¦¿à¦¦à§‡à¦¬à¦ªà§à¦° '),(1690,427,'Mominpur','à¦®à¦®à¦¿à¦¨à¦ªà§à¦° '),(1691,427,'Porshuram','à¦ªà¦°à¦¶à§à¦°à¦¾à¦®  '),(1692,427,'Rajendrapur','à¦°à¦¾à¦œà§‡à¦¨à§à¦¦à§à¦°à¦ªà§à¦° '),(1693,427,'Sadwapuskoroni','à¦¸à¦¦à§à¦¯à¦ªà§à¦¸à§à¦•à¦°à¦¨à§€ '),(1694,427,'Satgara','à¦¸à¦¾à¦¤à¦—à¦¾à¦°à¦¾ '),(1695,427,'Tampat','à¦¤à¦¾à¦®à¦ªà¦¾à¦Ÿ '),(1696,427,'Topodhan','à¦¤à¦ªà§‹à¦§à¦¨ '),(1697,427,'Uttam','à¦‰à¦¤à§à¦¤à¦® '),(1698,428,'Alambiditor','à¦†à¦²à¦®à¦¬à¦¿à¦¦à¦¿à¦¤à¦°'),(1699,428,'Betgari','à¦¬à§‡à¦¤à¦—à¦¾à§œà§€ '),(1700,428,'Borobil','à¦¬à§œà¦¬à¦¿à¦² '),(1701,428,'Gojoghonta','à¦—à¦œà¦˜à¦¨à§à¦Ÿà¦¾ '),(1702,428,'Gongachora','à¦—à¦‚à¦—à¦¾à¦šà§œà¦¾'),(1703,428,'Kholeya','à¦–à¦²à§‡à§Ÿà¦¾'),(1704,428,'Kolcondo','à¦•à§‹à¦²à¦•à§‹à¦¨à§à¦¦'),(1705,428,'Lakkhitari','à¦²à¦•à§à¦·à§€à¦Ÿà¦¾à¦°à§€ '),(1706,428,'Morneya','à¦®à¦°à§à¦£à§‡à§Ÿà¦¾ '),(1707,428,'Nohali','à¦¨à§‹à¦¹à¦¾à¦²à§€'),(1708,429,'Alampur','à¦†à¦²à¦®à¦ªà§à¦° '),(1709,429,'Hariarkuthi','à¦¹à¦¾à§œà¦¿à§Ÿà¦¾à¦°à¦•à§à¦ à¦¿ '),(1710,429,'Ikorchali','à¦‡à¦•à¦°à¦šà¦¾à¦²à§€ '),(1711,429,'Kurshatara','à¦•à§à¦°à§à¦¶à¦¾ '),(1712,429,'Soyar','à¦¸à§Ÿà¦¾à¦° '),(1713,430,'Bishnapur','à¦¬à¦¿à¦·à§à¦£à¦ªà§à¦°'),(1714,430,'Damodorpur','à¦¦à¦¾à¦®à§‹à¦¦à¦°à¦ªà§à¦° '),(1715,430,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(1716,430,'Gopinathpur','à¦—à§‹à¦ªà§€à¦¨à¦¾à¦¥à¦ªà§à¦°'),(1717,430,'Kalupara','à¦•à¦¾à¦²à§à¦ªà¦¾à§œà¦¾ '),(1718,430,'Kutubpur','à¦•à§à¦¤à§à¦¬à¦ªà§à¦° '),(1719,430,'Lohanipara','à¦²à§‹à¦¹à¦¾à¦¨à§€à¦ªà¦¾à§œà¦¾ '),(1720,430,'Modhupur','à¦®à¦§à§à¦ªà§à¦° '),(1721,430,'Radhanagar','à¦°à¦¾à¦§à¦¾à¦¨à¦—à¦° '),(1722,430,'Ramnathpurupb','à¦°à¦¾à¦®à¦¨à¦¾à¦¥à¦ªà§à¦°'),(1723,431,'Balarhat','à¦¬à¦¾à¦²à¦¾à¦°à¦¹à¦¾à¦Ÿ '),(1724,431,'Baluyamasimpur','à¦¬à¦¾à¦²à§à§Ÿà¦¾ à¦®à¦¾à¦¸à¦¿à¦®à¦ªà§à¦° '),(1725,431,'Borobala','à¦¬à§œà¦¬à¦¾à¦²à¦¾ '),(1726,431,'Borohazratpur','à¦¬à§œ à¦¹à¦¯à¦°à¦¤à¦ªà§à¦°'),(1727,431,'Chengmari','à¦šà§‡à¦‚à¦®à¦¾à¦°à§€ '),(1728,431,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦° '),(1729,431,'Imadpur','à¦‡à¦®à¦¾à¦¦à¦ªà§à¦°'),(1730,431,'Kafrikhal','à¦•à¦¾à¦«à§à¦°à¦¿à¦–à¦¾à¦² '),(1731,431,'Khoragach','à¦–à§‹à¦°à¦¾à¦—à¦¾à¦› '),(1732,431,'Latibpur','à¦²à¦¤à¦¿à¦¬à¦ªà§à¦° '),(1733,431,'Mgopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(1734,431,'Milonpur','à¦®à¦¿à¦²à¦¨à¦ªà§à¦°'),(1735,431,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(1736,431,'Moyenpur','à¦®à§Ÿà§‡à¦¨à¦ªà§à¦° '),(1737,431,'Payrabond','à¦ªà¦¾à§Ÿà¦°à¦¾à¦¬à¦¨à§à¦¦ '),(1738,431,'Ranipukur','à¦°à¦¾à¦£à§€à¦ªà§à¦•à§à¦° '),(1739,431,'Vangni','à¦­à¦¾à¦‚à¦¨à§€ '),(1740,432,'Boroalampur','à¦¬à§œ à¦†à¦²à¦®à¦ªà§à¦° '),(1741,432,'Borodargah','à¦¬à§œà¦¦à¦°à¦—à¦¾à¦¹ '),(1742,432,'Chattracol','à¦šà§ˆà¦¤à§à¦°à¦•à§‹à¦² '),(1743,432,'Chattra','à¦šà¦¤à¦°à¦¾ '),(1744,432,'Kabilpur','à¦•à¦¾à¦¬à¦¿à¦²à¦ªà§à¦° '),(1745,432,'Kumedpur','à¦•à§à¦®à§‡à¦¦à¦ªà§à¦° '),(1746,432,'Mithipur','à¦®à¦¿à¦ à¦¿à¦ªà§à¦°'),(1747,432,'Modankhali','à¦®à¦¦à¦¨à¦–à¦¾à¦²à§€ '),(1748,432,'Pachgachi','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦›à§€'),(1749,432,'Pirgonj','à¦ªà§€à¦°à¦—à¦žà§à¦œ '),(1750,432,'Ramnathpurup1','à¦°à¦¾à¦®à¦¨à¦¾à¦¥à¦ªà§à¦° '),(1751,432,'Raypur','à¦°à¦¾à§Ÿà¦ªà§à¦° '),(1752,432,'Shanerhat','à¦¶à¦¾à¦¨à§‡à¦°à¦¹à¦¾à¦Ÿ '),(1753,432,'Tukuria','à¦Ÿà§à¦•à§à¦°à¦¿à§Ÿà¦¾ '),(1754,432,'Vendabari','à¦­à§‡à¦¨à§à¦¡à¦¾à¦¬à¦¾à§œà§€ '),(1755,433,'Balapara','à¦¬à¦¾à¦²à¦¾à¦ªà¦¾à§œà¦¾ '),(1756,433,'Haragach','à¦¹à¦¾à¦°à¦¾à¦—à¦¾à¦› '),(1757,433,'Kurshaupk','à¦•à§à¦°à§à¦¶à¦¾'),(1758,433,'Sarai','à¦¸à¦¾à¦°à¦¾à¦‡ '),(1759,433,'Shahidbag','à¦¶à¦¹à§€à¦¦à¦¬à¦¾à¦— '),(1760,433,'Tepamodhupur','à¦Ÿà§‡à¦ªà¦¾à¦®à¦§à§à¦ªà§à¦° '),(1761,434,'Annodanagar','à¦…à¦¨à§à¦¨à¦¦à¦¾à¦¨à¦—à¦° '),(1762,434,'Itakumari','à¦‡à¦Ÿà¦¾à¦•à§à¦®à¦¾à¦°à§€ '),(1763,434,'Kandi','à¦•à¦¾à¦¨à§à¦¦à¦¿ '),(1764,434,'Koikuri','à¦•à§ˆà¦•à§à§œà§€ '),(1765,434,'Kollyani','à¦•à¦²à§à¦¯à¦¾à¦£à§€ '),(1766,434,'Parul','à¦ªà¦¾à¦°à§à¦² '),(1767,434,'Pirgacha','à¦ªà§€à¦°à¦—à¦¾à¦›à¦¾ '),(1768,434,'Saula','à¦›à¦¾à¦“à¦²à¦¾ '),(1769,434,'Tambulpur','à¦¤à¦¾à¦®à§à¦¬à§à¦²à¦ªà§à¦° '),(1770,22,'Bajitkhila','à¦¬à¦¾à¦œà¦¿à¦¤à¦–à¦¿à¦²à¦¾'),(1771,22,'Balairchar','à¦¬à¦²à¦¾à¦‡à¦°à¦šà¦°'),(1772,22,'Betmarighughurakandi','à¦¬à§‡à¦¤à¦®à¦¾à¦°à¦¿ à¦˜à§à¦˜à§à¦°à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1773,22,'Chormochoriya','à¦šà¦°à¦®à§‹à¦šà¦¾à¦°à¦¿à§Ÿà¦¾'),(1774,22,'Chorpokhimari','à¦šà¦°à¦ªà¦•à§à¦·à§€à¦®à¦¾à¦°à¦¿'),(1775,22,'Chorsherpur','à¦šà¦°à¦¶à§‡à¦°à¦ªà§à¦°'),(1776,22,'Dhola','à¦§à¦²à¦¾'),(1777,22,'Gajirkhamar','à¦—à¦¾à¦œà¦¿à¦° à¦–à¦¾à¦®à¦¾à¦°'),(1778,22,'Kamararchor','à¦•à¦¾à¦®à¦¾à¦°à§‡à¦° à¦šà¦°'),(1779,22,'Kamariya','à¦•à¦¾à¦®à¦¾à¦°à¦¿à§Ÿà¦¾'),(1780,22,'Losmonpur','à¦²à¦›à¦®à¦¨à¦ªà§à¦°'),(1781,22,'Pakuriya','à¦ªà¦¾à¦•à§à¦°à¦¿à§Ÿà¦¾'),(1782,22,'Rouha','à¦°à§Œà¦¹à¦¾'),(1783,22,'Vatshala','à¦­à¦¾à¦¤à¦¶à¦¾à¦²à¦¾'),(1784,23,'Bagber','à¦¬à¦¾à¦˜à¦¬à§‡à§œ'),(1785,23,'Juganiya','à¦¯à§‹à¦—à¦¨à§€à§Ÿà¦¾'),(1786,23,'Kakorkandhi','à¦•à¦¾à¦•à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1787,23,'Koloshpar','à¦•à¦²à¦¸à¦ªà¦¾à§œ'),(1788,23,'Morichpuran','à¦®à¦°à¦¿à¦šà¦ªà§à¦°à¦¾à¦£'),(1789,23,'Nalitabari','à¦¨à¦¾à¦²à¦¿à¦¤à¦¾à¦¬à¦¾à§œà§€'),(1790,23,'Nayabil','à¦¨à§Ÿà¦¾à¦¬à§€à¦²'),(1791,23,'Nonni','à¦¨à¦¨à§à¦¨à§€'),(1792,23,'Puraga','à¦ªà§‡à¦¾à§œà¦¾à¦—à¦¾à¦“'),(1793,23,'Rajnogor','à¦°à¦¾à¦œà¦¨à¦—à¦°'),(1794,23,'Ramchondrokura','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦•à§à§œà¦¾'),(1795,23,'Rupnarayankura','à¦°à§‚à¦ªà¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦•à§à§œà¦¾ '),(1796,24,'Bhelua','à¦­à§‡à¦²à§à§Ÿà¦¾'),(1797,24,'Garjaripa','à¦—à§œà¦œà¦°à¦¿à¦ªà¦¾'),(1798,24,'Gosaipur','à¦—à§‡à¦¾à¦¶à¦¾à¦‡à¦ªà§à¦°'),(1799,24,'Kakilakura','à¦•à¦¾à¦•à¦¿à¦²à¦¾à¦•à§à§œà¦¾'),(1800,24,'Khariakazirchar','à¦–à§œà¦¿à§Ÿà¦¾ à¦•à¦¾à¦œà¦¿à¦°à¦šà¦°'),(1801,24,'Kurikahonia','à¦•à§à§œà¦¿à¦•à¦¾à¦¹à¦¨à¦¿à§Ÿà¦¾'),(1802,24,'Ranishimul','à¦°à¦¾à¦¨à§€à¦¶à¦¿à¦®à§à¦²'),(1803,24,'Singabaruna','à¦¸à¦¿à¦‚à¦—à¦¾à¦¬à¦°à§à¦¨à¦¾'),(1804,24,'Sreebordi','à¦¶à§à¦°à§€à¦¬à¦°à¦¦à§€'),(1805,24,'Tatihati','à¦¤à¦¾à¦¤à§€à¦¹à¦¾à¦Ÿà¦¿'),(1806,25,'Baneshwardi','à¦¬à¦¾à¦¨à§‡à¦¶à§à¦¬à¦°à§à¦¦à§€'),(1807,25,'Chandrakona','à¦šà¦¨à§à¦¦à§à¦°à¦•à§‹à¦¨à¦¾'),(1808,25,'Choraustadhar','à¦šà¦°à¦…à¦·à§à¦Ÿà¦§à¦°'),(1809,25,'Gonopoddi','à¦—à¦£à¦ªà¦¦à§à¦¦à§€'),(1810,25,'Gourdwar','à¦—à§Œà§œà¦¦à§à¦¬à¦¾à¦°'),(1811,25,'Nokla','à¦¨à¦•à¦²à¦¾'),(1812,25,'Pathakata','à¦ªà¦¾à¦ à¦¾à¦•à¦¾à¦Ÿà¦¾'),(1813,25,'Talki','à¦Ÿà¦¾à¦²à¦•à§€'),(1814,25,'Urpha','à¦‰à¦°à¦«à¦¾'),(1815,26,'Dansail','à¦§à¦¾à¦¨à¦¶à¦¾à¦‡à¦²'),(1816,26,'Gouripur','à¦—à§Œà¦°à¦¿à¦ªà§à¦°'),(1817,26,'Hatibandha','à¦¹à¦¾à¦¤à¦¿à¦¬à¦¾à¦¨à§à¦¦à¦¾'),(1818,26,'Jhenaigati','à¦à¦¿à¦¨à¦¾à¦‡à¦—à¦¾à¦¤à§€'),(1819,26,'Kansa','à¦•à¦¾à¦‚à¦¶à¦¾'),(1820,26,'Malijhikanda','à¦®à¦¾à¦²à¦¿à¦à¦¿à¦•à¦¾à¦¨à§à¦¦à¦¾'),(1821,26,'Nolkura','à¦¨à¦²à¦•à§à§œà¦¾'),(1822,435,'Belgacha','à¦¬à§‡à¦²à¦—à¦¾à¦›à¦¾ '),(1823,435,'Bhogdanga','à¦­à§‹à¦—à¦¡à¦¾à¦™à§à¦—à¦¾'),(1824,435,'Ghogadhoh','à¦˜à§‹à¦—à¦¾à¦¦à¦¹ '),(1825,435,'Holokhana','à¦¹à¦²à§‹à¦–à¦¾à¦¨à¦¾ '),(1826,435,'Jatrapur','à¦¯à¦¾à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(1827,435,'Kanthalbari','à¦•à¦¾à¦à¦ à¦¾à¦²à¦¬à¦¾à§œà§€'),(1828,435,'Mogolbasa','à¦®à§‹à¦—à¦²à¦¬à¦¾à¦¸à¦¾ '),(1829,435,'Panchgachi','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦›à¦¿'),(1830,436,'Bamondanga','à¦¬à¦¾à¦®à¦¨à¦¡à¦¾à¦™à§à¦—à¦¾'),(1831,436,'Berubari','à¦¬à§‡à¦°à§à¦¬à¦¾à§œà§€'),(1832,436,'Bhitorbond','à¦­à¦¿à¦¤à¦°à¦¬à¦¨à§à¦¦'),(1833,436,'Bollobherkhas','à¦¬à¦²à§à¦²à¦­à§‡à¦°à¦–à¦¾à¦¸'),(1834,436,'Hasnabad','à¦¹à¦¾à¦¸à¦¨à¦¾à¦¬à¦¾à¦¦'),(1835,436,'Kachakata','à¦•à¦à¦šà¦¾à¦•à¦¾à¦à¦Ÿà¦¾ '),(1836,436,'Kaligonj','à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ'),(1837,436,'Kedar','à¦•à§‡à¦¦à¦¾à¦°'),(1838,436,'Narayanpur','à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦ªà§à¦°'),(1839,436,'Newyashi','à¦¨à§‡à¦“à§Ÿà¦¾à¦¶à§€'),(1840,436,'Noonkhawa','à¦¨à§à¦¨à¦–à¦¾à¦“à§Ÿà¦¾'),(1841,436,'Raigonj','à¦°à¦¾à§Ÿà¦—à¦žà§à¦œ'),(1842,436,'Ramkhana','à¦°à¦¾à¦®à¦–à¦¾à¦¨à¦¾'),(1843,436,'Sontaspur','à¦¸à¦¨à§à¦¤à§‹à¦·à¦ªà§à¦°'),(1844,437,'Andharirjhar','à¦†à¦¨à§à¦§à¦¾à¦°à§€à¦°à¦à¦¾à§œ'),(1845,437,'Bangasonahat','à¦¬à¦™à§à¦—à¦¸à§‹à¦¨à¦¾à¦¹à¦¾à¦Ÿ'),(1846,437,'Bhurungamari','à¦­à§‚à¦°à§à¦™à§à¦—à¦¾à¦®à¦¾à¦°à§€ '),(1847,437,'Boldia','à¦¬à¦²à¦¦à¦¿à§Ÿà¦¾'),(1848,437,'Charbhurungamari','à¦šà¦°à¦­à§‚à¦°à§à¦™à§à¦—à¦¾à¦®à¦¾à¦°à§€'),(1849,437,'Joymonirhat','à¦œà§Ÿà¦®à¦¨à¦¿à¦°à¦¹à¦¾à¦Ÿ'),(1850,437,'Paikarchara','à¦ªà¦¾à¦‡à¦•à§‡à¦°à¦›à§œà¦¾'),(1851,437,'Pathordubi','à¦ªà¦¾à¦¥à¦°à¦¡à§à¦¬à¦¿'),(1852,437,'Shilkhuri','à¦¶à¦¿à¦²à¦–à§à§œà¦¿'),(1853,437,'Tilai','à¦¤à¦¿à¦²à¦¾à¦‡'),(1854,438,'Baravita','à¦¬à§œà¦­à¦¿à¦Ÿà¦¾'),(1855,438,'Bhangamor','à¦­à¦¾à¦™à§à¦—à¦¾à¦®à§‹à§œ'),(1856,438,'Kashipur','à¦•à¦¾à¦¶à¦¿à¦ªà§à¦°'),(1857,438,'Nawdanga','à¦¨à¦¾à¦“à¦¡à¦¾à¦™à§à¦—à¦¾ '),(1858,438,'Phulbari','à¦«à§à¦²à¦¬à¦¾à§œà§€ '),(1859,438,'Shimulbari','à¦¶à¦¿à¦®à§à¦²à¦¬à¦¾à§œà§€'),(1860,439,'Biddanondo','à¦¬à¦¿à¦¦à§à¦¯à¦¾à¦¨à¦¨à§à¦¦ '),(1861,439,'Chakirpashar','à¦šà¦¾à¦•à¦¿à¦°à¦ªà¦¶à¦¾à¦°'),(1862,439,'Chinai','à¦›à¦¿à¦¨à¦¾à¦‡ '),(1863,439,'Gharialdanga','à¦˜à§œà¦¿à§Ÿà¦¾à¦²à¦¡à¦¾à¦™à§à¦—à¦¾'),(1864,439,'Nazimkhan','à¦¨à¦¾à¦œà¦¿à¦®à¦–à¦¾à¦à¦¨ '),(1865,439,'Rajarhat','à¦°à¦¾à¦œà¦¾à¦°à¦¹à¦¾à¦Ÿ '),(1866,439,'Umarmajid','à¦‰à¦®à¦° à¦®à¦œà¦¿à¦¦ '),(1867,440,'Bazra','à¦¬à¦œà¦°à¦¾'),(1868,440,'Begumgonj','à¦¬à§‡à¦—à¦®à¦—à¦žà§à¦œ'),(1869,440,'Buraburi','à¦¬à§à§œà¦¾à¦¬à§à§œà§€'),(1870,440,'Daldalia','à¦¦à¦²à¦¦à¦²à¦¿à§Ÿà¦¾ '),(1871,440,'Dhamsreni','à¦§à¦¾à¦®à¦¶à§à¦°à§‡à¦£à§€'),(1872,440,'Dharanibari','à¦§à¦°à¦£à§€à¦¬à¦¾à§œà§€'),(1873,440,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(1874,440,'Gunaigas','à¦—à§à¦¨à¦¾à¦‡à¦—à¦¾à¦›'),(1875,440,'Hatia','à¦¹à¦¾à¦¤à¦¿à§Ÿà¦¾'),(1876,440,'Pandul','à¦ªà¦¾à¦¨à§à¦¡à§à¦²'),(1877,440,'Shahabiaralga','à¦¸à¦¾à¦¹à§‡à¦¬à§‡à¦° à¦†à¦²à¦—à¦¾'),(1878,440,'Thetrai','à¦¥à§‡à¦¤à¦°à¦¾à¦‡'),(1879,440,'Tobockpur','à¦¤à¦¬à¦•à¦ªà§à¦°'),(1880,441,'Austomirchar','à¦…à¦·à§à¦Ÿà¦®à§€à¦° à¦šà¦°'),(1881,441,'Chilmari','à¦šà¦¿à¦²à¦®à¦¾à¦°à§€'),(1882,441,'Nayarhat','à¦¨à§Ÿà¦¾à¦°à¦¹à¦¾à¦Ÿ'),(1883,441,'Ramna','à¦°à¦®à¦¨à¦¾'),(1884,441,'Ranigonj','à¦°à¦¾à¦£à§€à¦—à¦žà§à¦œ '),(1885,441,'Thanahat','à¦¥à¦¾à¦¨à¦¾à¦¹à¦¾à¦Ÿ'),(1886,442,'Bondober','à¦¬à¦¨à§à¦¦à¦¬à§‡à§œ'),(1887,442,'Dadevanga','à¦¦à¦¾à¦à¦¤à¦­à¦¾à¦™à§à¦—à¦¾'),(1888,442,'Jadurchar','à¦¯à¦¾à¦¦à§à¦°à¦šà¦°'),(1889,442,'Rowmari','à¦°à§Œà¦®à¦¾à¦°à§€'),(1890,442,'Shoulemari','à¦¶à§Œà¦²à¦®à¦¾à¦°à§€'),(1891,443,'Kodalkati','à¦•à§‹à¦¦à¦¾à¦²à¦•à¦¾à¦Ÿà¦¿'),(1892,443,'Mohongonj','à¦®à§‹à¦¹à¦¨à¦—à¦žà§à¦œ'),(1893,443,'Rajibpur','à¦°à¦¾à¦œà¦¿à¦¬à¦ªà§à¦°'),(1894,27,'Basail','à¦¬à¦¾à¦¸à¦¾à¦‡à¦²'),(1895,27,'Fulki','à¦«à§à¦²à¦•à¦¿'),(1896,27,'Habla','à¦¹à¦¾à¦¬à¦²à¦¾'),(1897,27,'Kanchanpur','à¦•à¦¾à¦žà§à¦šà¦¨à¦ªà§à¦°'),(1898,27,'Kashil','à¦•à¦¾à¦¶à¦¿à¦²'),(1899,27,'Kauljani','à¦•à¦¾à¦‰à¦²à¦œà¦¾à¦¨à§€'),(1900,28,'Aloa','à¦†à¦²à§‹à¦¯à¦¼à¦¾'),(1901,28,'Arjuna','à¦…à¦°à§à¦œà§à¦¨à¦¾'),(1902,28,'Falda','à¦«à¦²à¦¦à¦¾'),(1903,28,'Gabshara','à¦—à¦¾à¦¬à¦¸à¦¾à¦°à¦¾'),(1904,28,'Gobindashi','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦¾à¦¸à§€'),(1905,28,'Nikrail','à¦¨à¦¿à¦•à¦°à¦¾à¦‡à¦²'),(1906,29,'Atia','à¦†à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(1907,29,'Delduar','à¦¦à§‡à¦²à¦¦à§à¦¯à¦¼à¦¾à¦°'),(1908,29,'Deuli','à¦¦à§‡à¦‰à¦²à§€'),(1909,29,'Dubail','à¦¡à§à¦¬à¦¾à¦‡à¦²'),(1910,29,'Elasin','à¦à¦²à¦¾à¦¸à¦¿à¦¨'),(1911,29,'Fazilhati','à¦«à¦¾à¦œà¦¿à¦²à¦¹à¦¾à¦Ÿà¦¿'),(1912,29,'Lauhati','à¦²à¦¾à¦‰à¦¹à¦¾à¦Ÿà¦¿'),(1913,29,'Patharail','à¦ªà¦¾à¦¥à¦°à¦¾à¦‡à¦²'),(1914,30,'Anehola','à¦†à¦¨à§‡à¦¹à¦²à¦¾'),(1915,30,'Deopara','à¦¦à§‡à¦“à¦ªà¦¾à¦¡à¦¼à¦¾'),(1916,30,'Deulabari','à¦¦à§‡à¦‰à¦²à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1917,30,'Dhalapara','à¦§à¦²à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(1918,30,'Digar','à¦¦à¦¿à¦—à¦¡à¦¼'),(1919,30,'Dighalkandia','à¦¦à¦¿à¦˜à¦²à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1920,30,'Ghatail','à¦˜à¦¾à¦Ÿà¦¾à¦‡à¦²'),(1921,30,'Jamuria','à¦œà¦¾à¦®à§à¦°à¦¿à¦¯à¦¼à¦¾'),(1922,30,'Lokerpara','à¦²à§‹à¦•à§‡à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(1923,30,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(1924,30,'Sandhanpur','à¦¸à¦¨à§à¦§à¦¾à¦¨à¦ªà§à¦°'),(1925,31,'Alamnagor','à¦†à¦²à¦®à¦¨à¦—à¦°'),(1926,31,'Dhopakandi','à¦§à§‹à¦ªà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(1927,31,'Hadera','à¦¹à¦¾à¦¦à¦¿à¦°à¦¾'),(1928,31,'Hemnagor','à¦¹à§‡à¦®à¦¨à¦—à¦°'),(1929,31,'Jhawail','à¦à¦¾à¦“à¦¯à¦¼à¦¾à¦‡à¦²'),(1930,31,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(1931,31,'Nagdashimla','à¦¨à¦—à¦¦à¦¾à¦¶à¦¿à¦®à¦²à¦¾'),(1932,32,'Alokdia','à¦†à¦²à§‹à¦•à¦¦à¦¿à¦¯à¦¼à¦¾'),(1933,32,'Aronkhola','à¦…à¦°à¦£à¦–à§‹à¦²à¦¾'),(1934,32,'Aushnara','à¦†à¦‰à¦¶à¦¨à¦¾à¦°à¦¾'),(1935,32,'Golabari','à¦—à§‹à¦²à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1936,32,'Mirjabari','à¦®à¦¿à¦°à§à¦œà¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1937,32,'Sholakuri','à¦¶à§‹à¦²à¦¾à¦•à§à¦¡à¦¼à¦¿'),(1938,33,'Ajgana','à¦†à¦œà¦—à¦¾à¦¨à¦¾'),(1939,33,'Anaitara','à¦†à¦¨à¦¾à¦‡à¦¤à¦¾à¦°à¦¾'),(1940,33,'Bahuria','à¦¬à¦¹à§à¦°à¦¿à¦¯à¦¼à¦¾'),(1941,33,'Banail','à¦¬à¦¾à¦¨à¦¾à¦‡à¦²'),(1942,33,'Baora','à¦­à¦¾à¦“à¦¡à¦¼à¦¾'),(1943,33,'Bastail','à¦¬à¦¾à¦à¦¶à¦¤à§ˆà¦²'),(1944,33,'Bhatram','à¦­à¦¾à¦¤à¦—à§à¦°à¦¾à¦®'),(1945,33,'Fatepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(1946,33,'Gorai','à¦—à§‹à¦¡à¦¼à¦¾à¦‡'),(1947,33,'Jamurki','à¦œà¦¾à¦®à§à¦°à§à¦•à§€'),(1948,33,'Latifpur','à¦²à¦¤à¦¿à¦«à¦ªà§à¦°'),(1949,33,'Mahera','à¦®à¦¹à§‡à¦¡à¦¼à¦¾'),(1950,33,'Tarafpur','à¦¤à¦°à¦«à¦ªà§à¦°'),(1951,33,'Warshi','à¦“à¦¯à¦¼à¦¾à¦°à§à¦¶à§€'),(1952,34,'Bekrahatgram','à¦¬à§‡à¦•à¦°à¦¾ à¦†à¦Ÿà¦—à§à¦°à¦¾à¦®'),(1953,34,'Bhadra','à¦­à¦¾à¦¦à§à¦°à¦¾'),(1954,34,'Bharra','à¦­à¦¾à¦°à¦¡à¦¼à¦¾'),(1955,34,'Dhuburia','à¦§à§à¦¬à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(1956,34,'Doptior','à¦¦à¦ªà§à¦¤à¦¿à¦¯à¦¼à¦°'),(1957,34,'Goyhata','à¦—à¦¯à¦¼à¦¹à¦¾à¦Ÿà¦¾'),(1958,34,'Mamudnagor','à¦®à¦¾à¦®à§à¦¦à¦¨à¦—à¦°'),(1959,34,'Mokna','à¦®à§‹à¦•à¦¨à¦¾'),(1960,34,'Nagorpur','à¦¨à¦¾à¦—à¦°à¦ªà§à¦°'),(1961,34,'Pakutia','à¦ªà¦¾à¦•à§à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(1962,34,'Sahabathpur','à¦¸à¦¹à¦¬à¦¤à¦ªà§à¦°'),(1963,34,'Solimabad','à¦¸à¦²à¦¿à¦®à¦¾à¦¬à¦¾à¦¦'),(1964,35,'Baharatoil','à¦¬à¦¹à§‡à¦¡à¦¼à¦¾à¦¤à§ˆà¦²'),(1965,35,'Dariapur','à¦¦à¦°à¦¿à¦¯à¦¼à¦¾à¦ªà§à¦°'),(1966,35,'Gajaria','à¦—à¦œà¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(1967,35,'Hatibandha','à¦¹à¦¾à¦¤à§€à¦¬à¦¾à¦¨à§à¦§à¦¾'),(1968,35,'Jaduppur','à¦¯à¦¾à¦¦à¦¬à¦ªà§à¦°'),(1969,35,'Kakrajan','à¦•à¦¾à¦•à¦¡à¦¼à¦¾à¦œà¦¾à¦¨'),(1970,35,'Kalia','à¦•à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(1971,35,'Kalmegha','à¦•à¦¾à¦²à¦®à§‡à¦˜à¦¾'),(1972,36,'Baghil','à¦¬à¦¾à¦˜à¦¿à¦²'),(1973,36,'Dyenna','à¦¦à¦¾à¦‡à¦¨à§à¦¯à¦¾'),(1974,36,'Gala','à¦—à¦¾à¦²à¦¾'),(1975,36,'Gharinda','à¦˜à¦¾à¦°à¦¿à¦¨à§à¦¦à¦¾'),(1976,36,'Hugra','à¦¹à§à¦—à¦¡à¦¼à¦¾'),(1977,36,'Kakua','à¦•à¦¾à¦•à§à¦¯à¦¼à¦¾'),(1978,36,'Karatia','à¦•à¦°à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(1979,36,'Katuli','à¦•à¦¾à¦¤à§à¦²à§€'),(1980,36,'Mahamudnagar','à¦®à¦¾à¦¹à¦®à§à¦¦à¦¨à¦—à¦°'),(1981,36,'Mogra','à¦®à¦—à¦¡à¦¼à¦¾'),(1982,36,'Porabari','à¦ªà§‹à¦¡à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1983,36,'Silimpur','à¦›à¦¿à¦²à¦¿à¦®à¦ªà§à¦°'),(1984,37,'Balla','à¦¬à¦²à§à¦²à¦¾'),(1985,37,'Bangra','à¦¬à¦¾à¦‚à¦¡à¦¼à¦¾'),(1986,37,'Birbashinda','à¦¬à§€à¦°à¦¬à¦¾à¦¸à¦¿à¦¨à§à¦¦à¦¾'),(1987,37,'Dashokia','à¦¦à¦¶à¦•à¦¿à¦¯à¦¼à¦¾'),(1988,37,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(1989,37,'Gohaliabari','à¦—à§‹à¦¹à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(1990,37,'Kokdahara','à¦•à§‹à¦•à¦¡à¦¹à¦°à¦¾'),(1991,37,'Nagbari','à¦¨à¦¾à¦—à¦¬à¦¾à¦¡à¦¼à§€'),(1992,37,'Narandia','à¦¨à¦¾à¦°à¦¾à¦¨à§à¦¦à¦¿à¦¯à¦¼à¦¾'),(1993,37,'Paikora','à¦ªà¦¾à¦‡à¦•à¦¡à¦¼à¦¾'),(1994,37,'Parkhi','à¦ªà¦¾à¦°à¦–à§€'),(1995,37,'Salla','à¦¸à¦²à§à¦²à¦¾'),(1996,37,'Shahadebpur','à¦¸à¦¹à¦¦à§‡à¦¬à¦ªà§à¦°'),(1997,38,'Baniajan','à¦¬à¦¾à¦¨à¦¿à¦¯à¦¼à¦¾à¦œà¦¾à¦¨'),(1998,38,'Birtara','à¦¬à§€à¦°à¦¤à¦¾à¦°à¦¾'),(1999,38,'Bolibodrow','à¦¬à¦²à¦¿à¦­à¦¦à§à¦°'),(2000,38,'Dhopakhali','à¦§à§‹à¦ªà¦¾à¦–à¦¾à¦²à§€'),(2001,38,'Jadunathpur','à¦¯à¦¦à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(2002,38,'Mushuddi','à¦®à§à¦¶à§à¦¦à§à¦¦à¦¿'),(2003,38,'Paiska','à¦ªà¦¾à¦‡à¦¸à§à¦•à¦¾'),(2004,276,'10novimpur','à¦­à§€à¦®à¦ªà§à¦°'),(2005,276,'1nomohadevpur','à¦®à¦¹à¦¾à¦¦à§‡à¦¬à¦ªà§à¦° '),(2006,276,'2nohatur','à¦¹à¦¾à¦¤à§à§œ'),(2007,276,'3nokhajur','à¦–à¦¾à¦œà§à¦° '),(2008,276,'4nochandas','à¦šà¦¾à¦à¦¨à§à¦¦à¦¾à¦¶'),(2009,276,'6noenayetpur','à¦à¦¨à¦¾à§Ÿà§‡à¦¤à¦ªà§à¦°'),(2010,276,'7nosofapur','à¦¸à¦«à¦¾à¦ªà§à¦°'),(2011,276,'8nouttargram','à¦‰à¦¤à§à¦¤à¦°à¦—à§à¦°à¦¾à¦®'),(2012,276,'9nocheragpur','à¦šà§‡à¦°à¦¾à¦—à¦ªà§à¦°'),(2013,276,'Roygon','à¦°à¦¾à¦‡à¦—à¦¾à¦'),(2014,277,'1nobadalgachi','à¦¬à¦¦à¦²à¦—à¦¾à¦›à§€ '),(2015,277,'2nomothurapur','à¦®à¦¥à§à¦°à¦¾à¦ªà§à¦° '),(2016,277,'3nopaharpur','à¦ªà¦¾à¦¹à¦¾à¦°à¦ªà§à¦° '),(2017,277,'4nomithapur','à¦®à¦¿à¦ à¦¾à¦ªà§à¦° '),(2018,277,'5nokola','à¦•à§‹à¦²à¦¾ '),(2019,277,'6nobilashbari','à¦¬à¦¿à¦²à¦¾à¦¶à¦¬à¦¾à§œà§€ '),(2020,277,'7noadhaipur','à¦†à¦§à¦¾à¦‡à¦ªà§à¦° '),(2021,277,'8nobalubhara','à¦¬à¦¾à¦²à§à¦­à¦°à¦¾ '),(2022,278,'10noamair','à¦†à¦®à¦¾à¦‡à§œ '),(2023,278,'11noahihara','à¦¶à¦¿à¦¹à¦¾à¦°à¦¾ '),(2024,278,'1nopatnitala','à¦ªà¦¤à§à¦¨à§€à¦¤à¦²à¦¾ '),(2025,278,'2nonirmail','à¦¨à¦¿à¦®à¦‡à¦² '),(2026,278,'3nodibar','à¦¦à¦¿à¦¬à¦° '),(2027,278,'4noakbarpur','à¦†à¦•à¦¬à¦°à¦ªà§à¦° '),(2028,278,'5nomatindar','à¦®à¦¾à¦Ÿà¦¿à¦¨à§à¦¦à¦° '),(2029,278,'6nokrishnapur','à¦•à§ƒà¦·à§à¦£à¦ªà§à¦° '),(2030,278,'7nopatichrara','à¦ªà¦¾à¦Ÿà¦¿à¦šà§œà¦¾ '),(2031,278,'8nonazipur','à¦¨à¦œà¦¿à¦ªà§à¦° '),(2032,278,'9noghasnagar','à¦˜à¦·à¦¨à¦—à¦° '),(2033,279,'1nodhamoirhat','à¦§à¦¾à¦®à¦‡à¦°à¦¹à¦¾à¦Ÿ'),(2034,279,'2noagradigun','à¦†à¦—à§à¦°à¦¾à¦¦à§à¦¬à¦¿à¦—à§à¦¨'),(2035,279,'3noalampur','à¦†à¦²à¦®à¦ªà§à¦°'),(2036,279,'4noumar','à¦‰à¦®à¦¾à¦° '),(2037,279,'5noaranagar','à¦†à§œà¦¾à¦¨à¦—à¦°'),(2038,279,'6nojahanpur','à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°'),(2039,279,'7noisabpur','à¦‡à¦¸à¦¬à¦ªà§à¦°'),(2040,279,'8nokhelna','à¦–à§‡à¦²à¦¨à¦¾'),(2041,251,'Borgachi','à§¦à§­ à¦¨à¦‚ à¦¬à¦¡à¦¼à§à¦—à¦¾à¦›à¦¿'),(2042,251,'Damkura','à§¦à§© à¦¨à¦‚ à¦¦à¦¾à¦®à¦•à§à¦¡à¦¼à¦¾'),(2043,251,'Darsanpara','à§¦à§§ à¦¨à¦‚ à¦¦à¦°à§à¦¶à¦¨à¦ªà¦¾à¦¡à¦¼à¦¾'),(2044,251,'Harian','à§¦à§¬ à¦¨à¦‚ à¦¹à¦°à¦¿à¦¯à¦¼à¦¾à¦¨'),(2045,251,'Horipur','à§¦à§ª à¦¨à¦‚ à¦¹à¦°à¦¿à¦ªà§à¦°'),(2046,251,'Horogram','à§¦à§« à¦¨à¦‚ à¦¹à¦¡à¦¼à¦—à§à¦°à¦¾à¦®'),(2047,251,'Hujuripara','à§¦à§¨ à¦¨à¦‚ à¦¹à§à¦œà§à¦°à§€ à¦ªà¦¾à¦¡à¦¼à¦¾'),(2048,251,'Parila','à§¦à§® à¦¨à¦‚ à¦ªà¦¾à¦°à¦¿à¦²à¦¾'),(2049,80,'Deluabari','à§¦à§ª à¦¨à¦‚ à¦¦à§‡à¦²à§à¦¯à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(2050,80,'Jhaluka','à§¦à§« à¦¨à¦‚ à¦à¦¾à¦²à§à¦•à¦¾'),(2051,80,'Joynogor','à§¦à§­ à¦¨à¦‚ à¦œà¦¯à¦¼à¦¨à¦—à¦°'),(2052,80,'Kismatgankoir','à§¦à§¨ à¦¨à¦‚ à¦•à¦¿à¦¸à¦®à¦¤à¦—à¦£à¦•à§ˆà¦¡à¦¼'),(2053,80,'Maria','à§¦à§¬ à¦¨à¦‚ à¦®à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(2054,80,'Naopara','à§¦à§§ à¦¨à¦‚ à¦¨à¦“à¦ªà¦¾à¦¡à¦¼à¦¾'),(2055,80,'Pananagar','à§¦à§© à¦¨à¦‚ à¦ªà¦¾à¦¨à¦¾à¦¨à¦—à¦°'),(2056,253,'Baksimoil','à§¦à§« à¦¨à¦‚ à¦¬à¦¾à¦•à¦¶à¦¿à¦®à¦‡à¦²'),(2057,253,'Dhuroil','à§¦à§§ à¦¨à¦‚ à¦§à§à¦°à¦‡à¦²'),(2058,253,'Ghasigram','à§¦à§¨ à¦¨à¦‚ à¦˜à¦·à¦¿à¦—à§à¦°à¦¾à¦®'),(2059,253,'Jahanabad','à§¦à§¬ à¦¨à¦‚ à¦œà¦¾à¦¹à¦¾à¦¨à¦¾à¦¬à¦¾à¦¦'),(2060,253,'Mougachi','à§¦à§ª à¦¨à¦‚ à¦®à§Œà¦—à¦¾à¦›à¦¿'),(2061,253,'Raighati','à§¦à§© à¦¨à¦‚ à¦°à¦¾à¦¯à¦¼à¦˜à¦¾à¦Ÿà¦¿'),(2062,39,'Asimpatuli','à¦†à¦›à¦¿à¦®à¦ªà¦¾à¦Ÿà§à¦²à§€'),(2063,39,'Bakta','à¦¬à¦¾à¦•à§à¦¤à¦¾'),(2064,39,'Balian','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦¨'),(2065,39,'Deukhola','à¦¦à§‡à¦“à¦–à§‹à¦²à¦¾'),(2066,39,'Enayetpur','à¦à¦¨à¦¾à§Ÿà§‡à¦¤à¦ªà§à¦°'),(2067,39,'Fulbaria','à¦«à§à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(2068,39,'Kaladaha','à¦•à¦¾à¦²à¦¾à¦¦à¦¹'),(2069,39,'Kushmail','à¦•à§à¦¶à¦®à¦¾à¦‡à¦²'),(2070,39,'Naogaon','à¦¨à¦¾à¦“à¦—à¦¾à¦à¦“'),(2071,39,'Putijana','à¦ªà§à¦Ÿà¦¿à¦œà¦¾à¦¨à¦¾'),(2072,39,'Radhakanai','à¦°à¦¾à¦§à¦¾à¦•à¦¾à¦¨à¦¾à¦‡'),(2073,39,'Rangamatia','à¦°à¦¾à¦™à§à¦—à¦¾à¦®à¦¾à¦Ÿà¦¿à§Ÿà¦¾'),(2074,39,'Vobanipur','à¦­à¦¬à¦¾à¦¨à§€à¦ªà§à¦°'),(2075,40,'Amirabari','à¦†à¦®à¦¿à¦°à¦¾à¦¬à¦¾à§œà§€'),(2076,40,'Bailor','à¦¬à§ˆà¦²à¦°'),(2077,40,'Balipara','à¦¬à¦¾à¦²à¦¿à¦ªà¦¾à§œà¦¾'),(2078,40,'Dhanikhola','à¦§à¦¾à¦¨à§€à¦–à§‡à¦¾à¦²à¦¾'),(2079,40,'Harirampur','à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(2080,40,'Kanihari','à¦•à¦¾à¦¨à¦¿à¦¹à¦¾à¦°à§€'),(2081,40,'Kanthal','à¦•à¦¾à¦à¦ à¦¾à¦²'),(2082,40,'Mathbari','à¦®à¦ à¦¬à¦¾à§œà§€'),(2083,40,'Mokshapur','à¦®à§‹à¦•à§à¦·à¦ªà§à¦°'),(2084,40,'Rampur','à¦°à¦¾à¦®à¦ªà§à¦°'),(2085,40,'Trishal','à¦¤à§à¦°à¦¿à¦¶à¦¾à¦²'),(2086,40,'Www','à¦¸à¦¾à¦–à§à§Ÿà¦¾'),(2087,266,'Gopinathpur','à¦—à§‹à¦ªà§€à¦¨à¦¾à¦¥à¦ªà§à¦° '),(2088,266,'Raikali','à¦°à¦¾à§Ÿà¦•à¦¾à¦²à§€ '),(2089,266,'Rukindipur','à¦°à§à¦•à¦¿à¦¨à§à¦¦à§€à¦ªà§à¦° '),(2090,266,'Sonamukhi','à¦¸à§‹à¦¨à¦¾à¦®à§‚à¦–à§€ '),(2091,266,'Tilakpur','à¦¤à¦¿à¦²à¦•à¦ªà§à¦° '),(2092,267,'Ahammedabad','à¦†à¦¹à¦®à§à¦®à§‡à¦¦à¦¾à¦¬à¦¾à¦¦ '),(2093,267,'Matrai','à¦®à¦¾à¦¤à§à¦°à¦¾à¦‡ '),(2094,267,'Punot','à¦ªà§à¦¨à¦Ÿ '),(2095,267,'Udaipur','à¦‰à¦¦à§Ÿà¦ªà§à¦°'),(2096,267,'Zindarpur','à¦œà¦¿à¦¨à§à¦¦à¦¾à¦°à¦ªà§à¦°'),(2097,322,'Chandkhali','à¦šà¦¾à¦à¦¦à¦–à¦¾à¦²à§€ '),(2098,322,'Deluti','à¦¦à§‡à¦²à§à¦Ÿà¦¿ '),(2099,322,'Godaipur','à¦—à¦¦à¦¾à¦‡à¦ªà§à¦° '),(2100,322,'Goroikhali','à¦—à¦¡à¦¼à¦‡à¦–à¦¾à¦²à§€ '),(2101,322,'Horidhali','à¦¹à¦°à¦¿à¦¢à¦¾à¦²à§€ '),(2102,322,'Kopilmuni','à¦•à¦ªà¦¿à¦²à¦®à§à¦¨à¦¿ '),(2103,322,'Loskor','à¦²à¦¸à§à¦•à¦° '),(2104,322,'Lota','à¦²à¦¤à¦¾ '),(2105,322,'Soladana','à¦¸à§‹à¦²à¦¾à¦¦à¦¾à¦¨à¦¾ '),(2106,322,'Www','à¦°à¦¾à¦¡à¦¼à§à¦²à§€ '),(2107,323,'Www','à¦†à¦Ÿà¦°à¦¾ à¦—à¦¿à¦²à¦¾à¦¤à¦²à¦¾ '),(2108,323,'Www','à¦¦à¦¾à¦®à§‹à¦¦à¦° '),(2109,323,'Www','à¦«à§à¦²à¦¤à¦²à¦¾ '),(2110,323,'Www','à¦œà¦¾à¦®à¦¿à¦°à¦¾ '),(2111,324,'Www','à¦†à¦¡à¦¼à¦‚à¦˜à¦¾à¦Ÿà¦¾ '),(2112,324,'Www','à¦¬à¦¾à¦°à¦¾à¦•à¦ªà§à¦° '),(2113,324,'Www','à¦¦à¦¿à¦˜à¦²à¦¿à§Ÿà¦¾ '),(2114,324,'Www','à¦—à¦¾à¦œà§€à¦°à¦¹à¦¾à¦Ÿ '),(2115,324,'Www','à¦¯à§‹à¦—à§€à¦ªà§‹à¦² '),(2116,324,'Www','à¦¸à§‡à¦¨à¦¹à¦¾à¦Ÿà¦¿ '),(2117,325,'Aichgati','à¦†à¦‡à¦šà¦—à¦¾à¦¤à§€ '),(2118,325,'Ghatvog','à¦˜à¦¾à¦Ÿà¦­à§‹à¦— '),(2119,325,'Noihati','à¦¨à§ˆà¦¹à¦¾à¦Ÿà¦¿ '),(2120,325,'Srifoltola','à¦¶à§à¦°à§€à¦«à¦²à¦¤à¦²à¦¾ '),(2121,325,'Tsb','à¦Ÿà¦¿à¦à¦¸à¦¬à¦¿ '),(2122,326,'Chagladoho','à¦›à¦¾à¦—à¦²à¦¾à¦¦à¦¹ '),(2123,326,'Terokhada','à¦¤à§‡à¦°à¦–à¦¾à¦¦à¦¾'),(2124,326,'Www','à¦†à¦œà¦—à¦¡à¦¼à¦¾ '),(2125,326,'Www','à¦¬à¦¾à¦°à¦¾à¦¸à¦¾à¦¤ '),(2126,326,'Www','à¦®à¦§à§à¦ªà§à¦° '),(2127,326,'Www','à¦¸à¦¾à¦šà¦¿à¦¯à¦¼à¦¾à¦¦à¦¾à¦¹ '),(2128,327,'Atlia','à¦†à¦Ÿà¦²à¦¿à¦¯à¦¼à¦¾ '),(2129,327,'Dhamalia','à¦§à¦¾à¦®à¦¾à¦²à¦¿à¦¯à¦¼à¦¾ '),(2130,327,'Dumuria','à¦¡à§à¦®à§à¦°à¦¿à¦¯à¦¼à¦¾ '),(2131,327,'Ghutudia','à¦—à§à¦Ÿà§à¦¦à¦¿à¦¯à¦¼à¦¾ '),(2132,327,'Khornia','à¦–à¦°à§à¦£à¦¿à¦¯à¦¼à¦¾ '),(2133,327,'Magurghona','à¦®à¦¾à¦—à§à¦°à¦¾à¦˜à§‹à¦¨à¦¾ '),(2134,327,'Magurkhali','à¦®à¦¾à¦—à§à¦°à¦–à¦¾à¦²à¦¿ '),(2135,327,'Raghunathpur','à¦°à¦˜à§à¦¨à¦¾à¦¥à¦ªà§à¦° '),(2136,327,'Rongpur','à¦°à¦‚à¦ªà§à¦° '),(2137,327,'Rudaghora','à¦°à§à¦¦à¦¾à¦˜à¦°à¦¾ '),(2138,327,'Sahos','à¦¸à¦¾à¦¹à¦¸ '),(2139,327,'Shorafpur','à¦¶à¦°à¦¾à¦«à¦ªà§à¦° '),(2140,327,'Shovna','à¦¶à§‹à¦­à¦¨à¦¾ '),(2141,327,'Vandarpara','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦ªà¦¾à¦¡à¦¼à¦¾ '),(2142,328,'Www','à¦†à¦®à¦¿à¦°à¦ªà§à¦° '),(2143,328,'Www','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾ '),(2144,328,'Www','à¦¬à¦Ÿà¦¿à§Ÿà¦¾à¦˜à¦¾à¦Ÿà¦¾ '),(2145,328,'Www','à¦—à¦™à§à¦—à¦¾à¦°à¦¾à¦®à¦ªà§à¦° '),(2146,328,'Www','à¦œà¦²à¦®à¦¾ '),(2147,328,'Www','à¦¸à§à¦°à¦–à¦¾à¦²à§€ '),(2148,328,'Www','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦•à§‹à¦Ÿ '),(2149,329,'Bajua','à¦¬à¦¾à¦œà§à¦¯à¦¼à¦¾ '),(2150,329,'Banishanta','à¦¬à¦¾à¦¨à¦¿à¦¶à¦¾à¦¨à§à¦¤à¦¾ '),(2151,329,'Koilashgonj','à¦•à§ˆà¦²à¦¾à¦¶à¦—à¦žà§à¦œ '),(2152,329,'Laudoba','à¦²à¦¾à¦‰à¦¡à§‹à¦¬ '),(2153,329,'Pankhali','à¦ªà¦¾à¦¨à¦–à¦¾à¦²à§€ '),(2154,329,'Www','à¦¦à¦¾à¦•à§‹à¦ª '),(2155,329,'Www','à¦•à¦¾à¦®à¦¾à¦°à¦–à§‹à¦²à¦¾ '),(2156,329,'Www','à¦¸à§à¦¤à¦¾à¦°à¦–à¦¾à¦²à§€ '),(2157,329,'Www','à¦¤à¦¿à¦²à¦¡à¦¾à¦™à§à¦—à¦¾ '),(2158,330,'Amadi','à¦†à¦®à¦¾à¦¦à¦¿ '),(2159,330,'Bagali','à¦¬à¦¾à¦—à¦¾à¦²à§€ '),(2160,330,'Koyra','à¦•à¦¯à¦¼à¦°à¦¾ '),(2161,330,'Moharajpur','à¦®à¦¹à¦¾à¦°à¦¾à¦œà¦ªà§à¦° '),(2162,330,'Moheswaripur','à¦®à¦¹à§‡à¦¶à§à¦¬à¦°à§€à¦ªà§à¦° '),(2163,330,'Northbedkashi','à¦‰à¦¤à§à¦¤à¦° à¦¬à§‡à¦¦à¦•à¦¾à¦¶à§€ '),(2164,330,'Southbedkashi','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¬à§‡à¦¦à¦•à¦¾à¦¶à§€ '),(2165,41,'Bhaluka','à¦­à¦¾à¦²à§à¦•à¦¾'),(2166,41,'Birunia','à¦¬à¦¿à¦°à§à¦¨à¦¿à§Ÿà¦¾'),(2167,41,'Dakatia','à¦¡à¦¾à¦•à¦¾à¦¤à¦¿à§Ÿà¦¾'),(2168,41,'Dhitpur','à¦§à§€à¦¤à¦ªà§à¦°'),(2169,41,'Habirbari','à¦¹à¦¬à¦¿à¦°à¦¬à¦¾à§œà§€'),(2170,41,'Kachina','à¦•à¦¾à¦šà¦¿à¦¨à¦¾'),(2171,41,'Mallikbari','à¦®à¦²à§à¦²à¦¿à¦•à¦¬à¦¾à§œà§€'),(2172,41,'Meduari','à¦®à§‡à¦¦à§à§Ÿà¦¾à¦°à§€'),(2173,41,'Rajoi','à¦°à¦¾à¦œà§ˆ'),(2174,41,'Uthura','à¦‰à¦¥à§à¦°à¦¾'),(2175,41,'Varadoba','à¦­à¦°à¦¾à¦¡à§‡à¦¾à¦¬à¦¾'),(2176,254,'Charghat','à§¦à§« à¦¨à¦‚ à¦šà¦¾à¦°à¦˜à¦¾à¦Ÿ'),(2177,254,'Nimpara','à§¦à§ª à¦¨à¦‚ à¦¨à¦¿à¦®à¦ªà¦¾à¦¡à¦¼à¦¾'),(2178,254,'Sardah','à§¦à§© à¦¨à¦‚ à¦¸à¦°à¦¦à¦¹'),(2179,254,'Solua','à§¦à§¨ à¦¨à¦‚ à¦¶à¦²à§à¦¯à¦¼à¦¾'),(2180,254,'Vialuxmipur','à§¦à§¬ à¦¨à¦‚ à¦­à¦¾à¦¯à¦¼à¦¾à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦°'),(2181,254,'Yousufpur','à§¦à§§ à¦¨à¦‚ à¦‡à¦‰à¦¸à§à¦«à¦ªà§à¦°'),(2182,280,'1nohajinagar','à¦¹à¦¾à¦œà§€à¦¨à¦—à¦° '),(2183,280,'2nochandannagar','à¦šà¦¨à§à¦¦à¦¨à¦¨à¦—à¦° '),(2184,280,'3nobhabicha','à¦­à¦¾à¦¬à¦¿à¦šà¦¾ '),(2185,280,'4noniamatpur','à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦ªà§à¦° '),(2186,280,'5norasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦° '),(2187,280,'6noparoil','à¦ªà¦¾à§œà¦‡à¦² '),(2188,280,'7nosremantapur','à¦¶à§à¦°à§€à¦®à¦¨à§à¦¤à¦ªà§à¦°'),(2189,280,'8nobahadurpur','à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦°'),(2190,281,'10nonurullabad','à¦¨à§‚à¦°à§à¦²à§à¦¯à¦¾à¦¬à¦¾à¦¦'),(2191,281,'11nokalikapur','à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(2192,281,'12nokashopara','à¦•à¦¾à¦à¦¶à§‹à¦•à¦¾à¦ªà§à¦°'),(2193,281,'13nokoshob','à¦•à¦¶à¦¬ '),(2194,281,'14nobisnopur','à¦¬à¦¿à¦·à§à¦£à¦ªà§à¦°'),(2195,281,'1novarsho','à¦­à¦¾à¦°à¦¶à§‹'),(2196,281,'2novalain','à¦­à¦¾à¦²à¦¾à¦‡à¦¨'),(2197,281,'3noparanpur','à¦ªà¦°à¦¾à¦¨à¦ªà§à¦°'),(2198,281,'4nomanda','à¦®à¦¾à¦¨à§à¦¦à¦¾'),(2199,281,'5nogoneshpur','à¦—à¦¨à§‡à¦¶à¦ªà§à¦°'),(2200,281,'6nomoinom','à¦®à§ˆà¦¨à¦®'),(2201,281,'7noproshadpur','à¦ªà§à¦°à¦¸à¦¾à¦¦à¦ªà§à¦° '),(2202,281,'8nokosomba','à¦•à§à¦¸à§à¦®à§à¦¬à¦¾'),(2203,281,'9notetulia','à¦¤à§‡à¦à¦¤à§à¦²à¦¿à§Ÿà¦¾'),(2204,282,'1noshahagola','à¦¶à¦¾à¦¹à¦¾à¦—à§‹à¦²à¦¾'),(2205,282,'2nobhonpara','à¦­à§‹à¦à¦ªà§œà¦¾'),(2206,282,'3noahsanganj','à¦†à¦¹à¦¸à¦¾à¦¨à¦—à¦žà§à¦œ'),(2207,282,'4nopanchupur','à¦ªà¦¾à¦à¦šà§à¦ªà§à¦°'),(2208,282,'5nobisha','à¦¬à¦¿à¦¶à¦¾'),(2209,282,'6nomaniary','à¦®à¦¨à¦¿à§Ÿà¦¾à¦°à§€'),(2210,282,'7nokalikapur','à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(2211,282,'8nohatkalupara','à¦¹à¦¾à¦Ÿà¦•à¦¾à¦²à§à¦ªà¦¾à§œà¦¾'),(2212,42,'Basati','à¦¬à¦¾à¦¶à¦¾à¦Ÿà¦¿'),(2213,42,'Borogram','à¦¬à§œà¦—à§à¦°à¦¾à¦®'),(2214,42,'Daogaon','à¦¦à¦¾à¦“à¦—à¦¾à¦à¦“'),(2215,42,'Dulla','à¦¦à§à¦²à§à¦²à¦¾'),(2216,42,'Ghoga','à¦˜à§‡à¦¾à¦—à¦¾'),(2217,42,'Kashimpur','à¦•à¦¾à¦¶à¦¿à¦®à¦ªà§à¦°'),(2218,42,'Kheruajani','à¦–à§‡à¦°à§à§Ÿà¦¾à¦œà¦¾à¦¨à§€'),(2219,42,'Kumargata','à¦•à§à¦®à¦¾à¦°à¦—à¦¾à¦¤à¦¾'),(2220,42,'Mankon','à¦®à¦¾à¦¨à¦•à§‡à¦¾à¦¨'),(2221,42,'Tarati','à¦¤à¦¾à¦°à¦¾à¦Ÿà¦¿'),(2222,268,'Alampur','à¦†à¦²à¦®à¦ªà§à¦° '),(2223,268,'Borail','à¦¬à§œà¦¾à¦‡à¦² '),(2224,268,'Boratara','à¦¬à§œà¦¤à¦¾à¦°à¦¾ '),(2225,268,'Mamudpur','à¦®à¦¾à¦®à§à¦¦à¦ªà§à¦° '),(2226,268,'Tulshiganga','à¦¤à§à¦²à¦¶à§€à¦—à¦‚à¦—à¦¾ '),(2227,255,'Baneswar','à§¦à§© à¦¨à¦‚ à¦¬à¦¾à¦¨à§‡à¦¶à§à¦¬à¦°'),(2228,255,'Belpukuria','à§¦à§¨ à¦¨à¦‚ à¦¬à§‡à¦²à¦ªà§à¦•à§à¦°à¦¿à§Ÿà¦¾ '),(2229,255,'Jewpara','à§¦à§¬ à¦¨à¦‚ à¦œà¦¿à¦‰à¦ªà¦¾à¦¡à¦¼à¦¾'),(2230,255,'Puthia','à§¦à§§ à¦¨à¦‚ à¦ªà§à¦ à¦¿à§Ÿà¦¾ '),(2231,255,'Shilmaria','à§¦à§« à¦¨à¦‚ à¦¶à¦¿à¦²à¦®à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(2232,255,'Valukgachi','à§¦à§ª à¦¨à¦‚ à¦­à¦¾à¦²à§à¦• à¦—à¦¾à¦›à¦¿'),(2233,256,'Arani','à§¦à§¬ à¦¨à¦‚ à¦†à§œà¦¾à¦¨à§€'),(2234,256,'Bajubagha','à§¦à§§ à¦¨à¦‚ à¦¬à¦¾à¦œà§à¦¬à¦¾à¦˜à¦¾'),(2235,256,'Bausa','à§¦à§« à¦¨à¦‚ à¦¬à¦¾à¦‰à¦¸à¦¾'),(2236,256,'Gorgori','à§¦à§¨ à¦¨à¦‚ à¦—à¦¡à¦¼à¦—à¦¡à¦¼à¦¿'),(2237,256,'Monigram','à§¦à§ª à¦¨à¦‚ à¦®à¦¨à¦¿à¦—à§à¦°à¦¾à¦®'),(2238,256,'Pakuria','à§¦à§© à¦¨à¦‚ à¦ªà¦¾à¦•à§à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(2239,257,'Asariadaha','à§¦à§¯ à¦¨à¦‚ à¦†à¦·à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾à¦¦à¦¹'),(2240,257,'Basudebpur','à§¦à§® à¦¨à¦‚ à¦¬à¦¾à¦¸à§à¦¦à§‡à¦¬à¦ªà§à¦°'),(2241,257,'Dewpara','à§¦à§­ à¦¨à¦‚ à¦¦à§‡à¦“à¦ªà¦¾à¦¡à¦¼à¦¾'),(2242,257,'Godagari','à§¦à§§ à¦¨à¦‚ à¦—à§‹à¦¦à¦¾à¦—à¦¾à¦¡à¦¼à§€'),(2243,257,'Gogram','à§¦à§« à¦¨à¦‚ à¦—à§‹à¦—à§à¦°à¦¾à¦®'),(2244,257,'Matikata','à§¦à§¬ à¦¨à¦‚ à¦®à¦¾à¦Ÿà¦¿à¦•à¦¾à¦Ÿà¦¾'),(2245,257,'Mohonpur','à§¦à§¨ à¦¨à¦‚ à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(2246,257,'Pakri','à§¦à§© à¦¨à¦‚ à¦ªà¦¾à¦•à¦¡à¦¼à§€'),(2247,257,'Risikul','à§¦à§ª à¦¨à¦‚ à¦°à¦¿à¦¶à¦¿à¦•à§à¦²'),(2248,258,'Badhair','à§¦à§¨ à¦¨à¦‚ à¦¬à¦¾à¦§à¦¾à¦‡à¦¡à¦¼'),(2249,258,'Chanduria','à§¦à§­ à¦¨à¦‚ à¦šà¦¾à¦¨à§à¦¦à§à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(2250,258,'Kalma','à§¦à§§ à¦¨à¦‚ à¦•à¦²à¦®à¦¾'),(2251,258,'Kamargaon','à§¦à§¬ à¦¨à¦‚ à¦•à¦¾à¦®à¦¾à¦°à¦—à¦¾à¦'),(2252,258,'Panchandar','à§¦à§© à¦¨à¦‚ à¦ªà¦¾à¦à¦šà¦¨à§à¦¦à¦°'),(2253,258,'Saranjai','à§¦à§ª à¦¨à¦‚ à¦¸à¦°à¦žà§à¦œà¦¾à¦‡'),(2254,258,'Talondo','à§¦à§« à¦¨à¦‚ à¦¤à¦¾à¦²à¦¨à§à¦¦'),(2255,472,'Dargapasha','à¦¦à¦°à¦—à¦¾à¦ªà¦¾à¦¶à¦¾'),(2256,472,'Joykalash','à¦œà§Ÿà¦•à¦²à¦¸ '),(2257,472,'Paschimbirgaon','à¦ªà¦¶à§à¦šà¦¿à¦® à¦¬à§€à¦°à¦—à¦¾à¦à¦“'),(2258,472,'Paschimpagla','à¦ªà¦¶à§à¦šà¦¿à¦® à¦ªà¦¾à¦—à¦²à¦¾'),(2259,472,'Patharia','à¦ªà¦¾à¦¥à¦¾à¦°à¦¿à§Ÿà¦¾ '),(2260,472,'Purbabirgaon','à¦ªà§‚à¦°à§à¦¬ à¦¬à§€à¦°à¦—à¦¾à¦à¦“'),(2261,472,'Purbapagla','à¦ªà§‚à¦°à§à¦¬ à¦ªà¦¾à¦—à¦²à¦¾'),(2262,472,'Shimulbak','à¦¶à¦¿à¦®à§à¦²à¦¬à¦¾à¦•'),(2263,473,'Badaghatsouth','à¦¬à¦¾à¦¦à¦¾à¦˜à¦¾à¦Ÿ à¦¦à¦•à§à¦·à¦¿à¦£ '),(2264,473,'Dhanpur','à¦§à¦¨à¦ªà§à¦°'),(2265,473,'Fatepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(2266,473,'Palash','à¦ªà¦²à¦¾à¦¶'),(2267,473,'Solukabad','à¦¸à¦²à§à¦•à¦¾à¦¬à¦¾à¦¦'),(2268,259,'Auchpara','à§¦à§« à¦¨à¦‚ à¦†à¦‰à¦šà¦ªà¦¾à¦¡à¦¼à¦¾'),(2269,259,'Basupara','à§¦à§­ à¦¨à¦‚ à¦¬à¦¾à¦¸à§à¦ªà¦¾à¦¡à¦¼à¦¾'),(2270,259,'Borobihanoli','à§¦à§ª à¦¨à¦‚ à¦¬à¦¡à¦¼à¦¬à¦¿à¦¹à¦¾à¦¨à¦²à§€'),(2271,259,'Dippur','à§¦à§© à¦¨à¦‚ à¦¦à§à¦¬à§€à¦ªà¦ªà§à¦°'),(2272,259,'Ganipur','à§§à§§ à¦¨à¦‚ à¦—à¦£à¦¿à¦ªà§à¦°'),(2273,259,'Gobindopara','à§¦à§§ à¦¨à¦‚ à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà¦¾à¦¡à¦¼à¦¾'),(2274,259,'Gualkandi','à§§à§© à¦¨à¦‚ à¦—à§‹à¦¯à¦¼à¦¾à¦²à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2275,259,'Hamirkutsa','à§§à§ª à¦¨à¦‚ à¦¹à¦¾à¦®à¦¿à¦°à¦•à§à§Žà¦¸à¦¾'),(2276,259,'Jogipara','à§§à§« à¦¨à¦‚ à¦¯à§‹à¦—à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(2277,259,'Kacharikoalipara','à§¦à§® à¦¨à¦‚ à¦•à¦¾à¦šà¦¾à¦¡à¦¼à§€ à¦•à§‹à¦¯à¦¼à¦²à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(2278,259,'Mariaup10','à§§à§¦ à¦¨à¦‚ à¦®à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(2279,259,'Nordas','à§¦à§¨ à¦¨à¦‚ à¦¨à¦°à¦¦à¦¾à¦¸'),(2280,259,'Sonadanga','à§§à§¬ à¦¨à¦‚ à¦¸à§‹à¦¨à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(2281,259,'Sreepur','à§¦à§¬ à¦¨à¦‚ à¦¶à§à¦°à§€à¦ªà§à¦°'),(2282,259,'Suvodanga','à§¦à§¯ à¦¨à¦‚ à¦¶à§à¦­à¦¡à¦¾à¦™à§à¦—à¦¾'),(2283,259,'Zhikara','à§§à§¨ à¦¨à¦‚ à¦à¦¿à¦•à¦¡à¦¼à¦¾'),(2284,79,'Asma','à¦†à¦¸à¦®à¦¾'),(2285,79,'Barhatta','à¦¬à¦¾à¦°à¦¹à¦¾à¦Ÿà§à¦Ÿà¦¾'),(2286,79,'Baushi','à¦¬à¦¾à¦‰à¦¶à§€'),(2287,79,'Chhiram','à¦šà¦¿à¦°à¦¾à¦®'),(2288,79,'Raypur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(2289,79,'Sahata','à¦¸à¦¾à¦¹à¦¤à¦¾'),(2290,79,'Singdha','à¦¸à¦¿à¦‚à¦§à¦¾'),(2291,80,'Bakaljora','à¦¬à¦¾à¦•à¦²à¦œà§‹à§œà¦¾'),(2292,80,'Birisiri','à¦¬à¦¿à¦°à¦¿à¦¶à¦¿à¦°à¦¿'),(2293,80,'Chandigarh','à¦šà¦£à§à¦¡à¦¿à¦—à§œ'),(2294,80,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(2295,80,'Gawkandia','à¦—à¦¾à¦à¦“à¦•à¦¾à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(2296,80,'Kakoirgora','à¦•à¦¾à¦•à§ˆà¦°à¦—à§œà¦¾'),(2297,80,'Kullagora','à¦•à§à¦²à§à¦²à¦¾à¦—à§œà¦¾'),(2298,81,'Asujia','à¦†à¦¶à§à¦œà¦¿à§Ÿà¦¾'),(2299,81,'Bolaishimul','à¦¬à¦²à¦¾à¦‡à¦¶à¦¿à¦®à§à¦²'),(2300,81,'Chirang','à¦šà¦¿à¦°à¦¾à¦‚'),(2301,81,'Dalpa','à¦¦à¦²à¦ªà¦¾'),(2302,81,'Gonda','à¦—à¦£à§à¦¡à¦¾'),(2303,81,'Goraduba','à¦—à§œà¦¾à¦¡à§‹à¦¬à¦¾'),(2304,81,'Kandiura','à¦•à¦¾à¦¨à§à¦¦à¦¿à¦‰à§œà¦¾'),(2305,81,'Maska','à¦®à¦¾à¦¸à¦•à¦¾'),(2306,81,'Muzafarpur','à¦®à§‹à¦œà¦¾à¦«à¦°à¦ªà§à¦°'),(2307,81,'Noapara','à¦¨à¦“à¦ªà¦¾à§œà¦¾'),(2308,81,'Paikura','à¦ªà¦¾à¦‡à¦•à§à§œà¦¾'),(2309,81,'Roailbariamtala','à¦°à§‹à§Ÿà¦¾à¦‡à¦²à¦¬à¦¾à§œà§€ à¦†à¦®à¦¤à¦²à¦¾'),(2310,81,'Sandikona','à¦¸à¦¾à¦¨à§à¦¦à¦¿à¦•à§‹à¦¨à¦¾'),(2311,82,'Baniyajan','à¦¬à¦¾à¦¨à¦¿à¦¯à¦¼à¦¾à¦œà¦¾à¦¨'),(2312,82,'Duoj','à¦¦à§à¦“à¦œ'),(2313,82,'Lunesshor','à¦²à§à¦¨à§‡à¦¶à§à¦¬à¦°'),(2314,82,'Shormushia','à¦¸à§à¦¬à¦°à¦®à§à¦¶à¦¿à¦¯à¦¼à¦¾'),(2315,82,'Shunoi','à¦¶à§à¦¨à¦‡'),(2316,82,'Sukhari','à¦¸à§à¦–à¦¾à¦°à§€'),(2317,82,'Teligati','à¦¤à§‡à¦²à¦¿à¦—à¦¾à¦¤à§€'),(2318,83,'Chandgaw','à¦šà¦¾à¦¨à¦—à¦¾à¦à¦“'),(2319,83,'Fathepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(2320,83,'Gobindasree','à¦—à§‡à¦¬à¦¿à¦¨à§à¦¦à¦¶à§à¦°à§€'),(2321,83,'Kytail','à¦•à¦¾à¦‡à¦Ÿà¦¾à¦²'),(2322,83,'Madan','à¦®à¦¦à¦¨'),(2323,83,'Magan','à¦®à¦¾à¦˜à¦¾à¦¨'),(2324,83,'Nayekpur','à¦¨à¦¾à§Ÿà§‡à¦•à¦ªà§à¦°'),(2325,83,'Teosree','à¦¤à¦¿à§Ÿà¦¶à§à¦°à§€'),(2326,84,'Chakua','à¦šà¦¾à¦•à§à§Ÿà¦¾'),(2327,84,'Gazipur','à¦—à¦¾à¦œà§€à¦ªà§à¦°'),(2328,84,'Khaliajuri','à¦–à¦¾à¦²à¦¿à§Ÿà¦¾à¦œà§à¦°à§€'),(2329,84,'Krishnapur','à¦•à§ƒà¦·à§à¦£à¦ªà§à¦°'),(2330,84,'Mendipur','à¦®à§‡à¦¨à§à¦¦à¦¿à¦ªà§à¦°'),(2331,84,'Nogor','à¦¨à¦—à¦°'),(2332,85,'Borokhapon','à¦¬à¦¡à¦¼à¦–à¦¾à¦ªà¦¨'),(2333,85,'Kharnoi','à¦–à¦¾à¦°à¦¨à§ˆ'),(2334,85,'Koilati','à¦•à§ˆà¦²à¦¾à¦Ÿà§€'),(2335,85,'Kolmakanda','à¦•à¦²à¦®à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(2336,85,'Lengura','à¦²à§‡à¦‚à¦—à§à¦°à¦¾'),(2337,85,'Najirpur','à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°'),(2338,85,'Pogla','à¦ªà§‹à¦—à¦²à¦¾'),(2339,85,'Rongchati','à¦°à¦‚à¦›à¦¾à¦¤à¦¿'),(2340,86,'Borokashiabirampur','à¦¬à¦¡à¦¼à¦•à¦¾à¦¶à¦¿à¦¯à¦¼à¦¾ à¦¬à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(2341,86,'Borotolibanihari','à¦¬à¦¡à¦¼à¦¤à¦²à§€ à¦¬à¦¾à¦¨à¦¿à¦¹à¦¾à¦°à§€'),(2342,86,'Gaglajur','à¦—à¦¾à¦—à¦²à¦¾à¦œà§à¦°'),(2343,86,'Maghansiadar','à¦®à¦¾à¦˜à¦¾à¦¨ à¦¸à¦¿à¦¯à¦¼à¦¾à¦¦à¦¾à¦°'),(2344,86,'Somajsohildeo','à¦¸à¦®à¦¾à¦œ à¦¸à¦¹à¦¿à¦²à¦¦à§‡à¦“'),(2345,86,'Suair','à¦¸à§à¦¯à¦¼à¦¾à¦‡à¦°'),(2346,86,'Tetulia','à¦¤à§‡à¦¤à§à¦²à¦¿à¦¯à¦¼à¦¾'),(2347,87,'Amtola','à¦†à¦®à¦¤à¦²à¦¾'),(2348,87,'Chollisha','à¦šà¦²à§à¦²à¦¿à¦¶à¦¾'),(2349,87,'Dokkhinbishiura','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¬à¦¿à¦¶à¦¿à¦‰à¦¡à¦¼à¦¾'),(2350,87,'Kailati','à¦•à¦¾à¦‡à¦²à¦¾à¦Ÿà¦¿'),(2351,87,'Kaliaragabragati','à¦•à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦°à¦¾ à¦—à¦¾à¦¬à¦°à¦¾à¦—à¦¾à¦¤à¦¿'),(2352,87,'Lokkhiganj','à¦²à¦•à§à¦·à§€à¦—à¦žà§à¦œ'),(2353,87,'Medni','à¦®à§‡à¦¦à¦¨à§€'),(2354,87,'Modonpur','à¦®à¦¦à¦¨à¦ªà§à¦°'),(2355,87,'Mougati','à¦®à§Œà¦—à¦¾à¦¤à¦¿'),(2356,87,'Rouha','à¦°à§Œà¦¹à¦¾'),(2357,87,'Singherbangla','à¦¸à¦¿à¦‚à¦¹à§‡à¦° à¦¬à¦¾à¦‚à¦²à¦¾'),(2358,87,'Thakurakona','à¦ à¦¾à¦•à§à¦°à¦¾à¦•à§‹à¦£à¦¾'),(2359,52,'Alonjori','à¦à¦²à¦‚à¦œà§à¦°à§€'),(2360,52,'Badla','à¦¬à¦¾à¦¦à¦²à¦¾'),(2361,52,'Boribari','à¦¬à§œà¦¿à¦¬à¦¾à§œà¦¿'),(2362,52,'Chawganga','à¦šà§Œà¦—à¦¾à¦‚à¦—à¦¾'),(2363,52,'Dhonpur','à¦§à¦¨à¦ªà§à¦°'),(2364,52,'Itna','à¦‡à¦Ÿà¦¨à¦¾ '),(2365,52,'Joysiddi','à¦œà§Ÿà¦¸à¦¿à¦¦à§à¦§à¦¿'),(2366,52,'Mriga','à¦®à§ƒà¦—à¦¾'),(2367,52,'Raytoti','à¦°à¦¾à§Ÿà¦Ÿà§à¦Ÿà¦¿'),(2368,53,'Acmita','à¦†à¦šà¦®à¦¿à¦¤à¦¾'),(2369,53,'Banagram','à¦¬à¦¨à¦—à§à¦°à¦¾à¦®'),(2370,53,'Chandpur','à¦šà¦¾à¦¨à§à¦¦à¦ªà§à¦°'),(2371,53,'Jalalpur','à¦œà¦¾à¦²à¦¾à¦²à¦ªà§à¦°'),(2372,53,'Kargaon','à¦•à¦¾à¦°à¦—à¦¾à¦à¦“'),(2373,53,'Lohajuree','à¦²à§‹à¦¹à¦¾à¦œà§à¦°à§€'),(2374,53,'Mosua','à¦®à¦¸à§‚à§Ÿà¦¾'),(2375,53,'Mumurdia','à¦®à§à¦®à§à¦°à¦¦à¦¿à§Ÿà¦¾'),(2376,53,'Shahasramdhuldia','à¦¸à¦¹à¦¶à§à¦°à¦¾à¦® à¦§à§à¦²à¦¦à¦¿à§Ÿà¦¾'),(2377,54,'Aganagar','à¦†à¦—à¦¾à¦¨à¦—à¦°'),(2378,54,'Gajaria','à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾'),(2379,54,'Kalikaprashad','à¦•à¦¾à¦²à¦¿à¦•à¦¾ à¦ªà§à¦°à¦¸à¦¾à¦¦'),(2380,54,'Sadekpur','à¦¸à¦¾à¦¦à§‡à¦•à¦ªà§à¦°'),(2381,54,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(2382,54,'Shimulkandi','à¦¶à¦¿à¦®à§à¦²à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2383,54,'Sreenagar','à¦¶à§à¦°à§€à¦¨à¦—à¦°'),(2384,55,'Damiha','à¦¦à¦¾à¦®à¦¿à¦¹à¦¾'),(2385,55,'Dhola','à¦§à¦²à¦¾'),(2386,55,'Digdair','à¦¦à¦¿à¦—à¦¦à¦¾à¦‡à¦°'),(2387,55,'Jawar','à¦œà¦¾à¦“à§Ÿà¦¾à¦°'),(2388,55,'Rauti','à¦°à¦¾à¦‰à¦¤à¦¿'),(2389,55,'Taljanga','à¦¤à¦¾à¦²à¦œà¦¾à¦™à§à¦—à¦¾'),(2390,55,'Tarailsachail','à¦¤à¦¾à§œà¦¾à¦‡à¦²-à¦¸à¦¾à¦šà¦¾à¦‡à¦²'),(2391,56,'Araibaria','à¦†à§œà¦¾à¦‡à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(2392,56,'Gobindapur','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(2393,56,'Jinari','à¦œà¦¿à¦¨à¦¾à¦°à§€'),(2394,56,'Pumdi','à¦ªà§à¦®à¦¦à¦¿'),(2395,56,'Sahedal','à¦¸à¦¾à¦¹à§‡à¦¦à¦²'),(2396,56,'Sidhla','à¦¸à¦¿à¦¦à¦²à¦¾'),(2397,57,'Burudia','à¦¬à§à§œà§à¦¦à¦¿à§Ÿà¦¾'),(2398,57,'Chandipasha','à¦šà¦¾à¦¨à§à¦¦à¦¿à¦ªà¦¾à¦¶à¦¾'),(2399,57,'Charfaradi','à¦šà¦¾à¦°à¦«à¦¾à¦°à¦¾à¦¦à¦¿'),(2400,57,'Egarasindur','à¦‡à¦œà¦¾à¦°à¦¾à¦¸à¦¿à¦¨à§à¦¦à§à¦°'),(2401,57,'Hosendi','à¦¹à§‹à¦¸à§‡à¦¨à¦¦à¦¿'),(2402,57,'Jangalia','à¦œà¦¾à¦™à§à¦—à¦¾à¦²à¦¿à§Ÿà¦¾'),(2403,57,'Narandi','à¦¨à¦¾à¦°à¦¾à¦¨à§à¦¦à¦¿'),(2404,57,'Pakundia','à¦ªà¦¾à¦•à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(2405,57,'Patuavabga','à¦ªà¦Ÿà§à§Ÿà¦¾à¦­à¦¾à¦™à§à¦—à¦¾'),(2406,57,'Shukhia','à¦¸à§à¦–à¦¿à§Ÿà¦¾'),(2407,58,'Chhaysuti','à¦›à§Ÿà¦¸à§‚à¦¤à§€'),(2408,58,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(2409,58,'Gobariaabdullahpur','à¦—à§‹à¦¬à¦°à¦¿à§Ÿà¦¾ à¦†à¦¬à§à¦¦à§à¦²à§à¦²à¦¾à¦¹à¦ªà§à¦°'),(2410,58,'Osmanpur','à¦‰à¦›à¦®à¦¾à¦¨à¦ªà§à¦°'),(2411,58,'Ramdi','à¦°à¦¾à¦®à¦¦à§€'),(2412,58,'Salua','à¦¸à¦¾à¦²à§à§Ÿà¦¾'),(2413,59,'Binnati','à¦¬à¦¿à¦¨à§à¦¨à¦¾à¦Ÿà¦¿'),(2414,59,'Bowlai','à¦¬à§Œà¦²à¦¾à¦‡'),(2415,59,'Chowddoshata','à¦šà§Œà¦¦à§à¦¦à¦¶à¦¤'),(2416,59,'Danapatuli','à¦¦à¦¾à¦¨à¦¾à¦ªà¦¾à¦Ÿà§à¦²à§€'),(2417,59,'Joshodal','à¦¯à¦¶à§‹à¦¦à¦²'),(2418,59,'Karshakarial','à¦•à¦°à§à¦¶à¦¾à¦•à§œà¦¿à§Ÿà¦¾à¦‡à¦²'),(2419,59,'Latibabad','à¦²à¦¤à¦¿à¦¬à¦¾à¦¬à¦¾à¦¦'),(2420,59,'Maizkhapan','à¦®à¦¾à¦‡à¦œà¦–à¦¾à¦ªà¦¨'),(2421,59,'Maria','à¦®à¦¾à¦°à¦¿à§Ÿà¦¾'),(2422,59,'Mohinanda','à¦®à¦¹à¦¿à¦¨à¦¨à§à¦¦'),(2423,59,'Rashidabad','à¦°à¦¶à¦¿à¦¦à¦¾à¦¬à¦¾à¦¦'),(2424,60,'Barogharia','à¦¬à¦¾à¦°à¦˜à§œà¦¿à§Ÿà¦¾'),(2425,60,'Dehunda','à¦¦à§‡à¦¹à§à¦¨à§à¦¦à¦¾'),(2426,60,'Gujadia','à¦—à§à¦œà¦¾à¦¦à¦¿à§Ÿà¦¾'),(2427,60,'Gunodhar','à¦—à§à¦¨à¦§à¦°'),(2428,60,'Joyka','à¦œà§Ÿà¦•à¦¾'),(2429,60,'Kadirjangal','à¦•à¦¾à¦¦à¦¿à¦°à¦œà¦™à§à¦—à¦²'),(2430,60,'Kiraton','à¦•à¦¿à¦°à¦¾à¦Ÿà¦¨ '),(2431,60,'Niamatpur','à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦ªà§à¦°'),(2432,60,'Noabad','à¦¨à§‹à§Ÿà¦¾à¦¬à¦¾à¦¦'),(2433,60,'Sutarpara','à¦¸à§à¦¤à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(2434,60,'Zafrabad','à¦œà¦¾à¦«à¦°à¦¾à¦¬à¦¾à¦¦'),(2435,61,'Boliardi','à¦¬à¦²à¦¿à§Ÿà¦¾à¦°à§à¦¦à§€'),(2436,61,'Dighirpar','à¦¦à¦¿à¦˜à§€à¦°à¦ªà¦¾à§œ'),(2437,61,'Dilalpur','à¦¦à¦¿à¦²à¦¾à¦²à¦ªà§à¦°'),(2438,61,'Gazirchar','à¦—à¦¾à¦œà§€à¦°à¦šà¦°'),(2439,61,'Halimpur','à¦¹à¦¾à¦²à¦¿à¦®à¦ªà§à¦°'),(2440,61,'Hilochia','à¦¹à¦¿à¦²à¦šà¦¿à§Ÿà¦¾'),(2441,61,'Homypur','à¦¹à§à¦®à¦¾à¦‡à¦ªà¦°'),(2442,61,'Kailag','à¦•à§ˆà¦²à¦¾à¦—'),(2443,61,'Maijchar9','à¦®à¦¾à¦‡à¦œà¦šà¦°'),(2444,61,'Pirijpur','à¦ªà¦¿à¦°à¦¿à¦œà¦ªà§à¦°'),(2445,61,'Sararchar','à¦¸à¦°à¦¾à¦°à¦šà¦°'),(2446,62,'Adampur','à¦†à¦¦à¦®à¦ªà§à¦°'),(2447,62,'Austagramsadar','à¦…à¦·à§à¦Ÿà¦—à§à¦°à¦¾à¦® à¦¸à¦¦à¦°'),(2448,62,'Bangalpara','à¦¬à¦¾à¦™à§à¦—à¦¾à¦²à¦ªà¦¾à§œà¦¾'),(2449,62,'Dewghar','à¦¦à§‡à¦“à¦˜à¦°'),(2450,62,'Kalma','à¦•à¦²à¦®à¦¾'),(2451,62,'Kastul','à¦•à¦¾à¦¸à§à¦¤à§à¦²'),(2452,62,'Khyerpurabdullahpur','à¦–à§Ÿà§‡à¦°à¦ªà§à¦°-à¦†à¦¬à§à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦°'),(2453,62,'Purbaaustagram','à¦ªà§‚à¦°à§à¦¬ à¦…à¦·à§à¦Ÿà¦—à§à¦°à¦¾à¦®'),(2454,63,'Bairati','à¦¬à§ˆà¦°à¦¾à¦Ÿà¦¿'),(2455,63,'Dhaki','à¦¢à¦¾à¦•à§€'),(2456,63,'Ghagra','à¦˜à¦¾à¦—à§œà¦¾'),(2457,63,'Gopdighi','à¦—à§‹à¦ªà¦¦à¦¿à¦˜à§€'),(2458,63,'Katkhal','à¦•à¦¾à¦Ÿà¦–à¦¾à¦²'),(2459,63,'Keoarjore','à¦•à§‡à¦“à§Ÿà¦¾à¦°à¦œà§‹à¦°'),(2460,63,'Mithamoin','à¦®à¦¿à¦ à¦¾à¦®à¦‡à¦¨'),(2461,64,'Chatirchar','à¦›à¦¾à¦¤à¦¿à¦°à¦šà¦°'),(2462,64,'Dampara','à¦¦à¦¾à¦®à¦ªà¦¾à§œà¦¾'),(2463,64,'Guroi','à¦—à§à¦°à¦‡'),(2464,64,'Jaraitala','à¦œà¦¾à¦°à¦‡à¦¤à¦²à¦¾'),(2465,64,'Karpasa','à¦•à¦¾à¦°à¦ªà¦¾à¦¶à¦¾'),(2466,64,'Niklisadar','à¦¨à¦¿à¦•à¦²à§€ à¦¸à¦¦à¦°'),(2467,64,'Singpur','à¦¸à¦¿à¦‚à¦ªà§à¦°'),(2468,269,'Aolai','à¦†à¦“à¦²à¦¾à¦‡'),(2469,269,'Atapur','à¦†à¦Ÿà¦¾à¦ªà§à¦° '),(2470,269,'Aymarasulpur','à¦†à§Ÿà¦®à¦¾à¦°à¦¸à§à¦²à¦ªà§à¦° '),(2471,269,'Bagjana','à¦¬à¦¾à¦—à¦œà¦¾à¦¨à¦¾ '),(2472,269,'Balighata','à¦¬à¦¾à¦²à¦¿à¦˜à¦¾à¦Ÿà¦¾ '),(2473,269,'Dharanji','à¦§à¦°à¦žà§à¦œà¦¿'),(2474,269,'Kusumba','à¦•à§à¦¸à§à¦®à§à¦¬à¦¾'),(2475,269,'Mohammadpur','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦° '),(2476,43,'Aqua','à¦†à¦•à§à§Ÿà¦¾'),(2477,43,'Austadhar','à¦…à¦·à§à¦Ÿà¦§à¦¾à¦°'),(2478,43,'Bororchar','à¦¬à§‡à¦¾à¦°à¦°à¦šà¦°'),(2479,43,'Boyra','à¦¬à§Ÿà§œà¦¾'),(2480,43,'Charishwardia','à¦šà¦° à¦ˆà¦¶à§à¦¬à¦°à¦¦à¦¿à§Ÿà¦¾'),(2481,43,'Charnilaxmia','à¦šà¦°à¦¨à¦¿à¦²à¦•à§à¦·à¦¿à§Ÿà¦¾'),(2482,43,'Dapunia','à¦¦à¦¾à¦ªà§à¦¨à¦¿à§Ÿà¦¾'),(2483,43,'Ghagra','à¦˜à¦¾à¦—à§œà¦¾'),(2484,43,'Khagdohor','à¦–à¦¾à¦—à¦¡à¦¹à¦°'),(2485,43,'Kushtia','à¦•à§à¦·à§à¦Ÿà¦¿à§Ÿà¦¾'),(2486,43,'Paranganj','à¦ªà¦°à¦¾à¦¨à¦—à¦žà§à¦œ'),(2487,43,'Sirta','à¦¸à¦¿à¦°à¦¤à¦¾'),(2488,43,'Vabokhali','à¦­à¦¾à¦¬à¦–à¦¾à¦²à§€'),(2489,44,'Baghber','à¦¬à¦¾à¦˜à¦¬à§‡à§œ'),(2490,44,'Dakshinmaijpara','à¦¦à¦•à§à¦·à¦¿à¦£'),(2491,44,'Dhobaura','à¦§à§‡à¦¾à¦¬à¦¾à¦‰à§œà¦¾'),(2492,44,'Gamaritola','à¦—à¦¾à¦®à¦¾à¦°à§€à¦¤à¦²à¦¾'),(2493,44,'Ghoshgaon','à¦˜à§‡à¦¾à¦·à¦—à¦¾à¦à¦“'),(2494,44,'Goatala','à¦—à§‡à¦¾à§Ÿà¦¾à¦¤à¦²à¦¾'),(2495,44,'Porakandulia','à¦ªà§‡à¦¾à§œà¦¾à¦•à¦¾à¦¨à§à¦¦à§à¦²à¦¿à§Ÿà¦¾'),(2496,45,'Balia','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾'),(2497,45,'Balikha','à¦¬à¦¾à¦²à¦¿à¦–à¦¾'),(2498,45,'Banihala','à¦¬à¦¾à¦¨à¦¿à¦¹à¦¾à¦²à¦¾'),(2499,45,'Baola','à¦¬à¦“à¦²à¦¾'),(2500,45,'Biska','à¦¬à¦¿à¦¸à§à¦•à¦¾'),(2501,45,'Dhakua','à¦¢à¦¾à¦•à§à§Ÿà¦¾'),(2502,45,'Galagaon','à¦—à¦¾à¦²à¦¾à¦—à¦¾à¦à¦“'),(2503,45,'Kakni','à¦•à¦¾à¦•à¦¨à§€'),(2504,45,'Kamargaon','à¦•à¦¾à¦®à¦¾à¦°à¦—à¦¾à¦à¦“'),(2505,45,'Kamaria','à¦•à¦¾à¦®à¦¾à¦°à¦¿à§Ÿà¦¾'),(2506,45,'Payari','à¦ªà§Ÿà¦¾à¦°à§€'),(2507,45,'Phulpur','à¦«à§à¦²à¦ªà§à¦°'),(2508,45,'Rahimganj','à¦°à¦¹à¦¿à¦®à¦—à¦žà§à¦œ'),(2509,45,'Rambhadrapur','à¦°à¦¾à¦®à¦­à¦¦à§à¦°à¦ªà§à¦°'),(2510,45,'Rampurup2','à¦°à¦¾à¦®à¦ªà§à¦°'),(2511,45,'Rupasi','à¦°à§‚à¦ªà¦¸à§€'),(2512,45,'Singheshwar','à¦¸à¦¿à¦‚à¦¹à§‡à¦¶à§à¦¬à¦°'),(2513,45,'Sondhara','à¦›à¦¨à¦§à¦°à¦¾'),(2514,45,'Tarakanda','à¦¤à¦¾à¦°à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(2515,45,'Vaitkandi','à¦­à¦¾à¦‡à¦Ÿà¦•à¦¾à¦¨à§à¦¦à¦¿'),(2516,88,'Aminbazar','à¦†à¦®à¦¿à¦¨à¦¬à¦¾à¦œà¦¾à¦°'),(2517,88,'Ashulia','à¦†à¦¶à§à¦²à¦¿à§Ÿà¦¾'),(2518,88,'Birulia','à¦¬à¦¿à¦°à§à¦²à¦¿à§Ÿà¦¾'),(2519,88,'Bongaon','à¦¬à¦¨à¦—à¦¾à¦à¦“'),(2520,88,'Dhamsona','à¦§à¦¾à¦®à¦¸à§‹à¦¨à¦¾'),(2521,88,'Kaundia','à¦•à¦¾à¦‰à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(2522,88,'Pathalia','à¦ªà¦¾à¦¥à¦¾à¦²à¦¿à§Ÿà¦¾'),(2523,88,'Savar','à¦¸à¦¾à¦­à¦¾à¦°'),(2524,88,'Shimulia','à¦¶à¦¿à¦®à§à¦²à¦¿à§Ÿà¦¾'),(2525,88,'Tetuljhora','à¦¤à§‡à¦à¦¤à§à¦²à¦à§‹à§œà¦¾'),(2526,88,'Vakurta','à¦­à¦¾à¦•à§à¦°à§à¦¤à¦¾'),(2527,88,'Yearpur','à¦‡à§Ÿà¦¾à¦°à¦ªà§à¦°'),(2528,89,'Amta','à¦†à¦®à¦¤à¦¾'),(2529,89,'Baisakanda','à¦¬à¦¾à¦‡à¦¶à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(2530,89,'Balia','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(2531,89,'Chauhat','à¦šà§Œà¦¹à¦¾à¦Ÿ'),(2532,89,'Dhamrai','à¦§à¦¾à¦®à¦°à¦¾à¦‡'),(2533,89,'Gangutia','à¦—à¦¾à¦‚à¦—à§à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(2534,89,'Jadabpur','à¦¯à¦¾à¦¦à¦¬à¦ªà§à¦°'),(2535,89,'Kulla','à¦•à§à¦²à§à¦²à¦¾'),(2536,89,'Kushura','à¦•à§à¦¶à§à¦°à¦¾'),(2537,89,'Nannar','à¦¨à¦¾à¦¨à§à¦¨à¦¾à¦°'),(2538,89,'Rowail','à¦°à§‹à¦¯à¦¼à¦¾à¦‡à¦²'),(2539,89,'Sanora','à¦¸à¦¾à¦¨à§‹à¦¡à¦¼à¦¾'),(2540,89,'Sombhag','à¦¸à§‹à¦®à¦­à¦¾à¦—'),(2541,89,'Suapur','à¦¸à§à¦¯à¦¼à¦¾à¦ªà§à¦°'),(2542,89,'Sutipara','à¦¸à§‚à¦¤à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(2543,89,'Vararia','à¦­à¦¾à¦¡à¦¼à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(2544,90,'Aganagar','à¦†à¦—à¦¾à¦¨à¦—à¦°'),(2545,90,'Basta','à¦¬à¦¾à¦¸à§à¦¤à¦¾'),(2546,90,'Hazratpur','à¦¹à¦¯à¦°à¦¤à¦ªà§à¦°'),(2547,90,'Kalatia','à¦•à¦²à¦¾à¦¤à¦¿à¦¯à¦¼à¦¾'),(2548,90,'Kalindi','à¦•à¦¾à¦²à¦¿à¦¨à§à¦¦à¦¿'),(2549,90,'Konda','à¦•à§‹à¦¨à§à¦¡à¦¾'),(2550,90,'Ruhitpur','à¦°à§‹à¦¹à¦¿à¦¤à¦ªà§à¦°'),(2551,90,'Sakta','à¦¶à¦¾à¦•à§à¦¤à¦¾'),(2552,90,'Suvadda','à¦¶à§à¦­à¦¾à¦¢à§à¦¯à¦¾'),(2553,90,'Taghoria','à¦¤à§‡à¦˜à¦°à¦¿à¦¯à¦¼à¦¾'),(2554,90,'Taranagar','à¦¤à¦¾à¦°à¦¾à¦¨à¦—à¦°'),(2555,90,'Zinzira','à¦œà¦¿à¦¨à¦œà¦¿à¦°à¦¾'),(2556,91,'Agla','à¦†à¦—à¦²à¦¾'),(2557,91,'Bakshanagar','à¦¬à¦•à§à¦¸à¦¨à¦—à¦°'),(2558,91,'Bandura','à¦¬à¦¾à¦¨à§à¦¦à§à¦°à¦¾'),(2559,91,'Barrah','à¦¬à¦¾à¦¹à§à¦°à¦¾'),(2560,91,'Baruakhali','à¦¬à¦¾à¦°à§à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€'),(2561,91,'Churain','à¦šà§à¦¡à¦¼à¦¾à¦‡à¦¨'),(2562,91,'Galimpur','à¦—à¦¾à¦²à¦¿à¦®à¦ªà§à¦°'),(2563,91,'Jantrail','à¦¯à¦¨à§à¦¤à§à¦°à¦¾à¦‡à¦²'),(2564,91,'Joykrishnapur','à¦œà¦¯à¦¼à¦•à§ƒà¦·à§à¦£à¦ªà§à¦°'),(2565,91,'Kailail','à¦•à§ˆà¦²à¦¾à¦‡à¦²'),(2566,91,'Kalakopa','à¦•à¦²à¦¾à¦•à§‹à¦ªà¦¾'),(2567,91,'Nayansree','à¦¨à¦¯à¦¼à¦¨à¦¶à§à¦°à§€'),(2568,91,'Shikaripara','à¦¶à¦¿à¦•à¦¾à¦°à§€à¦ªà¦¾à¦¡à¦¼à¦¾'),(2569,91,'Sholla','à¦¶à§‹à¦²à§à¦²à¦¾'),(2570,92,'Bilaspur','à¦¬à¦¿à¦²à¦¾à¦¸à¦ªà§à¦°'),(2571,92,'Kusumhathi','à¦•à§à¦¸à§à¦®à¦¹à¦¾à¦Ÿà¦¿'),(2572,92,'Mahmudpur','à¦®à¦¾à¦¹à¦®à§à¦¦à¦ªà§à¦°'),(2573,92,'Muksudpur','à¦®à§à¦•à¦¸à§à¦¦à¦ªà§à¦°'),(2574,92,'Narisha','à¦¨à¦¾à¦°à¦¿à¦¶à¦¾'),(2575,92,'Nayabari','à¦¨à¦¯à¦¼à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(2576,92,'Raipara','à¦°à¦¾à¦‡à¦ªà¦¾à¦¡à¦¼à¦¾'),(2577,92,'Sutarpara','à¦¸à§à¦¤à¦¾à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(2578,65,'Bashchara','à§®à¦¨à¦‚ à¦¬à¦¾à¦¶à¦à¦šà¦¡à¦¼à¦¾'),(2579,65,'Digpait','à§§à§ªà¦¨à¦‚ à¦¦à¦¿à¦—à¦ªà¦¾à¦‡à¦¤'),(2580,65,'Ghorada','à§­à¦¨à¦‚ à¦˜à§‹à¦¡à¦¼à¦¾à¦§à¦¾à¦ª'),(2581,65,'Itail','à§«à¦¨à¦‚ à¦‡à¦Ÿà¦¾à¦‡à¦²'),(2582,65,'Kendua','à§§à¦¨à¦‚ à¦•à§‡à¦¨à§à¦¦à§à¦¯à¦¼à¦¾'),(2583,65,'Laxirchar','à§©à¦¨à¦‚ à¦²à¦•à§à¦·à§€à¦°à¦šà¦°'),(2584,65,'Mesta','à§§à§©à¦¨à¦‚ à¦®à§‡à¦·à§à¦Ÿà¦¾'),(2585,65,'Narundi','à§¬à¦¨à¦‚ à¦¨à¦°à§à¦¨à§à¦¦à§€'),(2586,65,'Ranagacha','à§¯à¦¨à¦‚ à¦°à¦¾à¦¨à¦¾à¦—à¦¾à¦›à¦¾'),(2587,65,'Rashidpur','à§§à§«à¦¨à¦‚ à¦°à¦¶à¦¿à¦¦à¦ªà§à¦°'),(2588,65,'Shahbajpur','à§§à§§à¦¨à¦‚ à¦¶à¦¾à¦¹à¦¬à¦¾à¦œà¦ªà§à¦°'),(2589,65,'Sharifpur','à§¨à¦¨à¦‚ à¦¶à¦°à¦¿à¦«à¦ªà§à¦°'),(2590,65,'Sheepur','à§§à§¦à¦¨à¦‚ à¦¶à§à¦°à§€à¦ªà§à¦°'),(2591,65,'Titpalla','à§§à§¨à¦¨à¦‚ à¦¤à¦¿à¦¤à¦ªà¦²à§à¦²à¦¾'),(2592,65,'Tolshirchar','à§ªà¦¨à¦‚ à¦¤à§à¦²à¦¶à§€à¦°à¦šà¦°'),(2593,66,'Adra','à§¬à¦¨à¦‚ à¦†à¦¦à§à¦°à¦¾'),(2594,66,'Charbanipakuria','à§­à¦¨à¦‚ à¦šà¦°à¦¬à¦¾à¦¨à§€ à¦ªà¦¾à¦•à§à¦°à¦¿à¦¯à¦¼à¦¾'),(2595,66,'Durmot','à§§à¦¨à¦‚ à¦¦à§à¦°à¦®à§à¦Ÿ'),(2596,66,'Fulkucha','à§®à¦¨à¦‚ à¦«à§à¦²à¦•à§‹à¦šà¦¾'),(2597,66,'Ghuserpara','à§¯à¦¨à¦‚ à¦˜à§‹à¦·à§‡à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(2598,66,'Jhaugara','à§§à§¦à¦¨à¦‚ à¦à¦¾à¦‰à¦—à¦¡à¦¼à¦¾'),(2599,66,'Kulia','à§¨à¦¨à¦‚ à¦•à§à¦²à¦¿à¦¯à¦¼à¦¾'),(2600,66,'Mahmudpur','à§©à¦¨à¦‚ à¦®à¦¾à¦¹à¦®à§à¦¦à¦ªà§à¦°'),(2601,66,'Nangla','à§ªà¦¨à¦‚ à¦¨à¦¾à¦‚à¦²à¦¾'),(2602,66,'Nayanagar','à§«à¦¨à¦‚ à¦¨à¦¯à¦¼à¦¾à¦¨à¦—à¦°'),(2603,66,'Shuampur','à§§à§§à¦¨à¦‚ à¦¶à§à¦¯à¦¾à¦®à¦ªà§à¦°'),(2604,67,'Belghacha','à§¨à¦¨à¦‚ à¦¬à§‡à¦²à¦—à¦¾à¦›à¦¾'),(2605,67,'Chargualini','à§§à§¨ à¦¨à¦‚ à¦šà¦°à¦—à§‹à¦¯à¦¼à¦¾à¦²à§€à¦¨à¦¿'),(2606,67,'Charputimari','à§§à§§à¦¨à¦‚  à¦šà¦°à¦ªà§à¦Ÿà¦¿à¦®à¦¾à¦°à§€'),(2607,67,'Chinaduli','à§©à¦¨à¦‚ à¦šà¦¿à¦¨à¦¾à¦¡à§à¦²à§€'),(2608,67,'Gaibandha','à§§à§¦ à¦¨à¦‚ à¦—à¦¾à¦‡à¦¬à¦¾à¦¨à§à¦§à¦¾'),(2609,67,'Gualerchar','à§¯à¦¨à¦‚ à¦—à§‹à¦¯à¦¼à¦¾à¦²à§‡à¦°à¦šà¦°'),(2610,67,'Islampur','à§¬à¦¨à¦‚ à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(2611,67,'Kulkandi','à§§à¦¨à¦‚ à¦•à§à¦²à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2612,67,'Noarpara','à§«à¦¨à¦‚ à¦¨à§‹à¦¯à¦¼à¦¾à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(2613,67,'Palabandha','à§®à¦¨à¦‚ à¦ªà¦²à¦¬à¦¾à¦¨à§à¦§à¦¾'),(2614,67,'Partharshi','à§­à¦¨à¦‚ à¦ªà¦¾à¦¥à¦¶à§€'),(2615,67,'Shapdari','à§ªà¦¨à¦‚ à¦¸à¦¾à¦ªà¦§à¦°à§€'),(2616,72,'Azimnagar','à¦†à¦œà¦¿à¦®à¦¨à¦—à¦°'),(2617,72,'Baira','à¦¬à§Ÿà¦°à¦¾'),(2618,72,'Balla','à¦¬à¦¾à¦²à§à¦²à¦¾ '),(2619,72,'Blara','à¦¬à¦²à§œà¦¾'),(2620,72,'Chala','à¦šà¦¾à¦²à¦¾ '),(2621,72,'Dhulsura','à¦§à§‚à¦²à¦¶à§à§œà¦¾'),(2622,72,'Gala','à¦—à¦¾à¦²à¦¾ '),(2623,72,'Gopinathpur','à¦—à§‹à¦ªà§€à¦¨à¦¾à¦¥à¦ªà§à¦°'),(2624,72,'Harukandi','à¦¹à¦¾à¦°à§à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2625,72,'Kanchanpur','à¦•à¦¾à¦žà§à¦šà¦¨à¦ªà§à¦°'),(2626,72,'Lacharagonj','à¦²à§‡à¦›à§œà¦¾à¦—à¦žà§à¦œ'),(2627,72,'Ramkrishnapur','à¦°à¦¾à¦®à¦•à§ƒà¦žà§à¦šà¦ªà§à¦°'),(2628,72,'Sutalorie','à¦¸à§à¦¤à¦¾à¦²à§œà§€'),(2629,46,'Amtoil','à¦†à¦®à¦¤à§ˆà¦²'),(2630,46,'Bhubankura','à¦­à§‚à¦¬à¦¨à¦•à§à§œà¦¾'),(2631,46,'Bildora','à¦¬à¦¿à¦²à¦¡à§‡à¦¾à¦°à¦¾'),(2632,46,'Dhara','à¦§à¦¾à¦°à¦¾'),(2633,46,'Dhurail','à¦§à§à¦°à¦¾à¦‡à¦²'),(2634,46,'Gazirbhita','à¦—à¦¾à¦œà¦¿à¦°à¦­à¦¿à¦Ÿà¦¾'),(2635,46,'Haluaghat','à¦¹à¦¾à¦²à§à§Ÿà¦¾à¦˜à¦¾à¦Ÿ'),(2636,46,'Jugli','à¦œà§à¦—à¦²à§€'),(2637,46,'Kaichapur','à¦•à§ˆà¦šà¦¾à¦ªà§à¦°'),(2638,46,'Narail','à¦¨à§œà¦¾à¦‡à¦²'),(2639,46,'Sakuai','à¦¶à¦¾à¦•à§à§Ÿà¦¾à¦‡'),(2640,46,'Swadeshi','à¦¸à§à¦¬à¦¦à§‡à¦¶à§€'),(2641,10,'Ashikati','à¦†à¦¶à¦¿à¦•à¦¾à¦Ÿà¦¿'),(2642,10,'Baghadi','à¦¬à¦¾à¦—à¦¾à¦¦à§€'),(2643,10,'Balia','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(2644,10,'Bishnapur','à¦¬à¦¿à¦·à§à¦£à¦ªà§à¦°'),(2645,10,'Chandra','à¦šà¦¾à¦¨à§à¦¦à§à¦°à¦¾'),(2646,10,'Hanarchar','à¦¹à¦¾à¦¨à¦¾à¦°à¦šà¦°'),(2647,10,'Ibrahimpur','à¦‡à¦¬à§à¦°à¦¾à¦¹à§€à¦®à¦ªà§à¦°'),(2648,10,'Kalyanpur','à¦•à¦²à§à¦¯à¦¾à¦£à¦ªà§à¦°'),(2649,10,'Laxmipurmodel','à¦²à¦•à§à¦·à§€à¦ªà§à¦° à¦®à¦¡à§‡à¦²'),(2650,10,'Maishadi','à¦®à§ˆà¦¶à¦¾à¦¦à§€'),(2651,10,'Rajrajeshwar','à¦°à¦¾à¦œà¦°à¦¾à¦œà§‡à¦¶à§à¦¬à¦°'),(2652,10,'Rampur','à¦°à¦¾à¦®à¦ªà§à¦°'),(2653,10,'Shahmahmudpur','à¦¶à¦¾à¦¹à§â€Œ'),(2654,10,'Tarpurchandi','à¦¤à¦°à¦ªà§à¦šà¦¨à§à¦¡à§€'),(2655,175,'Khadergaon','à¦–à¦¾à¦¦à§‡à¦°à¦—à¦¾à¦à¦“'),(2656,175,'Narayanpur','à¦¨à¦¾à¦°à¦¾à¦¯à¦¼à¦¨à¦ªà§à¦°'),(2657,175,'Nayergaonnorth','à¦¨à¦¾à¦¯à¦¼à§‡à¦°à¦—à¦¾à¦à¦“ à¦‰à¦¤à§à¦¤à¦°'),(2658,175,'Nayergaonsouth','à¦¨à¦¾à¦¯à¦¼à§‡à¦°à¦—à¦¾à¦à¦“ à¦¦à¦•à§à¦·à¦¿à¦¨'),(2659,175,'Upadinorth','à¦‰à¦ªà¦¾à¦¦à§€'),(2660,175,'Upadisouth','à¦‰à¦ªà¦¾à¦¦à§€'),(2661,463,'Aushkandi','à¦†à¦‰à¦¶à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2662,463,'Barabhakoirpaschim','à¦¬à§œ à¦­à¦¾à¦•à§ˆà¦° (à¦ªà¦¶à§à¦šà¦¿à¦®)'),(2663,463,'Barabhakoirpurba','à¦¬à§œ à¦­à¦¾à¦•à§ˆà¦° (à¦ªà§‚à¦°à§à¦¬)'),(2664,463,'Bausha','à¦¬à¦¾à¦‰à¦¸à¦¾'),(2665,463,'Debparra','à¦¦à§‡à¦¬à¦ªà¦¾à§œà¦¾'),(2666,463,'Digholbak','à¦¦à§€à¦˜à¦²à¦¬à¦¾à¦•'),(2667,463,'Gaznaipur','à¦—à¦œà¦¨à¦¾à¦‡à¦ªà§à¦°'),(2668,463,'Inatganj','à¦‡à¦¨à¦¾à¦¤à¦—à¦žà§à¦œ'),(2669,463,'Kaliarbhanga','à¦•à¦¾à¦²à¦¿à§Ÿà¦¾à¦°à¦­à¦¾à¦‚à¦—à¦¾'),(2670,463,'Kargoan','à¦•à¦°à¦—à¦¾à¦à¦“'),(2671,463,'Kurshi','à¦•à§à¦°à§à¦¶à¦¿'),(2672,463,'Nabiganjsadar','à¦¨à¦¬à§€à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(2673,463,'Paniumda','à¦ªà¦¾à¦¨à¦¿à¦‰à¦®à¦¦à¦¾'),(2674,464,'Bahubalsadar','à¦¬à¦¾à¦¹à§à¦¬à¦² à¦¸à¦¦à¦°'),(2675,464,'Bhadeshwar','à¦­à¦¾à¦¦à§‡à¦¶à§à¦¬à¦°'),(2676,464,'Lamatashi','à¦²à¦¾à¦®à¦¾à¦¤à¦¾à¦¶à§€'),(2677,464,'Mirpur','à¦®à¦¿à¦°à¦ªà§à¦° '),(2678,464,'Putijuri','à¦ªà§à¦Ÿà¦¿à¦œà§à¦°à§€'),(2679,464,'Satkapon','à¦¸à¦¾à¦¤à¦•à¦¾à¦ªà¦¨'),(2680,464,'Snanghat','à¦¸à§à¦¨à¦¾à¦¨à¦˜à¦¾à¦Ÿ'),(2681,465,'Ajmiriganjsadar','à¦†à¦œà¦®à¦¿à¦°à§€à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(2682,465,'Badolpur','à¦¬à¦¦à¦²à¦ªà§à¦°'),(2683,465,'Jolsuka','à¦œà¦²à¦¸à§à¦–à¦¾'),(2684,465,'Kakailsao','à¦•à¦¾à¦•à¦¾à¦‡à¦²à¦›à§‡à¦“'),(2685,465,'Shibpasha','à¦¶à¦¿à¦¬à¦ªà¦¾à¦¶à¦¾'),(2686,466,'Baniachongnortheast','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚ à¦‰à¦¤à§à¦¤à¦° à¦ªà§‚à¦°à§à¦¬'),(2687,466,'Baniachongnorthwest','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚ à¦‰à¦¤à§à¦¤à¦° à¦ªà¦¶à§à¦šà¦¿à¦®'),(2688,466,'Baniachongsoutheast','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚ à¦¦à¦•à§à¦·à¦¿à¦£ à¦ªà§‚à¦°à§à¦¬'),(2689,466,'Baniachongsouthwest','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚ à¦¦à¦•à§à¦·à¦¿à¦£ à¦ªà¦¶à§à¦šà¦¿à¦®'),(2690,466,'Baraiuri','à¦¬à§œà¦‡à¦‰à§œà¦¿'),(2691,466,'Daulatpur',''),(2692,466,'Kagapasha','à¦•à¦¾à¦—à¦¾à¦ªà¦¾à¦¶à¦¾'),(2693,466,'Khagaura','à¦–à¦¾à¦—à¦¾à¦‰à§œà¦¾'),(2694,466,'Makrampur','à¦®à¦•à§à¦°à¦®à¦ªà§à¦°'),(2695,466,'Mandari','à¦®à¦¨à§à¦¦à¦°à§€'),(2696,466,'Muradpur','à¦®à§à¦°à¦¾à¦¦à¦ªà§à¦°'),(2697,466,'Pailarkandi','à¦ªà§ˆà¦²à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2698,466,'Pukra','à¦ªà§à¦•à§œà¦¾'),(2699,466,'Subidpur','à¦¸à§à¦¬à¦¿à¦¦à¦ªà§à¦°'),(2700,466,'Sujatpur','à¦¸à§à¦œà¦¾à¦¤à¦ªà§à¦°'),(2701,467,'Bamoi','à¦¬à¦¾à¦®à§ˆ'),(2702,467,'Bullaup6','à¦¬à§à¦²à§à¦²à¦¾'),(2703,467,'Karab','à¦•à¦°à¦¾à¦¬'),(2704,467,'Lakhai','à¦²à¦¾à¦–à¦¾à¦‡'),(2705,467,'Murakari','à¦®à§‹à§œà¦¾à¦•à¦°à¦¿'),(2706,467,'Muriauk','à¦®à§à§œà¦¿à§Ÿà¦¾à¦‰à¦•'),(2707,270,'Amdai','à¦†à¦®à¦¦à¦‡ '),(2708,270,'Bamb','à¦¬à¦®à§à¦¬à§ '),(2709,270,'Bhadsha','à¦­à¦¾à¦¦à¦¸à¦¾'),(2710,270,'Chakborkat','à¦šà¦•à¦¬à¦°à¦•à¦¤ '),(2711,270,'Dhalahar','à¦§à¦²à¦¾à¦¹à¦¾à¦° '),(2712,270,'Dogachi','à¦¦à§‹à¦—à¦¾à¦›à¦¿ '),(2713,270,'Jamalpur','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦° '),(2714,270,'Mohammadabad','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦¾à¦¬à¦¾à¦¦ '),(2715,270,'Puranapail','à¦ªà§à¦°à¦¾à¦¨à¦¾à¦ªà§ˆà¦² '),(2716,468,'Ahammadabad','à¦†à¦¹à¦®à§à¦®à¦¦à¦¾à¦¬à¦¾à¦¦'),(2717,468,'Chunarughat','à¦šà§à¦¨à¦¾à¦°à§à¦˜à¦¾à¦Ÿ'),(2718,468,'Deorgach','à¦¦à§‡à¦“à¦°à¦—à¦¾à¦›'),(2719,468,'Gazipur','à¦—à¦¾à¦œà§€à¦ªà§à¦°'),(2720,468,'Mirashi','à¦®à¦¿à¦°à¦¾à¦¶à§€'),(2721,468,'Paikpara','à¦ªà¦¾à¦‡à¦•à¦ªà¦¾à§œà¦¾'),(2722,468,'Ranigaon','à¦°à¦¾à¦£à§€à¦—à¦¾à¦à¦“'),(2723,468,'Shankhala','à¦¶à¦¾à¦¨à¦–à¦²à¦¾'),(2724,468,'Shatiajuri','à¦¸à¦¾à¦Ÿà¦¿à§Ÿà¦¾à¦œà§à¦°à§€'),(2725,468,'Ubahata','à¦‰à¦¬à¦¾à¦¹à¦¾à¦Ÿà¦¾'),(2726,469,'Gopaya','à¦—à§‹à¦ªà¦¾à§Ÿà¦¾'),(2727,469,'Laskerpur','à¦²à¦¸à§à¦•à¦°à¦ªà§à¦°'),(2728,469,'Lukra','à¦²à§à¦•à§œà¦¾'),(2729,469,'Nijampur','à¦¨à¦¿à¦œà¦¾à¦®à¦ªà§à¦°'),(2730,469,'Nurpur','à¦¨à§à¦°à¦ªà§à¦°'),(2731,469,'Poil','à¦ªà¦‡à¦²'),(2732,469,'Rajiura','à¦°à¦¾à¦œà¦¿à¦‰à§œà¦¾'),(2733,469,'Richi','à¦°à¦¿à¦šà¦¿'),(2734,469,'Shayestaganj','à¦¶à¦¾à§Ÿà§‡à¦¸à§à¦¤à¦¾à¦—à¦žà§à¦œ'),(2735,469,'Teghoria','à¦¤à§‡à¦˜à¦°à¦¿à§Ÿà¦¾'),(2736,470,'Adaoir','à¦†à¦¦à¦¾à¦à¦°'),(2737,470,'Andiura','à¦†à¦¨à§à¦¦à¦¿à¦‰à§œà¦¾'),(2738,470,'Bagashura','à¦¬à¦¾à¦˜à¦¾à¦¸à§à¦°à¦¾'),(2739,470,'Bahara','à¦¬à¦¹à¦°à¦¾'),(2740,470,'Bulla','à¦¬à§à¦²à§à¦²à¦¾'),(2741,470,'Chhatiain','à¦›à¦¾à¦¤à¦¿à§Ÿà¦¾à¦‡à¦¨'),(2742,470,'Choumohani','à¦šà§Œà¦®à§à¦¹à¦¨à§€'),(2743,470,'Dharmaghar','à¦§à¦°à§à¦®à¦˜à¦°'),(2744,470,'Jagadishpur','à¦œà¦—à¦¦à§€à¦¶à¦ªà§à¦°'),(2745,470,'Noapara','à¦¨à§‹à§Ÿà¦¾à¦ªà¦¾à§œà¦¾'),(2746,470,'Shahjahanpur','à¦¶à¦¾à¦¹à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°'),(2747,176,'Bakila','à¦¬à¦¾à¦•à¦¿à¦²à¦¾'),(2748,176,'Barkuleast','à¦¬à¦¡à¦¼à¦•à§à¦²'),(2749,176,'Barkulwest','à¦¬à¦¡à¦¼à¦•à§à¦²'),(2750,176,'Gandharbapurnorth','à¦—à¦¨à§à¦§à¦°à§à¦¬à§à¦¯à¦ªà§à¦°'),(2751,176,'Gandharbapursouth','à¦—à¦¨à§à¦§à¦°à§à¦¬à§à¦¯à¦ªà§à¦°'),(2752,176,'Hajiganjsadar','à¦¹à¦¾à¦œà§€à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(2753,176,'Hatilaeast','à¦¹à¦¾à¦Ÿà¦¿à¦²à¦¾'),(2754,176,'Hatilawest','à¦¹à¦¾à¦Ÿà¦¿à¦²à¦¾'),(2755,176,'Kalochonorth','à¦•à¦¾à¦²à¦šà§‹à¦ à¦‰à¦¤à§à¦¤à¦°'),(2756,176,'Kalochosouth','à¦•à¦¾à¦²à¦šà§‹à¦'),(2757,176,'Rajargaonnorth','à¦°à¦¾à¦œà¦¾à¦°à¦—à¦¾à¦à¦“'),(2758,283,'1nokhatteshawr','à¦–à¦Ÿà§à¦Ÿà§‡à¦¶à§à¦¬à¦° à¦°à¦¾à¦£à§€à¦¨à¦—à¦°'),(2759,283,'2nokashimpur','à¦•à¦¾à¦¶à¦¿à¦®à¦ªà§à¦°'),(2760,283,'3nogona','à¦—à§‹à¦¨à¦¾'),(2761,283,'4noparoil','à¦ªà¦¾à¦°à¦‡à¦²'),(2762,283,'5noborgoca','à¦¬à¦°à¦—à¦¾à¦›à¦¾'),(2763,283,'6nokaligram','à¦•à¦¾à¦²à¦¿à¦—à§à¦°à¦¾à¦®'),(2764,283,'7noekdala','à¦à¦•à¦¡à¦¾à¦²à¦¾'),(2765,283,'8nomirat','à¦®à¦¿à¦°à¦¾à¦Ÿ'),(2766,284,'10nobolihar','à¦¬à¦²à¦¿à¦¹à¦¾à¦°'),(2767,284,'11noshekerpur','à¦¶à¦¿à¦•à¦¾à¦°à¦ªà§à¦°'),(2768,284,'12noshailgachhi','à¦¶à§ˆà¦²à¦—à¦¾à¦›à§€'),(2769,284,'1nobarshail','à¦¬à¦°à§à¦·à¦¾à¦‡à¦²'),(2770,284,'2nokritipur','à¦•à¦¿à¦°à§à¦¤à§à¦¤à¦¿à¦ªà§à¦°'),(2771,284,'3nobaktiarpur','à¦¬à¦•à§à¦¤à¦¾à¦°à¦ªà§à¦° '),(2772,284,'4notilakpur','à¦¤à¦¿à¦²à§‹à¦•à¦ªà§à¦°'),(2773,284,'5nohapaniya','à¦¹à¦¾à¦ªà¦¾à¦¨à¦¿à§Ÿà¦¾'),(2774,284,'6nodubalhati','à¦¦à§à¦¬à¦²à¦¹à¦¾à¦Ÿà§€ '),(2775,284,'7noboalia','à¦¬à§‹à§Ÿà¦¾à¦²à¦¿à§Ÿà¦¾ '),(2776,284,'8nohashaigari','à¦¹à¦¾à¦à¦¸à¦¾à¦‡à¦—à¦¾à§œà§€'),(2777,284,'9nochandipur','à¦šà¦¨à§à¦¡à¦¿à¦ªà§à¦°'),(2778,285,'2notetulia','à¦¤à§‡à¦à¦¤à§à¦²à¦¿à§Ÿà¦¾'),(2779,285,'3nochhaor','à¦›à¦¾à¦“à§œ'),(2780,285,'4noganguria','à¦—à¦¾à¦™à§à¦—à§à¦°à¦¿à§Ÿà¦¾'),(2781,285,'5noghatnagar','à¦˜à¦¾à¦Ÿà¦¨à¦—à¦° '),(2782,285,'6nomoshidpur','à¦®à¦¶à¦¿à¦¦à¦ªà§à¦°'),(2783,285,'Nitpur','à¦¨à¦¿à¦¤à¦ªà§à¦° '),(2784,286,'1nosapahar','à¦¸à¦¾à¦ªà¦¾à¦¹à¦¾à¦°'),(2785,286,'3notilna','à¦¤à¦¿à¦²à¦¨à¦¾'),(2786,286,'4noaihai','à¦†à¦‡à¦¹à¦¾à¦‡'),(2787,286,'6noshironti','à¦¶à¦¿à¦°à¦¨à§à¦Ÿà§€'),(2788,286,'Goala','à¦—à§‹à§Ÿà¦¾à¦²à¦¾'),(2789,286,'Patari','à¦ªà¦¾à¦¤à¦¾à§œà§€'),(2790,474,'Bhatgaon','à¦­à¦¾à¦¤à¦—à¦¾à¦à¦“ '),(2791,474,'Chhailaafjalabad','à¦›à§ˆà¦²à¦¾ à¦†à¦«à¦œà¦²à¦¾à¦¬à¦¾à¦¦'),(2792,474,'Chhataksadar','à¦›à¦¾à¦¤à¦• à¦¸à¦¦à¦°'),(2793,474,'Chormohalla','à¦šà¦°à¦®à¦¹à¦²à§à¦²à¦¾'),(2794,474,'Dolarbazar','à¦¦à§‹à¦²à¦¾à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(2795,474,'Gobindganjsyedergaon','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦—à¦žà§à¦œ-à¦¸à§ˆà¦¦à§‡à¦°à¦—à¦¾à¦à¦“'),(2796,474,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦° '),(2797,474,'Jauwabazar','à¦œà¦¾à¦‰à§Ÿà¦¾ à¦¬à¦¾à¦œà¦¾à¦°'),(2798,474,'Kalaruka','à¦•à¦¾à¦²à¦¾à¦°à§à¦•à¦¾'),(2799,474,'Khurmanorth','à¦–à§à¦°à¦®à¦¾ à¦‰à¦¤à§à¦¤à¦°'),(2800,474,'Khurmasouth','à¦–à§à¦°à¦®à¦¾ à¦¦à¦•à§à¦·à¦¿à¦£'),(2801,474,'Noarai','à¦¨à§‹à§Ÿà¦¾à¦°à¦¾à¦‡'),(2802,474,'Singchapair','à¦¸à¦¿à¦‚à¦šà¦¾à¦ªà¦‡à§œ'),(2803,475,'Asharkandi','à¦†à¦¶à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2804,475,'Chilauraholdipur','à¦šà¦¿à¦²à¦¾à¦‰à§œà¦¾ à¦¹à¦²à¦¦à¦¿à¦ªà§à¦° '),(2805,475,'Kolkolia','à¦•à¦²à¦•à¦²à¦¿à§Ÿà¦¾'),(2806,475,'Mirpur','à¦®à§€à¦°à¦ªà§à¦° '),(2807,475,'Pailgaon','à¦ªà¦¾à¦‡à¦²à¦—à¦¾à¦à¦“'),(2808,475,'Patli','à¦ªà¦¾à¦Ÿà¦²à§€'),(2809,475,'Raniganj','à¦°à¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(2810,475,'Syedpurshaharpara','à¦¸à§ˆà§Ÿà¦¦à¦ªà§à¦° à¦¶à¦¾à¦¹à¦¾à§œà¦ªà¦¾à§œà¦¾'),(2811,476,'Banglabazar','à¦¬à¦¾à¦‚à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(2812,476,'Boglabazar','à¦¬à§‹à¦—à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(2813,476,'Dohalia','à¦¦à§‹à¦¹à¦¾à¦²à¦¿à§Ÿà¦¾'),(2814,476,'Dowarabazar','à¦¦à§‹à§Ÿà¦¾à¦°à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(2815,476,'Laxmipur','à¦²à¦•à§à¦·à§€à¦ªà§à¦°'),(2816,476,'Mannargaon','à¦®à¦¾à¦¨à§à¦¨à¦¾à¦°à¦—à¦¾à¦à¦“'),(2817,476,'Norsingpur','à¦¨à¦°à¦¸à¦¿à¦‚à¦¹à¦ªà§à¦°'),(2818,476,'Pandargaon','à¦ªà¦¾à¦¨à§à¦¡à¦¾à¦°à¦—à¦¾à¦à¦“'),(2819,476,'Surma2','à¦¸à§à¦°à¦®à¦¾'),(2820,177,'Banganbari',''),(2821,177,'Durgapur',''),(2822,177,'Eastfatehpur','à¦«à¦¤à§‡à¦¹à¦ªà§à¦°'),(2823,177,'Eklaspur',''),(2824,177,'Farajikandi',''),(2825,177,'Gazra',''),(2826,177,'Islamabad',''),(2827,177,'Jahirabad',''),(2828,177,'Kalakanda',''),(2829,177,'Mohanpur',''),(2830,177,'Sadullapur',''),(2831,177,'Satnal',''),(2832,177,'Sultanabad',''),(2833,177,'Westfatehpur','à¦«à¦¤à§‡à¦¹à¦ªà§à¦°'),(2834,178,'Balithubaeast','à¦¬à¦¾à¦²à¦¿à¦¥à§à¦¬à¦¾ à¦ªà§‚à¦°à§à¦¬'),(2835,178,'Balithubawest','à¦¬à¦¾à¦²à¦¿à¦¥à§à¦¬à¦¾ à¦ªà¦¶à§à¦šà¦¿à¦®'),(2836,178,'Chardukhiaeast','à¦šà¦°à¦¦à§à¦–à¦¿à¦¯à¦¼à¦¾'),(2837,178,'Chardukhiawest','à¦šà¦°à¦¦à§à¦ƒà¦–à¦¿à¦¯à¦¼à¦¾'),(2838,178,'Faridgonjsouth','à¦«à¦°à¦¿à¦¦à§à¦—à¦žà§à¦œ à¦¦à¦•à§à¦·à¦¿à¦£'),(2839,178,'Gobindapurnorth','à¦—à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(2840,178,'Gobindapursouth','à¦—à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(2841,178,'Guptieast','à¦—à§à¦ªà§à¦¤à¦¿'),(2842,178,'Guptiwest','à¦—à§à¦ªà§à¦¤à¦¿'),(2843,178,'Paikparanorth','à¦ªà¦¾à¦‡à¦•à¦ªà¦¾à¦¡à¦¼à¦¾'),(2844,178,'Paikparasouth','à¦ªà¦¾à¦‡à¦•à¦ªà¦¾à¦¡à¦¼à¦¾'),(2845,178,'Rupshanorth','à¦°à§à¦ªà¦¸à¦¾'),(2846,178,'Rupshasouth','à¦°à§à¦ªà¦¸à¦¾'),(2847,178,'Subidpureast','à¦¸à§à¦¬à¦¿à¦¦à¦ªà§à¦°'),(2848,178,'Subidpurwest','à¦¸à§à¦¬à¦¿à¦¦à¦ªà§à¦°'),(2849,47,'Achintapur','à¦…à¦šà¦¿à¦¨à§à¦¤à¦ªà§à¦°'),(2850,47,'Bhangnamari','à¦­à¦¾à¦‚à¦¨à¦¾à¦®à¦¾à¦°à§€'),(2851,47,'Bokainagar','à¦¬à§‹à¦•à¦¾à¦‡à¦¨à¦—à¦°'),(2852,47,'Douhakhola','à¦¡à§‡à§—à¦¹à¦¾à¦–à¦²à¦¾'),(2853,47,'Gouripur','à¦—à§‡à§—à¦°à§€à¦ªà§à¦°'),(2854,47,'Mailakanda','à¦®à¦‡à¦²à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(2855,47,'Maoha','à¦®à¦¾à¦“à¦¹à¦¾'),(2856,47,'Ramgopalpur','à¦°à¦¾à¦®à¦—à§‡à¦¾à¦ªà¦¾à¦²à¦ªà§à¦°'),(2857,47,'Sahanati','à¦¸à¦¹à¦¨à¦¾à¦Ÿà¦¿'),(2858,47,'Sidhla','à¦¸à¦¿à¦§à¦²à¦¾'),(2859,48,'Barobaria','à¦¬à¦¾à¦°à¦¬à¦¾à¦°à¦¿à§Ÿà¦¾'),(2860,48,'Charalgi','à¦šà¦°à¦†à¦²à¦—à§€'),(2861,48,'Dotterbazar','à¦¦à¦¤à§à¦¤à§‡à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(2862,48,'Gafargaon','à¦—à¦«à¦°à¦—à¦¾à¦à¦“'),(2863,48,'Josora','à¦¯à¦¶à¦°à¦¾'),(2864,48,'Longair','à¦²à¦‚à¦—à¦¾à¦‡à¦°'),(2865,48,'Moshakhali','à¦®à¦¶à¦¾à¦–à¦¾à¦²à§€'),(2866,48,'Niguari','à¦¨à¦¿à¦—à§à§Ÿà¦¾à¦°à§€'),(2867,48,'Paithol','à¦ªà¦¾à¦‡à¦¥à¦²'),(2868,48,'Panchbagh','à¦ªà¦¾à¦à¦šà¦¬à¦¾à¦—'),(2869,48,'Raona','à¦°à¦¾à¦“à¦¨à¦¾'),(2870,48,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(2871,48,'Saltia','à¦¸à¦¾à¦²à¦Ÿà¦¿à§Ÿà¦¾'),(2872,48,'Tangabo','à¦Ÿà¦¾à¦‚à¦—à¦¾à¦¬'),(2873,48,'Usthi','à¦‰à¦¸à§à¦¥à¦¿'),(2874,49,'Atharabari','à¦†à¦ à¦¾à¦°à¦¬à¦¾à§œà§€'),(2875,49,'Barahit','à¦¬à§œà¦¹à¦¿à¦¤'),(2876,49,'Iswarganj','à¦ˆà¦¶à§à¦¬à¦°à¦—à¦žà§à¦œ'),(2877,49,'Jatia','à¦œà¦¾à¦Ÿà¦¿à§Ÿà¦¾'),(2878,49,'Magtula','à¦®à¦—à¦Ÿà§à¦²à¦¾'),(2879,49,'Maijbagh','à¦®à¦¾à¦‡à¦œà¦¬à¦¾à¦—'),(2880,49,'Rajibpur','à¦°à¦¾à¦œà¦¿à¦¬à¦ªà§à¦°'),(2881,49,'Sarisha','à¦¸à¦°à¦¿à¦·à¦¾'),(2882,49,'Sohagi','à¦¸à§‡à¦¾à¦¹à¦¾à¦—à§€'),(2883,49,'Tarundia','à¦¤à¦¾à¦°à§à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(2884,49,'Uchakhila','à¦‰à¦šà¦¾à¦–à¦¿à¦²à¦¾'),(2885,50,'Achargaon','à¦†à¦šà¦¾à¦°à¦—à¦¾à¦à¦“'),(2886,50,'Batagoir','à¦¬à§‡à¦¤à¦¾à¦—à§ˆà¦°'),(2887,50,'Chandipasha','à¦šà¦¨à§à¦¡à§€à¦ªà¦¾à¦¶à¦¾'),(2888,50,'Gangail','à¦—à¦¾à¦‚à¦—à¦¾à¦‡à¦²'),(2889,50,'Jahangirpur','à¦œà¦¾à¦¹à¦¾à¦™à§à¦—à§€à¦°à¦ªà§à¦°'),(2890,50,'Kharua','à¦–à¦¾à¦°à§à§Ÿà¦¾'),(2891,50,'Muajjempur','à¦®à§‡à¦¾à§Ÿà¦¾à¦œà§à¦œà§‡à¦®à¦ªà§à¦°'),(2892,50,'Mushulli','à¦®à§à¦¶à§à¦²à§à¦²à§€'),(2893,50,'Nandail','à¦¨à¦¾à¦¨à§à¦¦à¦¾à¦‡à¦²'),(2894,50,'Rajgati','à¦°à¦¾à¦œà¦—à¦¾à¦¤à§€'),(2895,50,'Sherpur','à¦¶à§‡à¦°à¦ªà§à¦°'),(2896,50,'Singroil','à¦¸à¦¿à¦‚à¦°à¦‡à¦²'),(2897,477,'Badaghat','à¦¬à¦¾à¦¦à¦¾à¦˜à¦¾à¦Ÿ'),(2898,477,'Balijuri','à¦¬à¦¾à¦²à¦¿à¦œà§à¦°à§€'),(2899,477,'Bordalnorth','à¦¬à§œà¦¦à¦² à¦‰à¦¤à§à¦¤à¦°'),(2900,477,'Bordalsouth','à¦¬à§œà¦¦à¦² à¦¦à¦•à§à¦·à¦¿à¦£'),(2901,477,'Sreepurnorth','à¦¶à§à¦°à§€à¦ªà§à¦° à¦‰à¦¤à§à¦¤à¦°'),(2902,477,'Sreepursouth','à¦¶à§à¦°à§€à¦ªà§à¦° à¦¦à¦•à§à¦·à¦¿à¦£'),(2903,477,'Tahirpursadar','à¦¤à¦¾à¦¹à¦¿à¦°à¦ªà§à¦° à¦¸à¦¦à¦°'),(2904,478,'Bongshikundanorth','à¦¬à¦‚à¦¶à§€à¦•à§à¦¨à§à¦¡à¦¾ à¦‰à¦¤à§à¦¤à¦°'),(2905,478,'Bongshikundasouth','à¦¬à¦‚à¦¶à§€à¦•à§à¦¨à§à¦¡à¦¾ à¦¦à¦•à§à¦·à¦¿à¦£'),(2906,478,'Chamordani','à¦šà¦¾à¦®à¦°à¦¦à¦¾à¦¨à§€'),(2907,478,'Dharmapashasadar','à¦§à¦°à§à¦®à¦ªà¦¾à¦¶à¦¾ à¦¸à¦¦à¦°'),(2908,478,'Joyasree','à¦œà§Ÿà¦¶à§à¦°à§€'),(2909,478,'Madhyanagar','à¦®à¦§à§à¦¯à¦¨à¦—à¦°'),(2910,478,'Paikurati','à¦ªà¦¾à¦‡à¦•à§à¦°à¦¾à¦Ÿà§€'),(2911,478,'Selbarash','à¦¸à§‡à¦²à¦¬à¦°à¦·'),(2912,478,'Sukhairrajapurnorth','à¦¸à§à¦–à¦¾à¦‡à§œ à¦°à¦¾à¦œà¦¾à¦ªà§à¦° à¦‰à¦¤à§à¦¤à¦°'),(2913,478,'Sukhairrajapursouth','à¦¸à§à¦–à¦¾à¦‡à§œ à¦°à¦¾à¦œà¦¾à¦ªà§à¦° à¦¦à¦•à§à¦·à¦¿à¦£'),(2914,479,'Beheli','à¦¬à§‡à¦¹à§‡à¦²à§€'),(2915,479,'Bhimkhali','à¦­à§€à¦®à¦–à¦¾à¦²à§€'),(2916,479,'Fenerbak','à¦«à§‡à¦¨à¦¾à¦°à¦¬à¦¾à¦•'),(2917,479,'Jamalganjsadar','à¦œà¦¾à¦®à¦¾à¦²à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(2918,479,'Sachnabazar','à¦¸à¦¾à¦šà¦¨à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(2919,480,'Atgaon','à¦†à¦Ÿà¦—à¦¾à¦à¦“'),(2920,480,'Bahara','à¦¬à¦¾à¦¹à¦¾à¦°à¦¾'),(2921,480,'Habibpur','à¦¹à¦¬à¦¿à¦¬à¦ªà§à¦°'),(2922,480,'Shallasadar','à¦¶à¦¾à¦²à§à¦²à¦¾ à¦¸à¦¦à¦°'),(2923,481,'Bhatipara','à¦­à¦¾à¦Ÿà¦¿à¦ªà¦¾à§œà¦¾'),(2924,481,'Charnarchar','à¦šà¦°à¦¨à¦¾à¦°à¦šà¦°'),(2925,481,'Deraisarmangal','à¦¦à¦¿à¦°à¦¾à¦‡ à¦¸à¦°à¦®à¦™à§à¦—à¦²'),(2926,481,'Jagddol','à¦œà¦—à¦¦à¦²'),(2927,481,'Karimpur','à¦•à¦°à¦¿à¦®à¦ªà§à¦°'),(2928,481,'Kulanj','à¦•à§à¦²à¦žà§à¦œ'),(2929,481,'Rafinagar','à¦°à¦«à¦¿à¦¨à¦—à¦°'),(2930,481,'Rajanagar','à¦°à¦¾à¦œà¦¾à¦¨à¦—à¦°'),(2931,481,'Taral','à¦¤à¦¾à§œà¦²'),(2932,10,'Adhara','à¦†à¦§à¦¾à¦°à¦¾'),(2933,10,'Bajrajogini','à¦¬à¦œà§à¦°à¦¯à§‹à¦—à¦¿à¦¨à§€'),(2934,10,'Banglabazar','à¦¬à¦¾à¦‚à¦²à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(2935,10,'Charkewar','à¦šà¦°à¦•à§‡à¦“à§Ÿà¦¾à¦°'),(2936,10,'Mohakali','à¦®à¦¹à¦¾à¦•à¦¾à¦²à§€'),(2937,10,'Mollakandi','à¦®à§‹à¦²à§à¦²à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(2938,10,'Panchashar','à¦ªà¦žà§à¦šà¦¸à¦¾à¦°'),(2939,10,'Rampal','à¦°à¦¾à¦®à¦ªà¦¾à¦²'),(2940,10,'Shiloy','à¦¶à¦¿à¦²à¦‡'),(2941,94,'Atpara','à¦†à¦Ÿà¦ªà¦¾à§œà¦¾'),(2942,94,'Bagra','à¦¬à¦¾à¦˜à§œà¦¾'),(2943,94,'Baraikhali','à¦¬à¦¾à§œà§‡à¦–à¦¾à¦²'),(2944,94,'Birtara','à¦¬à¦¾à§œà¦¤à¦¾à¦°à¦¾'),(2945,94,'Hashara','à¦¹à¦¾à¦¸à¦¾à§œà¦¾'),(2946,94,'Kolapara','à¦•à§à¦²à¦¾à¦ªà¦¾à§œà¦¾'),(2947,94,'Kukutia','à¦•à§à¦•à§à¦Ÿà¦¿à§Ÿà¦¾'),(2948,94,'Patabhog','à¦ªà¦¾à¦¢à¦¾à¦­à§‹à¦—'),(2949,94,'Rarikhal','à¦°à¦¾à§à§€à¦–à¦¾à¦²'),(2950,94,'Shamshiddi','à¦¶à§à¦¯à¦¾à¦®à¦¸à¦¿à¦¦à§à¦¦à¦¿'),(2951,94,'Shologhor','à¦·à§‹à¦²à¦˜à¦°'),(2952,94,'Sreenagar','à¦¶à§à¦°à§€à¦¨à¦—à¦°'),(2953,94,'Tantor','à¦¤à¦¨à§à¦¤à¦°'),(2954,94,'Vaggakol','à¦­à¦¾à¦—à§à¦¯à¦•à§à¦²'),(2955,95,'Bairagadi','à¦¬à§Ÿà¦°à¦¾à¦—à¦¾à¦¦à¦¿'),(2956,95,'Baluchar','à¦¬à¦¾à¦²à§à¦šà¦°'),(2957,95,'Basail','à¦¬à¦¾à¦¸à¦¾à¦‡à¦²'),(2958,95,'Chitracoat','à¦šà¦¿à¦¤à§à¦°à¦•à§‹à¦Ÿ '),(2959,95,'Ichhapura','à¦‡à¦›à¦¾à¦ªà§à¦°à¦¾'),(2960,95,'Joyinshar','à¦œà§ˆà¦¨à¦¸à¦¾à¦°'),(2961,95,'Keyain','à¦•à§‡à§Ÿà¦¾à¦‡à¦¨'),(2962,95,'Kola','à¦•à§‹à¦²à¦¾'),(2963,95,'Latabdi','à¦²à¦¤à¦¾à¦¬à§à¦¦à§€'),(2964,95,'Madhypara','à¦®à¦§à§à¦¯à¦ªà¦¾à§œà¦¾'),(2965,95,'Malkhanagar','à¦®à¦¾à¦²à¦–à¦¾à¦¨à¦—à¦°'),(2966,95,'Rajanagar','à¦°à¦¾à¦œà¦¾à¦¨à¦—à¦°'),(2967,95,'Rasunia','à¦°à¦¶à§à¦¨à¦¿à§Ÿà¦¾'),(2968,95,'Sekhornagar','à¦¶à§‡à¦–à¦°à¦¨à¦—à¦¾à¦°'),(2969,96,'Baultoli','à¦¬à§Œà¦²à¦¤à¦²à§€'),(2970,96,'Bejgaon','à¦¬à§‡à¦œà¦—à¦¾à¦à¦“'),(2971,96,'Gaodia','à¦—à¦¾à¦“à¦¦à¦¿à§Ÿà¦¾'),(2972,96,'Haldia','à¦¹à¦²à¦¦à¦¿à§Ÿà¦¾'),(2973,96,'Kalma','à¦•à¦²à¦®à¦¾'),(2974,96,'Kanaksar','à¦•à¦¨à¦•à¦¸à¦¾à¦°'),(2975,96,'Khidirpara','à¦–à¦¿à¦¦à¦¿à¦°à¦ªà¦¾à§œà¦¾'),(2976,96,'Kumarbhog','à¦•à§à¦®à¦¾à¦°à¦­à§‹à¦—'),(2977,96,'Lohajangteotia','à¦²à§Œà¦¹à¦œà¦‚-à¦¤à§‡à¦“à¦Ÿà¦¿à§Ÿà¦¾'),(2978,96,'Medinimandal','à¦®à§‡à¦¦à¦¿à¦¨à§€à¦®à¦¨à§à¦¡à¦²'),(2979,97,'Baluakandi','à¦¬à¦¾à¦²à§à§Ÿà¦¾à¦•à¦¾à¦¨à§à¦¦à§€'),(2980,97,'Baushia','à¦¬à¦¾à¦‰à¦¶à¦¿à§Ÿà¦¾'),(2981,97,'Gajaria','à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾'),(2982,97,'Guagachia','à¦—à§à§Ÿà¦¾à¦—à¦¾à¦›à¦¿à§Ÿà¦¾'),(2983,97,'Hosendee','à¦¹à§‹à¦¸à§‡à¦¨à§à¦¦à§€'),(2984,97,'Imampur','à¦‡à¦®à¦¾à¦®à¦ªà§à¦°'),(2985,97,'Tengarchar','à¦Ÿà§‡à¦‚à¦—à¦¾à¦°à¦šà¦°'),(2986,97,'Vaberchar','à¦­à¦¬à§‡à¦°à¦šà¦°'),(2987,98,'Abdullapur','à¦†à¦¬à§à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦°'),(2988,98,'Arialbaligaon','à¦†à§œà¦¿à§Ÿà¦² à¦¬à¦¾à¦²à¦¿à¦—à¦¾à¦à¦“'),(2989,98,'Autshahi','à¦†à¦‰à¦Ÿà¦¶à¦¾à¦¹à§€'),(2990,98,'Betka','à¦¬à§‡à¦¤à¦•à¦¾'),(2991,98,'Dhipur','à¦§à§€à¦ªà§à¦°'),(2992,98,'Dighirpar','à¦¦à¦¿à¦˜à§€à¦°à¦ªà¦¾à§œ'),(2993,98,'Hasailbanari','à¦¹à¦¾à¦¸à¦¾à¦‡à¦² à¦¬à¦¾à¦¨à¦¾à¦°à§€'),(2994,98,'Joslong','à¦¯à¦¶à¦²à¦‚'),(2995,98,'Kamarkhara','à¦•à¦¾à¦®à¦¾à¦°à¦–à¦¾à§œà¦¾ '),(2996,98,'Kathadiashimolia','à¦•à¦¾à¦ à¦¾à¦¦à¦¿à§Ÿà¦¾ à¦¶à¦¿à¦®à§à¦²à¦¿à§Ÿà¦¾'),(2997,98,'Panchgaon','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦“'),(2998,98,'Sonarongtongibari','à¦¸à§‹à¦¨à¦¾à¦°à¦‚ à¦Ÿà¦‚à¦—à§€à¦¬à¦¾à§œà§€'),(2999,10,'Alipur','à¦†à¦²à§€à¦ªà§à¦°'),(3000,10,'Banibaha','à¦¬à¦¾à¦¨à§€à¦¬à¦¹'),(3001,10,'Basantapur','à¦¬à¦¸à¦¨à§à¦¤à¦ªà§à¦°'),(3002,10,'Borat','à¦¬à¦°à¦¾à¦Ÿ'),(3003,10,'Chandoni','à¦šà¦¨à§à¦¦à¦¨à§€'),(3004,10,'Dadshee','à¦¦à¦¾à¦¦à¦¶à§€'),(3005,10,'Khangonj','à¦–à¦¾à¦¨à¦—à¦žà§à¦œ'),(3006,10,'Khankhanapur','à¦–à¦¾à¦¨à¦–à¦¾à¦¨à¦¾à¦ªà§à¦°'),(3007,10,'Mijanpur','à¦®à¦¿à¦œà¦¾à¦¨à¦ªà§à¦°'),(3008,10,'Mulghar','à¦®à§à¦²à¦˜à¦°'),(3009,10,'Panchuria','à¦ªà¦¾à¦à¦šà§à¦°à¦¿à¦¯à¦¼à¦¾'),(3010,10,'Ramkantapur','à¦°à¦¾à¦®à¦•à¦¾à¦¨à§à¦¤à¦ªà§à¦°'),(3011,10,'Shahidwahabpur','à¦¶à¦¹à§€à¦¦à¦“à¦¹à¦¾à¦¬à¦ªà§à¦°'),(3012,10,'Sultanpur','à¦¸à§à¦²à¦¤à¦¾à¦¨à¦ªà§à¦°'),(3013,100,'Chotovakla','à¦›à§‹à¦Ÿà¦­à¦¾à¦•à¦²à¦¾'),(3014,100,'Debugram','à¦¦à§‡à¦¬à¦—à§à¦°à¦¾à¦®'),(3015,100,'Doulatdia','à¦¦à§Œà¦²à¦¤à¦¦à¦¿à¦¯à¦¼à¦¾'),(3016,100,'Uzancar','à¦‰à¦œà¦¾à¦¨à¦šà¦°'),(3017,101,'Babupara','à¦¬à¦¾à¦¬à§à¦ªà¦¾à¦¡à¦¼à¦¾'),(3018,101,'Bahadurpur','à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦°'),(3019,101,'Habashpur','à¦¹à¦¾à¦¬à¦¾à¦¸à¦ªà§à¦°'),(3020,101,'Jashai','à¦¯à¦¶à¦¾à¦‡'),(3021,101,'Kalimahar','à¦•à¦²à¦¿à¦®à¦¹à¦°'),(3022,101,'Kasbamajhail','à¦•à¦¸à¦¬à¦¾à¦®à¦¾à¦œà¦¾à¦‡à¦²'),(3023,101,'Machhpara','à¦®à¦¾à¦›à¦ªà¦¾à§œà¦¾'),(3024,101,'Mourat','à¦®à§Œà¦°à¦¾à¦Ÿ'),(3025,101,'Patta','à¦ªà¦¾à¦Ÿà§à¦Ÿà¦¾'),(3026,101,'Sarisha','à¦¸à¦°à¦¿à¦·à¦¾'),(3027,102,'Baharpur','à¦¬à¦¹à¦°à¦ªà§à¦°'),(3028,102,'Baliakandi','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3029,102,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(3030,102,'Jamalpur','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦°'),(3031,102,'Janjal','à¦œà¦™à§à¦—à¦²'),(3032,102,'Narua','à¦¨à¦¾à¦°à§à¦¯à¦¼à¦¾'),(3033,102,'Nawabpur','à¦¨à¦¬à¦¾à¦¬à¦ªà§à¦°'),(3034,103,'Boalia','à¦¬à§‹à¦¯à¦¼à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(3035,103,'Kalikapur','à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(3036,103,'Kalukhali','à¦•à¦¾à¦²à§à¦–à¦¾à¦²à§€'),(3037,103,'Madapur','à¦®à¦¦à¦¾à¦ªà§à¦°'),(3038,103,'Majbari','à¦®à¦¾à¦œà¦¬à¦¾à¦¡à¦¼à§€'),(3039,103,'Mrigi','à¦®à§ƒà¦—à§€'),(3040,103,'Ratandia','à¦°à¦¤à¦¨à¦¦à¦¿à¦¯à¦¼à¦¾'),(3041,103,'Shawrail','à¦¸à¦¾à¦“à¦°à¦¾à¦‡à¦²'),(3042,10,'Angaria','à¦†à¦‚à¦—à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(3043,10,'Binodpur','à¦¬à¦¿à¦¨à§‹à¦¦à¦ªà§à¦°'),(3044,10,'Chandrapur','à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(3045,10,'Chikondi','à¦šà¦¿à¦•à¦¨à§à¦¦à¦¿'),(3046,10,'Chitolia','à¦šà¦¿à¦¤à¦²à¦¯à¦¼à¦¾'),(3047,10,'Domshar','à¦¡à§‹à¦®à¦¸à¦¾à¦°'),(3048,10,'Mahmudpur','à¦®à¦¾à¦¹à¦®à§à¦¦à¦ªà§à¦°'),(3049,10,'Palong','à¦ªà¦¾à¦²à¦‚'),(3050,10,'Rudrakar','à¦°à§à¦¦à§à¦°à¦•à¦°'),(3051,10,'Shulpara','à¦¶à§Œà¦²à¦ªà¦¾à¦¡à¦¼à¦¾'),(3052,10,'Tulasar','à¦¤à§à¦²à¦¾à¦¸à¦¾à¦°'),(3053,13,'Bijari','à¦¬à¦¿à¦à¦¾à¦°à¦¿'),(3054,13,'Charatra','à¦šà¦°à¦†à¦¤à§à¦°à¦¾'),(3055,13,'Dingamanik','à¦¡à¦¿à¦‚à¦—à¦¾à¦®à¦¾à¦¨à¦¿à¦•'),(3056,13,'Fategongpur','à¦«à¦¤à§‡à¦œà¦‚à¦ªà§à¦°'),(3057,13,'Garishar','à¦˜à¦¡à¦¼à¦¿à¦·à¦¾à¦°'),(3058,13,'Japsa','à¦œà¦ªà¦¸à¦¾'),(3059,13,'Kedarpur','à¦•à§‡à¦¦à¦¾à¦°à¦ªà§à¦°'),(3060,13,'Moktererchar','à¦®à§‹à¦¤à§à¦¤à¦¾à¦°à§‡à¦°à¦šà¦°'),(3061,13,'Nashason','à¦¨à¦¶à¦¾à¦¸à¦¨'),(3062,13,'Nowpara','à¦¨à¦“à¦ªà¦¾à¦¡à¦¼à¦¾'),(3063,13,'Rajnagar','à¦°à¦¾à¦œà¦¨à¦—à¦°'),(3064,13,'Vojeshwar','à¦­à§‹à¦œà§‡à¦¶à§à¦¬à¦°'),(3065,13,'Vumkhara','à¦­à§‚à¦®à¦–à¦¾à¦¡à¦¼à¦¾'),(3066,14,'Barogopalpur','à¦¬à¦¡à¦¼à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3067,14,'Barokandi','à¦¬à§œà¦•à¦¾à¦¨à§à¦¦à¦¿'),(3068,14,'Bilaspur','à¦¬à¦¿à¦²à¦¾à¦¸à¦ªà§à¦°'),(3069,14,'Bknagar','à¦¬à¦¿. à¦•à§‡. à¦¨à¦—à¦°'),(3070,14,'Jaynagor','à¦œà¦¯à¦¼à¦¨à¦—à¦°'),(3071,14,'Kundarchar','à¦•à§à¦¨à§à¦¡à§‡à¦°à¦šà¦°'),(3072,14,'Mulna','à¦®à§‚à¦²à¦¨à¦¾'),(3073,14,'Nawdoba','à¦¨à¦¾à¦“à¦¡à§‹à¦¬à¦¾'),(3074,14,'Palerchar','à¦ªà¦¾à¦²à§‡à¦°à¦šà¦°'),(3075,14,'Purbanawdoba','à¦ªà§à¦°à§à¦¬ à¦¨à¦¾à¦“à¦¡à§‹à¦¬à¦¾'),(3076,14,'Shenerchar','à¦¸à§‡à¦¨à§‡à¦°à¦šà¦°'),(3077,14,'Zajirasadar','à¦œà¦¾à¦œà¦¿à¦°à¦¾ à¦¸à¦¦à¦°'),(3078,15,'Alaolpur','à¦†à¦²à¦¾à¦“à¦²à¦ªà§à¦°'),(3079,15,'Edilpur','à¦‡à¦¦à¦¿à¦²à¦ªà§à¦°'),(3080,15,'Goshairhat','à¦—à§‹à¦¸à¦¾à¦‡à¦°à¦¹à¦¾à¦Ÿ'),(3081,15,'Kodalpur','à¦•à§‹à¦¦à¦¾à¦²à¦ªà§à¦°'),(3082,15,'Kuchipatti','à¦•à§à¦šà¦¾à¦‡à¦ªà¦Ÿà§à¦Ÿà¦¿'),(3083,15,'Nagerpara','à¦¨à¦¾à¦—à§‡à¦° à¦ªà¦¾à¦¡à¦¼à¦¾'),(3084,15,'Nalmuri','à¦¨à¦²à¦®à§à¦¡à¦¼à¦¿'),(3085,15,'Samontasar','à¦¸à¦¾à¦®à¦¨à§à¦¤à¦¸à¦¾à¦°'),(3086,16,'Arsinagar','à¦†à¦°à¦¶à¦¿à¦¨à¦—à¦°'),(3087,16,'Charkumaria','à¦šà¦°à¦•à§à¦®à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(3088,16,'Charsensas','à¦šà¦°à¦¸à§‡à¦¨à¦¸à¦¾à¦¸'),(3089,16,'Charvaga','à¦šà¦°à¦­à¦¾à¦—à¦¾'),(3090,16,'Dmkhali','à¦¡à¦¿.à¦à¦® à¦–à¦¾à¦²à¦¿'),(3091,16,'Kachikata','à¦•à¦¾à¦šà¦¿à¦•à¦¾à¦à¦Ÿà¦¾'),(3092,16,'Mahisar','à¦®à¦¹à¦¿à¦·à¦¾à¦°'),(3093,16,'Narayanpur','à¦¨à¦¾à¦°à¦¾à¦¯à¦¼à¦¨à¦ªà§à¦°'),(3094,16,'Northtarabunia','à¦‰à¦¤à§à¦¤à¦° à¦¤à¦¾à¦°à¦¾à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(3095,16,'Ramvadrapur','à¦°à¦¾à¦®à¦­à¦¦à§à¦°à¦ªà§à¦°'),(3096,16,'Sakhipur','à¦¸à¦–à¦¿à¦ªà§à¦°'),(3097,16,'Saygaon','à¦›à¦¯à¦¼à¦—à¦¾à¦à¦“'),(3098,16,'Southtarabunia','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦¤à¦¾à¦°à¦¾à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(3099,17,'Dankati','à¦§à¦¾à¦¨à¦•à¦¾à¦Ÿà¦¿'),(3100,17,'Darulaman','à¦¦à¦¾à¦°à§à¦² à¦†à¦®à¦¾à¦¨'),(3101,17,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(3102,17,'Kaneshar','à¦•à¦¨à§‡à¦¸à§à¦¬à¦°'),(3103,17,'Purbadamudya','à¦ªà§à¦°à§à¦¬ à¦¡à¦¾à¦®à§à¦¡à§à¦¯à¦¾'),(3104,17,'Shidulkura','à¦¶à¦¿à¦§à¦²à¦•à§à¦¡à¦¼à¦¾'),(3105,17,'Sidya','à¦¸à¦¿à¦¡à§à¦¯à¦¾'),(3106,10,'Bahadurpur','à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦ªà§à¦°'),(3107,10,'Chilarchar','à¦›à¦¿à¦²à¦¾à¦°à¦šà¦°'),(3108,10,'Dhurail','à¦§à§à¦°à¦¾à¦‡à¦²'),(3109,10,'Dudkhali','à¦¦à§à¦§à¦–à¦¾à¦²à§€'),(3110,10,'Ghatmajhi','à¦˜à¦Ÿà¦®à¦¾à¦à¦¿'),(3111,10,'Jhaoudi','à¦à¦¾à¦‰à¦¦à§€'),(3112,10,'Kalikapur','à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(3113,10,'Kandua','à¦•à§‡à¦¨à§à¦¦à§à§Ÿà¦¾'),(3114,10,'Khoajpur','à¦–à§‹à§Ÿà¦¾à¦œà¦ªà§à¦°'),(3115,10,'Kunia','à¦•à§à¦¨à¦¿à§Ÿà¦¾'),(3116,10,'Mastofapur','à¦®à¦¸à§à¦¤à¦«à¦¾à¦ªà§à¦°'),(3117,10,'Panchkhola','à¦ªà¦¾à¦à¦šà¦–à§‹à¦²à¦¾'),(3118,10,'Peyarpur','à¦ªà§‡à§Ÿà¦¾à¦°à¦ªà§à¦°'),(3119,10,'Rasti','à¦°à¦¾à¦¸à§à¦¤à¦¿'),(3120,10,'Sirkhara','à¦¶à¦¿à§œà¦–à¦¾à§œà¦¾'),(3121,105,'Baheratalanorth','à¦¬à¦¹à§‡à¦°à¦¾à¦¤à¦²à¦¾ à¦‰à¦¤à§à¦¤à¦°'),(3122,105,'Bahertalasouth','à¦¬à¦¹à§‡à¦°à¦¾à¦¤à¦²à¦¾ à¦¦à¦•à§à¦·à¦¿à¦£'),(3123,105,'Bandarkhola','à¦¬à¦¨à§à¦¦à¦°à¦–à§‹à¦²à¦¾'),(3124,105,'Baskandi','à¦¬à¦¾à¦à¦¶à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3125,105,'Charjanazat','à¦šà¦°à¦œà¦¾à¦¨à¦¾à¦œà¦¾à¦¤'),(3126,105,'Dattapara','à¦¦à¦¤à§à¦¤à¦ªà¦¾à¦¡à¦¼à¦¾'),(3127,105,'Ditiyakhando','à¦¦à§à¦¬à¦¿à¦¤à§€à¦¯à¦¼à¦–à¦¨à§à¦¡'),(3128,105,'Kadirpur','à¦•à¦¾à¦¦à¦¿à¦°à¦ªà§à¦°'),(3129,105,'Kathalbari','à¦•à¦¾à¦à¦ à¦¾à¦²à¦¬à¦¾à¦¡à¦¼à§€'),(3130,105,'Kutubpur','à¦•à§à¦¤à§à¦¬à¦ªà§à¦°'),(3131,105,'Madbarerchar','à¦®à¦¾à¦¦à¦¬à¦°à§‡à¦°à¦šà¦°'),(3132,105,'Nilokhe','à¦¨à¦¿à¦²à¦–à¦¿'),(3133,105,'Panchar','à¦ªà¦¾à¦à¦šà¦šà¦°'),(3134,105,'Sannasirchar','à¦¸à¦¨à§à¦¯à¦¾à¦¸à¦¿à¦°à¦šà¦°'),(3135,105,'Shibchar','à¦¶à¦¿à¦¬à¦šà¦°'),(3136,105,'Shiruail','à¦¶à¦¿à¦°à§à¦¯à¦¼à¦¾à¦‡à¦²'),(3137,105,'Umedpur','à¦‰à¦®à§‡à¦¦à¦ªà§à¦°'),(3138,105,'Vhadrasion','à¦­à¦¦à§à¦°à¦¾à¦¸à¦¨'),(3139,105,'Vhandarikandi','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à§€à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3140,106,'Alinagar','à¦†à¦²à§€à¦¨à¦—à¦°'),(3141,106,'Baligram','à¦¬à¦¾à¦²à§€à¦—à§à¦°à¦¾à¦®'),(3142,106,'Basgari','à¦¬à¦¾à¦à¦¶à¦—à¦¾à¦¡à¦¼à§€'),(3143,106,'Chardoulatkhan','à¦šà¦°à¦¦à§Œà¦²à¦¤à¦–à¦¾à¦¨'),(3144,106,'Dashar','à¦¡à¦¾à¦¸à¦¾à¦°'),(3145,106,'Enayetnagor','à¦à¦¨à¦¾à¦¯à¦¼à§‡à¦¤à¦¨à¦—à¦°'),(3146,106,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3147,106,'Kazibakai','à¦•à¦¾à¦œà§€à¦¬à¦¾à¦•à¦¾à¦‡'),(3148,106,'Koyaria','à¦•à¦¯à¦¼à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(3149,106,'Laxmipur','à¦²à¦•à§à¦·à§€à¦ªà§à¦°'),(3150,106,'Nabogram','à¦¨à¦¬à¦—à§à¦°à¦¾à¦®'),(3151,106,'Ramjanpur','à¦°à¦®à¦œà¦¾à¦¨à¦ªà§à¦°'),(3152,106,'Shahebrampur','à¦¸à¦¾à¦¹à§‡à¦¬à¦°à¦¾à¦®à¦ªà§à¦°'),(3153,106,'Shikarmongol','à¦¶à¦¿à¦•à¦¾à¦°à¦®à¦™à§à¦—à¦²'),(3154,107,'Amgram','à¦†à¦®à¦—à§à¦°à¦¾à¦®'),(3155,107,'Badarpasa','à¦¬à¦¦à¦°à¦ªà¦¾à¦¶à¦¾'),(3156,107,'Bajitpur','à¦¬à¦¾à¦œà¦¿à¦¤à¦ªà§à¦°'),(3157,107,'Haridasdi-mahendrodi','à¦¹à¦°à¦¿à¦¦à¦¾à¦¸à¦¦à§€-à¦®à¦¹à§‡à¦¨à§à¦¦à§à¦°à¦¦à§€'),(3158,107,'Hosenpur','à¦¹à§‹à¦¸à§‡à¦¨à¦ªà§à¦°'),(3159,107,'Ishibpur','à¦‡à¦¶à¦¿à¦¬à¦ªà§à¦°'),(3160,107,'Kabirajpur','à¦•à¦¬à¦¿à¦°à¦¾à¦œà¦ªà§à¦°'),(3161,107,'Kadambari','à¦•à¦¦à¦®à¦¬à¦¾à§œà§€'),(3162,107,'Khaliya','à¦–à¦¾à¦²à¦¿à§Ÿà¦¾'),(3163,107,'Paikpara','à¦ªà¦¾à¦‡à¦•à¦ªà¦¾à§œà¦¾'),(3164,107,'Rajoir','à¦°à¦¾à¦œà§ˆà¦°'),(3165,10,'Borashi','à¦¬à§‹à¦¡à¦¼à¦¾à¦¶à§€'),(3166,10,'Boultali','à¦¬à§Œà¦²à¦¤à¦²à§€'),(3167,10,'Chandradighalia','à¦šà¦¨à§à¦¦à§à¦°à¦¦à¦¿à¦˜à¦²à¦¿à¦¯à¦¼à¦¾'),(3168,10,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(3169,10,'Gobra','à¦—à§‹à¦¬à¦°à¦¾'),(3170,10,'Gopinathpur','à¦—à§‹à¦ªà§€à¦¨à¦¾à¦¥à¦ªà§à¦°'),(3171,10,'Horidaspur','à¦¹à¦°à¦¿à¦¦à¦¾à¦¸à¦ªà§à¦°'),(3172,10,'Jalalabad','à¦œà¦¾à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦¦'),(3173,10,'Kajulia','à¦•à¦¾à¦œà§à¦²à¦¿à¦¯à¦¼à¦¾'),(3174,10,'Karpara','à¦•à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(3175,10,'Kati','à¦•à¦¾à¦ à¦¿'),(3176,10,'Lotifpur','à¦²à¦¤à¦¿à¦«à¦ªà§à¦°'),(3177,10,'Majhigati','à¦®à¦¾à¦à¦¿à¦—à¦¾à¦¤à§€'),(3178,10,'Nizra','à¦¨à¦¿à¦œà¦¡à¦¼à¦¾'),(3179,10,'Paikkandi','à¦ªà¦¾à¦‡à¦•à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3180,10,'Roghunathpur','à¦°à¦˜à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(3181,10,'Sahapur','à¦¸à¦¾à¦¹à¦¾à¦ªà§à¦°'),(3182,10,'Satpar','à¦¸à¦¾à¦¤à¦ªà¦¾à¦¡à¦¼'),(3183,10,'Shuktail','à¦¶à§à¦•à¦¤à¦¾à¦‡à¦²'),(3184,10,'Ulpur','à¦‰à¦²à¦ªà§à¦°'),(3185,10,'Urfi','à¦‰à¦°à¦«à¦¿'),(3186,109,'Bethuri','à¦¬à§‡à¦¥à§à§œà§€'),(3187,109,'Fukura','à¦«à§à¦•à¦°à¦¾'),(3188,109,'Hatiara','à¦¹à¦¾à¦¤à¦¿à§Ÿà¦¾à§œà¦¾'),(3189,109,'Kashiani','à¦•à¦¾à¦¶à¦¿à§Ÿà¦¾à¦¨à§€'),(3190,109,'Mamudpur','à¦®à¦¾à¦¹à¦®à§à¦¦à¦ªà§à¦°'),(3191,109,'Nijamkandi','à¦¨à¦¿à¦œà¦¾à¦®à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3192,109,'Orakandia','à¦“à§œà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3193,109,'Parulia','à¦ªà¦¾à¦°à§à¦²à¦¿à§Ÿà¦¾'),(3194,109,'Puisur','à¦ªà§à¦‡à¦¶à§à¦°'),(3195,109,'Rajpat','à¦°à¦¾à¦œà¦ªà¦¾à¦Ÿ'),(3196,109,'Ratail','à¦°à¦¾à¦¤à¦‡à¦²'),(3197,109,'Sajail','à¦¸à¦¾à¦œà¦¾à¦‡à¦²'),(3198,109,'Singa','à¦¸à¦¿à¦‚à¦—à¦¾'),(3199,110,'Borni','à¦¬à¦°à§à¦£à¦¿'),(3200,110,'Dumaria','à¦¡à§à¦®à¦°à¦¿à§Ÿà¦¾'),(3201,110,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3202,110,'Kushli','à¦•à§à¦¶à¦²à§€'),(3203,110,'Patgati','à¦ªà¦¾à¦Ÿà¦—à¦¾à¦¤à§€'),(3204,111,'Amtoli','à¦†à¦®à¦¤à¦²à§€'),(3205,111,'Bandhabari','à¦¬à¦¾à¦¨à§à¦§à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(3206,111,'Ghaghor','à¦˜à¦¾à¦˜à¦°'),(3207,111,'Hiron','à¦¹à¦¿à¦°à¦£'),(3208,111,'Kandi','à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3209,111,'Kolabari','à¦•à¦²à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(3210,111,'Kushla','à¦•à§à¦¶à¦²à¦¾'),(3211,111,'Pinjuri','à¦ªà¦¿à¦žà§à¦œà§à¦°à§€'),(3212,111,'Radhaganj','à¦°à¦¾à¦§à¦¾à¦—à¦žà§à¦œ'),(3213,111,'Ramshil','à¦°à¦¾à¦®à¦¶à§€à¦²'),(3214,111,'Sadullapur','à¦¸à¦¾à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦°'),(3215,112,'Banshbaria','à¦¬à¦¾à¦¶à¦à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3216,112,'Batikamari','à¦¬à¦¾à¦Ÿà¦¿à¦•à¦¾à¦®à¦¾à¦°à§€'),(3217,112,'Bohugram','à¦¬à¦¹à§à¦—à§à¦°à¦¾à¦®'),(3218,112,'Dignagar','à¦¦à¦¿à¦—à¦¨à¦—à¦°'),(3219,112,'Gobindopur','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(3220,112,'Gohala','à¦—à§‹à¦¹à¦¾à¦²à¦¾'),(3221,112,'Jalirpar','à¦œà¦²à¦¿à¦°à¦ªà¦¾à§œ'),(3222,112,'Kashalia','à¦•à¦¾à¦¶à¦¾à¦²à¦¿à§Ÿà¦¾'),(3223,112,'Khandarpara','à¦–à¦¾à¦¨à§à¦¦à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(3224,112,'Mochna','à¦®à§‹à¦šà¦¨à¦¾'),(3225,112,'Moharajpur','à¦®à¦¹à¦¾à¦°à¦¾à¦œà¦ªà§à¦°'),(3226,112,'Nanikhir',''),(3227,112,'Poshargati','à¦ªà¦¶à¦¾à¦°à¦—à¦¾à¦¤à¦¿'),(3228,112,'Raghdi','à¦°à¦¾à¦˜à¦¦à§€'),(3229,112,'Ujani','à¦‰à¦œà¦¾à¦¨à§€'),(3230,112,'Vabrashur','à¦­à¦¾à¦¬à§œà¦¾à¦¶à§à¦°'),(3231,10,'Aliabad','à¦†à¦²à¦¿à§Ÿà¦¾à¦¬à¦¾à¦¦'),(3232,10,'Ambikapur','à¦…à¦®à§à¦¬à¦¿à¦•à¦¾à¦ªà§à¦°'),(3233,10,'Charmadbdia','à¦šà¦°à¦®à¦¾à¦§à¦¬à¦¦à¦¿à§Ÿà¦¾'),(3234,10,'Decreerchar','à¦¡à¦¿à¦•à§à¦°à¦¿à¦°à¦šà¦°'),(3235,10,'Greda','à¦—à§‡à¦°à¦¦à¦¾'),(3236,10,'Ishangopalpur','à¦ˆà¦¶à¦¾à¦¨à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3237,10,'Kaijuri','à¦•à§ˆà¦œà§à¦°à§€'),(3238,10,'Kanaipur','à¦•à¦¾à¦¨à¦¾à¦‡à¦ªà§à¦°'),(3239,10,'Krishnanagar','à¦•à§ƒà¦·à§à¦£à¦¨à¦—à¦°'),(3240,10,'Majchar','à¦®à¦¾à¦šà§à¦šà¦°'),(3241,10,'Uttarchannel','à¦¨à¦°à§à¦¥à¦šà§à¦¯à¦¾à¦¨à§‡à¦²'),(3242,114,'Alfadanga','à¦†à¦²à¦«à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(3243,114,'Bana','à¦¬à¦¾à¦¨à¦¾'),(3244,114,'Buraich','à¦¬à§à§œà¦¾à¦‡à¦š'),(3245,114,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3246,114,'Panchuria','à¦ªà¦¾à¦à¦šà§à§œà¦¿à§Ÿà¦¾'),(3247,114,'Tagarbanda','à¦Ÿà¦—à¦°à¦¬à¦¨à§à¦¦'),(3248,115,'Boalmari','à¦¬à§‹à§Ÿà¦¾à¦²à¦®à¦¾à¦°à§€'),(3249,115,'Chandpur','à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(3250,115,'Chatul','à¦šà¦¤à§à¦²'),(3251,115,'Dadpur','à¦¦à¦¾à¦¦à¦ªà§à¦°'),(3252,115,'Ghoshpur','à¦˜à§‡à¦¾à¦·à¦ªà§à¦°'),(3253,115,'Gunbaha','à¦—à§à¦¨à¦¬à¦¹à¦¾'),(3254,115,'Moyna','à¦®à§Ÿà¦¨à¦¾'),(3255,115,'Parameshwardi','à¦ªà¦°à¦®à§‡à¦¶à§à¦¬à¦°à¦¦à§€'),(3256,115,'Rupapat','à¦°à§‚à¦ªà¦¾à¦ªà¦¾à¦¤'),(3257,115,'Satair','à¦¸à¦¾à¦¤à§ˆà¦°'),(3258,115,'Shekhar','à¦¶à§‡à¦–à¦°'),(3259,116,'Akoterchar','à¦†à¦•à§‹à¦Ÿà§‡à¦° à¦šà¦°'),(3260,116,'Bhashanchar','à¦­à¦¾à¦·à¦¾à¦¨à¦šà¦°'),(3261,116,'Charbisnopur','à¦šà¦° à¦¬à¦¿à¦·à§à¦£à§à¦ªà§à¦°'),(3262,116,'Charmanair','à¦šà¦° à¦®à¦¾à¦¨à¦¾à¦‡à¦°'),(3263,116,'Charnasirpur','à¦šà¦° à¦¨à¦¾à¦¸à¦¿à¦°à¦ªà§à¦°'),(3264,116,'Dhaukhali','à¦¢à§‡à¦‰à¦–à¦¾à¦²à§€'),(3265,116,'Krishnapur','à¦•à§ƒà¦·à§à¦£à¦ªà§à¦°'),(3266,116,'Narikelbariya','à¦¨à¦¾à¦°à¦¿à¦•à§‡à¦² à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3267,116,'Sadarpur','à¦¸à¦¦à¦°à¦ªà§à¦°'),(3268,117,'Charjashordi','à¦šà¦°à¦¯à¦¶à§‹à¦°à¦¦à§€'),(3269,117,'Dangi','à¦¡à¦¾à¦™à§à¦—à§€'),(3270,117,'Fulsuti','à¦«à§à¦²à¦¸à§à¦¤à¦¿'),(3271,117,'Kaichail','à¦•à¦¾à¦‡à¦šà¦¾à¦‡à¦²'),(3272,117,'Kodaliashohidnagar','à¦•à§‹à¦¦à¦¾à¦²à¦¿à§Ÿà¦¾'),(3273,117,'Laskardia','à¦²à¦¸à§à¦•à¦°à¦¦à¦¿à§Ÿà¦¾'),(3274,117,'Purapara','à¦ªà§à¦°à¦¾à¦ªà¦¾à§œà¦¾'),(3275,117,'Ramnagar','à¦°à¦¾à¦®à¦¨à¦—à¦°'),(3276,117,'Talma','à¦¤à¦¾à¦²à¦®à¦¾'),(3277,118,'Algi','à¦†à¦²à¦—à§€'),(3278,118,'Azimnagor','à¦†à¦œà¦¿à¦®à¦¨à¦—à¦°'),(3279,118,'Chandra','à¦šà¦¾à¦¨à§à¦¦à§à¦°à¦¾'),(3280,118,'Chumurdi','à¦šà§à¦®à§à¦°à¦¦à§€'),(3281,118,'Gharua','à¦˜à¦¾à¦°à§à§Ÿà¦¾'),(3282,118,'Hamirdi','à¦¹à¦¾à¦®à¦¿à¦°à¦¦à§€'),(3283,118,'Kalamridha','à¦•à¦¾à¦²à¦¾à¦®à§ƒà¦§à¦¾'),(3284,118,'Kawlibera','à¦•à¦¾à¦‰à¦²à¦¿à¦¬à§‡à§œà¦¾'),(3285,118,'Manikdha','à¦®à¦¾à¦¨à¦¿à¦•à¦¦à¦¹'),(3286,118,'Nasirabad','à¦¨à¦¾à¦›à¦¿à¦°à¦¾à¦¬à¦¾à¦¦'),(3287,118,'Nurullagonj','à¦¨à§à¦°à§à¦²à§à¦¯à¦¾à¦—à¦žà§à¦œ'),(3288,118,'Tujerpur','à¦¤à§à¦œà¦¾à¦°à¦ªà§à¦°'),(3289,119,'Charbhadrasan','à¦šà¦° à¦­à¦¦à§à¦°à¦¾à¦¸à¦¨'),(3290,119,'Charharirampur','à¦šà¦° à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(3291,119,'Charjahukanda','à¦šà¦° à¦à¦¾à¦‰à¦•à¦¾à¦¨à§à¦¦à¦¾'),(3292,119,'Gazirtek','à¦—à¦¾à¦œà§€à¦°à¦Ÿà§‡à¦•'),(3293,120,'Bagat','à¦¬à¦¾à¦—à¦¾à¦Ÿ'),(3294,120,'Dumain','à¦¡à§à¦®à¦¾à¦‡à¦¨'),(3295,120,'Gazna','à¦—à¦¾à¦œà¦¨à¦¾'),(3296,120,'Jahapur','à¦œà¦¾à¦¹à¦¾à¦ªà§à¦°'),(3297,120,'Kamarkhali','à¦•à¦¾à¦®à¦¾à¦°à¦–à¦¾à¦²à§€'),(3298,120,'Madhukhali','à¦®à¦§à§à¦–à¦¾à¦²à§€'),(3299,120,'Megchami','à¦®à§‡à¦—à¦šà¦¾à¦®à§€'),(3300,120,'Nowpara','à¦¨à¦“à¦ªà¦¾à§œà¦¾'),(3301,120,'Raipur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(3302,121,'Atghar','à¦†à¦Ÿà¦˜à¦°'),(3303,121,'Ballabhdi','à¦¬à¦²à§à¦²à¦­à¦¦à§€'),(3304,121,'Bhawal','à¦­à¦¾à¦“à§Ÿà¦¾à¦²'),(3305,121,'Gatti','à¦—à¦Ÿà§à¦Ÿà¦¿'),(3306,121,'Jadunandi','à¦¯à¦¦à§à¦¨à¦¨à§à¦¦à§€'),(3307,121,'Mazadia','à¦®à¦¾à¦à¦¾à¦°à¦¦à¦¿à§Ÿà¦¾'),(3308,121,'Ramkantapur','à¦°à¦¾à¦®à¦•à¦¾à¦¨à§à¦¤à¦ªà§à¦°'),(3309,121,'Sonapur','à¦¸à§‹à¦¨à¦¾à¦ªà§à¦°'),(3310,10,'Balukhali','à§¬ à¦¨à¦‚ à¦¬à¦¾à¦²à§à¦–à¦¾à¦²à§€'),(3311,10,'Bandukbhanga','à§« à¦¨à¦‚ à¦¬à¦¨à§à¦¦à§à¦•à¦­à¦¾à¦™à§à¦—à¦¾'),(3312,10,'Jibtali','à§§ à¦¨à¦‚ à¦œà§€à¦¬à¦¤à¦²à¦¿'),(3313,10,'Kutukchari','à§ª à¦¨à¦‚ à¦•à§à¦¤à§à¦•à¦›à§œà¦¿'),(3314,10,'Mogban','à§¨ à¦¨à¦‚ à¦®à¦—à¦¬à¦¾à¦¨'),(3315,10,'Sapchari','à§© à¦¨à¦‚ à¦¸à¦¾à¦ªà¦›à§œà¦¿'),(3316,154,'Chandraghona','à§§ à¦¨à¦‚ à¦šà¦¨à§à¦¦à§à¦°à¦˜à§‹à¦¨à¦¾'),(3317,154,'Chitmorom','à§© à¦¨à¦‚ à¦šà¦¿à§Žà¦®à¦°à¦®'),(3318,154,'Kaptai','à§ª à¦¨à¦‚ à¦•à¦¾à¦ªà§à¦¤à¦¾à¦‡'),(3319,154,'Raikhali','à§¨ à¦¨à¦‚ à¦°à¦¾à¦‡à¦–à¦¾à¦²à§€'),(3320,154,'Wagga','à§« à¦¨à¦‚ à¦“à§Ÿà¦¾à¦œà§à¦žà¦¾'),(3321,155,'Betbunia','à§§ à¦¨à¦‚ à¦¬à§‡à¦¤à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(3322,155,'Fatikchari','à§¨ à¦¨à¦‚ à¦«à¦Ÿà¦¿à¦•à¦›à§œà¦¿'),(3323,155,'Ghagra','à§© à¦¨à¦‚ à¦˜à¦¾à¦—à§œà¦¾'),(3324,155,'Kalampati','à§ª à¦¨à¦‚ à¦•à¦²à¦®à¦ªà¦¤à¦¿'),(3325,156,'Amtali','à§©à§­ à¦¨à¦‚ à¦†à¦®à¦¤à¦²à§€'),(3326,156,'Baghaichari','à§©à§¨ à¦¨à¦‚ à¦¬à¦¾à¦˜à¦¾à¦‡à¦›à§œà¦¿'),(3327,156,'Bongoltali','à§©à§« à¦¨à¦‚ à¦¬à¦™à§à¦—à¦²à¦¤à¦²à§€'),(3328,156,'Khedarmara','à§©à§§ à¦¨à¦‚ à¦–à§‡à¦¦à¦¾à¦°à¦®à¦¾à¦°à¦¾'),(3329,156,'Marisha','à§©à§© à¦¨à¦‚ à¦®à¦¾à¦°à¦¿à¦¶à§à¦¯à¦¾'),(3330,156,'Rupokari','à§©à§ª à¦¨à¦‚ à¦°à§à¦ªà¦•à¦¾à¦°à§€'),(3331,156,'Sajek','à§©à§¬ à¦¨à¦‚ à¦¸à¦¾à¦œà§‡à¦•'),(3332,156,'Sharoyatali','à§©à§¦ à¦¨à¦‚ à¦¸à¦¾à¦°à§‹à§Ÿà¦¾à¦¤à¦²à§€'),(3333,10,'Chowfaldandi','à¦šà§Œà¦«à¦²à¦¦à¦¨à§à¦¡à§€'),(3334,10,'Eidgaon','à¦ˆà¦¦à¦—à¦¾à¦à¦“'),(3335,10,'Islamabad','à¦‡à¦¸à¦²à¦¾à¦®à¦¾à¦¬à¦¾à¦¦'),(3336,10,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(3337,10,'Jalalabad','à¦œà¦¾à¦²à¦¾à¦²à¦¾à¦¬à¦¾à¦¦'),(3338,10,'Jhilongjha','à¦à¦¿à¦²à¦‚à¦à¦¾'),(3339,10,'Khurushkhul','à¦–à§à¦°à§à¦¶à¦•à§à¦²'),(3340,10,'Pmkhali','à¦ªà¦¿à¦à¦®à¦–à¦¾à¦²à§€'),(3341,10,'Pokkhali','à¦ªà§‹à¦•à¦–à¦¾à¦²à§€'),(3342,10,'Varuakhali','à¦­à¦¾à¦°à§à§Ÿà¦¾à¦–à¦¾à¦²à§€'),(3343,199,'Badarkhali','à¦¬à¦¦à¦°à¦–à¦¾à¦²à§€'),(3344,199,'Bamobilchari','à¦¬à¦¾à¦®à§ à¦¬à¦¿à¦²à¦›à¦¡à¦¼à¦¿'),(3345,199,'Baraitali','à¦¬à¦¡à¦¼à¦‡à¦¤à¦²à§€'),(3346,199,'Bheolamanikchar','à¦­à§‡à¦“à¦²à¦¾ à¦®à¦¾à¦¨à¦¿à¦•à¦šà¦°'),(3347,199,'Chiringa','à¦šà¦¿à¦°à¦¿à¦™à§à¦—à¦¾'),(3348,199,'Demusia','à¦¢à§‡à¦®à§à¦¶à¦¿à¦¯à¦¼à¦¾'),(3349,199,'Dulahazara','à¦¡à§à¦²à¦¾à¦¹à¦¾à¦œà¦¾à¦°à¦¾'),(3350,199,'Fashiakhali','à¦«à¦¾à¦à¦¸à¦¿à§Ÿà¦¾à¦–à¦¾à¦²à§€'),(3351,199,'Harbang','à¦¹à¦¾à¦°à¦¬à¦¾à¦™à§à¦—'),(3352,199,'Kaiarbil','à¦•à¦¾à¦‡à¦¯à¦¼à¦¾à¦° à¦¬à¦¿à¦²'),(3353,199,'Kakhara','à¦•à¦¾à¦•à¦¾à¦°à¦¾'),(3354,199,'Khuntakhali','à¦–à§à¦Ÿà¦¾à¦–à¦¾à¦²à§€'),(3355,199,'Konakhali','à¦•à§‹à¦¨à¦¾à¦–à¦¾à¦²à§€'),(3356,199,'Paschimbarabheola','à¦ªà¦¶à§à¦šà¦¿à¦® à¦¬à¦¡à¦¼ à¦­à§‡à¦“à¦²à¦¾'),(3357,199,'Saharbil','à¦¶à¦¾à¦¹à¦¾à¦°à¦¬à¦¿à¦²'),(3358,199,'Surajpurmanikpur','à¦¸à§à¦°à¦œà¦ªà§à¦° à¦®à¦¾à¦¨à¦¿à¦•à¦ªà§à¦°'),(3359,200,'Aliakbardeil','à¦†à¦²à¦¿ à¦†à¦•à¦¬à¦° à¦¡à§‡à¦‡à¦²'),(3360,200,'Baragho','à¦¬à¦¡à¦¼à¦˜à§‹à¦ª'),(3361,200,'Dakshidhurung','à¦¦à¦•à§à¦·à¦¿à¦£ à¦§à§à¦°à§à¦‚'),(3362,200,'Kaiyarbil','à¦•à§ˆà§Ÿà¦¾à¦°à¦¬à¦¿à¦²'),(3363,200,'Lemsikhali','à¦²à§‡à¦®à¦¸à¦¿à¦–à¦¾à¦²à§€'),(3364,200,'Uttardhurung','à¦‰à¦¤à§à¦¤à¦° à¦§à§à¦°à§à¦‚'),(3365,201,'Holdiapalong','à¦¹à¦²à¦¦à¦¿à§Ÿà¦¾à¦ªà¦¾à¦²à¦‚'),(3366,201,'Jaliapalong','à¦œà¦¾à¦²à¦¿à§Ÿà¦¾à¦ªà¦¾à¦²à¦‚'),(3367,201,'Palongkhali','à¦ªà¦¾à¦²à¦‚à¦–à¦¾à¦²à§€'),(3368,201,'Rajapalong','à¦°à¦¾à¦œà¦¾à¦ªà¦¾à¦²à¦‚'),(3369,201,'Ratnapalong','à¦°à¦¤à§à¦¨à¦¾à¦ªà¦¾à¦²à¦‚'),(3370,202,'Boramoheshkhali','à¦¬à§œ à¦®à¦¹à§‡à¦¶à¦–à¦¾à¦²à§€'),(3371,202,'Chotamoheshkhali','à¦›à§‹à¦Ÿ à¦®à¦¹à§‡à¦¶à¦–à¦¾à¦²à§€'),(3372,202,'Dhalghata','à¦§à¦²à¦˜à¦¾à¦Ÿà¦¾'),(3373,202,'Hoanak','à¦¹à§‹à§Ÿà¦¾à¦¨à¦•'),(3374,202,'Kalarmarchhara','à¦•à¦¾à¦²à¦¾à¦°à¦®à¦¾à¦°à¦›à§œà¦¾'),(3375,202,'Kutubjum','à¦•à§à¦¤à§à¦¬à¦œà§‹à¦®'),(3376,202,'Matarbari','à¦®à¦¾à¦¤à¦¾à¦°à¦¬à¦¾à§œà§€'),(3377,202,'Shaplapur','à¦¶à¦¾à¦ªà¦²à¦¾à¦ªà§à¦°'),(3378,203,'Barabakia','à¦¬à§œ à¦¬à¦¾à¦•à¦¿à§Ÿà¦¾'),(3379,203,'Magnama','à¦®à¦—à¦¨à¦¾à¦®à¦¾'),(3380,203,'Pekua','à¦ªà§‡à¦•à§à§Ÿà¦¾'),(3381,203,'Rajakhali','à¦°à¦¾à¦œà¦¾à¦–à¦¾à¦²à§€'),(3382,203,'Shilkhali','à¦¶à§€à¦²à¦–à¦¾à¦²à§€'),(3383,203,'Taitong','à¦Ÿà¦¾à¦‡à¦Ÿà¦‚'),(3384,203,'Ujantia','à¦‰à¦œà¦¾à¦¨à¦Ÿà¦¿à§Ÿà¦¾'),(3385,204,'Chakmarkul','à¦šà¦¾à¦•à¦®à¦¾à¦°à¦•à§à¦²'),(3386,204,'Dakkhinmithachhari','à¦¦à¦•à§à¦·à¦¿à¦£ à¦®à¦¿à¦ à¦¾à¦›à¦¡à¦¼à¦¿'),(3387,204,'Eidghar','à¦ˆà¦¦à¦—à¦¡à¦¼'),(3388,204,'Fotekharkul','à¦«à¦¤à§‡à¦–à¦¾à¦à¦°à¦•à§à¦²'),(3389,204,'Garjoniya','à¦—à¦°à§à¦œà¦¨à¦¿à¦¯à¦¼à¦¾'),(3390,204,'Jouarianala','à¦œà§‹à¦¯à¦¼à¦¾à¦°à¦¿à¦¯à¦¼à¦¾ à¦¨à¦¾à¦²à¦¾'),(3391,204,'Kacchapia','à¦•à¦šà§à¦›à¦ªà¦¿à¦¯à¦¼à¦¾'),(3392,204,'Kauwarkho','à¦•à¦¾à¦‰à¦¯à¦¼à¦¾à¦°à¦–à§‹à¦ª'),(3393,204,'Khuniapalong','à¦–à§à¦¨à¦¿à¦¯à¦¼à¦¾à¦ªà¦¾à¦²à¦‚'),(3394,204,'Rajarkul','à¦°à¦¾à¦œà¦¾à¦°à¦•à§à¦²'),(3395,204,'Rashidnagar','à¦°à¦¶à§€à¦¦à¦¨à¦—à¦°'),(3396,205,'Baharchara','à¦¬à¦¾à¦¹à¦¾à¦°à¦›à§œà¦¾'),(3397,205,'Hnila','à¦¹à§à¦¨à§€à¦²à¦¾'),(3398,205,'Saintmartin','à¦¸à§‡à¦¨à§à¦Ÿ à¦®à¦¾à¦°à§à¦Ÿà¦¿à¦¨'),(3399,205,'Subrang','à¦¸à¦¾à¦¬à¦°à¦¾à¦‚'),(3400,205,'Teknafsadar','à¦Ÿà§‡à¦•à¦¨à¦¾à¦« à¦¸à¦¦à¦°'),(3401,205,'Whykong','à¦¹à§‹à§Ÿà¦¾à¦‡à¦•à§à¦¯à¦‚'),(3402,331,'Bahirdiamansa','à¦¬à¦¾à¦¹à¦¿à¦°à¦¦à¦¿à§Ÿà¦¾-à¦®à¦¾à¦¨à¦¸à¦¾'),(3403,331,'Betaga','à¦¬à§‡à¦¤à¦¾à¦—à¦¾'),(3404,331,'Fakirhat','à¦«à¦•à¦¿à¦°à¦¹à¦¾à¦Ÿ'),(3405,331,'Lakhpur','à¦²à¦–à¦ªà§à¦°'),(3406,331,'Mulghar','à¦®à§‚à¦²à¦˜à¦°'),(3407,331,'Naldhamauvhog','à¦¨à¦²à¦§à¦¾-à¦®à§Œà¦­à§‹à¦—'),(3408,331,'Piljanga','à¦ªà¦¿à¦²à¦œà¦‚à¦—'),(3409,331,'Suvhadia','à¦¶à§à¦­à¦¦à¦¿à§Ÿà¦¾'),(3410,10,'Bamorta','à¦¬à§‡à¦®à¦°à¦¤à¦¾'),(3411,10,'Baruipara','à¦¬à¦¾à¦°à§à¦‡à¦ªà¦¾à§œà¦¾'),(3412,10,'Bishnapur','à¦¬à¦¿à¦·à§à¦£à§à¦ªà§à¦°'),(3413,10,'Dema','à¦¡à§‡à¦®à¦¾'),(3414,10,'Gotapara','à¦—à§‹à¦Ÿà¦¾à¦ªà¦¾à§œà¦¾'),(3415,10,'Jatharapur','à¦¯à¦¾à¦¤à§à¦°à¦¾à¦ªà§à¦°'),(3416,10,'Karapara','à¦•à¦¾à§œà¦¾à¦ªà¦¾à§œà¦¾'),(3417,10,'Khanpur','à¦–à¦¾à¦¨à¦ªà§à¦°'),(3418,10,'Rakhalgachi','à¦°à¦¾à¦–à¦¾à¦²à¦—à¦¾à¦›à¦¿'),(3419,10,'Shaitgomboj','à¦·à¦¾à¦Ÿà¦—à§à¦®à§à¦¬à¦œ'),(3420,333,'Atjuri','à¦†à¦Ÿà¦œà§à§œà§€'),(3421,333,'Chunkhola','à¦šà§à¦¨à¦–à§‹à¦²à¦¾'),(3422,333,'Gangni','à¦—à¦¾à¦‚à¦¨à§€'),(3423,333,'Gaola','à¦—à¦¾à¦“à¦²à¦¾'),(3424,333,'Kodalia','à¦•à§‹à¦¦à¦¾à¦²à¦¿à§Ÿà¦¾'),(3425,333,'Kulia','à¦•à§à¦²à¦¿à§Ÿà¦¾'),(3426,333,'Udoypur','à¦‰à¦¦à§Ÿà¦ªà§à¦°'),(3427,334,'Dhanshagor','à¦§à¦¾à¦¨à¦¸à¦¾à¦—à¦°'),(3428,334,'Khontakata','à¦–à§‹à¦¨à§à¦¤à¦¾à¦•à¦¾à¦Ÿà¦¾'),(3429,334,'Rayenda','à¦°à¦¾à§Ÿà§‡à¦¨à§à¦¦à¦¾'),(3430,334,'Southkhali','à¦¸à¦¾à¦‰à¦¥à¦–à¦¾à¦²à§€'),(3431,335,'Baintala','à¦¬à¦¾à¦‡à¦¨à¦¤à¦²à¦¾'),(3432,335,'Bastoli','à¦¬à¦¾à¦à¦¶à¦¤à¦²à§€'),(3433,335,'Gouramva','à¦—à§Œà¦°à¦®à§à¦­à¦¾'),(3434,335,'Hurka','à¦¹à§à§œà¦•à¦¾'),(3435,335,'Mollikerbar','à¦®à¦²à§à¦²à¦¿à¦•à§‡à¦°à¦¬à§‡à§œ'),(3436,335,'Perikhali','à¦ªà§‡à§œà¦¿à¦–à¦¾à¦²à§€'),(3437,335,'Rajnagar','à¦°à¦¾à¦œà¦¨à¦—à¦°'),(3438,335,'Rampal','à¦°à¦¾à¦®à¦ªà¦¾à¦²'),(3439,335,'Uzzalkur','à¦‰à¦œà¦²à¦•à§à§œ'),(3440,335,'Vospatia','à¦­à§‹à¦œà¦ªà¦¾à¦¤à¦¿à§Ÿà¦¾'),(3441,336,'Baharbunia','à¦¬à¦¹à¦°à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(3442,336,'Balaibunia','à¦¬à¦²à¦‡à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(3443,336,'Banagram','à¦¬à¦¨à¦—à§à¦°à¦¾à¦®'),(3444,336,'Baraikhali','à¦¬à¦¾à¦°à¦‡à¦–à¦¾à¦²à§€'),(3445,336,'Chingrakhali','à¦šà¦¿à¦‚à§œà¦¾à¦–à¦¾à¦²à§€'),(3446,336,'Daibagnyahati','à¦¦à§ˆà¦¬à¦œà§à¦žà¦¹à¦¾à¦Ÿà¦¿'),(3447,336,'Hoglabunia','à¦¹à§‹à¦—à¦²à¦¾à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(3448,336,'Hoglapasha','à¦¹à§‹à¦—à¦²à¦¾à¦ªà¦¾à¦¶à¦¾'),(3449,336,'Jiudhara','à¦œà¦¿à¦‰à¦§à¦°à¦¾'),(3450,336,'Khaulia','à¦–à¦¾à¦‰à¦²à¦¿à§Ÿà¦¾'),(3451,336,'Morrelganj','à¦®à§‹à§œà§‡à¦²à¦—à¦žà§à¦œ'),(3452,336,'Nishanbaria','à¦¨à¦¿à¦¶à¦¾à¦¨à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3453,336,'Panchakaran','à¦ªà¦žà§à¦šà¦•à¦°à¦£'),(3454,336,'Putikhali','à¦ªà§à¦Ÿà¦¿à¦–à¦¾à¦²à§€'),(3455,336,'Ramchandrapur','à¦°à¦¾à¦®à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(3456,336,'Teligati','à¦¤à§‡à¦²à¦¿à¦—à¦¾à¦¤à§€'),(3457,172,'Badhal','à¦¬à¦¾à¦§à¦¾à¦²'),(3458,172,'Dhopakhali','à¦§à§‹à¦ªà¦¾à¦–à¦¾à¦²à§€'),(3459,172,'Gojalia','à¦—à¦œà¦¾à¦²à¦¿à§Ÿà¦¾'),(3460,172,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3461,172,'Kachua','à¦•à¦šà§à§Ÿà¦¾'),(3462,172,'Moghia','à¦®à¦˜à¦¿à§Ÿà¦¾'),(3463,172,'Raripara','à¦°à¦¾à§œà§€à¦ªà¦¾à§œà¦¾'),(3464,338,'Burrirdangga','à¦¬à§à§œà¦¿à¦°à¦¡à¦¾à¦™à§à¦—à¦¾'),(3465,338,'Chadpai','à¦šà¦¾à¦à¦¦à¦ªà¦¾à¦‡'),(3466,338,'Chila','à¦šà¦¿à¦²à¦¾'),(3467,338,'Mithakhali','à¦®à¦¿à¦ à¦¾à¦–à¦¾à¦²à§€'),(3468,338,'Sonailtala','à¦¸à§‹à¦¨à¦¾à¦‡à¦²à¦¤à¦²à¦¾'),(3469,338,'Sundarban','à¦¸à§à¦¨à§à¦¦à¦°à¦¬à¦¨'),(3470,339,'Barobaria','à¦¬à§œà¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3471,339,'Charbaniri','à¦šà¦°à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦°à§€'),(3472,339,'Chitalmari','à¦šà¦¿à¦¤à¦²à¦®à¦¾à¦°à§€'),(3473,339,'Hizla','à¦¹à¦¿à¦œà¦²à¦¾'),(3474,339,'Kalatala','à¦•à¦²à¦¾à¦¤à¦²à¦¾'),(3475,339,'Shantoshpur','à¦¸à¦¨à§à¦¤à§‹à¦·à¦ªà§à¦°'),(3476,339,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(3477,10,'Bandarbansadar','à¦¬à¦¾à¦¨à§à¦¦à¦°à¦¬à¦¾à¦¨ à¦¸à¦¦à¦°'),(3478,10,'Kuhalong','à¦•à§à¦¹à¦¾à¦²à¦‚'),(3479,10,'Rajbila','à¦°à¦¾à¦œà¦¬à¦¿à¦²à¦¾'),(3480,10,'Suwalok','à¦¸à§à¦¯à¦¼à¦¾à¦²à¦•'),(3481,10,'Tongkaboty','à¦Ÿà¦‚à¦•à¦¾à¦¬à¦¤à§€'),(3482,10,'Golabari','à¦—à§‹à¦²à¦¾à¦¬à¦¾à§œà§€'),(3483,10,'Kamalchari','à¦•à¦®à¦²à¦›à§œà¦¿'),(3484,10,'Parachara','à¦ªà§‡à¦°à¦¾à¦›à§œà¦¾'),(3485,10,'Sadar','à¦–à¦¾à¦—à¦°à¦¾à¦›à§œà¦¿ à¦¸à¦¦à¦°'),(3486,10,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(3487,10,'Kodomtala','à¦•à¦¦à¦®à¦¤à¦²à¦¾'),(3488,10,'Kolakhali','à¦•à¦²à¦¾à¦–à¦¾à¦²à§€'),(3489,10,'Shankorpasa','à¦¶à¦‚à¦•à¦°à¦ªà¦¾à¦¶à¦¾'),(3490,10,'Shariktola','à¦¶à¦°à¦¿à¦•à¦¤à¦²à¦¾'),(3491,10,'Shikdermallik','à¦¶à¦¿à¦•à¦¦à¦¾à¦° à¦®à¦²à§à¦²à¦¿à¦•'),(3492,10,'Tona','à¦Ÿà§‹à¦¨à¦¾'),(3493,358,'Daulbaridobra','à¦¦à§‡à¦‰à¦²à¦¬à¦¾à¦¡à¦¼à§€ à¦¦à§‹à¦¬à¦¡à¦¼à¦¾'),(3494,358,'Dirgha','à¦¦à§€à¦°à§à¦˜à¦¾'),(3495,358,'Kolardoania','à¦•à¦²à¦¾à¦°à¦¦à§‹à¦¯à¦¼à¦¾à¦¨à¦¿à¦¯à¦¼à¦¾'),(3496,358,'Malikhali','à¦®à¦¾à¦²à¦¿à¦–à¦¾à¦²à§€'),(3497,358,'Mativangga','à¦®à¦¾à¦Ÿà¦¿à¦­à¦¾à¦‚à¦—à¦¾'),(3498,358,'Nazirpursadar','à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦° à¦¸à¦¦à¦°'),(3499,358,'Shakharikathi','à¦¶à¦¾à¦–à¦¾à¦°à§€à¦•à¦¾à¦ à§€'),(3500,358,'Shakhmatia','à¦¸à§‡à¦–à¦®à¦¾à¦Ÿà¦¿à¦¯à¦¼à¦¾'),(3501,358,'Sriramkathi','à¦¶à§à¦°à§€à¦°à¦¾à¦®à¦•à¦¾à¦ à§€'),(3502,155,'Amrazuri','à¦†à¦®à¦¡à¦¼à¦¾à¦œà§à¦¡à¦¼à¦¿'),(3503,155,'Chirapara','à¦šà¦¿à¦°à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(3504,155,'Kawkhalisadar','à¦•à¦¾à¦‰à¦–à¦¾à¦²à¦¿ à¦¸à¦¦à¦°'),(3505,155,'Saynarogunathpur','à¦¸à¦¯à¦¼à¦¨à¦¾ à¦°à¦˜à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(3506,155,'Shialkhathi','à¦¶à¦¿à¦¯à¦¼à¦¾à¦²à¦•à¦¾à¦ à§€'),(3507,360,'Balipara','à¦¬à¦¾à¦²à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(3508,360,'Parerhat','à¦ªà¦¾à¦¡à¦¼à§‡à¦°à¦¹à¦¾à¦Ÿ'),(3509,360,'Pattashi','à¦ªà¦¤à§à¦¤à¦¾à¦¶à¦¿'),(3510,361,'Dhaoa','à¦§à¦¾à¦“à¦¯à¦¼à¦¾'),(3511,361,'Ekree','à¦‡à¦•à¦¡à¦¼à§€'),(3512,361,'Gouripur','à¦—à§Œà¦°à§€à¦ªà§à¦°'),(3513,361,'Nodmulla','à¦¨à¦¦à¦®à§‚à¦²à¦¾ à¦¶à¦¿à¦¯à¦¼à¦¾à¦²à¦•à¦¾à¦ à§€'),(3514,361,'Telikhali','à¦¤à§‡à¦²à¦¿à¦–à¦¾à¦²à§€'),(3515,361,'Vandariasadar','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦¿à¦¯à¦¼à¦¾ à¦¸à¦¦à¦°'),(3516,361,'Vitabaria','à¦­à¦¿à¦Ÿà¦¾à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(3517,362,'Amragachia','à¦†à¦®à¦¡à¦¼à¦¾à¦—à¦¾à¦›à¦¿à¦¯à¦¼à¦¾'),(3518,362,'Baramasua','à¦¬à¦¡à¦¼à¦®à¦¾à¦›à§à¦¯à¦¼à¦¾'),(3519,362,'Betmorrajpara','à¦¬à§‡à¦¤à¦®à§‹à¦° à¦°à¦¾à¦œà¦ªà¦¾à¦¡à¦¼à¦¾'),(3520,362,'Daudkhali','à¦¦à¦¾à¦‰à¦¦à¦–à¦¾à¦²à§€'),(3521,362,'Dhanisafa','à¦§à¦¾à¦¨à§€à¦¸à¦¾à¦«à¦¾'),(3522,362,'Haltagulishakhali','à¦¹à¦²à¦¤à¦¾à¦—à§à¦²à¦¿à¦¶à¦¾à¦–à¦¾à¦²à§€'),(3523,362,'Mathbaria','à¦®à¦ à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(3524,362,'Mirukhali','à¦®à¦¿à¦°à§à¦–à¦¾à¦²à§€'),(3525,362,'Shapleza','à¦¶à¦¾à¦ªà¦²à§‡à¦œà¦¾'),(3526,362,'Tikikata','à¦Ÿà¦¿à¦•à¦¿à¦•à¦¾à¦Ÿà¦¾'),(3527,362,'Tuskhali','à¦¤à§à¦·à¦–à¦¾à¦²à§€'),(3528,363,'Atghorkuriana','à¦†à¦Ÿà¦˜à¦° à¦•à§à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾à¦¨à¦¾'),(3529,363,'Boldia','à¦¬à¦²à¦¦à¦¿à¦¯à¦¼à¦¾'),(3530,363,'Doyhary','à¦¦à§ˆà¦¹à¦¾à¦°à§€'),(3531,363,'Guarekha','à¦—à§à¦¯à¦¼à¦¾à¦°à§‡à¦–à¦¾'),(3532,363,'Jolabari','à¦œà¦²à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(3533,363,'Sarengkathi','à¦¸à¦¾à¦°à§‡à¦‚à¦•à¦¾à¦ à§€'),(3534,363,'Shorupkathi','à¦¸à§à¦¬à¦°à§à¦ªà¦•à¦¾à¦ à§€'),(3535,363,'Sohagdal','à¦¸à§‹à¦¹à¦¾à¦—à¦¦à¦²'),(3536,363,'Somudoykathi','à¦¸à¦®à§à¦¦à¦¯à¦¼à¦•à¦¾à¦ à§€'),(3537,363,'Sutiakathi','à¦¸à§à¦Ÿà¦¿à¦¯à¦¼à¦¾à¦•à¦¾à¦ à§€'),(3538,207,'Babuchara','à¦¬à¦¾à¦¬à§à¦›à§œà¦¾'),(3539,207,'Boalkhali','à¦¬à§‹à§Ÿà¦¾à¦²à¦–à¦¾à¦²à§€'),(3540,207,'Dighinala','à¦¦à¦¿à¦˜à§€à¦¨à¦¾à¦²à¦¾'),(3541,207,'Kabakhali','à¦•à¦¬à¦¾à¦–à¦¾à¦²à§€'),(3542,207,'Merung','à¦®à§‡à¦°à§à¦‚'),(3543,208,'Changi','à¦šà§‡à¦‚à¦—à§€'),(3544,208,'Latiban','à¦²à¦¤à¦¿à¦¬à¦¾à¦¨'),(3545,208,'Logang','à¦²à§‹à¦—à¦¾à¦‚'),(3546,208,'Panchari','à¦ªà¦¾à¦¨à¦›à§œà¦¿'),(3547,209,'Barmachari','à¦¬à¦°à§à¦®à¦¾à¦›à§œà¦¿'),(3548,209,'Dullyatali','à¦¦à§à¦²à§à¦¯à¦¾à¦¤à¦²à§€'),(3549,209,'Laxmichhari','à¦²à¦•à§à¦·à§€à¦›à§œà¦¿'),(3550,210,'Bhaibonchara','à¦­à¦¾à¦‡à¦¬à§‹à¦¨à¦›à§œà¦¾'),(3551,210,'Kayanghat','à¦•à§à¦¯à¦¾à§Ÿà¦¾à¦‚à¦˜à¦¾à¦Ÿ'),(3552,210,'Mahalchari','à¦®à¦¹à¦¾à¦²à¦›à§œà¦¿'),(3553,210,'Maischari','à¦®à¦¾à¦‡à¦¸à¦›à§œà¦¿'),(3554,210,'Mobachari','à¦®à§à¦¬à¦¾à¦›à§œà¦¿'),(3555,211,'Batnatali','à¦¬à¦¾à¦Ÿà¦¨à¦¾à¦¤à¦²à§€'),(3556,211,'Jogyachola','à¦¯à§‹à¦—à§à¦¯à¦›à§‹à¦²à¦¾'),(3557,211,'Manikchari','à¦®à¦¾à¦¨à¦¿à¦•à¦›à§œà¦¿'),(3558,211,'Tintahari','à¦¤à¦¿à¦¨à¦Ÿà¦¹à¦°à§€'),(3559,10,'Dogachhi','à¦¦à§‹à¦—à¦¾à¦›à¦¿'),(3560,10,'Furshondi','à¦«à§à¦°à¦¸à¦¨à§à¦¦à¦¿'),(3561,10,'Ganna','à¦—à¦¾à¦¨à§à¦¨à¦¾'),(3562,10,'Ghorshal','à¦˜à§‹à§œà¦¶à¦¾à¦²'),(3563,10,'Halidhani','à¦¹à¦²à¦¿à¦§à¦¾à¦¨à§€'),(3564,10,'Harishongkorpur','à¦¹à¦°à¦¿à¦¶à¦‚à¦•à¦°à¦ªà§à¦°'),(3565,10,'Kalicharanpur','à¦•à¦¾à¦²à§€à¦šà¦°à¦£à¦ªà§à¦°'),(3566,10,'Kumrabaria','à¦•à§à¦®à§œà¦¾à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(3567,10,'Maharazpur','à¦®à¦¹à¦¾à¦°à¦¾à¦œà¦ªà§à¦°'),(3568,10,'Modhuhati','à¦®à¦§à§à¦¹à¦¾à¦Ÿà§€'),(3569,10,'Naldanga','à¦¨à¦²à¦¡à¦¾à¦™à§à¦—à¦¾'),(3570,10,'Padmakar','à¦ªà¦¦à§à¦®à¦¾à¦•à¦°'),(3571,10,'Paglakanai','à¦ªà¦¾à¦—à¦²à¦¾à¦•à¦¾à¦¨à¦¾à¦‡'),(3572,10,'Porahati','à¦ªà§‹à§œà¦¾à¦¹à¦¾à¦Ÿà§€'),(3573,10,'Sadhuhati','à¦¸à¦¾à¦§à§à¦¹à¦¾à¦Ÿà§€'),(3574,10,'Saganna','à¦¸à¦¾à¦—à¦¾à¦¨à§à¦¨à¦¾'),(3575,10,'Surat','à¦¸à§à¦°à¦¾à¦Ÿ'),(3576,341,'Abaipur','à¦†à¦¬à¦¾à¦‡à¦ªà§à¦°'),(3577,341,'Bogura','à¦¬à¦—à§à§œà¦¾'),(3578,341,'Dhaloharachandra','à¦§à¦²à¦¹à¦°à¦¾à¦šà¦¨à§à¦¦à§à¦°'),(3579,341,'Dignagore','à¦¦à¦¿à¦—à¦¨à¦—à¦°'),(3580,341,'Dudshar','à¦¦à§à¦§à¦¸à¦°'),(3581,341,'Fulhari','à¦«à§à¦²à¦¹à¦°à¦¿'),(3582,341,'Hakimpur','à¦¹à¦¾à¦•à¦¿à¦®à¦ªà§à¦°'),(3583,341,'Kancherkol','à¦•à¦¾à¦à¦šà§‡à¦°à¦•à§‹à¦²'),(3584,341,'Manoharpur','à¦®à¦¨à§‹à¦¹à¦°à¦ªà§à¦°'),(3585,341,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(3586,341,'Nityanandapur','à¦¨à¦¿à¦¤à§à¦¯à¦¾à¦¨à¦¨à§à¦¦à¦ªà§à¦°'),(3587,341,'Sarutia','à¦¸à¦¾à¦°à§à¦Ÿà¦¿à§Ÿà¦¾'),(3588,341,'Tribeni','à¦¤à§à¦°à¦¿à¦¬à§‡à¦¨à§€'),(3589,341,'Umedpur','à¦‰à¦®à§‡à¦¦à¦ªà§à¦°'),(3590,342,'Bhayna','à¦­à¦¾à§Ÿà¦¨à¦¾'),(3591,342,'Chandpur','à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(3592,342,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(3593,342,'Falsi','à¦«à¦²à¦¸à§€'),(3594,342,'Joradah','à¦œà§‹à§œà¦¾à¦¦à¦¹'),(3595,342,'Kapashatia','à¦•à¦¾à¦ªà¦¾à¦¶à¦¹à¦¾à¦Ÿà¦¿à§Ÿà¦¾'),(3596,342,'Raghunathpur','à¦°à¦˜à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(3597,342,'Taherhuda','à¦¤à¦¾à¦¹à§‡à¦°à¦¹à§à¦¦à¦¾'),(3598,7,'Barabazar','à¦¬à¦¾à¦°à¦¬à¦¾à¦œà¦¾à¦°'),(3599,7,'Jamal','à¦œà¦¾à¦®à¦¾à¦²'),(3600,7,'Kashtabhanga','à¦•à¦¾à¦·à§à¦Ÿà¦­à¦¾à¦™à§à¦—à¦¾'),(3601,7,'Kola','à¦•à§‹à¦²à¦¾'),(3602,7,'Maliat','à¦®à¦¾à¦²à¦¿à§Ÿà¦¾à¦Ÿ'),(3603,7,'Niamatpur','à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦ªà§à¦°'),(3604,7,'Rakhalgachhi','à¦°à¦¾à¦–à¦¾à¦²à¦—à¦¾à¦›à¦¿'),(3605,7,'Raygram','à¦°à¦¾à§Ÿà¦—à§à¦°à¦¾à¦®'),(3606,7,'Simlarokonpur','à¦¶à¦¿à¦®à¦²à¦¾-à¦°à§‹à¦•à¦¨à¦ªà§à¦°'),(3607,7,'Sundarpurdurgapur','à¦¸à§à¦¨à§à¦¦à¦°à¦ªà§à¦°-à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(3608,7,'Trilochanpur','à¦¤à§à¦°à¦¿à¦²à§‹à¦šà¦¨à¦ªà§à¦°'),(3609,344,'Baluhar','à¦¬à¦²à§à¦¹à¦°'),(3610,344,'Dora','à¦¦à§‹à§œà¦¾'),(3611,344,'Elangi','à¦à¦²à¦¾à¦™à§à¦—à§€'),(3612,344,'Kushna','à¦•à§à¦¶à¦¨à¦¾'),(3613,344,'Sabdalpur','à¦¸à¦¾à¦¬à¦¦à¦¾à¦²à¦ªà§à¦°'),(3614,345,'Azampur','à¦†à¦œà¦®à¦ªà§à¦°'),(3615,345,'Banshbaria','à¦¬à¦¾à¦à¦¶à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(3616,345,'Fatepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(3617,345,'Jadabpur','à¦¯à¦¾à¦¦à¦¬à¦ªà§à¦°'),(3618,345,'Kazirber','à¦•à¦¾à¦œà§€à¦°à¦¬à§‡à§œ'),(3619,345,'Manderbaria','à¦®à¦¾à¦¨à§à¦¦à¦¾à¦°à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(3620,345,'Natima','à¦¨à¦¾à¦Ÿà¦¿à¦®à¦¾'),(3621,345,'Nepa','à¦¨à§‡à¦ªà¦¾'),(3622,345,'Panthapara','à¦ªà¦¾à¦¨à§à¦¥à¦ªà¦¾à§œà¦¾'),(3623,345,'Sbk','à¦à¦¸, à¦¬à¦¿, à¦•à§‡'),(3624,345,'Shyamkur','à¦¶à§à¦¯à¦¾à¦®à¦•à§à§œ'),(3625,345,'Swaruppur','à¦¸à§à¦¬à¦°à§à¦ªà¦ªà§à¦°'),(3626,212,'Hafchari','à¦¹à¦¾à¦«à¦›à§œà¦¿'),(3627,212,'Patachara','à¦ªà¦¾à¦¤à¦¾à¦›à§œà¦¾'),(3628,212,'Ramgarh','à¦°à¦¾à¦®à¦—à§œ'),(3629,213,'Amtali','à¦†à¦®à¦¤à¦²à¦¿'),(3630,213,'Balchari','à¦¬à§‡à¦²à¦›à§œà¦¿'),(3631,213,'Barnal','à¦¬à¦°à§à¦£à¦¾à¦²'),(3632,213,'Gomti','à¦—à§‹à¦®à¦¤à¦¿'),(3633,213,'Guimara','à¦—à§à¦‡à¦®à¦¾à¦°à¦¾'),(3634,213,'Matiranga','à¦®à¦¾à¦Ÿà¦¿à¦°à¦¾à¦™à§à¦—à¦¾'),(3635,213,'Tabalchari','à¦¤à¦¬à¦²à¦›à§œà¦¿'),(3636,213,'Taindong','à¦¤à¦¾à¦‡à¦¨à§à¦¦à¦‚'),(3637,215,'Alikadamsadar','à¦†à¦²à§€à¦•à¦¦à¦® à¦¸à¦¦à¦° '),(3638,215,'Chwekhyong','à¦šà§ˆà¦•à§à¦·à§à¦¯à¦‚ '),(3639,216,'Baishari','à¦¬à¦¾à¦‡à¦¶à¦¾à¦°à§€'),(3640,216,'Duwchari','à¦¦à§‹à¦›à¦¡à¦¼à¦¿'),(3641,216,'Gumdhum','à¦˜à§à¦®à¦§à§à¦®'),(3642,216,'Naikhyongcharisadar','à¦¨à¦¾à¦‡à¦•à§à¦·à§à¦¯à¦‚à¦›à¦¡à¦¼à¦¿ à¦¸à¦¦à¦°'),(3643,216,'Sonaychari','à¦¸à§‹à¦¨à¦¾à¦‡à¦›à¦¡à¦¼à¦¿'),(3644,217,'Alekyong','à¦†à¦²à§‡à¦•à§à¦·à§à¦¯à¦‚'),(3645,217,'Nawapotong','à¦¨à§‹à§Ÿà¦¾à¦ªà¦¤à¦‚'),(3646,217,'Rowangcharisadar','à¦°à§‹à§Ÿà¦¾à¦‚à¦›à§œà¦¿ à¦¸à¦¦à¦°'),(3647,217,'Taracha','à¦¤à¦¾à¦°à¦¾à¦›à¦¾'),(3648,218,'Aziznagar','à¦†à¦œà¦¿à¦œà¦¨à¦—à¦°'),(3649,218,'Fasiakhali','à¦«à¦¾à¦¸à¦¿à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€'),(3650,218,'Fythong','à¦«à¦¾à¦‡à¦¤à¦‚'),(3651,218,'Gajalia','à¦—à¦œà¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(3652,218,'Lamasadar','à¦²à¦¾à¦®à¦¾ à¦¸à¦¦à¦°'),(3653,218,'Rupushipara','à¦°à§‚à¦ªà¦¸à§€à¦ªà¦¾à¦¡à¦¼à¦¾'),(3654,218,'Sarai','à¦¸à¦°à¦‡'),(3655,219,'Galanggya','à¦—à§à¦¯à¦¾à¦²à§‡à¦‚à¦—à§à¦¯à¦¾ '),(3656,219,'Paind','à¦ªà¦¾à¦‡à¦¨à§à¦¦à§ '),(3657,219,'Ramakreprangsa','à¦°à§‡à¦®à¦¾à¦•à§à¦°à§€à¦ªà§à¦°à¦¾à¦‚à¦¸à¦¾ '),(3658,219,'Rumasadar','à¦°à§à¦®à¦¾ à¦¸à¦¦à¦° '),(3659,220,'Balipara','à¦¬à¦²à¦¿à¦ªà¦¾à§œà¦¾ '),(3660,220,'Remakre','à¦°à§‡à¦®à¦¾à¦•à§à¦°à§€ '),(3661,220,'Thanchisadar','à¦¥à¦¾à¦¨à¦šà¦¿ à¦¸à¦¦à¦° '),(3662,220,'Tind','à¦¤à¦¿à¦¨à§à¦¦à§ '),(3663,184,'Betagi','à¦¬à§‡à¦¤à¦¾à¦—à§€'),(3664,184,'Chandraghona','à¦šà¦¨à§à¦¦à§à¦°à¦˜à§‹à¦¨à¦¾'),(3665,184,'Hosnabad','à¦¹à§‹à¦›à¦¨à¦¾à¦¬à¦¾à¦¦'),(3666,184,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(3667,184,'Kodala','à¦•à§‹à¦¦à¦¾à¦²à¦¾'),(3668,184,'Lalanagar','à¦²à¦¾à¦²à¦¾à¦¨à¦—à¦°'),(3669,184,'Mariumnagar','à¦®à¦°à¦¿à§Ÿà¦®à¦¨à¦—à¦°'),(3670,184,'Parua','à¦ªà¦¾à¦°à§à§Ÿà¦¾'),(3671,184,'Pomra','à¦ªà§‹à¦®à¦°à¦¾'),(3672,184,'Rajanagar','à¦°à¦¾à¦œà¦¾à¦¨à¦—à¦°'),(3673,184,'Sharafbhata','à¦¸à¦°à¦«à¦­à¦¾à¦Ÿà¦¾'),(3674,184,'Shilok','à¦¶à¦¿à¦²à¦•'),(3675,184,'Southrajanagar','à¦¦à¦•à§à¦·à¦¿à¦£ à¦°à¦¾à¦œà¦¾à¦¨à¦—à¦° '),(3676,184,'Swanirborrangunia','à¦¸à§à¦¬à¦¨à¦¿à¦°à§à¦­à¦° à¦°à¦¾à¦™à§à¦—à§à¦¨à¦¿à§Ÿà¦¾'),(3677,157,'Aimachara','à§© à¦¨à¦‚ à¦†à¦‡à¦®à¦¾à¦›à§œà¦¾'),(3678,157,'Barkal','à§¨ à¦¨à¦‚ à¦¬à¦°à¦•à¦²'),(3679,157,'Borohorina','à§« à¦¨à¦‚ à¦¬à§œ à¦¹à¦°à¦¿à¦£à¦¾'),(3680,157,'Bushanchara','à§ª à¦¨à¦‚ à¦­à§‚à¦·à¦¨à¦›à§œà¦¾'),(3681,157,'Subalong','à§§ à¦¨à¦‚ à¦¸à§à¦¬à¦²à¦‚'),(3682,158,'Atarakchara','à¦†à¦Ÿà¦¾à¦°à¦•à¦›à§œà¦¾'),(3683,158,'Bogachattar','à¦¬à¦—à¦¾à¦šà¦¤à¦°'),(3684,158,'Gulshakhali','à¦—à§à¦²à¦¶à¦¾à¦–à¦¾à¦²à§€'),(3685,158,'Kalapakujja','à¦•à¦¾à¦²à¦¾à¦ªà¦¾à¦•à§à¦œà§à¦¯à¦¾'),(3686,158,'Langad','à¦²à¦‚à¦—à¦¦à§'),(3687,158,'Maeinimukh','à¦®à¦¾à¦‡à¦¨à§€à¦®à§à¦–'),(3688,158,'Vasannadam','à¦­à¦¾à¦¸à¦¾à¦¨à§à¦¯à¦¾à¦¦à¦®'),(3689,159,'Bangalhalia','à§© à¦¨à¦‚ à¦¬à¦¾à¦™à§à¦—à¦¾à¦²à¦¹à¦¾à¦²à¦¿à§Ÿà¦¾'),(3690,159,'Gaindya','à§¨ à¦¨à¦‚ à¦—à¦¾à¦‡à¦¨à§à¦¦à§à¦¯à¦¾'),(3691,159,'Ghilachari','à§§ à¦¨à¦‚ à¦˜à¦¿à¦²à¦¾à¦›à§œà¦¿'),(3692,73,'Baliyati','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦Ÿà¦¿'),(3693,73,'Baried','à¦¬à¦°à¦¾à¦‡à¦¦'),(3694,73,'Dargram','à¦¦à§œà¦—à§à¦°à¦¾à¦®'),(3695,73,'Dhankora','à¦§à¦¾à¦¨à¦•à§‹à§œà¦¾'),(3696,73,'Dighulia','à¦¦à¦¿à¦˜à§à¦²à¦¿à§Ÿà¦¾'),(3697,73,'Fukurhati','à¦«à§à¦•à§à¦°à¦¹à¦¾à¦Ÿà¦¿'),(3698,73,'Hargaj','à¦¹à¦°à¦—à¦œ'),(3699,73,'Saturia','à¦¸à¦¾à¦Ÿà§à¦°à¦¿à§Ÿà¦¾'),(3700,73,'Tilli','à¦¤à¦¿à¦²à§à¦²à§€'),(3701,10,'Atigram','à¦†à¦Ÿà¦¿à¦—à§à¦°à¦¾à¦® '),(3702,10,'Betilamitara','à¦¬à§‡à¦¤à¦¿à¦²à¦¾-à¦®à¦¿à¦¤à¦°à¦¾ '),(3703,10,'Dighi','à¦¦à¦¿à¦˜à§€ '),(3704,10,'Garpara','à¦—à§œà¦ªà¦¾à§œà¦¾ '),(3705,10,'Hatipara','à¦¹à¦¾à¦Ÿà¦¿à¦ªà¦¾à§œà¦¾ '),(3706,10,'Jagir','à¦œà¦¾à¦—à§€à¦° '),(3707,10,'Krishnapur','à¦•à§ƒà¦žà§à¦šà¦ªà§à¦° '),(3708,10,'Nbogram','à¦¨à¦¬à¦—à§à¦°à¦¾à¦® '),(3709,10,'Putile','à¦ªà§à¦Ÿà¦¾à¦‡à¦² '),(3710,10,'Vararia','à¦­à¦¾à§œà¦¾à¦°à¦¿à§Ÿà¦¾ '),(3711,75,'Baliyakhora','à¦¬à¦¾à¦²à¦¿à§Ÿà¦¾à¦–à§‹à§œà¦¾ '),(3712,75,'Baniazuri','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦œà§à§œà§€'),(3713,75,'Bartia','à¦¬à§œà¦Ÿà¦¿à§Ÿà¦¾ '),(3714,75,'Gior','à¦˜à¦¿à¦“à¦° '),(3715,75,'Nalee','à¦¨à¦¾à¦²à§€'),(3716,75,'Paila','à¦ªà§Ÿà¦²à¦¾ '),(3717,75,'Shingzuri','à¦¸à¦¿à¦‚à¦œà§à§œà§€ '),(3718,76,'Aruoa','à¦†à¦°à§à§Ÿà¦¾ '),(3719,76,'Mohadebpur','à¦®à¦¹à¦¾à¦¦à§‡à¦¬à¦ªà§à¦°'),(3720,76,'Shibaloy','à¦¶à¦¿à¦¬à¦¾à¦²à§Ÿ '),(3721,76,'Shimulia','à¦¶à¦¿à¦®à§à¦²à¦¿à§Ÿà¦¾'),(3722,76,'Teota','à¦¤à§‡à¦“à¦¤à¦¾ '),(3723,76,'Ulayel','à¦‰à¦²à¦¾à¦‡à¦² '),(3724,76,'Utholi','à¦‰à¦¥à¦²à§€ '),(3725,77,'Bachamara','à¦¬à¦¾à¦šà¦¾à¦®à¦¾à¦°à¦¾'),(3726,77,'Baghutia','à¦¬à¦¾à¦˜à§à¦Ÿà¦¿à§Ÿà¦¾'),(3727,77,'Chakmirpur','à¦šà¦•à¦®à¦¿à¦°à¦ªà§à¦°'),(3728,77,'Charkataree','à¦šà¦°à¦•à¦¾à¦Ÿà¦¾à¦°à§€'),(3729,77,'Dhamswar','à¦§à¦¾à¦®à¦¶à§à¦¬à¦°'),(3730,77,'Khalshi','à¦–à¦²à¦¶à§€'),(3731,77,'Klia','à¦•à¦²à¦¿à§Ÿà¦¾'),(3732,77,'Zionpur','à¦œà¦¿à§Ÿà¦¨à¦ªà§à¦°'),(3733,78,'Baldhara','à¦¬à¦²à¦§à¦¾à¦°à¦¾'),(3734,78,'Buyra','à¦¬à¦¾à§Ÿà¦°à¦¾'),(3735,78,'Chandhar','à¦šà¦¾à¦¨à§à¦¦à¦¹à¦°'),(3736,78,'Charigram','à¦šà¦¾à¦°à¦¿à¦—à§à¦°à¦¾à¦®'),(3737,78,'Dhalla','à¦§à¦²à§à¦²à¦¾'),(3738,78,'Jamirta','à¦œà¦¾à¦°à§à¦®à¦¿à¦¤à¦¾'),(3739,78,'Joymonto','à¦œà§Ÿà¦®à¦¨à§à¦Ÿà¦ª'),(3740,78,'Shayesta','à¦¶à¦¾à§Ÿà§‡à¦¸à§à¦¤à¦¾'),(3741,78,'Singiar','à¦¸à¦¿à¦‚à¦—à¦¾à¦‡à¦°'),(3742,78,'Talebpur','à¦¤à¦¾à¦²à§‡à¦¬à¦ªà§à¦°'),(3743,78,'Zamsha','à¦œà¦¾à¦®à¦¶à¦¾'),(3744,68,'Bahadurabad','à§«à¦¨à¦‚ à¦¬à¦¾à¦¹à¦¾à¦¦à§à¦°à¦¾à¦¬à¦¾à¦¦'),(3745,68,'Charamkhawa','à§¨à¦¨à¦‚ à¦šà¦°à¦†à¦®à¦–à¦¾à¦“à¦¯à¦¼à¦¾'),(3746,68,'Chikajani','à§¬à¦¨à¦‚ à¦šà¦¿à¦•à¦¾à¦œà¦¾à¦¨à§€'),(3747,68,'Chukaibari','à§­ à¦¨à¦‚ à¦šà§à¦•à¦¾à¦‡à¦¬à¦¾à¦¡à¦¼à§€'),(3748,68,'Dewangonj','à§®à¦¨à¦‚ à¦¦à§‡à¦“à¦¯à¦¼à¦¾à¦¨à¦—à¦žà§à¦œ'),(3749,68,'Dungdhara','à§§à¦¨à¦‚ à¦¡à¦¾à¦‚à¦§à¦°à¦¾'),(3750,68,'Hatibanga','à§ªà¦¨à¦‚ à¦¹à¦¾à¦¤à§€à¦­à¦¾à¦™à§à¦—à¦¾'),(3751,68,'Parramrampur','à§©à¦¨à¦‚ à¦ªà¦¾à¦°à¦°à¦¾à¦® à¦°à¦¾à¦®à¦ªà§à¦°'),(3752,364,'Chandpura','à¦šà¦¾à¦à¦¦à¦ªà§à¦°à¦¾'),(3753,364,'Chandramohan','à¦šà¦¨à§à¦¦à§à¦°à¦®à§‹à¦¹à¦¨'),(3754,364,'Charbaria','à¦šà¦°à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3755,364,'Charcowa','à¦šà¦°à¦•à¦¾à¦‰à§Ÿà¦¾'),(3756,364,'Charmonai','à¦šà¦°à¦®à§‹à¦¨à¦¾à¦‡'),(3757,364,'Kashipur','à¦•à¦¾à¦¶à§€à¦ªà§à¦°'),(3758,364,'Raipashakarapur','à¦°à¦¾à§Ÿà¦ªà¦¾à¦¶à¦¾ à¦•à§œà¦¾à¦ªà§à¦°'),(3759,364,'Shyastabad','à¦¸à¦¾à§Ÿà§‡à¦¸à§à¦¤à¦¾à¦¬à¦¾à¦¦'),(3760,364,'Tungibaria','à¦Ÿà§à¦™à§à¦—à§€à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3761,364,'Zagua','à¦œà¦¾à¦—à§à§Ÿà¦¾'),(3762,365,'Bharpasha','à¦­à¦°à¦ªà¦¾à¦¶à¦¾'),(3763,365,'Charade','à¦šà¦°à¦¾à¦¦à¦¿'),(3764,365,'Charamaddi','à¦šà¦°à¦¾à¦®à¦¦à§à¦¦à¦¿'),(3765,365,'Darial','à¦¦à¦¾à§œà¦¿à§Ÿà¦¾à¦²'),(3766,365,'Dudhal','à¦¦à§à¦§à¦²'),(3767,365,'Durgapasha','à¦¦à§à¦°à§à¦—à¦¾à¦ªà¦¾à¦¶à¦¾'),(3768,365,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(3769,365,'Garuria','à¦—à¦¾à¦°à§à¦°à¦¿à§Ÿà¦¾'),(3770,365,'Kabai','à¦•à¦¬à¦¾à¦‡'),(3771,365,'Kalashkathi','à¦•à¦²à¦¸à¦•à¦¾à¦ à§€'),(3772,365,'Nalua','à¦¨à¦²à§à§Ÿà¦¾'),(3773,365,'Niamoti','à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦¿'),(3774,365,'Padreeshibpur','à¦ªà¦¾à¦¦à§à¦°à¦¿à¦¶à¦¿à¦¬à¦ªà§à¦°'),(3775,365,'Rangasree','à¦°à¦™à§à¦—à¦¶à§à¦°à§€'),(3776,366,'Chandpasha','à¦šà¦¾à¦à¦¦à¦ªà¦¾à¦¶à¦¾'),(3777,366,'Deherhoti','à¦¦à§‡à¦¹à§‡à¦°à¦—à¦¤à¦¿'),(3778,366,'Jahangirnagor','à¦œà¦¾à¦¹à¦¾à¦™à§à¦—à§€à¦° à¦¨à¦—à¦°'),(3779,366,'Kaderpur','à¦•à§‡à¦¦à¦¾à¦°à¦ªà§à¦°'),(3780,366,'Madhbpasha','à¦®à¦¾à¦§à¦¬à¦ªà¦¾à¦¶à¦¾'),(3781,366,'Rahamtpur','à¦°à¦¹à¦®à¦¤à¦ªà§à¦°'),(3782,367,'Bamrail','à¦¬à¦¾à¦®à¦°à¦¾à¦‡à¦²'),(3783,367,'Barakhota','à¦¬à¦°à¦¾à¦•à§‹à¦ à¦¾'),(3784,367,'Gouthia','à¦—à§à¦ à¦¿à§Ÿà¦¾'),(3785,367,'Harta','à¦¹à¦¾à¦°à¦¤à¦¾'),(3786,367,'Jalla','à¦œà¦²à§à¦²à¦¾'),(3787,367,'Otra','à¦“à¦Ÿà¦°à¦¾'),(3788,367,'Shatla','à¦¸à¦¾à¦¤à¦²à¦¾'),(3789,367,'Shikerpurwazirpur','à¦¶à¦¿à¦•à¦¾à¦°à¦ªà§à¦° à¦‰à¦œà¦¿à¦°à¦ªà§à¦°'),(3790,367,'Sholok','à¦¶à§‹à¦²à¦•'),(3791,368,'Baishari','à¦¬à¦¾à¦‡à¦¶à¦¾à¦°à§€'),(3792,368,'Banaripara','à¦¬à¦¾à¦¨à¦¾à¦°à¦¿à¦ªà¦¾à§œà¦¾'),(3793,368,'Bisharkandi','à¦¬à¦¿à¦¶à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3794,368,'Chakhar','à¦šà¦¾à¦–à¦¾à¦°'),(3795,368,'Illuhar','à¦‡à¦²à§à¦¹à¦¾à¦°'),(3796,368,'Saliabakpur','à¦¸à¦²à¦¿à§Ÿà¦¾à¦¬à¦¾à¦•à¦ªà§à¦°'),(3797,368,'Sayedkathi','à¦¸à§ˆà§Ÿà¦¦à¦•à¦¾à¦ à§€'),(3798,368,'Udykhati','à¦‰à¦¦à§Ÿà¦•à¦¾à¦ à§€'),(3799,369,'Barthi','à¦¬à¦¾à¦°à§à¦¥à§€'),(3800,369,'Batajore','à¦¬à¦¾à¦Ÿà¦¾à¦œà§‹à¦°'),(3801,369,'Chandshi','à¦šà¦¾à¦à¦¦à¦¶à§€'),(3802,369,'Khanjapur','à¦–à¦¾à¦žà§à¦œà¦¾à¦ªà§à¦°'),(3803,369,'Mahilara','à¦®à¦¾à¦¹à¦¿à¦²à¦¾à¦°à¦¾'),(3804,369,'Nalchira','à¦¨à¦²à¦šà¦¿à§œà¦¾'),(3805,369,'Sarikal','à¦¸à¦°à¦¿à¦•à¦²'),(3806,370,'Bagdha','à¦¬à¦¾à¦—à¦§à¦¾'),(3807,370,'Bakal','à¦¬à¦¾à¦•à¦¾à¦²'),(3808,370,'Goila','à¦—à§ˆà¦²à¦¾'),(3809,370,'Rajihar','à¦°à¦¾à¦œà¦¿à¦¹à¦¾à¦°'),(3810,370,'Ratnapur','à¦°à¦¤à§à¦¨à¦ªà§à¦°'),(3811,371,'Alimabad','à¦†à¦²à¦¿à¦®à¦¾à¦¬à¦¾à¦¦'),(3812,371,'Andarmanik','à¦†à¦¨à§à¦¦à¦¾à¦°à¦®à¦¾à¦¨à¦¿à¦•'),(3813,371,'Bhashanchar','à¦­à¦¾à¦·à¦¾à¦¨à¦šà¦°'),(3814,371,'Biddanandapur','à¦¬à¦¿à¦¦à§à¦¯à¦¾à¦¨à¦¨à§à¦¦à¦¨à¦ªà§à¦°'),(3815,371,'Chandpur','à¦šà¦¾à¦¨à¦ªà§à¦°'),(3816,371,'Charakkorea','à¦šà¦°à¦à¦•à¦•à¦°à¦¿à§Ÿà¦¾'),(3817,371,'Chargopalpur','à¦šà¦°à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3818,371,'Darircharkhajuria','à¦¦à§œà¦¿à¦°à¦šà¦° à¦–à¦¾à¦œà§à¦°à¦¿à§Ÿà¦¾'),(3819,371,'Gobindapur','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦ªà§à¦°'),(3820,371,'Jangalia','à¦œà¦¾à¦™à§à¦—à¦¾à¦²à¦¿à§Ÿà¦¾'),(3821,371,'Lata','à¦²à¦¤à¦¾'),(3822,371,'Mehendigong','à¦®à§‡à¦¹à§‡à¦¨à§à¦¦à¦¿à¦—à¦žà§à¦œ'),(3823,371,'Ulania','à¦‰à¦²à¦¾à¦¨à¦¿à§Ÿà¦¾'),(3824,372,'Batamara','à¦¬à¦¾à¦Ÿà¦¾à¦®à¦¾à¦°à¦¾'),(3825,372,'Charkalekha','à¦šà¦°à¦•à¦¾à¦²à§‡à¦–à¦¾'),(3826,372,'Gaschua','à¦—à¦¾à¦›à§à§Ÿà¦¾'),(3827,372,'Kazirchar','à¦•à¦¾à¦œà¦¿à¦°à¦šà¦°'),(3828,372,'Muladi','à¦®à§à¦²à¦¾à¦¦à§€'),(3829,372,'Nazirpur','à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°'),(3830,372,'Safipur','à¦¸à¦«à¦¿à¦ªà§à¦°'),(3831,373,'Barjalia','à¦¬à§œà¦œà¦¾à¦²à¦¿à§Ÿà¦¾'),(3832,373,'Dhulkhola','à¦§à§à¦²à¦–à§‹à¦²à¦¾'),(3833,373,'Guabaria','à¦—à§à§Ÿà¦¾à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(3834,373,'Harinathpur','à¦¹à¦°à¦¿à¦¨à¦¾à¦¥à¦ªà§à¦°'),(3835,373,'Hizlagourabdi','à¦¹à¦¿à¦œà¦²à¦¾ à¦—à§Œà¦°à¦¾à¦¬à§à¦¦à¦¿'),(3836,373,'Memania','à¦®à§‡à¦®à¦¾à¦¨à¦¿à§Ÿà¦¾'),(3837,69,'Aona','à§ªà¦¨à¦‚ à¦†à¦“à¦¨à¦¾'),(3838,69,'Bhatara','à§¬à¦¨à¦‚ à¦­à¦¾à¦Ÿà¦¾à¦°à¦¾'),(3839,69,'Doail','à§©à¦¨à¦‚ à¦¡à§‹à¦¯à¦¼à¦¾à¦‡à¦²'),(3840,69,'Kamrabad','à§­à¦¨à¦‚ à¦•à¦¾à¦®à¦°à¦¾à¦¬à¦¾à¦¦'),(3841,69,'Mahadan','à§®à¦¨à¦‚ à¦®à¦¹à¦¾à¦¦à¦¾à¦¨'),(3842,69,'Pingna','à§«à¦¨à¦‚ à¦ªà¦¿à¦‚à¦¨à¦¾'),(3843,69,'Pogaldigha','à§¨à¦¨à¦‚ à¦ªà§‹à¦—à¦²à¦¦à¦¿à¦˜à¦¾'),(3844,69,'Satpoa','à§§à¦¨à¦‚ à¦¸à¦¾à¦¤à¦ªà§‹à¦¯à¦¼à¦¾'),(3845,70,'Adarvita','à§¬à¦¨à¦‚ à¦†à¦¦à¦¾à¦°à¦­à¦¿à¦Ÿà¦¾'),(3846,70,'Balijuri','à§ªà¦¨à¦‚ à¦¬à¦¾à¦²à¦¿à¦œà§à¦¡à¦¼à§€'),(3847,70,'Charpakerdah','à§§ à¦¨à¦‚ à¦šà¦°à¦ªà¦¾à¦•à§‡à¦°à¦¦à¦¹'),(3848,70,'Gunaritala','à§©à¦¨à¦‚ à¦—à§à¦¨à¦¾à¦°à§€à¦¤à¦²à¦¾'),(3849,70,'Jorekhali','à§«à¦¨à¦‚ à¦œà§‹à¦¡à¦¼à¦–à¦¾à¦²à§€'),(3850,70,'Karaichara','à§¨à¦¨à¦‚ à¦•à¦¡à¦¼à¦‡à¦šà¦¡à¦¼à¦¾'),(3851,70,'Sidhuli','à§­à¦¨à¦‚ à¦¸à¦¿à¦§à§à¦²à§€'),(3852,71,'Bagarchar','à§¨à¦¨à¦‚ à¦¬à¦—à¦¾à¦°à¦šà¦°'),(3853,71,'Bakshigonj','à§«à¦¨à¦‚ à¦¬à¦•à¦¸à§€à¦—à¦žà§à¦œ'),(3854,71,'Battajore','à§©à¦¨à¦‚ à¦¬à¦¾à¦Ÿà§à¦°à¦¾à¦œà§‹à¦¡à¦¼'),(3855,71,'Danua','à§§ à¦¨à¦‚ à¦§à¦¾à¦¨à§à¦¯à¦¼à¦¾'),(3856,71,'Merurchar','à§­à¦¨à¦‚ à¦®à§‡à¦°à§à¦°à¦šà¦°'),(3857,71,'Nilakhia','à§¬à¦¨à¦‚ à¦¨à¦¿à¦²à¦•à§à¦·à¦¿à¦¯à¦¼à¦¾'),(3858,71,'Shadurpara','à§ªà¦¨à¦‚ à¦¸à¦¾à¦§à§à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(3859,10,'Andarchar','à¦†à¦¨à§à¦¡à¦¾à¦°à¦šà¦°'),(3860,10,'Ashwadia','à¦…à¦¶à§à¦¬à¦¦à¦¿à¦¯à¦¼à¦¾'),(3861,10,'Aujbalia','à¦à¦“à¦œà¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(3862,10,'Binodpur','à¦¬à¦¿à¦¨à§‹à¦¦à¦ªà§à¦°'),(3863,10,'Charmatua','à¦šà¦°à¦®à¦Ÿà§à¦¯à¦¼à¦¾'),(3864,10,'Dadpur','à¦¦à¦¾à¦¦à¦ªà§à¦°'),(3865,10,'Dharmapur','à¦§à¦°à§à¦®à¦ªà§à¦°'),(3866,10,'Eastcharmatua','à¦ªà§‚à¦°à§à¦¬ à¦šà¦°à¦®à¦Ÿà§à¦¯à¦¼à¦¾'),(3867,10,'Kadirhanif','à¦•à¦¾à¦¦à¦¿à¦° à¦¹à¦¾à¦¨à¦¿à¦«'),(3868,10,'Kaladara','à¦•à¦¾à¦²à¦¾à¦¦à¦°à¦ª'),(3869,10,'Newajpur','à¦¨à¦¿à¦¯à¦¼à¦¾à¦œà¦ªà§à¦°'),(3870,10,'Noakhali','à¦¨à§‹à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€'),(3871,10,'Noannoi','à¦¨à§‹à¦¯à¦¼à¦¾à¦¨à§à¦¨à¦‡'),(3872,164,'Charelahi','à¦šà¦°à¦à¦²à¦¾à¦¹à§€'),(3873,164,'Charfakira','à¦šà¦°à¦«à¦•à¦¿à¦°à¦¾'),(3874,164,'Charhazari','à¦šà¦°à¦¹à¦¾à¦œà¦¾à¦°à§€'),(3875,164,'Charkakra','à¦šà¦°à¦•à¦¾à¦à¦•à¦¡à¦¼à¦¾'),(3876,164,'Charparboti','à¦šà¦°à¦ªà¦¾à¦°à§à¦¬à¦¤à§€'),(3877,164,'Musapur','à¦®à§à¦¸à¦¾à¦ªà§à¦°'),(3878,164,'Rampur','à¦°à¦¾à¦®à¦ªà§à¦°'),(3879,164,'Sirajpur','à¦¸à¦¿à¦°à¦¾à¦œà¦ªà§à¦°'),(3880,165,'Alyearpur','à¦†à¦²à¦¾à¦‡à¦¯à¦¼à¦¾à¦°à¦ªà§à¦°'),(3881,165,'Amanullapur','à¦†à¦®à¦¾à¦¨à¦‰à¦²à§à¦²à§à¦¯à¦¾à¦ªà§à¦°'),(3882,165,'Begumganj','à¦¬à§‡à¦—à¦®à¦—à¦žà§à¦œ'),(3883,165,'Chayani','à¦›à¦¯à¦¼à¦¾à¦¨à§€'),(3884,165,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(3885,165,'Eklashpur','à¦à¦•à¦²à¦¾à¦¶à¦ªà§à¦°'),(3886,165,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(3887,165,'Hajipur','à¦¹à¦¾à¦œà§€à¦ªà§à¦°'),(3888,165,'Jirtali','à¦œà¦¿à¦°à¦¤à¦²à§€'),(3889,165,'Kadirpur','à¦•à¦¾à¦¦à¦¿à¦°à¦ªà§à¦°'),(3890,165,'Kutubpur','à¦•à§à¦¤à¦¬à¦ªà§à¦°'),(3891,165,'Mirwarishpur','à¦®à¦¿à¦°à¦“à¦¯à¦¼à¦¾à¦°à¦¿à¦¶à¦ªà§à¦°'),(3892,165,'Narottampur','à¦¨à¦°à§‹à¦¤à§à¦¤à¦®à¦ªà§à¦°'),(3893,165,'Rajganj','à¦°à¦¾à¦œà¦—à¦žà§à¦œ'),(3894,165,'Rasulpur','à¦°à¦¸à§à¦²à¦ªà§à¦°'),(3895,165,'Sharifpur','à¦¶à¦°à§€à¦«à¦ªà§à¦°'),(3896,380,'Amtali','à¦†à¦®à¦¤à¦²à§€'),(3897,380,'Arpangasia','à¦†à¦¡à¦¼à¦ªà¦¾à¦™à§à¦—à¦¾à¦¶à¦¿à¦¯à¦¼à¦¾'),(3898,380,'Athrogasia','à¦†à¦ à¦¾à¦°à¦—à¦¾à¦›à¦¿à¦¯à¦¼à¦¾'),(3899,380,'Chotobogi','à¦›à§‹à¦Ÿà¦¬à¦—à§€'),(3900,380,'Chowra','à¦šà¦¾à¦“à¦¡à¦¼à¦¾'),(3901,380,'Gulishakhali','à¦—à§à¦²à¦¿à¦¶à¦¾à¦–à¦¾à¦²à§€'),(3902,380,'Haldia','à¦¹à¦²à¦¦à¦¿à¦¯à¦¼à¦¾'),(3903,380,'Kukua','à¦•à§à¦•à§à¦¯à¦¼à¦¾'),(3904,138,'Gopal','à¦˜à§‹à¦ªà¦¾à¦²'),(3905,138,'Mohamaya','à¦®à¦¹à¦¾à¦®à¦¾à§Ÿà¦¾'),(3906,138,'Pathannagar','à¦ªà¦¾à¦ à¦¾à¦¨à¦¨à¦—à¦°'),(3907,138,'Radhanagar','à¦°à¦¾à¦§à¦¾à¦¨à¦—à¦°'),(3908,138,'Subhapur','à¦¶à§à¦­à¦ªà§à¦°'),(3909,10,'AylaPatakata','à¦†à¦¯à¦¼à¦²à¦¾ à¦ªà¦¾à¦¤à¦¾à¦•à¦¾à¦Ÿà¦¾'),(3910,10,'Barguna','à¦¬à¦°à¦—à§à¦¨à¦¾'),(3911,10,'Bodorkhali','à¦¬à¦¦à¦°à¦–à¦¾à¦²à§€'),(3912,10,'Burirchor','à¦¬à§à¦¡à¦¼à¦¿à¦°à¦šà¦°'),(3913,10,'Dhalua','à¦¢à¦²à§à¦¯à¦¼à¦¾'),(3914,10,'Fuljhuri','à¦«à§à¦²à¦à§à¦¡à¦¼à¦¿'),(3915,10,'Gowrichanna','à¦—à§Œà¦°à¦¿à¦šà¦¨à§à¦¨à¦¾'),(3916,10,'Keorabunia','à¦•à§‡à¦“à¦¡à¦¼à¦¾à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(3917,10,'M','à¦à¦®. à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦¤à¦²à§€'),(3918,10,'Noltona','à¦¨à¦²à¦Ÿà§‹à¦¨à¦¾'),(3919,382,'Betagi','à¦¬à§‡à¦¤à¦¾à¦—à§€'),(3920,382,'Bibichini','à¦¬à¦¿à¦¬à¦¿à¦šà¦¿à¦¨'),(3921,382,'Buramajumder','à¦¬à§à¦¡à¦¼à¦¾à¦®à¦œà§à¦®à¦¦à¦¾à¦°'),(3922,382,'Hosnabad','à¦¹à§‹à¦¸à¦¨à¦¾à¦¬à¦¾à¦¦'),(3923,382,'Kazirabad','à¦•à¦¾à¦œà§€à¦°à¦¾à¦¬à¦¾à¦¦'),(3924,382,'Mokamia','à¦®à§‹à¦•à¦¾à¦®à¦¿à¦¯à¦¼à¦¾'),(3925,382,'Sarisamuri','à¦¸à¦°à¦¿à¦·à¦¾à¦®à§à¦¡à¦¼à§€'),(3926,166,'Burirchar','à¦¬à§à¦¡à¦¼à¦¿à¦°à¦šà¦°'),(3927,166,'Charishwar','à¦šà¦°à¦ˆà¦¶à§à¦¬à¦°'),(3928,166,'Charking','à¦šà¦°à¦•à¦¿à¦‚'),(3929,166,'Jahajmara','à¦œà¦¾à¦¹à¦¾à¦œà¦®à¦¾à¦°à¦¾'),(3930,166,'Nijhumdwi','à¦¨à¦¿à¦à§à¦®à¦¦à§à¦¬à§€à¦ª'),(3931,166,'Nolchira','à¦¨à¦²à¦šà¦¿à¦°à¦¾'),(3932,166,'Sonadiya','à¦¸à§‹à¦¨à¦¾à¦¦à¦¿à¦¯à¦¼à¦¾'),(3933,166,'Sukhchar','à¦¸à§à¦–à¦šà¦°'),(3934,166,'Tomoroddi','à¦¤à¦®à¦°à¦¦à§à¦¦à¦¿'),(3935,167,'Charamanullah','à¦šà¦°à¦†à¦®à¦¾à¦¨'),(3936,167,'Charbata','à¦šà¦°à¦¬à¦¾à¦Ÿà¦¾'),(3937,167,'Charclerk','à¦šà¦°à¦•à§à¦²à¦¾à¦°à§à¦•'),(3938,167,'Charjabbar','à¦šà¦°à¦œà¦¾à¦¬à§à¦¬à¦¾à¦°'),(3939,167,'Charjubilee','à¦šà¦°à¦œà§à¦¬à¦²à§€'),(3940,167,'Charwapda','à¦šà¦°à¦“à¦¯à¦¼à¦¾à¦ªà¦¦à¦¾'),(3941,167,'Eastcharbata','à¦ªà§‚à¦°à§à¦¬ à¦šà¦°à¦¬à¦¾à¦Ÿà¦¾'),(3942,167,'Mohammadpur','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦°'),(3943,10,'Baligaon','à¦¬à¦¾à¦²à¦¿à¦—à¦¾à¦à¦“'),(3944,10,'Chonua','à¦›à¦¨à§à§Ÿà¦¾'),(3945,10,'Dholia','à¦§à¦²à¦¿à§Ÿà¦¾'),(3946,10,'Dhormapur','à¦§à¦°à§à¦®à¦ªà§à¦°'),(3947,10,'Fazilpur','à¦«à¦¾à¦œà¦¿à¦²à¦ªà§à¦°'),(3948,10,'Forhadnogor','à¦«à¦°à¦¹à¦¾à¦¦à¦¨à¦—à¦°'),(3949,10,'Kalidah','à¦•à¦¾à¦²à¦¿à¦¦à¦¹'),(3950,10,'Kazirbag','à¦•à¦¾à¦œà¦¿à¦°à¦¬à¦¾à¦—'),(3951,10,'Lemua','à¦²à§‡à¦®à§à§Ÿà¦¾'),(3952,10,'Motobi','à¦®à§‹à¦Ÿà¦¬à§€'),(3953,10,'Panchgachia','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦›à¦¿à§Ÿà¦¾'),(3954,10,'Sarishadi','à¦¶à¦°à§à¦¶à¦¦à¦¿'),(3955,140,'Amirabad','à¦†à¦®à¦¿à¦°à¦¾à¦¬à¦¾à¦¦'),(3956,140,'Bogadana','à¦¬à¦—à¦¾à¦¦à¦¾à¦¨à¦¾'),(3957,140,'Chardorbesh','à¦šà¦°à¦¦à¦°à¦¬à§‡à¦¶'),(3958,140,'Charmozlishpur','à¦šà¦°à¦®à¦œà¦²à¦¿à¦¶à¦ªà§à¦°'),(3959,140,'Chorchandia','à¦šà¦°à¦šà¦¾à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(3960,140,'Mongolkandi','à¦®à¦™à§à¦—à¦²à¦•à¦¾à¦¨à§à¦¦à¦¿'),(3961,140,'Motigonj','à¦®à¦¤à¦¿à¦—à¦žà§à¦œ'),(3962,140,'Nababpur','à¦¨à¦¬à¦¾à¦¬à¦ªà§à¦°'),(3963,140,'Sonagazi','à¦¸à§‹à¦¨à¦¾à¦—à¦¾à¦œà§€'),(3964,383,'Bamna','à¦¬à¦¾à¦®à¦¨à¦¾'),(3965,383,'Bukabunia','à¦¬à§à¦•à¦¾à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(3966,383,'Doutola','à¦¡à§Œà¦¯à¦¼à¦¾à¦¤à¦²à¦¾'),(3967,383,'Ramna','à¦°à¦¾à¦®à¦¨à¦¾'),(3968,384,'Charduany','à¦šà¦°à¦¦à§à¦¯à¦¼à¦¾à¦¨à§€'),(3969,384,'Kakchira','à¦•à¦¾à¦•à¦šà¦¿à¦¢à¦¼à¦¾'),(3970,384,'Kalmegha','à¦•à¦¾à¦²à¦®à§‡à¦˜à¦¾'),(3971,384,'Kathaltali','à¦•à¦¾à¦ à¦¾à¦²à¦¤à¦²à§€'),(3972,384,'Nachnapara','à¦¨à¦¾à¦šà¦¨à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(3973,384,'Patharghata','à¦ªà¦¾à¦¥à¦°à¦˜à¦¾à¦Ÿà¦¾'),(3974,384,'Raihanpur','à¦°à¦¾à¦¯à¦¼à¦¹à¦¾à¦¨à¦ªà§à¦°'),(3975,141,'Amzadhat','à¦†à¦®à¦œà¦¾à¦¦à¦¹à¦¾à¦Ÿ'),(3976,141,'Anandopur','à¦†à¦¨à¦¨à§à¦¦à¦ªà§à¦°'),(3977,141,'Dorbarpur','à¦¦à¦°à¦¬à¦¾à¦°à¦ªà§à¦°'),(3978,141,'Fulgazi','à¦«à§à¦²à¦—à¦¾à¦œà§€'),(3979,141,'Gmhat','à¦œà¦¿,à¦à¦®, à¦¹à¦¾à¦Ÿ'),(3980,141,'Munshirhat','à¦®à§à¦¨à§à¦¸à¦¿à¦°à¦¹à¦¾à¦Ÿ'),(3981,168,'Arjuntala','à¦…à¦°à§à¦œà§à¦¨à¦¤à¦²à¦¾'),(3982,168,'Bejbagh','à¦¬à¦¿à¦œà¦¬à¦¾à¦—'),(3983,168,'Chhatarpaia','à¦›à¦¾à¦¤à¦¾à¦°à¦ªà¦¾à¦‡à¦¯à¦¼à¦¾'),(3984,168,'Dumurua','à¦¡à§à¦®à§à¦°à§à¦¯à¦¼à¦¾'),(3985,168,'Kabilpur','à¦•à¦¾à¦¬à¦¿à¦²à¦ªà§à¦°'),(3986,168,'Kadra','à¦•à¦¾à¦¦à¦°à¦¾'),(3987,168,'Kesharpar','à¦•à§‡à¦¶à¦°à¦ªà¦¾à¦¡à¦¼à¦¾'),(3988,168,'Mohammadpurup7','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦°'),(3989,168,'Nabipur','à¦¨à¦¬à§€à¦ªà§à¦°'),(3990,142,'Boxmahmmud','à¦¬à¦•à§à¦¸à¦®à¦¾à¦¹à¦®à§à¦¦'),(3991,142,'Ctholia','à¦šà¦¿à¦¥à¦²à¦¿à§Ÿà¦¾'),(3992,142,'Mizanagar','à¦®à¦¿à¦°à§à¦œà¦¾à¦¨à¦—à¦°'),(3993,143,'Daganbhuiyan','à¦¦à¦¾à¦—à¦¨à¦­à§‚à¦žà¦¾'),(3994,143,'Jayloskor','à¦œà¦¾à§Ÿà¦²à¦¸à§à¦•à¦°'),(3995,143,'Matubhuiyan','à¦®à¦¾à¦¤à§à¦­à§‚à¦žà¦¾'),(3996,143,'Purbachandrapur','à¦ªà§‚à¦°à§à¦¬à¦šà¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(3997,143,'Rajapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦°'),(3998,143,'Ramnagar','à¦°à¦¾à¦®à¦¨à¦—à¦°'),(3999,143,'Sindurpur','à¦¸à¦¿à¦¨à§à¦¦à§à¦°à¦ªà§à¦°'),(4000,143,'Yeakubpur','à¦‡à§Ÿà¦¾à¦•à§à¦¬à¦ªà§à¦°'),(4001,169,'Badalkot','à¦¬à¦¾à¦¦à¦²à¦•à§‹à¦Ÿ'),(4002,169,'Hatpukuriaghatlabag','à¦¹à¦¾à¦Ÿ-à¦ªà§à¦•à§à¦°à¦¿à¦¯à¦¼à¦¾'),(4003,169,'Khilpara','à¦–à¦¿à¦²à¦ªà¦¾à¦¡à¦¼à¦¾'),(4004,169,'Mohammadpuru5','à¦®à§‹à¦¹à¦¾à¦®à§à¦®à¦¦à¦ªà§à¦°'),(4005,169,'Noakhala','à¦¨à§‹à¦¯à¦¼à¦¾à¦–à¦²à¦¾'),(4006,169,'Panchgaon','à¦ªà¦¾à¦à¦šà¦—à¦¾à¦à¦“'),(4007,169,'Porokote','à¦ªà¦°à¦•à§‹à¦Ÿ'),(4008,169,'Ramnarayanpur','à¦°à¦¾à¦®à¦¨à¦¾à¦°à¦¾à¦¯à¦¼à¦¨à¦ªà§à¦°'),(4009,169,'Sahapur','à¦¸à¦¾à¦¹à¦¾à¦ªà§à¦°'),(4010,170,'Ambarnagor','à¦…à¦®à§à¦¬à¦°à¦¨à¦—à¦°'),(4011,170,'Amishapara','à¦†à¦®à¦¿à¦¶à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(4012,170,'Bajra','à¦¬à¦œà¦°à¦¾'),(4013,170,'Barogaon','à¦¬à¦¾à¦°à¦—à¦¾à¦à¦“'),(4014,170,'Chashirhat','à¦šà¦¾à¦·à§€à¦°à¦¹à¦¾à¦Ÿ'),(4015,170,'Deoti','à¦¦à§‡à¦“à¦Ÿà¦¿'),(4016,170,'Joyag','à¦œà¦¯à¦¼à¦¾à¦—'),(4017,170,'Nateshwar','à¦¨à¦¾à¦Ÿà§‡à¦¶à§à¦¬à¦°'),(4018,170,'Nodona','à¦¨à¦¦à¦¨à¦¾'),(4019,170,'Sonapur','à¦¸à§‹à¦¨à¦¾à¦ªà§à¦°'),(4020,10,'Bangakha','à¦¬à¦¾à¦™à§à¦—à¦¾à¦–à¦¾à¦'),(4021,10,'Basikpur','à¦¬à¦¶à¦¿à¦•à¦ªà§à¦°'),(4022,10,'Chandrogonj','à¦šà¦¨à§à¦¦à§à¦°à¦—à¦žà§à¦œ'),(4023,10,'Charramonimohon','à¦šà¦°à¦°à¦®à¦¨à§€ à¦®à§‹à¦¹à¦¨'),(4024,10,'Charruhita','à¦šà¦°à¦°à§à¦¹à¦¿à¦¤à¦¾'),(4025,10,'Charshahi','à¦šà¦°à¦¶à¦¾à¦¹à§€'),(4026,10,'Dalalbazar','à¦¦à¦¾à¦²à¦¾à¦² à¦¬à¦¾à¦œà¦¾à¦°'),(4027,10,'Digli','à¦¦à¦¿à¦˜à¦²à§€'),(4028,10,'Dotopara','à¦¦à¦¤à§à¦¤à¦ªà¦¾à§œà¦¾'),(4029,10,'Hazirpara','à¦¹à¦¾à¦œà¦¿à¦°à¦ªà¦¾à§œà¦¾'),(4030,10,'Kusakhali','à¦•à§à¦¶à¦¾à¦–à¦¾à¦²à§€'),(4031,10,'Laharkandi','à¦²à¦¾à¦¹à¦¾à¦°à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4032,10,'Northhamsadi','à¦‰à¦¤à§à¦¤à¦° à¦¹à¦¾à¦®à¦›à¦¾à¦¦à§€'),(4033,10,'Nourthjoypur','à¦‰à¦¤à§à¦¤à¦° à¦œà§Ÿà¦ªà§à¦°'),(4034,10,'Parbotinagar','à¦ªà¦¾à¦°à§à¦¬à¦¤à§€à¦¨à¦—à¦°'),(4035,10,'Sakchor','à¦¶à¦¾à¦•à¦šà¦°'),(4036,10,'Southhamsadi','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦¹à¦¾à¦®à¦›à¦¾à¦¦à§€'),(4037,10,'Tearigonj','à¦¤à§‡à§Ÿà¦¾à¦°à§€à¦—à¦žà§à¦œ'),(4038,10,'Tumchor','à¦Ÿà§à¦®à¦šà¦°'),(4039,10,'Vobanigonj','à¦­à¦¬à¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(4040,180,'Charfolcon','à¦šà¦° à¦«à¦²à¦•à¦¨'),(4041,180,'Charkadira','à¦šà¦° à¦•à¦¾à¦¦à¦¿à¦°à¦¾'),(4042,180,'Charkalkini','à¦šà¦° à¦•à¦¾à¦²à¦•à¦¿à¦¨à¦¿'),(4043,180,'Charlorench','à¦šà¦° à¦²à¦°à§‡à¦žà§à¦š'),(4044,180,'Charmartin','à¦šà¦° à¦®à¦¾à¦°à§à¦Ÿà¦¿à¦¨'),(4045,180,'Hajirhat','à¦¹à¦¾à¦œà¦¿à¦°à¦¹à¦¾à¦Ÿ'),(4046,180,'Patarirhat','à¦ªà¦¾à¦Ÿà¦¾à¦°à§€à¦°à¦¹à¦¾à¦Ÿ'),(4047,180,'Shaheberhat','à¦¸à¦¾à¦¹à§‡à¦¬à§‡à¦°à¦¹à¦¾à¦Ÿ'),(4048,180,'Torabgonj','à¦¤à§‹à¦°à¦¾à¦¬à¦—à¦žà§à¦œ'),(4049,181,'Bamni','à¦¬à¦¾à¦®à¦¨à§€'),(4050,181,'Charmohana','à¦šà¦° à¦®à§‹à¦¹à¦¨à¦¾'),(4051,181,'Charpata','à¦šà¦° à¦ªà¦¾à¦¤à¦¾'),(4052,181,'Keora','à¦•à§‡à¦°à§‹à§Ÿà¦¾'),(4053,181,'Northcharababil','à¦‰à¦¤à§à¦¤à¦° à¦šà¦° à¦†à¦¬à¦¾à¦¬à¦¿à¦²'),(4054,181,'Northcharbangshi','à¦‰à¦¤à§à¦¤à¦° à¦šà¦° à¦¬à¦‚à¦¶à§€'),(4055,181,'Raipur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(4056,181,'Sonapur','à¦¸à§‹à¦¨à¦¾à¦ªà§à¦°'),(4057,181,'Southcharababil','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦šà¦° à¦†à¦¬à¦¾à¦¬à¦¿à¦²'),(4058,181,'Southcharbangshi','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦šà¦° à¦¬à¦‚à¦¶à§€'),(4059,182,'Alxendar','à¦†à¦²à§‡à¦•à¦œà¦¾à¦¨à§à¦¡à¦¾à¦°'),(4060,182,'Borokheri','à¦¬à§œà¦–à§‡à§œà§€'),(4061,182,'Charabdullah','à¦šà¦° à¦†à¦¬à¦¦à§à¦²à§à¦¯à¦¾à¦¹'),(4062,182,'Charalgi','à¦šà¦° à¦†à¦²à¦—à§€'),(4063,182,'Charbadam','à¦šà¦° à¦¬à¦¾à¦¦à¦¾à¦®'),(4064,182,'Chargazi','à¦šà¦°à¦—à¦¾à¦œà§€'),(4065,182,'Charporagacha','à¦šà¦° à¦ªà§‹à§œà¦¾à¦—à¦¾à¦›à¦¾'),(4066,182,'Charramiz','à¦šà¦° à¦°à¦®à¦¿à¦œ'),(4067,183,'Bhadur','à¦­à¦¾à¦¦à§à¦°'),(4068,183,'Bhatra','à¦­à¦¾à¦Ÿà¦°à¦¾'),(4069,183,'Bholakot','à¦­à§‹à¦²à¦¾à¦•à§‹à¦Ÿ'),(4070,183,'Chandipur','à¦šà¦¨à§à¦¡à¦¿à¦ªà§à¦°'),(4071,183,'Darbeshpur','à¦¦à¦°à¦¬à§‡à¦¶à¦ªà§à¦°'),(4072,183,'Ichhapur','à¦‡à¦›à¦¾à¦ªà§à¦°'),(4073,183,'Kanchanpur','à¦•à¦¾à¦žà§à¦šà¦¨à¦ªà§à¦°'),(4074,183,'Karpara','à¦•à¦°à¦ªà¦¾à§œà¦¾'),(4075,183,'Lamchar','à¦²à¦¾à¦®à¦šà¦°'),(4076,183,'Noagaon','à¦¨à§‹à§Ÿà¦¾à¦—à¦¾à¦à¦“ '),(4077,10,'Auliapur','à¦†à¦‰à¦²à¦¿à¦¯à¦¼à¦¾à¦ªà§à¦°'),(4078,10,'Badarpur','à¦¬à¦¦à¦°à¦ªà§à¦°'),(4079,10,'Borobighai','à¦¬à¦¡à¦¼ à¦¬à¦¿à¦˜à¦¾à¦‡'),(4080,10,'Chotobighai','à¦›à§‹à¦Ÿ à¦¬à¦¿à¦˜à¦¾à¦‡'),(4081,10,'Itbaria','à¦‡à¦Ÿà¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(4082,10,'Jainkathi','à¦œà§ˆà¦¨à¦•à¦¾à¦ à§€'),(4083,10,'Kalikapur','à¦•à¦¾à¦²à¦¿à¦•à¦¾à¦ªà§à¦°'),(4084,10,'Kamalapur','à¦•à¦®à¦²à¦¾à¦ªà§à¦°'),(4085,10,'Laukathi','à¦²à¦¾à¦‰à¦•à¦¾à¦ à§€'),(4086,10,'Lohalia','à¦²à§‹à¦¹à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(4087,10,'Madarbunia','à¦®à¦¾à¦¦à¦¾à¦°à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(4088,10,'Marichbunia','à¦®à¦°à¦¿à¦šà¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(4089,351,'Angaria','à¦†à¦‚à¦—à¦¾à¦°à¦¿à¦¯à¦¼à¦¾'),(4090,351,'Labukhali','à¦²à§‡à¦¬à§à¦–à¦¾à¦²à§€'),(4091,351,'Muradia','à¦®à§à¦°à¦¾à¦¦à¦¿à¦¯à¦¼à¦¾'),(4092,351,'Pangasia','à¦ªà¦¾à¦‚à¦—à¦¾à¦¶à¦¿à¦¯à¦¼à¦¾'),(4093,351,'Sreerampur','à¦¶à§à¦°à§€à¦°à¦¾à¦®à¦ªà§à¦°'),(4094,352,'Alipur','à¦†à¦²à§€à¦ªà§à¦°'),(4095,352,'Baharampur','à¦¬à¦¹à¦°à¦®à¦ªà§à¦°'),(4096,352,'Bashbaria','à¦¬à¦¾à¦à¦¶à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(4097,352,'Betagishankipur','à¦¬à§‡à¦¤à¦¾à¦—à§€ à¦¸à¦¾à¦¨à¦•à¦¿à¦ªà§à¦°'),(4098,352,'Dashmina','à¦¦à¦¶à¦®à¦¿à¦¨à¦¾'),(4099,352,'Rangopaldi','à¦°à¦£à¦—à§‹à¦ªà¦¾à¦²à¦¦à§€'),(4100,10,'Basudeb','à¦¬à¦¾à¦¸à§à¦¦à§‡à¦¬'),(4101,10,'Bodhal','à¦¬à§à¦§à¦²'),(4102,10,'Machihata','à¦®à¦¾à¦›à¦¿à¦¹à¦¾à¦¤à¦¾'),(4103,10,'Majlishpur','à¦®à¦œà¦²à¦¿à¦¶à¦ªà§à¦°'),(4104,10,'Natain','à¦¨à¦¾à¦Ÿà¦¾à¦‡'),(4105,10,'Natais','à¦¨à¦¾à¦Ÿà¦¾à¦‡ (à¦¦à¦ƒ) '),(4106,10,'Ramrail','à¦°à¦¾à¦®à¦°à¦¾à¦‡à¦² '),(4107,10,'Sadekpur','à¦¸à¦¾à¦¦à§‡à¦•à¦ªà§à¦° '),(4108,10,'Shuhilpur','à¦¸à§à¦¹à¦¿à¦²à¦ªà§à¦°'),(4109,10,'Sultanpur','à¦¸à§à¦²à¦¤à¦¾à¦¨à¦ªà§à¦°'),(4110,10,'Talsahar','à¦¤à¦¾à¦²à¦¶à¦¹à¦°'),(4111,145,'Badair','à¦¬à¦¾à¦¦à§ˆà¦°'),(4112,145,'Bayek','à¦¬à¦¾à§Ÿà§‡à¦•'),(4113,145,'Benauty','à¦¬à¦¿à¦¨à¦¾à¦‰à¦Ÿà¦¿'),(4114,145,'Gopinathpur','à¦—à§‹à¦ªà§€à¦¨à¦¾à¦¥à¦ªà§à¦°'),(4115,145,'Kasbaw','à¦•à¦¸à¦¬à¦¾(à¦ªà¦ƒ)'),(4116,145,'Kayempur','à¦•à¦¾à¦‡à¦®à¦ªà§à¦°'),(4117,145,'Kharera','à¦–à¦¾à§œà§‡à¦°à¦¾'),(4118,145,'Kuti','à¦•à§à¦Ÿà¦¿'),(4119,145,'Mehari','à¦®à§‡à¦¹à¦¾à¦°à§€'),(4120,145,'Mulagram','à¦®à§‚à¦²à¦—à§à¦°à¦¾à¦®'),(4121,146,'Bhalakut','à¦­à¦²à¦¾à¦•à§à¦Ÿ'),(4122,146,'Burishwar','à¦¬à§à§œà¦¿à¦¶à§à¦¬à¦°'),(4123,146,'Chapartala','à¦šà¦¾à¦ªà§ˆà¦°à¦¤à¦²à¦¾'),(4124,146,'Chatalpar','à¦šà¦¾à¦¤à¦²à¦ªà¦¾à§œ'),(4125,146,'Dharnondol','à¦§à¦°à¦®à¦¨à§à¦¡à¦²'),(4126,146,'Fandauk','à¦«à¦¾à¦¨à§à¦¦à¦¾à¦‰à¦•'),(4127,146,'Goalnagar','à¦—à§‹à§Ÿà¦¾à¦²à¦¨à¦—à¦° '),(4128,146,'Gokarna','à¦—à§‹à¦•à¦°à§à¦£'),(4129,146,'Goniauk','à¦—à§à¦¨à¦¿à§Ÿà¦¾à¦‰à¦•'),(4130,146,'Haripur','à¦¹à¦°à¦¿à¦ªà§à¦°'),(4131,146,'Kunda','à¦•à§à¦¨à§à¦¡à¦¾'),(4132,146,'Nasirnagar','à¦¨à¦¾à¦¸à¦¿à¦°à¦¨à¦—à¦°'),(4133,146,'Purbabhag','à¦ªà§‚à¦°à§à¦¬à¦­à¦¾à¦—'),(4134,353,'Baliatali','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦¤à¦²à§€'),(4135,353,'Chakamaia','à¦šà¦¾à¦•à¦¾à¦®à¦‡à¦¯à¦¼à¦¾'),(4136,353,'Champapur','à¦šà¦®à§à¦ªà¦¾à¦ªà§à¦°'),(4137,353,'Dalbugonj','à¦¡à¦¾à¦²à¦¬à§à¦—à¦žà§à¦œ'),(4138,353,'Dhankhali','à¦§à¦¾à¦¨à¦–à¦¾à¦²à§€'),(4139,353,'Dulaser','à¦§à§à¦²à¦¾à¦¸à¦¾à¦°'),(4140,353,'Lalua','à¦²à¦¾à¦²à§à§Ÿà¦¾ '),(4141,353,'Latachapli','à¦²à¦¤à¦¾à¦šà¦¾à¦ªà¦²à§€'),(4142,353,'Mahipur','à¦®à¦¹à¦¿à¦ªà§à¦°'),(4143,353,'Mithagonj','à¦®à¦¿à¦ à¦¾à¦—à¦žà§à¦œ'),(4144,353,'Nilgonj','à¦¨à§€à¦²à¦—à¦žà§à¦œ'),(4145,353,'Tiakhali','à¦Ÿà¦¿à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€'),(4146,147,'Auraol','à¦…à¦°à§à§Ÿà¦¾à¦‡à¦²'),(4147,147,'Chunta','à¦šà§à¦¨à§à¦Ÿà¦¾'),(4148,147,'Kalikaccha','à¦•à¦¾à¦²à§€à¦•à¦šà§à¦›'),(4149,147,'Noagoun','à¦¨à§‹à§Ÿà¦¾à¦—à¦¾à¦à¦“'),(4150,147,'Pakshimuul','à¦ªà¦¾à¦•à¦¶à¦¿à¦®à§à¦²'),(4151,147,'Panishor','à¦ªà¦¾à¦¨à¦¿à¦¶à§à¦¬à¦° '),(4152,147,'Sarail','à¦¸à¦°à¦¾à¦‡à¦² à¦¸à¦¦à¦°'),(4153,147,'Shahajadapur','à¦¶à¦¾à¦¹à¦œà¦¾à¦¦à¦¾à¦ªà§à¦°'),(4154,147,'Shahbazpur','à¦¶à¦¾à¦¹à¦¬à¦¾à¦œà¦ªà§à¦°'),(4155,185,'Banshbaria','à¦¬à¦¾à¦à¦¶à¦¬à¦¾à¦°à§€à§Ÿà¦¾'),(4156,185,'Barabkunda','à¦¬à¦¾à¦°à¦¬à¦•à§à¦¨à§à¦¡'),(4157,185,'Bariadyala','à¦¬à¦¾à§œà¦¿à§Ÿà¦¾à¦¡à¦¿à§Ÿà¦¾à¦²à¦¾'),(4158,185,'Bhatiari','à¦­à¦¾à¦Ÿà¦¿à§Ÿà¦¾à¦°à§€'),(4159,185,'Kumira','à¦•à§à¦®à¦¿à¦°à¦¾'),(4160,185,'Muradpur','à¦®à§à¦°à¦¾à¦¦à¦ªà§à¦°'),(4161,185,'Saidpur','à¦¸à¦¾à¦ˆà¦¦à¦ªà§à¦°'),(4162,185,'Salimpur','à¦¸à¦¾à¦²à¦¿à¦®à¦ªà§à¦°'),(4163,185,'Sonaichhari','à¦¸à§‹à¦¨à¦¾à¦‡à¦›à§œà¦¿'),(4164,354,'Amragachia','à¦†à¦®à¦¡à¦¼à¦¾à¦—à¦¾à¦›à¦¿à¦¯à¦¼à¦¾'),(4165,354,'Deulisubidkhali','à¦¦à§‡à¦‰à¦²à§€ à¦¸à§à¦¬à¦¿à¦¦à¦–à¦¾à¦²à§€'),(4166,354,'Kakrabunia','à¦•à¦¾à¦•à¦¡à¦¼à¦¾à¦¬à§à¦¨à¦¿à¦¯à¦¼à¦¾'),(4167,354,'Madhabkhali','à¦®à¦¾à¦§à¦¬à¦–à¦¾à¦²à§€'),(4168,354,'Majidbaria','à¦®à¦œà¦¿à¦¦à¦¬à¦¾à¦¡à¦¼à¦¿à¦¯à¦¼à¦¾'),(4169,354,'Mirzaganj','à¦®à¦¿à¦°à§à¦œà¦¾à¦—à¦žà§à¦œ'),(4170,186,'Dhoom','à¦§à§à¦®'),(4171,186,'Durgapur','à¦¦à§‚à¦°à§à¦—à¦¾à¦ªà§à¦°'),(4172,186,'Haitkandi','à¦¹à¦¾à¦‡à¦¤à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4173,186,'Hinguli','à¦¹à¦¿à¦‚à¦—à§à¦²à¦¿'),(4174,186,'Ichakhali','à¦‡à¦›à¦¾à¦–à¦¾à¦²à§€'),(4175,186,'Jorarganj','à¦œà§‹à¦°à¦¾à¦°à¦—à¦žà§à¦œ'),(4176,186,'Katachhara','à¦•à¦¾à¦Ÿà¦¾à¦›à¦°à¦¾'),(4177,186,'Khaiyachhara','à¦–à§ˆà§Ÿà¦¾à¦›à¦°à¦¾'),(4178,186,'Korerhat','à¦•à¦°à§‡à¦°à¦¹à¦¾à¦Ÿ'),(4179,186,'Maghadia','à¦®à¦˜à¦¾à¦¦à¦¿à§Ÿà¦¾'),(4180,186,'Mayani','à¦®à¦¾à§Ÿà¦¾à¦¨à§€'),(4181,186,'Mirsharai','à¦®à§€à¦°à¦¸à¦°à¦¾à¦‡'),(4182,186,'Mithanala','à¦®à¦¿à¦ à¦¾à¦¨à¦¾à¦²à¦¾'),(4183,186,'Osmanpur','à¦“à¦¸à¦®à¦¾à¦¨à¦ªà§à¦°'),(4184,186,'Saherkhali','à¦¸à¦¾à¦¹à§‡à¦°à¦–à¦¾à¦²à§€'),(4185,186,'Wahedpur','à¦“à§Ÿà¦¾à¦¹à§‡à¦¦à¦ªà§à¦°'),(4186,355,'Amkhola','à¦†à¦®à¦–à§‹à¦²à¦¾'),(4187,355,'Bakulbaria','à¦¬à¦•à§à¦²à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(4188,355,'Charbiswas','à¦šà¦°à¦¬à¦¿à¦¶à§à¦¬à¦¾à¦¸'),(4189,355,'Charkajol','à¦šà¦°à¦•à¦¾à¦œà¦²'),(4190,355,'Chiknikandi','à¦šà¦¿à¦•à¦¨à¦¿à¦•à¦¾à¦¨à§à¦¦à§€'),(4191,355,'Dakua','à¦¡à¦¾à¦•à§à¦¯à¦¼à¦¾'),(4192,355,'Galachipa','à¦—à¦²à¦¾à¦šà¦¿à¦ªà¦¾'),(4193,355,'Gazalia','à¦—à¦œà¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(4194,355,'Golkhali','à¦—à§‹à¦²à¦–à¦¾à¦²à§€'),(4195,355,'Kalagachhia','à¦•à¦²à¦¾à¦—à¦¾à¦›à¦¿à¦¯à¦¼à¦¾'),(4196,355,'Panpatty','à¦ªà¦¾à¦¨à¦ªà¦Ÿà§à¦Ÿà¦¿'),(4197,355,'Ratanditaltali','à¦°à¦¤à¦¨à¦¦à§€ à¦¤à¦¾à¦²à¦¤à¦²à§€'),(4198,187,'Asia','à¦†à¦¶à¦¿à§Ÿà¦¾'),(4199,187,'Baralia','à¦¬à¦°à¦²à¦¿à§Ÿà¦¾'),(4200,187,'Barauthan','à¦¬à§œ à¦‰à¦ à¦¾à¦¨'),(4201,187,'Bhatikhain','à¦­à¦¾à¦Ÿà¦¿à¦–à¦¾à¦‡à¦¨'),(4202,187,'Chanhara','à¦›à¦¨à¦¹à¦°à¦¾'),(4203,187,'Charlakshya','à¦šà¦°à¦²à¦•à§à¦·à§à¦¯à¦¾'),(4204,187,'Charpatharghata','à¦šà¦°à¦ªà¦¾à¦¥à¦°à¦˜à¦¾à¦Ÿà¦¾'),(4205,187,'Dakhinbhurshi','à¦¦à¦•à§à¦·à¦¿à¦£ à¦­à§‚à¦°à§à¦·à¦¿'),(4206,187,'Dhalghat','à¦§à¦²à¦˜à¦¾à¦Ÿ'),(4207,187,'Habilasdwi','à¦¹à¦¾à¦¬à¦¿à¦²à¦¾à¦¸à¦¦à§à¦¬à§€à¦ª'),(4208,187,'Haidgaon','à¦¹à¦¾à¦‡à¦¦à¦—à¦¾à¦à¦“'),(4209,187,'Janglukhain','à¦œà¦™à§à¦—à¦²à¦–à¦¾à¦‡à¦¨'),(4210,187,'Jiri','à¦œà¦¿à¦°à¦¿'),(4211,187,'Juldha','à¦œà§à¦²à¦§à¦¾'),(4212,187,'Kachuai','à¦•à¦¾à¦šà§à§Ÿà¦¾à¦‡'),(4213,187,'Kasiais','à¦•à¦¾à¦¶à¦¿à§Ÿà¦¾à¦‡à¦¶'),(4214,187,'Kelishahar','à¦•à§‡à¦²à¦¿à¦¶à¦¹à¦°'),(4215,187,'Kharana','à¦–à¦°à¦¨à¦¾'),(4216,187,'Kolagaon','à¦•à§‹à¦²à¦¾à¦—à¦¾à¦à¦“'),(4217,187,'Kusumpura','à¦•à§à¦¸à§à¦®à¦ªà§à¦°à¦¾'),(4218,187,'Sikalbaha','à¦¶à¦¿à¦•à¦²à¦¬à¦¾à¦¹à¦¾'),(4219,187,'Sobhandandi','à¦¶à§‹à¦­à¦¨à¦¦à¦¨à§à¦¡à§€'),(4220,160,'Belaichari','à§§ à¦¨à¦‚ à¦¬à¦¿à¦²à¦¾à¦‡à¦›à§œà¦¿'),(4221,160,'Farua','à§© à¦¨à¦‚ à¦«à¦¾à¦°à§à§Ÿà¦¾'),(4222,160,'Kengrachari','à§¨ à¦¨à¦‚ à¦•à§‡à¦‚à§œà¦¾à¦›à§œà¦¿'),(4223,161,'Banajogichara','à¦¬à¦¨à¦¯à§‹à¦—à§€à¦›à§œà¦¾'),(4224,161,'Dumdumya','à¦¦à§à¦®à¦¦à§à¦®à§à¦¯à¦¾'),(4225,161,'Juraichari','à¦œà§à¦°à¦¾à¦›à§œà¦¿'),(4226,161,'Moidong','à¦®à§ˆà¦¦à¦‚'),(4227,162,'Burighat','à¦¬à§à§œà¦¿à¦˜à¦¾à¦Ÿ'),(4228,162,'Ghilachhari','à¦˜à¦¿à¦²à¦¾à¦›à§œà¦¿'),(4229,162,'Naniarchar','à¦¨à¦¾à¦¨à¦¿à§Ÿà¦¾à¦°à¦šà¦°'),(4230,162,'Sabekkhong','à¦¸à¦¾à¦¬à§‡à¦•à§à¦·à§à¦¯à¦‚'),(4231,188,'Amanullah','à¦†à¦®à¦¾à¦¨à¦‰à¦²à§à¦¯à¦¾'),(4232,188,'Azimpur','à¦†à¦œà¦¿à¦®à¦ªà§à¦°'),(4233,188,'Bauria','à¦¬à¦¾à¦‰à¦°à¦¿à§Ÿà¦¾'),(4234,188,'Gachhua','à¦—à¦¾à¦›à§à§Ÿà¦¾'),(4235,188,'Haramia','à¦¹à¦¾à¦°à¦¾à¦®à¦¿à§Ÿà¦¾'),(4236,188,'Harispur','à¦¹à¦°à¦¿à¦¶à¦ªà§à¦°'),(4237,188,'Kalapania','à¦•à¦¾à¦²à¦¾à¦ªà¦¾à¦¨à¦¿à§Ÿà¦¾'),(4238,188,'Magdhara','à¦®à¦—à¦§à¦°à¦¾'),(4239,188,'Maitbhanga','à¦®à¦¾à¦‡à¦Ÿà¦­à¦¾à¦™à§à¦—à¦¾'),(4240,188,'Musapur','à¦®à§à¦›à¦¾à¦ªà§à¦°'),(4241,188,'Rahmatpur','à¦°à¦¹à¦®à¦¤à¦ªà§à¦° '),(4242,188,'Santoshpur','à¦¸à¦¨à§à¦¤à§‹à¦·à¦ªà§à¦°'),(4243,188,'Sarikait','à¦¸à¦¾à¦°à¦¿à¦•à¦¾à¦‡à¦¤'),(4244,188,'Urirchar','à¦‰à§œà¦¿à¦°à¦šà¦°'),(4245,189,'Baharchhara','à¦¬à¦¾à¦¹à¦¾à¦°à¦›à§œà¦¾'),(4246,189,'Bailchhari','à¦¬à§ˆà¦²à¦›à§œà¦¿'),(4247,189,'Chambal','à¦šà¦¾à¦®à§à¦¬à¦²'),(4248,189,'Chhanua','à¦›à¦¨à§à§Ÿà¦¾'),(4249,189,'Gandamara','à¦—à¦¨à§à¦¡à¦¾à¦®à¦¾à¦°à¦¾'),(4250,189,'Kalipur','à¦•à¦¾à¦²à§€à¦ªà§à¦°'),(4251,189,'Katharia','à¦•à¦¾à¦¥à¦°à¦¿à§Ÿà¦¾'),(4252,189,'Khankhanabad','à¦–à¦¾à¦¨à¦–à¦¾à¦¨à¦¾à¦¬à¦¾à¦¦'),(4253,189,'Puichhari','à¦ªà§à¦à¦‡à¦›à§œà¦¿'),(4254,189,'Pukuria','à¦ªà§à¦•à§à¦°à¦¿à§Ÿà¦¾'),(4255,189,'Sadhanpur','à¦¸à¦¾à¦§à¦¨à¦ªà§à¦°'),(4256,189,'Saral','à¦¸à¦°à¦²'),(4257,189,'Sekherkhil','à¦¶à§‡à¦–à§‡à¦°à¦–à§€à¦²'),(4258,189,'Silk','à¦¶à§€à¦²à¦•à§à¦ª'),(4259,190,'Ahlakaraldenga','à¦†à¦¹à¦²à§à¦²à¦¾ à¦•à¦°à¦²à¦¡à§‡à¦™à§à¦—à¦¾'),(4260,190,'Amuchia','à¦†à¦®à§à¦šà¦¿à§Ÿà¦¾ '),(4261,190,'Charandwi','à¦šà¦°à¦¨à¦¦à§à¦¬à§€à¦ª'),(4262,190,'Kandhurkhil','à¦•à¦§à§à¦°à¦–à§€à¦²'),(4263,190,'Pashchimgamdandi','à¦ªà¦¶à§à¦šà¦¿à¦® à¦—à§‹à¦®à¦¦à¦¨à§à¦¡à§€'),(4264,190,'Popadia','à¦ªà§‹à¦ªà¦¾à¦¦à¦¿à§Ÿà¦¾ '),(4265,190,'Purbagomdandi','à¦ªà§à¦°à§à¦¬ à¦—à§‹à¦®à¦¦à¦¨à§à¦¡à§€'),(4266,190,'Sakpura','à¦¶à¦¾à¦•à¦ªà§à¦°à¦¾ '),(4267,190,'Saroatali','à¦¸à¦¾à¦°à§‹à§Ÿà¦¾à¦¤à¦²à§€'),(4268,190,'Sreepurkharandwi','à¦¶à§à¦°à§€à¦ªà§à¦°-à¦–à¦°à¦¨à§à¦¦à§€à¦ª'),(4269,191,'Anwara','à¦†à¦¨à§‹à§Ÿà¦¾à¦°à¦¾'),(4270,191,'Barasat','à¦¬à¦¾à¦°à¦¶à¦¤'),(4271,191,'Baroakhan','à¦¬à¦¾à¦°à¦–à¦¾à¦‡à¦¨'),(4272,191,'Barumchara','à¦¬à¦°à¦®à§à¦¨à¦®à¦šà§œà¦¾'),(4273,191,'Battali','à¦¬à¦Ÿà¦¤à¦²à§€'),(4274,191,'Boirag','à¦¬à§ˆà¦°à¦¾à¦—'),(4275,191,'Chatari','à¦šà¦¾à¦¤à¦°à§€'),(4276,191,'Haildhar','à¦¹à¦¾à¦‡à¦²à¦§à¦°'),(4277,191,'Juidandi','à¦œà§à¦à¦‡à¦¦à¦¨à§à¦¡à§€'),(4278,191,'Paraikora','à¦ªà¦°à§ˆà¦•à§‹à§œà¦¾'),(4279,191,'Raipur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(4280,192,'Bailtali','à¦¬à§ˆà¦²à¦¤à¦²à§€'),(4281,192,'Barama','à¦¬à¦°à¦®à¦¾'),(4282,192,'Barkal','à¦¬à¦°à¦•à¦²'),(4283,192,'Dhopachhari','à¦§à§‹à¦ªà¦¾à¦›à§œà§€'),(4284,192,'Dohazari','à¦¦à§‹à¦¹à¦¾à¦œà¦¾à¦°à§€'),(4285,192,'Hashimpur','à¦¹à¦¾à¦¶à¦¿à¦®à¦ªà§à¦°'),(4286,192,'Joara','à¦œà§‹à§Ÿà¦¾à¦°à¦¾'),(4287,192,'Kanchanabad','à¦•à¦¾à¦žà§à¦šà¦¨à¦¾à¦¬à¦¾à¦¦'),(4288,192,'Satbaria','à¦¸à¦¾à¦¤à¦¬à¦¾à§œà¦¿à§Ÿà¦¾'),(4289,193,'Amilaisi','à¦†à¦®à¦¿à¦²à¦¾à¦‡à¦¶'),(4290,193,'Bazalia','à¦¬à¦¾à¦œà¦¾à¦²à¦¿à§Ÿà¦¾'),(4291,193,'Charati','à¦šà¦°à¦¤à§€'),(4292,193,'Dhemsa','à¦¢à§‡à¦®à¦¶à¦¾'),(4293,193,'Eochiai','à¦à¦“à¦šà¦¿à§Ÿà¦¾'),(4294,193,'Kaliais','à¦•à¦¾à¦²à¦¿à§Ÿà¦¾à¦‡à¦¶'),(4295,193,'Kanchana','à¦•à¦¾à¦žà§à¦šà¦¨à¦¾'),(4296,193,'Keochia','à¦•à§‡à¦à¦“à¦šà¦¿à§Ÿà¦¾'),(4297,193,'Khagaria','à¦–à¦¾à¦—à¦°à¦¿à§Ÿà¦¾'),(4298,193,'Madarsa','à¦®à¦¾à¦¦à¦¾à¦°à§à¦¶à¦¾'),(4299,193,'Nalua','à¦¨à¦²à§à§Ÿà¦¾'),(4300,193,'Paschimdhemsa','à¦ªà¦¶à§à¦šà¦¿à¦® à¦¢à§‡à¦®à¦¶à¦¾'),(4301,193,'Puranagar','à¦ªà§à¦°à¦¾à¦¨à¦—à§œ'),(4302,193,'Sadaha','à¦›à¦¦à¦¾à¦¹à¦¾'),(4303,193,'Satkania','à¦¸à¦¾à¦¤à¦•à¦¾à¦¨à¦¿à§Ÿà¦¾'),(4304,193,'Sonakania','à¦¸à§‹à¦¨à¦¾à¦•à¦¾à¦¨à¦¿à§Ÿà¦¾'),(4305,194,'Adhunagar','à¦†à¦§à§à¦¨à¦—à¦°'),(4306,194,'Amirabad','à¦†à¦®à¦¿à¦°à¦¾à¦¬à¦¾à¦¦'),(4307,194,'Barahatia','à¦¬à§œà¦¹à¦¾à¦¤à¦¿à§Ÿà¦¾'),(4308,194,'Charamba','à¦šà¦°à¦®à§à¦¬à¦¾'),(4309,194,'Chunati','à¦šà§à¦¨à¦¤à¦¿'),(4310,194,'Kalauzan','à¦•à¦²à¦¾à¦‰à¦œà¦¾à¦¨'),(4311,194,'Lohagara','à¦²à§‹à¦¹à¦¾à¦—à¦¾à§œà¦¾'),(4312,194,'Padua','à¦ªà¦¦à§à§Ÿà¦¾'),(4313,194,'Putibila','à¦ªà§à¦Ÿà¦¿à¦¬à¦¿à¦²à¦¾'),(4314,195,'Budirchar','à¦¬à§à¦¡à¦¿à¦°à¦¶à§à¦šà¦°'),(4315,195,'Chikondandi','à¦šà¦¿à¦•à¦¨à¦¦à¦¨à§à¦¡à§€'),(4316,195,'Chipatali','à¦›à¦¿à¦ªà¦¾à¦¤à¦²à§€'),(4317,195,'Dakkinmadrasha','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦®à¦¾à¦¦à¦¾à¦°à§à¦¶à¦¾'),(4318,195,'Dhalai','à¦§à¦²à¦‡'),(4319,195,'Farhadabad','à¦«à¦°à¦¹à¦¾à¦¦à¦¾à¦¬à¦¾à¦¦'),(4320,195,'Fathepur','à¦«à¦¤à§‡à¦ªà§à¦°'),(4321,195,'Garduara','à¦—à§œà¦¦à§à§Ÿà¦¾à¦°à¦¾'),(4322,195,'Gomanmordan','à¦—à§à¦®à¦¾à¦¨à¦®à¦°à§à¦¦à§à¦¦à¦¨'),(4323,195,'Hathazari','à¦¹à¦¾à¦Ÿà¦¹à¦¾à¦œà¦¾à¦°à§€'),(4324,195,'Mekhal','à¦®à§‡à¦–à¦²'),(4325,195,'Mirjapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(4326,195,'Nangolmora','à¦¨à¦¾à¦™à§à¦—à¦²à¦®à§‹à¦°à¦¾'),(4327,195,'Sikarpur','à¦¶à¦¿à¦•à¦¾à¦°à¦ªà§à¦°'),(4328,195,'Uttarmadrasha','à¦‰à¦¤à§à¦¤à¦° à¦®à¦¾à¦¦à¦¾à¦°à§à¦¶à¦¾'),(4329,196,'Abdullapur','à¦†à¦¬à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦° '),(4330,196,'Baganbazar','à¦¬à¦¾à¦—à¦¾à¦¨ à¦¬à¦¾à¦œà¦¾à¦°'),(4331,196,'Bhujpur','à¦­à§‚à¦œà¦ªà§à¦° '),(4332,196,'Bokhtapur','à¦¬à¦•à§à¦¤à¦ªà§à¦° '),(4333,196,'Dantmara','à¦¦à¦¾à¦à¦¤à¦®à¦¾à¦°à¦¾'),(4334,196,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦° '),(4335,196,'Dharmapur','à¦§à¦°à§à¦®à¦ªà§à¦°'),(4336,196,'Harualchari','à¦¹à¦¾à¦°à§à§Ÿà¦¾à¦²à¦›à§œà¦¿ '),(4337,196,'Jafathagar','à¦œà¦¾à¦«à¦¤à¦¨à¦—à¦° '),(4338,196,'Kanchannagor','à¦•à¦¾à¦žà§à¦šà¦¨à¦—à¦° '),(4339,196,'Lelang','à¦²à§‡à¦²à¦¾à¦‚ '),(4340,196,'Nanupur','à¦¨à¦¾à¦¨à§à¦ªà§à¦° '),(4341,196,'Narayanhat','à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦¹à¦¾à¦Ÿ '),(4342,196,'Paindong','à¦ªà¦¾à¦‡à¦¨à¦¦à¦‚ '),(4343,196,'Roshangiri','à¦°à§‹à¦¸à¦¾à¦‚à¦—à¦¿à¦°à§€ '),(4344,196,'Samitirhat','à¦¸à¦®à¦¿à¦¤à¦¿à¦° à¦¹à¦¾à¦Ÿ '),(4345,196,'Suabil','à¦¸à§à§Ÿà¦¾à¦¬à¦¿à¦² '),(4346,196,'Sunderpur','à¦¸à§à¦¨à¦¦à¦°à¦ªà§à¦° '),(4347,197,'Bagoan','à¦¬à¦¾à¦—à§‹à§Ÿà¦¾à¦¨'),(4348,197,'Binajuri','à¦¬à¦¿à¦¨à¦¾à¦œà§à¦°à§€'),(4349,197,'Chikdair','à¦šà¦¿à¦•à¦¦à¦¾à¦‡à¦°'),(4350,197,'Dabua','à¦¡à¦¾à¦¬à§à§Ÿà¦¾'),(4351,197,'Gohira','à¦—à¦¹à¦¿à¦°à¦¾'),(4352,197,'Holdia','à¦¹à¦²à¦¦à¦¿à§Ÿà¦¾'),(4353,197,'Kodolpur','à¦•à¦¦à¦²à¦ªà§‚à¦°'),(4354,197,'Noapara','à¦¨à§‹à¦¯à¦¼à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(4355,197,'Nowajushpur','à¦¨à¦“à§Ÿà¦¾à¦œà¦¿à¦¶à¦ªà§à¦°'),(4356,197,'Pahartali','à¦ªà¦¾à¦¹à¦¾à§œà¦¤à¦²à§€'),(4357,197,'Paschimgujra','à¦ªà¦¶à§à¦šà¦¿à¦® à¦—à§à¦œà¦°à¦¾'),(4358,197,'Purbagujra','à¦ªà§‚à¦°à§à¦¬ à¦—à§à¦œà¦°à¦¾'),(4359,197,'Raozan','à¦°à¦¾à¦‰à¦œà¦¾à¦¨'),(4360,197,'Urkirchar','à¦‰à§œà¦•à¦¿à¦°à¦šà¦°'),(4361,148,'Araishidha','à¦†à§œà¦¾à¦‡à¦¸à¦¿à¦§à¦¾'),(4362,148,'Ashuganj','à¦†à¦¶à§à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(4363,148,'Charchartala','à¦šà¦°à¦šà¦¾à¦°à¦¤à¦²à¦¾'),(4364,148,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(4365,148,'Lalpur','à¦²à¦¾à¦²à¦ªà§à¦°'),(4366,148,'Sarifpur','à¦¶à¦°à§€à¦«à¦ªà§à¦°'),(4367,148,'Talshaharw','à¦¤à¦¾à¦²à¦¶à¦¹à¦°(à¦ªà¦ƒ)'),(4368,148,'Tarua','à¦¤à¦¾à¦°à§à§Ÿà¦¾'),(4369,149,'Akhauran','à¦†à¦–à¦¾à¦‰à§œà¦¾ (à¦‰à¦ƒ)'),(4370,149,'Akhauras','à¦†à¦–à¦¾à¦‰à§œà¦¾ (à¦¦à¦ƒ)'),(4371,149,'Dharkhar','à¦§à¦°à¦–à¦¾à¦°'),(4372,149,'Mogra','à¦®à§‹à¦—à§œà¦¾'),(4373,149,'Monionda','à¦®à¦¨à¦¿à§Ÿà¦¨à§à¦¦'),(4374,150,'Barail','à¦¬à§œà¦¾à¦‡à¦²'),(4375,150,'Barikandi','à¦¬à§œà¦¿à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4376,150,'Biddayakut','à¦¬à¦¿à¦¦à§à¦¯à¦¾à¦•à§à¦Ÿ'),(4377,150,'Birgaon','à¦¬à§€à¦°à¦—à¦¾à¦à¦“'),(4378,150,'Bitghar','à¦¬à¦¿à¦Ÿà¦˜à¦°'),(4379,150,'Ibrahimpur','à¦‡à¦¬à§à¦°à¦¾à¦¹à¦¿à¦®à¦ªà§à¦°'),(4380,150,'Jinudpur','à¦œà¦¿à¦¨à§‹à¦¦à¦ªà§à¦°'),(4381,150,'Kaitalan','à¦•à¦¾à¦‡à¦¤à¦²à¦¾ (à¦‰à¦ƒ)'),(4382,150,'Kaitalas','à¦•à¦¾à¦‡à¦¤à¦²à¦¾'),(4383,150,'Krishnanagar','à¦•à§ƒà¦·à§à¦£à¦¨à¦—à¦°'),(4384,150,'Laurfatehpur','à¦²à¦¾à¦‰à¦°à¦«à¦¤à§‡à¦ªà§à¦°'),(4385,150,'Nabinagare','à¦¨à¦¬à§€à¦¨à¦—à¦°'),(4386,150,'Nabinagarw','à¦¨à¦¬à§€à¦¨à¦—à¦°(à¦ªà¦¶à§à¦šà¦¿à¦®)'),(4387,150,'Nathghar','à¦¨à¦¾à¦Ÿà¦˜à¦°'),(4388,150,'Rasullabad','à¦°à¦¸à§à¦²à§à¦²à¦¾à¦¬à¦¾à¦¦'),(4389,150,'Ratanpur','à¦°à¦¤à¦¨à¦ªà§à¦°'),(4390,150,'Salimganj','à¦›à¦²à¦¿à¦®à¦—à¦žà§à¦œ'),(4391,150,'Satmura','à¦¸à¦¾à¦¤à¦®à§‹à§œà¦¾'),(4392,150,'Shamogram','à¦¶à§à¦¯à¦¾à¦®à¦—à§à¦°à¦¾à¦®'),(4393,150,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(4394,150,'Sreerampur','à¦¶à§à¦°à§€à¦°à¦¾à¦®à¦ªà§à¦°'),(4395,151,'Ayabpur','à¦†à¦‡à§Ÿà§à¦¬à¦ªà§à¦°'),(4396,151,'Bancharampur','à¦¬à¦¾à¦žà§à¦›à¦¾à¦°à¦¾à¦®à¦ªà§à¦°'),(4397,151,'Dariadulat','à¦¦à¦°à¦¿à§Ÿà¦¾à¦¦à§Œà¦²à¦¤'),(4398,151,'Darikandi','à¦¦à§œà¦¿à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4399,151,'Fardabad','à¦«à¦°à¦¦à¦¾à¦¬à¦¾à¦¦'),(4400,151,'Manikpur','à¦®à¦¾à¦¨à¦¿à¦•à¦ªà§à¦°'),(4401,151,'Pahariyakandi','à¦ªà¦¾à¦¹à¦¾à§œà¦¿à§Ÿà¦¾ à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4402,151,'Rupushdi','à¦°à§à¦ªà¦¸à¦¦à§€ à¦ªà¦¶à§à¦šà¦¿à¦®'),(4403,151,'Saifullyakandi','à¦›à§Ÿà¦«à§à¦²à§à¦²à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(4404,151,'Salimabad','à¦›à¦²à¦¿à¦®à¦¾à¦¬à¦¾à¦¦'),(4405,151,'Sonarampur','à¦¸à§‹à¦¨à¦¾à¦°à¦¾à¦®à¦ªà§à¦°'),(4406,151,'Tazkhali','à¦¤à§‡à¦œà¦–à¦¾à¦²à§€'),(4407,151,'Ujanchar','à¦‰à¦œà¦¾à¦¨à¦šà¦° à¦ªà§‚à¦°à§à¦¬'),(4408,152,'Bhudanty','à¦¬à§à¦§à¦¨à§à¦¤à¦¿'),(4409,152,'Bishupor','à¦¬à¦¿à¦·à§à¦£à§à¦ªà§à¦°'),(4410,152,'Champaknagar','à¦šà¦®à§à¦ªà¦•à¦¨à¦—à¦°'),(4411,152,'Chandura','à¦šà¦¾à¦¨à§à¦¦à§à¦°à¦¾'),(4412,152,'Charislampur','à¦šà¦°-à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(4413,152,'Harashpur','à¦¹à¦°à¦·à¦ªà§à¦°'),(4414,152,'Ichapura','à¦‡à¦›à¦¾à¦ªà§à¦°à¦¾'),(4415,152,'Paharpur','à¦ªà¦¾à¦¹à¦¾à§œà¦ªà§à¦°'),(4416,152,'Pattan','à¦ªà¦¤à§à¦¤à¦¨'),(4417,152,'Singerbil','à¦¸à¦¿à¦‚à¦—à¦¾à¦°à¦¬à¦¿à¦²'),(4418,10,'Alinagor','à¦†à¦²à§€à¦¨à¦—à¦°'),(4419,10,'Bapta','à¦¬à¦¾à¦ªà§à¦¤à¦¾'),(4420,10,'Charshamya','à¦šà¦°à¦¸à¦¾à¦®à¦¾à¦‡à¦¯à¦¼à¦¾'),(4421,10,'Dhania','à¦§à¦¨à¦¿à¦¯à¦¼à¦¾'),(4422,10,'Ilisha','à¦‡à¦²à¦¿à¦¶à¦¾'),(4423,10,'Kachia','à¦•à¦¾à¦šà¦¿à¦¯à¦¼à¦¾'),(4424,10,'Northdigholdi','à¦‰à¦¤à§à¦¤à¦°'),(4425,10,'Razapur','à¦°à¦¾à¦œà¦¾à¦ªà§à¦°'),(4426,10,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(4427,10,'Southdigholdi','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¦à¦¿à¦˜à¦²à¦¦à§€'),(4428,10,'Vheduria','à¦­à§‡à¦¦à§à¦°à¦¿à¦¯à¦¼à¦¾'),(4429,10,'Vhelumia','à¦­à§‡à¦²à§à¦®à¦¿à¦¯à¦¼à¦¾'),(4430,10,'Westilisa','à¦ªà¦¶à§à¦šà¦¿à¦® à¦‡à¦²à¦¿à¦¶à¦¾'),(4431,375,'Boromanika','à¦¬à¦¡à¦¼ à¦®à¦¾à¦¨à¦¿à¦•à¦¾'),(4432,375,'Deula','à¦¦à§‡à¦‰à¦²à¦¾'),(4433,375,'Kachiaup4','à§ªà¦¨à¦‚ à¦•à¦¾à¦šà¦¿à¦¯à¦¼à¦¾'),(4434,375,'Kutuba','à¦•à§à¦¤à§à¦¬à¦¾'),(4435,375,'Pakshia','à¦ªà¦•à§à¦·à¦¿à¦¯à¦¼à¦¾'),(4436,376,'Charkhalipa','à¦šà¦° à¦–à¦²à¦¿à¦«à¦¾'),(4437,376,'Charpata','à¦šà¦°à¦ªà¦¾à¦¤à¦¾'),(4438,376,'Hazipur','à¦¹à¦¾à¦œà§€à¦ªà§à¦°'),(4439,376,'Madanpur','à¦®à¦¦à¦¨à¦ªà§à¦°'),(4440,376,'Madua','à¦®à§‡à¦¦à§à¦¯à¦¼à¦¾'),(4441,376,'Northjoynagar','à¦‰à¦¤à§à¦¤à¦° à¦œà¦¯à¦¼à¦¨à¦—à¦°'),(4442,376,'Sayedpur','à¦¸à§ˆà¦¯à¦¼à¦¦à¦ªà§à¦°'),(4443,376,'Southjoynagar','à¦¦à¦•à§à¦·à¦¿à¦¨ à¦œà¦¯à¦¼à¦¨à¦—à¦°'),(4444,376,'Vhovanipur','à¦­à¦¬à¦¾à¦¨à§€à¦ªà§à¦°'),(4445,377,'Hazirhat','à¦¹à¦¾à¦œà§€à¦° à¦¹à¦¾à¦Ÿ'),(4446,377,'Monpura','à¦®à¦¨à¦ªà§à¦°à¦¾'),(4447,377,'Sakuchianorth','à¦¸à¦¾à¦•à§à¦šà¦¿à¦¯à¦¼à¦¾ à¦‰à¦¤à§à¦¤à¦°'),(4448,377,'Sakuchiasouth','à¦¸à¦¾à¦•à§à¦šà¦¿à¦¯à¦¼à¦¾ à¦¦à¦•à§à¦·à¦¿à¦¨'),(4449,378,'Baromolongchora','à¦¬à¦¡à¦¼ à¦®à¦²à¦‚à¦šà¦¡à¦¼à¦¾'),(4450,378,'Chadpur','à¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(4451,378,'Chanchra','à¦šà¦¾à¦šà¦à¦¡à¦¼à¦¾'),(4452,378,'Shambupur','à¦¶à¦®à§à¦­à§à¦ªà§à¦°'),(4453,378,'Sonapur','à¦¸à§‹à¦¨à¦¾à¦ªà§à¦°'),(4454,379,'Badarpur','à¦¬à¦¦à¦°à¦ªà§à¦°'),(4455,379,'Charbhuta','à¦šà¦°à¦­à§‚à¦¤à¦¾'),(4456,379,'Dholigournagar','à¦§à¦²à§€à¦—à§Œà¦° à¦¨à¦—à¦°'),(4457,379,'Farajgonj','à¦«à¦°à¦¾à¦œà¦—à¦žà§à¦œ'),(4458,379,'Kalma','à¦•à¦¾à¦²à¦®à¦¾'),(4459,379,'Lalmohan','à¦²à¦¾à¦²à¦®à§‹à¦¹à¦¨'),(4460,379,'Lordhardinge','à¦²à¦°à§à¦¡ à¦¹à¦¾à¦°à§à¦¡à¦¿à¦žà§à¦œ'),(4461,379,'Paschimcharumed','à¦ªà¦¶à§à¦šà¦¿à¦® à¦šà¦° à¦‰à¦®à§‡à¦¦'),(4462,379,'Ramagonj','à¦°à¦®à¦¾à¦—à¦žà§à¦œ'),(4463,356,'chalitabunia','à¦šà¦¾à¦²à¦¿à¦¤à¦¾à¦¬à§à¦¨à¦¿à§Ÿà¦¾'),(4464,356,'Barobaisdia','à¦¬à§œà¦¬à¦¾à¦‡à¦¶à¦¦à¦¿à§Ÿà¦¾'),(4465,356,'Charmontaz','à¦šà¦°à¦®à§‹à¦¨à§à¦¤à¦¾à¦œ'),(4466,356,'Chattobaisdia','à¦›à§‹à¦Ÿà¦¬à¦¾à¦‡à¦¶à¦¦à¦¿à§Ÿà¦¾'),(4467,356,'Rangabali','à¦°à¦¾à¦™à§à¦—à¦¾à¦¬à¦¾à¦²à§€'),(4468,385,'Barabagi','à¦¬à§œà¦¬à¦—à¦¿'),(4469,385,'Chhotabagi','à¦›à§‹à¦Ÿà¦¬à¦—à¦¿'),(4470,385,'Karibaria','à¦•à¦¡à¦¼à¦‡à¦¬à¦¾à¦¡à¦¼à§€à¦¯à¦¼à¦¾'),(4471,385,'Nishanbaria','à¦¨à¦¿à¦¶à¦¾à¦¨à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(4472,385,'Panchakoralia','à¦ªà¦šà¦¾à¦•à§‹à¦¡à¦¼à¦¾à¦²à¦¿à¦¯à¦¼à¦¾'),(4473,385,'Sarikkhali','à¦¶à¦¾à¦°à¦¿à¦•à¦–à¦¾à¦²à¦¿'),(4474,385,'Sonakata','à¦¸à§‹à¦¨à¦¾à¦•à¦¾à¦Ÿà¦¾');

/*Table structure for table `loc_upazilas` */

DROP TABLE IF EXISTS `loc_upazilas`;

CREATE TABLE `loc_upazilas` (
  `id_upazila` smallint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` tinyint unsigned NOT NULL,
  `upazila_name_en` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Upazila name in English',
  `upazila_name_bn` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Upazila name in Bangla',
  PRIMARY KEY (`id_upazila`),
  KEY `district_id` (`district_id`),
  CONSTRAINT `loc_upazilas_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `loc_districts` (`id_district`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `loc_upazilas` */

insert  into `loc_upazilas`(`id_upazila`,`district_id`,`upazila_name_en`,`upazila_name_bn`) values (1,1,'Belabo','à¦¬à§‡à¦²à¦¾à¦¬à§‹'),(2,1,'Monohardi','à¦®à¦¨à§‹à¦¹à¦°à¦¦à§€'),(3,1,'Narsingdisadar','à¦¨à¦°à¦¸à¦¿à¦‚à¦¦à§€ à¦¸à¦¦à¦°'),(4,1,'Palash','à¦ªà¦²à¦¾à¦¶'),(5,1,'Raipura','à¦°à¦¾à¦¯à¦¼à¦ªà§à¦°à¦¾'),(6,1,'Shibpur','à¦¶à¦¿à¦¬à¦ªà§à¦°'),(7,2,'Kaliganj','à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ'),(8,2,'Kaliakair','à¦•à¦¾à¦²à¦¿à§Ÿà¦¾à¦•à§ˆà¦°'),(9,2,'Kapasia','à¦•à¦¾à¦ªà¦¾à¦¸à¦¿à§Ÿà¦¾'),(10,2,'Sadar','à¦—à¦¾à¦œà§€à¦ªà§à¦° à¦¸à¦¦à¦°'),(11,2,'Sreepur','à¦¶à§à¦°à§€à¦ªà§à¦°'),(12,3,'Sadar','à¦¶à¦°à¦¿à§Ÿà¦¤à¦ªà§à¦° à¦¸à¦¦à¦°'),(13,3,'Naria','à¦¨à§œà¦¿à§Ÿà¦¾'),(14,3,'Zajira','à¦œà¦¾à¦œà¦¿à¦°à¦¾'),(15,3,'Gosairhat','à¦—à§‹à¦¸à¦¾à¦‡à¦°à¦¹à¦¾à¦Ÿ'),(16,3,'Bhedarganj','à¦­à§‡à¦¦à¦°à¦—à¦žà§à¦œ'),(17,3,'Damudya','à¦¡à¦¾à¦®à§à¦¡à§à¦¯à¦¾'),(18,4,'Araihazar','à¦†à¦¡à¦¼à¦¾à¦‡à¦¹à¦¾à¦œà¦¾à¦°'),(19,4,'Narayanganjsadar','à¦¨à¦¾à¦°à¦¾à§Ÿà¦¨à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(20,4,'Rupganj','à¦°à§‚à¦ªà¦—à¦žà§à¦œ'),(21,4,'Sonargaon','à¦¸à§‹à¦¨à¦¾à¦°à¦—à¦¾à¦'),(22,5,'Sherpursadar','à¦¶à§‡à¦°à¦ªà§à¦° à¦¸à¦¦à¦°'),(23,5,'Nalitabari','à¦¨à¦¾à¦²à¦¿à¦¤à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(24,5,'Sreebordi','à¦¶à§à¦°à§€à¦¬à¦°à¦¦à§€'),(25,5,'Nokla','à¦¨à¦•à¦²à¦¾'),(26,5,'Jhenaigati','à¦à¦¿à¦¨à¦¾à¦‡à¦—à¦¾à¦¤à§€'),(27,6,'Basail','à¦¬à¦¾à¦¸à¦¾à¦‡à¦²'),(28,6,'Bhuapur','à¦­à§à¦¯à¦¼à¦¾à¦ªà§à¦°'),(29,6,'Delduar','à¦¦à§‡à¦²à¦¦à§à¦¯à¦¼à¦¾à¦°'),(30,6,'Ghatail','à¦˜à¦¾à¦Ÿà¦¾à¦‡à¦²'),(31,6,'Gopalpur','à¦—à§‹à¦ªà¦¾à¦²à¦ªà§à¦°'),(32,6,'Madhupur','à¦®à¦§à§à¦ªà§à¦°'),(33,6,'Mirzapur','à¦®à¦¿à¦°à§à¦œà¦¾à¦ªà§à¦°'),(34,6,'Nagarpur','à¦¨à¦¾à¦—à¦°à¦ªà§à¦°'),(35,6,'Sakhipur','à¦¸à¦–à¦¿à¦ªà§à¦°'),(36,6,'Tangailsadar','à¦Ÿà¦¾à¦™à§à¦—à¦¾à¦‡à¦² à¦¸à¦¦à¦°'),(37,6,'Kalihati','à¦•à¦¾à¦²à¦¿à¦¹à¦¾à¦¤à§€'),(38,6,'Dhanbari','à¦§à¦¨à¦¬à¦¾à§œà§€'),(39,7,'Fulbaria','à¦«à§à¦²à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(40,7,'Trishal','à¦¤à§à¦°à¦¿à¦¶à¦¾à¦²'),(41,7,'Bhaluka','à¦­à¦¾à¦²à§à¦•à¦¾'),(42,7,'Muktagacha','à¦®à§à¦•à§à¦¤à¦¾à¦—à¦¾à¦›à¦¾'),(43,7,'Mymensinghsadar','à¦®à§Ÿà¦®à¦¨à¦¸à¦¿à¦‚à¦¹ à¦¸à¦¦à¦°'),(44,7,'Dhobaura','à¦§à§‡à¦¾à¦¬à¦¾à¦‰à§œà¦¾'),(45,7,'Phulpur','à¦«à§à¦²à¦ªà§à¦°'),(46,7,'Haluaghat','à¦¹à¦¾à¦²à§à§Ÿà¦¾à¦˜à¦¾à¦Ÿ'),(47,7,'Gouripur','à¦—à§Œà¦°à§€à¦ªà§à¦°'),(48,7,'Gafargaon','à¦—à¦«à¦°à¦—à¦¾à¦à¦“'),(49,7,'Iswarganj','à¦ˆà¦¶à§à¦¬à¦°à¦—à¦žà§à¦œ'),(50,7,'Nandail','à¦¨à¦¾à¦¨à§à¦¦à¦¾à¦‡à¦²'),(51,7,'Tarakanda','à¦¤à¦¾à¦°à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(52,8,'Itna','à¦‡à¦Ÿà¦¨à¦¾'),(53,8,'Katiadi','à¦•à¦Ÿà¦¿à§Ÿà¦¾à¦¦à§€'),(54,8,'Bhairab','à¦­à§ˆà¦°à¦¬'),(55,8,'Tarail','à¦¤à¦¾à§œà¦¾à¦‡à¦²'),(56,8,'Hossainpur','à¦¹à§‹à¦¸à§‡à¦¨à¦ªà§à¦°'),(57,8,'Pakundia','à¦ªà¦¾à¦•à§à¦¨à§à¦¦à¦¿à§Ÿà¦¾'),(58,8,'Kuliarchar','à¦•à§à¦²à¦¿à§Ÿà¦¾à¦°à¦šà¦°'),(59,8,'Kishoreganjsadar','à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(60,8,'Karimgonj','à¦•à¦°à¦¿à¦®à¦—à¦žà§à¦œ'),(61,8,'Bajitpur','à¦¬à¦¾à¦œà¦¿à¦¤à¦ªà§à¦°'),(62,8,'Austagram','à¦…à¦·à§à¦Ÿà¦—à§à¦°à¦¾à¦®'),(63,8,'Mithamoin','à¦®à¦¿à¦ à¦¾à¦®à¦‡à¦¨'),(64,8,'Nikli','à¦¨à¦¿à¦•à¦²à§€'),(65,9,'Jamalpursadar','à¦œà¦¾à¦®à¦¾à¦²à¦ªà§à¦° à¦¸à¦¦à¦°'),(66,9,'Melandah','à¦®à§‡à¦²à¦¾à¦¨à§à¦¦à¦¹'),(67,9,'Islampur','à¦‡à¦¸à¦²à¦¾à¦®à¦ªà§à¦°'),(68,9,'Dewangonj','à¦¦à§‡à¦“à¦¯à¦¼à¦¾à¦¨à¦—à¦žà§à¦œ'),(69,9,'Sarishabari','à¦¸à¦°à¦¿à¦·à¦¾à¦¬à¦¾à¦¡à¦¼à§€'),(70,9,'Madarganj','à¦®à¦¾à¦¦à¦¾à¦°à¦—à¦žà§à¦œ'),(71,9,'Bokshiganj','à¦¬à¦•à¦¶à§€à¦—à¦žà§à¦œ'),(72,10,'Harirampur','à¦¹à¦°à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(73,10,'Saturia','à¦¸à¦¾à¦Ÿà§à¦°à¦¿à§Ÿà¦¾'),(74,10,'Sadar','à¦®à¦¾à¦¨à¦¿à¦•à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(75,10,'Gior','à¦˜à¦¿à¦“à¦°'),(76,10,'Shibaloy','à¦¶à¦¿à¦¬à¦¾à¦²à§Ÿ'),(77,10,'Doulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(78,10,'Singiar','à¦¸à¦¿à¦‚à¦—à¦¾à¦‡à¦°'),(79,11,'Barhatta','à¦¬à¦¾à¦°à¦¹à¦¾à¦Ÿà§à¦Ÿà¦¾'),(80,11,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(81,11,'Kendua','à¦•à§‡à¦¨à§à¦¦à§à§Ÿà¦¾'),(82,11,'Atpara','à¦†à¦Ÿà¦ªà¦¾à§œà¦¾'),(83,11,'Madan','à¦®à¦¦à¦¨'),(84,11,'Khaliajuri','à¦–à¦¾à¦²à¦¿à§Ÿà¦¾à¦œà§à¦°à§€'),(85,11,'Kalmakanda','à¦•à¦²à¦®à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¾'),(86,11,'Mohongonj','à¦®à§‹à¦¹à¦¨à¦—à¦žà§à¦œ'),(87,11,'Netrokonasadar','à¦¨à§‡à¦¤à§à¦°à¦•à§‹à¦£à¦¾ à¦¸à¦¦à¦°'),(88,12,'Savar','à¦¸à¦¾à¦­à¦¾à¦°'),(89,12,'Dhamrai','à¦§à¦¾à¦®à¦°à¦¾à¦‡'),(90,12,'Keraniganj','à¦•à§‡à¦°à¦¾à¦£à§€à¦—à¦žà§à¦œ'),(91,12,'Nawabganj','à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ'),(92,12,'Dohar','à¦¦à§‹à¦¹à¦¾à¦°'),(93,13,'Sadar','à¦®à§à¦¨à§à¦¸à¦¿à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(94,13,'Sreenagar','à¦¶à§à¦°à§€à¦¨à¦—à¦°'),(95,13,'Sirajdikhan','à¦¸à¦¿à¦°à¦¾à¦œà¦¦à¦¿à¦–à¦¾à¦¨'),(96,13,'Louhajanj','à¦²à§Œà¦¹à¦œà¦‚'),(97,13,'Gajaria','à¦—à¦œà¦¾à¦°à¦¿à§Ÿà¦¾'),(98,13,'Tongibari','à¦Ÿà¦‚à¦—à§€à¦¬à¦¾à§œà¦¿'),(99,14,'Sadar','à¦°à¦¾à¦œà¦¬à¦¾à¦¡à¦¼à§€ à¦¸à¦¦à¦°'),(100,14,'Goalanda','à¦—à§‹à¦¯à¦¼à¦¾à¦²à¦¨à§à¦¦'),(101,14,'Pangsa','à¦ªà¦¾à¦‚à¦¶à¦¾'),(102,14,'Baliakandi','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(103,14,'Kalukhali','à¦•à¦¾à¦²à§à¦–à¦¾à¦²à§€'),(104,15,'Sadar','à¦®à¦¾à¦¦à¦¾à¦°à§€à¦ªà§à¦° à¦¸à¦¦à¦°'),(105,15,'Shibchar','à¦¶à¦¿à¦¬à¦šà¦°'),(106,15,'Kalkini','à¦•à¦¾à¦²à¦•à¦¿à¦¨à¦¿'),(107,15,'Rajoir','à¦°à¦¾à¦œà§ˆà¦°'),(108,16,'Sadar','à¦—à§‹à¦ªà¦¾à¦²à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(109,16,'Kashiani','à¦•à¦¾à¦¶à¦¿à¦¯à¦¼à¦¾à¦¨à§€'),(110,16,'Tungipara','à¦Ÿà§à¦‚à¦—à§€à¦ªà¦¾à¦¡à¦¼à¦¾'),(111,16,'Kotalipara','à¦•à§‹à¦Ÿà¦¾à¦²à§€à¦ªà¦¾à¦¡à¦¼à¦¾'),(112,16,'Muksudpur','à¦®à§à¦•à¦¸à§à¦¦à¦ªà§à¦°'),(113,17,'Sadar','à¦«à¦°à¦¿à¦¦à¦ªà§à¦° à¦¸à¦¦à¦°'),(114,17,'Alfadanga','à¦†à¦²à¦«à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾'),(115,17,'Boalmari','à¦¬à§‹à§Ÿà¦¾à¦²à¦®à¦¾à¦°à§€'),(116,17,'Sadarpur','à¦¸à¦¦à¦°à¦ªà§à¦°'),(117,17,'Nagarkanda','à¦¨à¦—à¦°à¦•à¦¾à¦¨à§à¦¦à¦¾'),(118,17,'Bhanga','à¦­à¦¾à¦™à§à¦—à¦¾'),(119,17,'Charbhadrasan','à¦šà¦°à¦­à¦¦à§à¦°à¦¾à¦¸à¦¨'),(120,17,'Madhukhali','à¦®à¦§à§à¦–à¦¾à¦²à§€'),(121,17,'Saltha','à¦¸à¦¾à¦²à¦¥à¦¾'),(122,18,'Debidwar','à¦¦à§‡à¦¬à¦¿à¦¦à§à¦¬à¦¾à¦°'),(123,18,'Barura','à¦¬à¦°à§à¦¡à¦¼à¦¾'),(124,18,'Brahmanpara','à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦ªà¦¾à¦¡à¦¼à¦¾'),(125,18,'Chandina','à¦šà¦¾à¦¨à§à¦¦à¦¿à¦¨à¦¾'),(126,18,'Chauddagram','à¦šà§Œà¦¦à§à¦¦à¦—à§à¦°à¦¾à¦®'),(127,18,'Daudkandi','à¦¦à¦¾à¦‰à¦¦à¦•à¦¾à¦¨à§à¦¦à¦¿'),(128,18,'Homna','à¦¹à§‹à¦®à¦¨à¦¾'),(129,18,'Laksam','à¦²à¦¾à¦•à¦¸à¦¾à¦®'),(130,18,'Muradnagar','à¦®à§à¦°à¦¾à¦¦à¦¨à¦—à¦°'),(131,18,'Nangalkot','à¦¨à¦¾à¦™à§à¦—à¦²à¦•à§‹à¦Ÿ'),(132,18,'Comillasadar','à¦•à§à¦®à¦¿à¦²à§à¦²à¦¾ à¦¸à¦¦à¦°'),(133,18,'Meghna','à¦®à§‡à¦˜à¦¨à¦¾'),(134,18,'Monohargonj','à¦®à¦¨à§‹à¦¹à¦°à¦—à¦žà§à¦œ'),(135,18,'Sadarsouth','à¦¸à¦¦à¦° à¦¦à¦•à§à¦·à¦¿à¦£'),(136,18,'Titas','à¦¤à¦¿à¦¤à¦¾à¦¸'),(137,18,'Burichang','à¦¬à§à¦¡à¦¼à¦¿à¦šà¦‚'),(138,19,'Chhagalnaiya','à¦›à¦¾à¦—à¦²à¦¨à¦¾à¦‡à§Ÿà¦¾'),(139,19,'Sadar','à¦«à§‡à¦¨à§€ à¦¸à¦¦à¦°'),(140,19,'Sonagazi','à¦¸à§‹à¦¨à¦¾à¦—à¦¾à¦œà§€'),(141,19,'Fulgazi','à¦«à§à¦²à¦—à¦¾à¦œà§€'),(142,19,'Parshuram','à¦ªà¦°à¦¶à§à¦°à¦¾à¦®'),(143,19,'Daganbhuiyan','à¦¦à¦¾à¦—à¦¨à¦­à§‚à¦žà¦¾'),(144,20,'Sadar','à¦¬à§à¦°à¦¾à¦¹à§à¦®à¦£à¦¬à¦¾à§œà¦¿à§Ÿà¦¾ à¦¸à¦¦à¦°'),(145,20,'Kasba','à¦•à¦¸à¦¬à¦¾'),(146,20,'Nasirnagar','à¦¨à¦¾à¦¸à¦¿à¦°à¦¨à¦—à¦°'),(147,20,'Sarail','à¦¸à¦°à¦¾à¦‡à¦²'),(148,20,'Ashuganj','à¦†à¦¶à§à¦—à¦žà§à¦œ'),(149,20,'Akhaura','à¦†à¦–à¦¾à¦‰à§œà¦¾'),(150,20,'Nabinagar','à¦¨à¦¬à§€à¦¨à¦—à¦°'),(151,20,'Bancharampur','à¦¬à¦¾à¦žà§à¦›à¦¾à¦°à¦¾à¦®à¦ªà§à¦°'),(152,20,'Bijoynagar','à¦¬à¦¿à¦œà§Ÿà¦¨à¦—à¦°'),(153,21,'Sadar','à¦°à¦¾à¦™à§à¦—à¦¾à¦®à¦¾à¦Ÿà¦¿ à¦¸à¦¦à¦°'),(154,21,'Kaptai','à¦•à¦¾à¦ªà§à¦¤à¦¾à¦‡'),(155,21,'Kawkhali','à¦•à¦¾à¦‰à¦–à¦¾à¦²à§€'),(156,21,'Baghaichari','à¦¬à¦¾à¦˜à¦¾à¦‡à¦›à§œà¦¿'),(157,21,'Barkal','à¦¬à¦°à¦•à¦²'),(158,21,'Langadu','à¦²à¦‚à¦—à¦¦à§'),(159,21,'Rajasthali','à¦°à¦¾à¦œà¦¸à§à¦¥à¦²à§€'),(160,21,'Belaichari','à¦¬à¦¿à¦²à¦¾à¦‡à¦›à§œà¦¿'),(161,21,'Juraichari','à¦œà§à¦°à¦¾à¦›à§œà¦¿'),(162,21,'Naniarchar','à¦¨à¦¾à¦¨à¦¿à§Ÿà¦¾à¦°à¦šà¦°'),(163,22,'Sadar','à¦¨à§‹à¦¯à¦¼à¦¾à¦–à¦¾à¦²à§€ à¦¸à¦¦à¦°'),(164,22,'Companiganj','à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(165,22,'Begumganj','à¦¬à§‡à¦—à¦®à¦—à¦žà§à¦œ'),(166,22,'Hatia','à¦¹à¦¾à¦¤à¦¿à¦¯à¦¼à¦¾'),(167,22,'Subarnachar','à¦¸à§à¦¬à¦°à§à¦£à¦šà¦°'),(168,22,'Senbug','à¦¸à§‡à¦¨à¦¬à¦¾à¦—'),(169,22,'Chatkhil','à¦šà¦¾à¦Ÿà¦–à¦¿à¦²'),(170,22,'Sonaimori','à¦¸à§‹à¦¨à¦¾à¦‡à¦®à§à¦¡à¦¼à§€'),(171,23,'Haimchar','à¦¹à¦¾à¦‡à¦®à¦šà¦°'),(172,23,'Kachua','à¦•à¦šà§à¦¯à¦¼à¦¾'),(173,23,'Shahrasti','à¦¶à¦¾à¦¹à¦°à¦¾à¦¸à§à¦¤à¦¿'),(174,23,'Sadar','à¦šà¦¾à¦à¦¦à¦ªà§à¦° à¦¸à¦¦à¦°'),(175,23,'Matlabsouth','à¦®à¦¤à¦²à¦¬ à¦¦à¦•à§à¦·à¦¿à¦£'),(176,23,'Hajiganj','à¦¹à¦¾à¦œà§€à¦—à¦žà§à¦œ'),(177,23,'Matlabnorth','à¦®à¦¤à¦²à¦¬ à¦‰à¦¤à§à¦¤à¦°'),(178,23,'Faridgonj','à¦«à¦°à¦¿à¦¦à¦—à¦žà§à¦œ'),(179,24,'Sadar','à¦²à¦•à§à¦·à§à¦®à§€à¦ªà§à¦° à¦¸à¦¦à¦°'),(180,24,'Kamalnagar','à¦•à¦®à¦²à¦¨à¦—à¦°'),(181,24,'Raipur','à¦°à¦¾à§Ÿà¦ªà§à¦°'),(182,24,'Ramgati','à¦°à¦¾à¦®à¦—à¦¤à¦¿'),(183,24,'Ramganj','à¦°à¦¾à¦®à¦—à¦žà§à¦œ'),(184,25,'Rangunia','à¦°à¦¾à¦™à§à¦—à§à¦¨à¦¿à§Ÿà¦¾'),(185,25,'Sitakunda','à¦¸à§€à¦¤à¦¾à¦•à§à¦¨à§à¦¡'),(186,25,'Mirsharai','à¦®à§€à¦°à¦¸à¦°à¦¾à¦‡'),(187,25,'Patiya','à¦ªà¦Ÿà¦¿à§Ÿà¦¾'),(188,25,'Sandwip','à¦¸à¦¨à§à¦¦à§à¦¬à§€à¦ª'),(189,25,'Banshkhali','à¦¬à¦¾à¦à¦¶à¦–à¦¾à¦²à§€'),(190,25,'Boalkhali','à¦¬à§‹à§Ÿà¦¾à¦²à¦–à¦¾à¦²à§€'),(191,25,'Anwara','à¦†à¦¨à§‹à¦¯à¦¼à¦¾à¦°à¦¾'),(192,25,'Chandanaish','à¦šà¦¨à§à¦¦à¦¨à¦¾à¦‡à¦¶'),(193,25,'Satkania','à¦¸à¦¾à¦¤à¦•à¦¾à¦¨à¦¿à§Ÿà¦¾'),(194,25,'Lohagara','à¦²à§‹à¦¹à¦¾à¦—à¦¾à§œà¦¾'),(195,25,'Hathazari','à¦¹à¦¾à¦Ÿà¦¹à¦¾à¦œà¦¾à¦°à§€'),(196,25,'Fatikchhari','à¦«à¦Ÿà¦¿à¦•à¦›à§œà¦¿'),(197,25,'Raozan','à¦°à¦¾à¦‰à¦œà¦¾à¦¨'),(198,26,'Sadar','à¦•à¦•à§à¦¸à¦¬à¦¾à¦œà¦¾à¦° à¦¸à¦¦à¦°'),(199,26,'Chakaria','à¦šà¦•à¦°à¦¿à§Ÿà¦¾'),(200,26,'Kutubdia','à¦•à§à¦¤à§à¦¬à¦¦à¦¿à§Ÿà¦¾'),(201,26,'Ukhiya','à¦‰à¦–à¦¿à§Ÿà¦¾'),(202,26,'Moheshkhali','à¦®à¦¹à§‡à¦¶à¦–à¦¾à¦²à§€'),(203,26,'Pekua','à¦ªà§‡à¦•à§à§Ÿà¦¾'),(204,26,'Ramu','à¦°à¦¾à¦®à§'),(205,26,'Teknaf','à¦Ÿà§‡à¦•à¦¨à¦¾à¦«'),(206,27,'Sadar','à¦–à¦¾à¦—à¦¡à¦¼à¦¾à¦›à¦¡à¦¼à¦¿ à¦¸à¦¦à¦°'),(207,27,'Dighinala','à¦¦à¦¿à¦˜à§€à¦¨à¦¾à¦²à¦¾'),(208,27,'Panchari','à¦ªà¦¾à¦¨à¦›à¦¡à¦¼à¦¿'),(209,27,'Laxmichhari','à¦²à¦•à§à¦·à§€à¦›à¦¡à¦¼à¦¿'),(210,27,'Mohalchari','à¦®à¦¹à¦¾à¦²à¦›à¦¡à¦¼à¦¿'),(211,27,'Manikchari','à¦®à¦¾à¦¨à¦¿à¦•à¦›à¦¡à¦¼à¦¿'),(212,27,'Ramgarh','à¦°à¦¾à¦®à¦—à¦¡à¦¼'),(213,27,'Matiranga','à¦®à¦¾à¦Ÿà¦¿à¦°à¦¾à¦™à§à¦—à¦¾'),(214,28,'Sadar','à¦¬à¦¾à¦¨à§à¦¦à¦°à¦¬à¦¾à¦¨ à¦¸à¦¦à¦°'),(215,28,'Alikadam','à¦†à¦²à§€à¦•à¦¦à¦®'),(216,28,'Naikhongchhari','à¦¨à¦¾à¦‡à¦•à§à¦·à§à¦¯à¦‚à¦›à§œà¦¿'),(217,28,'Rowangchhari','à¦°à§‹à§Ÿà¦¾à¦‚à¦›à§œà¦¿'),(218,28,'Lama','à¦²à¦¾à¦®à¦¾'),(219,28,'Ruma','à¦°à§à¦®à¦¾'),(220,28,'Thanchi','à¦¥à¦¾à¦¨à¦šà¦¿'),(221,29,'Belkuchi','à¦¬à§‡à¦²à¦•à§à¦šà¦¿'),(222,29,'Chauhali','à¦šà§Œà¦¹à¦¾à¦²à¦¿'),(223,29,'Kamarkhand','à¦•à¦¾à¦®à¦¾à¦°à¦–à¦¨à§à¦¦'),(224,29,'Kazipur','à¦•à¦¾à¦œà§€à¦ªà§à¦°'),(225,29,'Raigonj','à¦°à¦¾à§Ÿà¦—à¦žà§à¦œ'),(226,29,'Shahjadpur','à¦¶à¦¾à¦¹à¦œà¦¾à¦¦à¦ªà§à¦°'),(227,29,'Sirajganjsadar','à¦¸à¦¿à¦°à¦¾à¦œà¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(228,29,'Tarash','à¦¤à¦¾à§œà¦¾à¦¶'),(229,29,'Ullapara','à¦‰à¦²à§à¦²à¦¾à¦ªà¦¾à§œà¦¾'),(230,30,'Sujanagar','à¦¸à§à¦œà¦¾à¦¨à¦—à¦°'),(231,30,'Ishurdi','à¦ˆà¦¶à§à¦¬à¦°à¦¦à§€'),(232,30,'Bhangura','à¦­à¦¾à¦™à§à¦—à§à§œà¦¾'),(233,30,'Pabnasadar','à¦ªà¦¾à¦¬à¦¨à¦¾ à¦¸à¦¦à¦°'),(234,30,'Bera','à¦¬à§‡à§œà¦¾'),(235,30,'Atghoria','à¦†à¦Ÿà¦˜à¦°à¦¿à§Ÿà¦¾'),(236,30,'Chatmohar','à¦šà¦¾à¦Ÿà¦®à§‹à¦¹à¦°'),(237,30,'Santhia','à¦¸à¦¾à¦à¦¥à¦¿à§Ÿà¦¾'),(238,30,'Faridpur','à¦«à¦°à¦¿à¦¦à¦ªà§à¦°'),(239,31,'Kahaloo','à¦•à¦¾à¦¹à¦¾à¦²à§'),(240,31,'Sadar','à¦¬à¦—à§à§œà¦¾ à¦¸à¦¦à¦°'),(241,31,'Shariakandi','à¦¸à¦¾à¦°à¦¿à§Ÿà¦¾à¦•à¦¾à¦¨à§à¦¦à¦¿'),(242,31,'Shajahanpur','à¦¶à¦¾à¦œà¦¾à¦¹à¦¾à¦¨à¦ªà§à¦°'),(243,31,'Dupchanchia','à¦¦à§à¦ªà¦šà¦¾à¦šà¦¿à¦à§Ÿà¦¾'),(244,31,'Adamdighi','à¦†à¦¦à¦®à¦¦à¦¿à¦˜à¦¿'),(245,31,'Nondigram','à¦¨à¦¨à§à¦¦à¦¿à¦—à§à¦°à¦¾à¦®'),(246,31,'Sonatala','à¦¸à§‹à¦¨à¦¾à¦¤à¦²à¦¾'),(247,31,'Dhunot','à¦§à§à¦¨à¦Ÿ'),(248,31,'Gabtali','à¦—à¦¾à¦¬à¦¤à¦²à§€'),(249,31,'Sherpur','à¦¶à§‡à¦°à¦ªà§à¦°'),(250,31,'Shibganj','à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ'),(251,32,'Paba','à¦ªà¦¬à¦¾'),(252,32,'Durgapur','à¦¦à§à¦°à§à¦—à¦¾à¦ªà§à¦°'),(253,32,'Mohonpur','à¦®à§‹à¦¹à¦¨à¦ªà§à¦°'),(254,32,'Charghat','à¦šà¦¾à¦°à¦˜à¦¾à¦Ÿ'),(255,32,'Puthia','à¦ªà§à¦ à¦¿à¦¯à¦¼à¦¾'),(256,32,'Bagha','à¦¬à¦¾à¦˜à¦¾'),(257,32,'Godagari','à¦—à§‹à¦¦à¦¾à¦—à¦¾à¦¡à¦¼à§€'),(258,32,'Tanore','à¦¤à¦¾à¦¨à§‹à¦°'),(259,32,'Bagmara','à¦¬à¦¾à¦—à¦®à¦¾à¦°à¦¾'),(260,33,'Natoresadar','à¦¨à¦¾à¦Ÿà§‹à¦° à¦¸à¦¦à¦°'),(261,33,'Singra','à¦¸à¦¿à¦‚à¦¡à¦¼à¦¾'),(262,33,'Baraigram','à¦¬à¦¡à¦¼à¦¾à¦‡à¦—à§à¦°à¦¾à¦®'),(263,33,'Bagatipara','à¦¬à¦¾à¦—à¦¾à¦¤à¦¿à¦ªà¦¾à¦¡à¦¼à¦¾'),(264,33,'Lalpur','à¦²à¦¾à¦²à¦ªà§à¦°'),(265,33,'Gurudaspur','à¦—à§à¦°à§à¦¦à¦¾à¦¸à¦ªà§à¦°'),(266,34,'Akkelpur','à¦†à¦•à§à¦•à§‡à¦²à¦ªà§à¦°'),(267,34,'Kalai','à¦•à¦¾à¦²à¦¾à¦‡'),(268,34,'Khetlal','à¦•à§à¦·à§‡à¦¤à¦²à¦¾à¦²'),(269,34,'Panchbibi','à¦ªà¦¾à¦à¦šà¦¬à¦¿à¦¬à¦¿'),(270,34,'Joypurhatsadar','à¦œà§Ÿà¦ªà§à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°'),(271,35,'Chapainawabganjsadar','à¦šà¦¾à¦à¦ªà¦¾à¦‡à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(272,35,'Gomostapur','à¦—à§‹à¦®à¦¸à§à¦¤à¦¾à¦ªà§à¦°'),(273,35,'Nachol','à¦¨à¦¾à¦šà§‹à¦²'),(274,35,'Bholahat','à¦­à§‹à¦²à¦¾à¦¹à¦¾à¦Ÿ'),(275,35,'Shibganj','à¦¶à¦¿à¦¬à¦—à¦žà§à¦œ'),(276,36,'Mohadevpur','à¦®à¦¹à¦¾à¦¦à§‡à¦¬à¦ªà§à¦°'),(277,36,'Badalgachi','à¦¬à¦¦à¦²à¦—à¦¾à¦›à§€'),(278,36,'Patnitala','à¦ªà¦¤à§à¦¨à¦¿à¦¤à¦²à¦¾'),(279,36,'Dhamoirhat','à¦§à¦¾à¦®à¦‡à¦°à¦¹à¦¾à¦Ÿ'),(280,36,'Niamatpur','à¦¨à¦¿à§Ÿà¦¾à¦®à¦¤à¦ªà§à¦°'),(281,36,'Manda','à¦®à¦¾à¦¨à§à¦¦à¦¾'),(282,36,'Atrai','à¦†à¦¤à§à¦°à¦¾à¦‡'),(283,36,'Raninagar','à¦°à¦¾à¦£à§€à¦¨à¦—à¦°'),(284,36,'Naogaonsadar','à¦¨à¦“à¦—à¦¾à¦ à¦¸à¦¦à¦°'),(285,36,'Porsha','à¦ªà§‹à¦°à¦¶à¦¾'),(286,36,'Sapahar','à¦¸à¦¾à¦ªà¦¾à¦¹à¦¾à¦°'),(287,37,'Manirampur','à¦®à¦£à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(288,37,'Abhaynagar','à¦…à¦­à§Ÿà¦¨à¦—à¦°'),(289,37,'Bagherpara','à¦¬à¦¾à¦˜à¦¾à¦°à¦ªà¦¾à§œà¦¾'),(290,37,'Chougachha','à¦šà§Œà¦—à¦¾à¦›à¦¾'),(291,37,'Jhikargacha','à¦à¦¿à¦•à¦°à¦—à¦¾à¦›à¦¾'),(292,37,'Keshabpur','à¦•à§‡à¦¶à¦¬à¦ªà§à¦°'),(293,37,'Sadar','à¦¯à¦¶à§‹à¦° à¦¸à¦¦à¦°'),(294,37,'Sharsha','à¦¶à¦¾à¦°à§à¦¶à¦¾'),(295,38,'Assasuni','à¦†à¦¶à¦¾à¦¶à§à¦¨à¦¿'),(296,38,'Debhata','à¦¦à§‡à¦¬à¦¹à¦¾à¦Ÿà¦¾'),(297,38,'Kalaroa','à¦•à¦²à¦¾à¦°à§‹à§Ÿà¦¾'),(298,38,'Satkhirasadar','à¦¸à¦¾à¦¤à¦•à§à¦·à§€à¦°à¦¾ à¦¸à¦¦à¦°'),(299,38,'Shyamnagar','à¦¶à§à¦¯à¦¾à¦®à¦¨à¦—à¦°'),(300,38,'Tala','à¦¤à¦¾à¦²à¦¾'),(301,38,'Kaliganj','à¦•à¦¾à¦²à¦¿à¦—à¦žà§à¦œ'),(302,39,'Mujibnagar','à¦®à§à¦œà¦¿à¦¬à¦¨à¦—à¦°'),(303,39,'Meherpursadar','à¦®à§‡à¦¹à§‡à¦°à¦ªà§à¦° à¦¸à¦¦à¦°'),(304,39,'Gangni','à¦—à¦¾à¦‚à¦¨à§€'),(305,40,'Narailsadar','à¦¨à§œà¦¾à¦‡à¦² à¦¸à¦¦à¦°'),(306,40,'Lohagara','à¦²à§‹à¦¹à¦¾à¦—à§œà¦¾'),(307,40,'Kalia','à¦•à¦¾à¦²à¦¿à§Ÿà¦¾'),(308,41,'Chuadangasadar','à¦šà§à¦¯à¦¼à¦¾à¦¡à¦¾à¦™à§à¦—à¦¾ à¦¸à¦¦à¦°'),(309,41,'Alamdanga','à¦†à¦²à¦®à¦¡à¦¾à¦™à§à¦—à¦¾'),(310,41,'Damurhuda','à¦¦à¦¾à¦®à§à¦¡à¦¼à¦¹à§à¦¦à¦¾'),(311,41,'Jibannagar','à¦œà§€à¦¬à¦¨à¦¨à¦—à¦°'),(312,42,'Kushtiasadar','à¦•à§à¦·à§à¦Ÿà¦¿à§Ÿà¦¾ à¦¸à¦¦à¦°'),(313,42,'Kumarkhali','à¦•à§à¦®à¦¾à¦°à¦–à¦¾à¦²à§€'),(314,42,'Khoksa','à¦–à§‹à¦•à¦¸à¦¾'),(315,42,'Mirpurkushtia','à¦®à¦¿à¦°à¦ªà§à¦°'),(316,42,'Daulatpur','à¦¦à§Œà¦²à¦¤à¦ªà§à¦°'),(317,42,'Bheramara','à¦­à§‡à¦¡à¦¼à¦¾à¦®à¦¾à¦°à¦¾'),(318,43,'Shalikha','à¦¶à¦¾à¦²à¦¿à¦–à¦¾'),(319,43,'Sreepur','à¦¶à§à¦°à§€à¦ªà§à¦°'),(320,43,'Magurasadar','à¦®à¦¾à¦—à§à¦°à¦¾ à¦¸à¦¦à¦°'),(321,43,'Mohammadpur','à¦®à¦¹à¦®à§à¦®à¦¦à¦ªà§à¦°'),(322,44,'Paikgasa','à¦ªà¦¾à¦‡à¦•à¦—à¦¾à¦›à¦¾'),(323,44,'Fultola','à¦«à§à¦²à¦¤à¦²à¦¾'),(324,44,'Digholia','à¦¦à¦¿à¦˜à¦²à¦¿à§Ÿà¦¾'),(325,44,'Rupsha','à¦°à§‚à¦ªà¦¸à¦¾'),(326,44,'Terokhada','à¦¤à§‡à¦°à¦–à¦¾à¦¦à¦¾'),(327,44,'Dumuria','à¦¡à§à¦®à§à¦°à¦¿à§Ÿà¦¾'),(328,44,'Botiaghata','à¦¬à¦Ÿà¦¿à¦¯à¦¼à¦¾à¦˜à¦¾à¦Ÿà¦¾'),(329,44,'Dakop','à¦¦à¦¾à¦•à§‹à¦ª'),(330,44,'Koyra','à¦•à§Ÿà¦°à¦¾'),(331,45,'Fakirhat','à¦«à¦•à¦¿à¦°à¦¹à¦¾à¦Ÿ'),(332,45,'Sadar','à¦¬à¦¾à¦—à§‡à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°'),(333,45,'Mollahat','à¦®à§‹à¦²à§à¦²à¦¾à¦¹à¦¾à¦Ÿ'),(334,45,'Sarankhola','à¦¶à¦°à¦£à¦–à§‹à¦²à¦¾'),(335,45,'Rampal','à¦°à¦¾à¦®à¦ªà¦¾à¦²'),(336,45,'Morrelganj','à¦®à§‹à§œà§‡à¦²à¦—à¦žà§à¦œ'),(337,45,'Kachua','à¦•à¦šà§à§Ÿà¦¾'),(338,45,'Mongla','à¦®à§‹à¦‚à¦²à¦¾'),(339,45,'Chitalmari','à¦šà¦¿à¦¤à¦²à¦®à¦¾à¦°à§€'),(340,46,'Sadar','à¦à¦¿à¦¨à¦¾à¦‡à¦¦à¦¹ à¦¸à¦¦à¦°'),(341,46,'Shailkupa','à¦¶à§ˆà¦²à¦•à§à¦ªà¦¾'),(342,46,'Harinakundu','à¦¹à¦°à¦¿à¦£à¦¾à¦•à§à¦¨à§à¦¡à§'),(343,46,'Kaliganj','à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ'),(344,46,'Kotchandpur','à¦•à§‹à¦Ÿà¦šà¦¾à¦à¦¦à¦ªà§à¦°'),(345,46,'Moheshpur','à¦®à¦¹à§‡à¦¶à¦ªà§à¦°'),(346,47,'Sadar','à¦à¦¾à¦²à¦•à¦¾à¦ à¦¿ à¦¸à¦¦à¦°'),(347,47,'Kathalia','à¦•à¦¾à¦ à¦¾à¦²à¦¿à§Ÿà¦¾'),(348,47,'Nalchity','à¦¨à¦²à¦›à¦¿à¦Ÿà¦¿'),(349,48,'Bauphal','à¦¬à¦¾à¦‰à¦«à¦²'),(350,48,'Sadar','à¦ªà¦Ÿà§à§Ÿà¦¾à¦–à¦¾à¦²à§€ à¦¸à¦¦à¦°'),(351,48,'Dumki','à¦¦à§à¦®à¦•à¦¿'),(352,48,'Dashmina','à¦¦à¦¶à¦®à¦¿à¦¨à¦¾'),(353,48,'Kalapara','à¦•à¦²à¦¾à¦ªà¦¾à¦¡à¦¼à¦¾'),(354,48,'Mirzaganj','à¦®à¦¿à¦°à§à¦œà¦¾à¦—à¦žà§à¦œ'),(355,48,'Galachipa','à¦—à¦²à¦¾à¦šà¦¿à¦ªà¦¾'),(356,48,'Rangabali','à¦°à¦¾à¦™à§à¦—à¦¾à¦¬à¦¾à¦²à§€'),(357,49,'Sadar','à¦ªà¦¿à¦°à§‹à¦œà¦ªà§à¦° à¦¸à¦¦à¦°'),(358,49,'Nazirpur','à¦¨à¦¾à¦œà¦¿à¦°à¦ªà§à¦°'),(359,49,'Kawkhali','à¦•à¦¾à¦‰à¦–à¦¾à¦²à§€'),(360,49,'Zianagar','à¦œà¦¿à§Ÿà¦¾à¦¨à¦—à¦°'),(361,49,'Bhandaria','à¦­à¦¾à¦¨à§à¦¡à¦¾à¦°à¦¿à§Ÿà¦¾'),(362,49,'Mathbaria','à¦®à¦ à¦¬à¦¾à§œà§€à§Ÿà¦¾'),(363,49,'Nesarabad','à¦¨à§‡à¦›à¦¾à¦°à¦¾à¦¬à¦¾à¦¦'),(364,50,'Barisalsadar','à¦¬à¦°à¦¿à¦¶à¦¾à¦² à¦¸à¦¦à¦°'),(365,50,'Bakerganj','à¦¬à¦¾à¦•à§‡à¦°à¦—à¦žà§à¦œ'),(366,50,'Babuganj','à¦¬à¦¾à¦¬à§à¦—à¦žà§à¦œ'),(367,50,'Wazirpur','à¦‰à¦œà¦¿à¦°à¦ªà§à¦°'),(368,50,'Banaripara','à¦¬à¦¾à¦¨à¦¾à¦°à§€à¦ªà¦¾à§œà¦¾'),(369,50,'Gournadi','à¦—à§Œà¦°à¦¨à¦¦à§€'),(370,50,'Agailjhara','à¦†à¦—à§ˆà¦²à¦à¦¾à§œà¦¾'),(371,50,'Mehendiganj','à¦®à§‡à¦¹à§‡à¦¨à§à¦¦à¦¿à¦—à¦žà§à¦œ'),(372,50,'Muladi','à¦®à§à¦²à¦¾à¦¦à§€'),(373,50,'Hizla','à¦¹à¦¿à¦œà¦²à¦¾'),(374,51,'Sadar','à¦­à§‹à¦²à¦¾ à¦¸à¦¦à¦°'),(375,51,'Borhanuddin','à¦¬à§‹à¦°à¦¹à¦¾à¦¨ à¦‰à¦¦à§à¦¦à¦¿à¦¨'),(376,51,'Doulatkhan','à¦¦à§Œà¦²à¦¤à¦–à¦¾à¦¨'),(377,51,'Monpura','à¦®à¦¨à¦ªà§à¦°à¦¾'),(378,51,'Tazumuddin','à¦¤à¦œà§à¦®à¦¦à§à¦¦à¦¿à¦¨'),(379,51,'Lalmohan','à¦²à¦¾à¦²à¦®à§‹à¦¹à¦¨'),(380,52,'Amtali','à¦†à¦®à¦¤à¦²à§€'),(381,52,'Sadar','à¦¬à¦°à¦—à§à¦¨à¦¾ à¦¸à¦¦à¦°'),(382,52,'Betagi','à¦¬à§‡à¦¤à¦¾à¦—à§€'),(383,52,'Bamna','à¦¬à¦¾à¦®à¦¨à¦¾'),(384,52,'Pathorghata','à¦ªà¦¾à¦¥à¦°à¦˜à¦¾à¦Ÿà¦¾'),(385,52,'Taltali','à¦¤à¦¾à¦²à¦¤à¦²à¦¿'),(386,53,'Panchagarhsadar','à¦ªà¦žà§à¦šà¦—à¦¡à¦¼ à¦¸à¦¦à¦°'),(387,53,'Debiganj','à¦¦à§‡à¦¬à§€à¦—à¦žà§à¦œ'),(388,53,'Boda','à¦¬à§‹à¦¦à¦¾'),(389,53,'Atwari','à¦†à¦Ÿà§‹à¦¯à¦¼à¦¾à¦°à§€'),(390,53,'Tetulia','à¦¤à§‡à¦¤à§à¦²à¦¿à¦¯à¦¼à¦¾'),(391,54,'Nawabganj','à¦¨à¦¬à¦¾à¦¬à¦—à¦žà§à¦œ'),(392,54,'Birganj','à¦¬à§€à¦°à¦—à¦žà§à¦œ'),(393,54,'Ghoraghat','à¦˜à§‹à§œà¦¾à¦˜à¦¾à¦Ÿ'),(394,54,'Birampur','à¦¬à¦¿à¦°à¦¾à¦®à¦ªà§à¦°'),(395,54,'Parbatipur','à¦ªà¦¾à¦°à§à¦¬à¦¤à§€à¦ªà§à¦°'),(396,54,'Bochaganj','à¦¬à§‹à¦šà¦¾à¦—à¦žà§à¦œ'),(397,54,'Kaharol','à¦•à¦¾à¦¹à¦¾à¦°à§‹à¦²'),(398,54,'Fulbari','à¦«à§à¦²à¦¬à¦¾à§œà§€'),(399,54,'Dinajpursadar','à¦¦à¦¿à¦¨à¦¾à¦œà¦ªà§à¦° à¦¸à¦¦à¦°'),(400,54,'Hakimpur','à¦¹à¦¾à¦•à¦¿à¦®à¦ªà§à¦°'),(401,54,'Khansama','à¦–à¦¾à¦¨à¦¸à¦¾à¦®à¦¾'),(402,54,'Birol','à¦¬à¦¿à¦°à¦²'),(403,54,'Chirirbandar','à¦šà¦¿à¦°à¦¿à¦°à¦¬à¦¨à§à¦¦à¦°'),(404,55,'Sadar','à¦²à¦¾à¦²à¦®à¦¨à¦¿à¦°à¦¹à¦¾à¦Ÿ à¦¸à¦¦à¦°'),(405,55,'Kaliganj','à¦•à¦¾à¦²à§€à¦—à¦žà§à¦œ'),(406,55,'Hatibandha','à¦¹à¦¾à¦¤à§€à¦¬à¦¾à¦¨à§à¦§à¦¾'),(407,55,'Patgram','à¦ªà¦¾à¦Ÿà¦—à§à¦°à¦¾à¦®'),(408,55,'Aditmari','à¦†à¦¦à¦¿à¦¤à¦®à¦¾à¦°à§€'),(409,56,'Syedpur','à¦¸à§ˆà¦¯à¦¼à¦¦à¦ªà§à¦°'),(410,56,'Domar','à¦¡à§‹à¦®à¦¾à¦°'),(411,56,'Dimla','à¦¡à¦¿à¦®à¦²à¦¾'),(412,56,'Jaldhaka','à¦œà¦²à¦¢à¦¾à¦•à¦¾'),(413,56,'Kishorganj','à¦•à¦¿à¦¶à§‹à¦°à¦—à¦žà§à¦œ'),(414,56,'Nilphamarisadar','à¦¨à§€à¦²à¦«à¦¾à¦®à¦¾à¦°à§€ à¦¸à¦¦à¦°'),(415,57,'Sadullapur','à¦¸à¦¾à¦¦à§à¦²à§à¦²à¦¾à¦ªà§à¦°'),(416,57,'Gaibandhasadar','à¦—à¦¾à¦‡à¦¬à¦¾à¦¨à§à¦§à¦¾ à¦¸à¦¦à¦°'),(417,57,'Palashbari','à¦ªà¦²à¦¾à¦¶à¦¬à¦¾à§œà§€'),(418,57,'Saghata','à¦¸à¦¾à¦˜à¦¾à¦Ÿà¦¾'),(419,57,'Gobindaganj','à¦—à§‹à¦¬à¦¿à¦¨à§à¦¦à¦—à¦žà§à¦œ'),(420,57,'Sundarganj','à¦¸à§à¦¨à§à¦¦à¦°à¦—à¦žà§à¦œ'),(421,57,'Phulchari','à¦«à§à¦²à¦›à§œà¦¿'),(422,58,'Thakurgaonsadar','à¦ à¦¾à¦•à§à¦°à¦—à¦¾à¦à¦“ à¦¸à¦¦à¦°'),(423,58,'Pirganj','à¦ªà§€à¦°à¦—à¦žà§à¦œ'),(424,58,'Ranisankail','à¦°à¦¾à¦£à§€à¦¶à¦‚à¦•à§ˆà¦²'),(425,58,'Haripur','à¦¹à¦°à¦¿à¦ªà§à¦°'),(426,58,'Baliadangi','à¦¬à¦¾à¦²à¦¿à¦¯à¦¼à¦¾à¦¡à¦¾à¦™à§à¦—à§€'),(427,59,'Rangpursadar','à¦°à¦‚à¦ªà§à¦° à¦¸à¦¦à¦°'),(428,59,'Gangachara','à¦—à¦‚à¦—à¦¾à¦šà¦¡à¦¼à¦¾'),(429,59,'Taragonj','à¦¤à¦¾à¦°à¦¾à¦—à¦žà§à¦œ'),(430,59,'Badargonj','à¦¬à¦¦à¦°à¦—à¦žà§à¦œ'),(431,59,'Mithapukur','à¦®à¦¿à¦ à¦¾à¦ªà§à¦•à§à¦°'),(432,59,'Pirgonj','à¦ªà§€à¦°à¦—à¦žà§à¦œ'),(433,59,'Kaunia','à¦•à¦¾à¦‰à¦¨à¦¿à¦¯à¦¼à¦¾'),(434,59,'Pirgacha','à¦ªà§€à¦°à¦—à¦¾à¦›à¦¾'),(435,60,'Kurigramsadar','à¦•à§à¦¡à¦¼à¦¿à¦—à§à¦°à¦¾à¦® à¦¸à¦¦à¦°'),(436,60,'Nageshwari','à¦¨à¦¾à¦—à§‡à¦¶à§à¦¬à¦°à§€'),(437,60,'Bhurungamari','à¦­à§à¦°à§à¦™à§à¦—à¦¾à¦®à¦¾à¦°à§€'),(438,60,'Phulbari','à¦«à§à¦²à¦¬à¦¾à§œà§€'),(439,60,'Rajarhat','à¦°à¦¾à¦œà¦¾à¦°à¦¹à¦¾à¦Ÿ'),(440,60,'Ulipur','à¦‰à¦²à¦¿à¦ªà§à¦°'),(441,60,'Chilmari','à¦šà¦¿à¦²à¦®à¦¾à¦°à§€'),(442,60,'Rowmari','à¦°à§Œà¦®à¦¾à¦°à§€'),(443,60,'Charrajibpur','à¦šà¦° à¦°à¦¾à¦œà¦¿à¦¬à¦ªà§à¦°'),(444,61,'Balaganj','à¦¬à¦¾à¦²à¦¾à¦—à¦žà§à¦œ'),(445,61,'Beanibazar','à¦¬à¦¿à§Ÿà¦¾à¦¨à§€à¦¬à¦¾à¦œà¦¾à¦°'),(446,61,'Bishwanath','à¦¬à¦¿à¦¶à§à¦¬à¦¨à¦¾à¦¥'),(447,61,'Companiganj','à¦•à§‹à¦®à§à¦ªà¦¾à¦¨à§€à¦—à¦žà§à¦œ'),(448,61,'Fenchuganj','à¦«à§‡à¦žà§à¦šà§à¦—à¦žà§à¦œ'),(449,61,'Golapganj','à¦—à§‹à¦²à¦¾à¦ªà¦—à¦žà§à¦œ'),(450,61,'Gowainghat','à¦—à§‹à§Ÿà¦¾à¦‡à¦¨à¦˜à¦¾à¦Ÿ'),(451,61,'Jaintiapur','à¦œà§ˆà¦¨à§à¦¤à¦¾à¦ªà§à¦°'),(452,61,'Kanaighat','à¦•à¦¾à¦¨à¦¾à¦‡à¦˜à¦¾à¦Ÿ'),(453,61,'Sylhetsadar','à¦¸à¦¿à¦²à§‡à¦Ÿ à¦¸à¦¦à¦°'),(454,61,'Zakiganj','à¦œà¦•à¦¿à¦—à¦žà§à¦œ'),(455,61,'Dakshinsurma','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¸à§à¦°à¦®à¦¾'),(456,62,'Barlekha','à¦¬à§œà¦²à§‡à¦–à¦¾'),(457,62,'Kamolganj','à¦•à¦®à¦²à¦—à¦žà§à¦œ'),(458,62,'Kulaura','à¦•à§à¦²à¦¾à¦‰à§œà¦¾'),(459,62,'Moulvibazarsadar','à¦®à§Œà¦²à¦­à§€à¦¬à¦¾à¦œà¦¾à¦° à¦¸à¦¦à¦°'),(460,62,'Rajnagar','à¦°à¦¾à¦œà¦¨à¦—à¦°'),(461,62,'Sreemangal','à¦¶à§à¦°à§€à¦®à¦™à§à¦—à¦²'),(462,62,'Juri','à¦œà§à§œà§€'),(463,63,'Nabiganj','à¦¨à¦¬à§€à¦—à¦žà§à¦œ'),(464,63,'Bahubal','à¦¬à¦¾à¦¹à§à¦¬à¦²'),(465,63,'Ajmiriganj','à¦†à¦œà¦®à¦¿à¦°à§€à¦—à¦žà§à¦œ'),(466,63,'Baniachong','à¦¬à¦¾à¦¨à¦¿à§Ÿà¦¾à¦šà¦‚'),(467,63,'Lakhai','à¦²à¦¾à¦–à¦¾à¦‡'),(468,63,'Chunarughat','à¦šà§à¦¨à¦¾à¦°à§à¦˜à¦¾à¦Ÿ'),(469,63,'Habiganj','à¦¹à¦¬à¦¿à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(470,63,'Madhabpur','à¦®à¦¾à¦§à¦¬à¦ªà§à¦°'),(471,64,'Sadar','à¦¸à§à¦¨à¦¾à¦®à¦—à¦žà§à¦œ à¦¸à¦¦à¦°'),(472,64,'Southsunamganj','à¦¦à¦•à§à¦·à¦¿à¦£ à¦¸à§à¦¨à¦¾à¦®à¦—à¦žà§à¦œ'),(473,64,'Bishwambarpur','à¦¬à¦¿à¦¶à§à¦¬à¦®à§à¦­à¦°à¦ªà§à¦°'),(474,64,'Chhatak','à¦›à¦¾à¦¤à¦•'),(475,64,'Jagannathpur','à¦œà¦—à¦¨à§à¦¨à¦¾à¦¥à¦ªà§à¦°'),(476,64,'Dowarabazar','à¦¦à§‹à¦¯à¦¼à¦¾à¦°à¦¾à¦¬à¦¾à¦œà¦¾à¦°'),(477,64,'Tahirpur','à¦¤à¦¾à¦¹à¦¿à¦°à¦ªà§à¦°'),(478,64,'Dharmapasha','à¦§à¦°à§à¦®à¦ªà¦¾à¦¶à¦¾'),(479,64,'Jamalganj','à¦œà¦¾à¦®à¦¾à¦²à¦—à¦žà§à¦œ'),(480,64,'Shalla','à¦¶à¦¾à¦²à§à¦²à¦¾'),(481,64,'Derai','à¦¦à¦¿à¦°à¦¾à¦‡');

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `log` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `dtt_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `logs` */

/*Table structure for table `office_transactions` */

DROP TABLE IF EXISTS `office_transactions`;

CREATE TABLE `office_transactions` (
  `id_office_transaction` int unsigned NOT NULL AUTO_INCREMENT,
  `trx_type_id` tinyint unsigned NOT NULL COMMENT '`transaction_types`.`id_transaction_type`',
  `amount` decimal(10,2) unsigned NOT NULL,
  `qty_multiplier` tinyint(1) NOT NULL,
  `trx_id` int unsigned NOT NULL,
  `description` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_office_transaction`),
  KEY `trx_type_id` (`trx_type_id`),
  KEY `trx_id` (`trx_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `office_transactions` */

/*Table structure for table `order_details` */

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `id_order_detail` int NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `product_id` int DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amt` decimal(10,2) DEFAULT '0.00',
  `promotion_id` int DEFAULT NULL,
  `vat_rate` decimal(10,2) DEFAULT '0.00',
  `vat_amt` decimal(10,2) DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_order_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `order_details` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_id` int NOT NULL,
  `station_id` int DEFAULT NULL,
  `customer_id` int NOT NULL,
  `sales_person_id` int NOT NULL,
  `notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `product_amt` decimal(10,2) DEFAULT '0.00',
  `vat_amt` decimal(10,2) DEFAULT '0.00',
  `discount_amt` decimal(10,2) DEFAULT '0.00',
  `tot_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(10,2) DEFAULT '0.00',
  `due_amt` decimal(10,2) DEFAULT '0.00',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=order,2=partial sale,3=sales,4=cancel',
  `version` smallint DEFAULT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `orders` */

/*Table structure for table `payment_methods` */

DROP TABLE IF EXISTS `payment_methods`;

CREATE TABLE `payment_methods` (
  `id_payment_method` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1',
  `version` tinyint unsigned DEFAULT '1',
  PRIMARY KEY (`id_payment_method`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `payment_methods` */

insert  into `payment_methods`(`id_payment_method`,`method_name`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Cash','2017-09-23 15:22:49',0,NULL,NULL,1,1),(2,'Card','0000-00-00 00:00:00',0,NULL,NULL,1,1),(3,'MobileAccount','0000-00-00 00:00:00',0,NULL,NULL,1,1);

/*Table structure for table `product_attributes` */

DROP TABLE IF EXISTS `product_attributes`;

CREATE TABLE `product_attributes` (
  `id_attribute` int NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attribute_value` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint NOT NULL DEFAULT '1',
  `version` smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `product_attributes` */

/*Table structure for table `product_brands` */

DROP TABLE IF EXISTS `product_brands`;

CREATE TABLE `product_brands` (
  `id_product_brand` smallint unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(1024) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `img_main` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'ImageName with absoulte FilePath',
  `img_thumb` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'ImageName with absoulte FilePath',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_product_brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `product_brands` */

/*Table structure for table `product_categories` */

DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
  `id_product_category` smallint unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parent_cat_id` smallint unsigned DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_product_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `product_categories` */

/*Table structure for table `product_units` */

DROP TABLE IF EXISTS `product_units`;

CREATE TABLE `product_units` (
  `id_product_unit` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `unit_code` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `title` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` tinyint unsigned DEFAULT '1',
  PRIMARY KEY (`id_product_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `product_units` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id_product` smallint unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Product Code. Unique value.',
  `cat_id` smallint unsigned NOT NULL COMMENT 'Category ID',
  `subcat_id` smallint unsigned DEFAULT NULL COMMENT 'Subcategory ID',
  `product_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(1024) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `brand_id` smallint unsigned DEFAULT NULL,
  `is_vatable` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Vatable,2=Non vatable',
  `vat` decimal(5,2) unsigned DEFAULT '0.00' COMMENT 'Vat in %',
  `unit_id` tinyint unsigned NOT NULL,
  `buy_price` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Estimated Buying Price',
  `sell_price` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Estimated Selling Price',
  `min_stock` smallint unsigned DEFAULT NULL,
  `max_stock` smallint DEFAULT NULL,
  `product_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'FileName with absoulte FilePath',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_product`),
  UNIQUE KEY `unq_product_code` (`product_code`),
  KEY `cat_id` (`cat_id`),
  KEY `subcat_id` (`subcat_id`),
  KEY `unit_id` (`unit_id`),
  KEY `brand_id` (`brand_id`),
  KEY `idx_product_name` (`product_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `products` */

/*Table structure for table `products_suppliers` */

DROP TABLE IF EXISTS `products_suppliers`;

CREATE TABLE `products_suppliers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `porduct_id` smallint unsigned NOT NULL,
  `supplier_id` smallint unsigned NOT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_porduct_supplier` (`porduct_id`,`supplier_id`),
  KEY `porduct_id` (`porduct_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `products_suppliers_ibfk_1` FOREIGN KEY (`porduct_id`) REFERENCES `products` (`id_product`),
  CONSTRAINT `products_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `products_suppliers` */

/*Table structure for table `promotion_details` */

DROP TABLE IF EXISTS `promotion_details`;

CREATE TABLE `promotion_details` (
  `id_promotion_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `promotion_id` int unsigned NOT NULL,
  `customer_type_id` smallint unsigned DEFAULT NULL COMMENT '`customer_types`.`id_customer_type`',
  `brand_id` smallint unsigned DEFAULT NULL,
  `cat_id` smallint unsigned DEFAULT NULL,
  `subcat_id` smallint unsigned DEFAULT NULL,
  `product_id` smallint unsigned DEFAULT NULL,
  `store_id` int DEFAULT NULL,
  `batch_no` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `min_purchase_amt` decimal(10,2) unsigned DEFAULT NULL,
  `purchase_amt_from` decimal(10,2) unsigned DEFAULT NULL,
  `purchase_amt_to` decimal(10,2) unsigned DEFAULT NULL,
  `payment_type` tinyint(1) DEFAULT NULL COMMENT '1=Card,2=MobileBankAccount',
  `card_id` tinyint unsigned DEFAULT NULL COMMENT '`card_types`.`id_card_type`',
  `bank_id` tinyint unsigned DEFAULT NULL COMMENT '`banks`.`id_bank` AND `bank`.`bank_type_id`=2',
  `discount_rate` decimal(10,2) unsigned DEFAULT NULL,
  `discount_amount` decimal(10,2) unsigned DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive,1=Active,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_promotion_detail`),
  KEY `promotion_id` (`promotion_id`),
  KEY `customer_type_id` (`customer_type_id`),
  KEY `brand_id` (`brand_id`),
  KEY `cat_id` (`cat_id`),
  KEY `subcat_id` (`subcat_id`),
  KEY `product_id` (`product_id`),
  KEY `purchase_amt_from` (`purchase_amt_from`),
  KEY `purchase_amt_to` (`purchase_amt_to`),
  CONSTRAINT `promotion_details_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id_promotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `promotion_details` */

/*Table structure for table `promotion_stores` */

DROP TABLE IF EXISTS `promotion_stores`;

CREATE TABLE `promotion_stores` (
  `promotion_id` int unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  KEY `promotion_id` (`promotion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `promotion_stores` */

/*Table structure for table `promotions` */

DROP TABLE IF EXISTS `promotions`;

CREATE TABLE `promotions` (
  `id_promotion` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Promotion Title',
  `details` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Promotion Details',
  `type_id` tinyint unsigned NOT NULL COMMENT '1=Promotion on Product, 2=Promotion on Purchase, 3=Promotion on Card',
  `is_customer_type` tinyint unsigned NOT NULL,
  `is_brand` tinyint unsigned NOT NULL,
  `is_category` tinyint unsigned NOT NULL,
  `is_product` tinyint unsigned NOT NULL,
  `dt_from` date NOT NULL COMMENT 'Start date of promotion offer',
  `dt_to` date NOT NULL COMMENT 'End date of promotion offer',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive,1=Active,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_promotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `promotions` */

/*Table structure for table `purchase_attributes` */

DROP TABLE IF EXISTS `purchase_attributes`;

CREATE TABLE `purchase_attributes` (
  `id_purchase_attribute` int NOT NULL AUTO_INCREMENT,
  `order_details_id` int NOT NULL,
  `p_attribute_id` int DEFAULT NULL COMMENT 'product_attribute_id',
  `s_attribute_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `s_attribute_value` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_id` smallint DEFAULT '1',
  PRIMARY KEY (`id_purchase_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_attributes` */

/*Table structure for table `purchase_order_details` */

DROP TABLE IF EXISTS `purchase_order_details`;

CREATE TABLE `purchase_order_details` (
  `id_purchase_order_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int unsigned NOT NULL,
  `product_id` smallint unsigned NOT NULL,
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'product_code|product_name|Cat_name|Subcat_name',
  `qty` decimal(10,2) unsigned NOT NULL,
  `unit_id` tinyint unsigned DEFAULT NULL,
  `unit_amt` decimal(10,2) NOT NULL COMMENT 'Unit Amount',
  `tot_amt` decimal(10,2) NOT NULL COMMENT 'UnitAmount * Qty',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '1=Active,2=Cancled',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_purchase_order_detail`),
  KEY `purchase_order_id` (`purchase_order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchase_order_details_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id_purchase_order`),
  CONSTRAINT `purchase_order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_order_details` */

/*Table structure for table `purchase_orders` */

DROP TABLE IF EXISTS `purchase_orders`;

CREATE TABLE `purchase_orders` (
  `id_purchase_order` int unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Batch number of purchase order',
  `store_id` tinyint unsigned NOT NULL,
  `supplier_id` smallint unsigned NOT NULL,
  `supplier_details` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Name|Mobile|Email|Address',
  `tot_amt` decimal(10,2) unsigned NOT NULL COMMENT 'Ordered Amount in Total',
  `dtt_receive_est` datetime DEFAULT NULL COMMENT 'Estimated receive date-time',
  `dtt_receive_act` datetime DEFAULT NULL COMMENT 'Actual receive date-time',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Order placed, 2=order cancelled, 3=Order received',
  `version` tinyint DEFAULT '1',
  PRIMARY KEY (`id_purchase_order`),
  UNIQUE KEY `purchase_order_no` (`invoice_no`),
  KEY `store_id` (`store_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`),
  CONSTRAINT `purchase_orders_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_orders` */

/*Table structure for table `purchase_receive_details` */

DROP TABLE IF EXISTS `purchase_receive_details`;

CREATE TABLE `purchase_receive_details` (
  `id_purchase_receive_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `purchase_receive_id` int unsigned NOT NULL,
  `purchase_order_detail_id` int unsigned DEFAULT NULL,
  `product_id` smallint unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `supplier_id` smallint unsigned NOT NULL,
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Json of Product, Store and Supplier Details',
  `qty` decimal(10,2) unsigned NOT NULL,
  `unit_id` tinyint unsigned DEFAULT NULL,
  `purchase_price` decimal(10,2) unsigned NOT NULL,
  `selling_price_est` decimal(10,2) DEFAULT NULL,
  `selling_price_act` decimal(10,2) DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `discount_rate` decimal(10,2) DEFAULT NULL,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `alert_date` date DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '1=Active,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_purchase_receive_detail`),
  KEY `purchase_receive_id` (`purchase_receive_id`),
  KEY `product_id` (`product_id`),
  KEY `purchase_order_detail_id` (`purchase_order_detail_id`),
  CONSTRAINT `purchase_receive_details_ibfk_1` FOREIGN KEY (`purchase_receive_id`) REFERENCES `purchase_receives` (`id_purchase_receive`),
  CONSTRAINT `purchase_receive_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_receive_details` */

/*Table structure for table `purchase_receives` */

DROP TABLE IF EXISTS `purchase_receives`;

CREATE TABLE `purchase_receives` (
  `id_purchase_receive` int unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Batch number',
  `purchase_order_id` int unsigned DEFAULT NULL COMMENT 'Might not have purchase_order_id',
  `store_id` tinyint unsigned DEFAULT NULL,
  `supplier_id` smallint unsigned DEFAULT NULL,
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'JSon of StoreDetails|SupplierDetails for appropriate case.  Name|Mobile|Email|Address',
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `stock_mvt_reason_id` tinyint unsigned DEFAULT NULL,
  `invoice_amt` decimal(10,2) unsigned NOT NULL COMMENT 'Amount shown in invoice',
  `discount_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Discount amount by mitual discuss',
  `tot_amt` decimal(10,2) unsigned NOT NULL,
  `paid_amt` decimal(10,2) unsigned NOT NULL,
  `settle` int DEFAULT '0' COMMENT '1=settle',
  `due_amt` decimal(10,2) unsigned NOT NULL,
  `is_doc_attached` tinyint unsigned NOT NULL DEFAULT '2' COMMENT 'Indicates if document attached. If yes, check in `documents` table. 1=Yes, 2=No',
  `dtt_receive` datetime DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Received, 2=Cancled',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_purchase_receive`),
  KEY `purchase_order_id` (`purchase_order_id`),
  KEY `store_id` (`store_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `purchase_receives_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`),
  CONSTRAINT `purchase_receives_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_receives` */

/*Table structure for table `purchase_requisitions` */

DROP TABLE IF EXISTS `purchase_requisitions`;

CREATE TABLE `purchase_requisitions` (
  `id_purchase_requisition` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` smallint unsigned NOT NULL,
  `qty` decimal(10,2) unsigned NOT NULL,
  `store_id` tinyint unsigned DEFAULT NULL,
  `notes` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional)',
  `purchase_order_id` int unsigned DEFAULT NULL COMMENT 'If item is ordered, then its id will be stored here as reference',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Informed, 2=Canceled, 3=Purchase Request Sent',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_purchase_requisition`),
  KEY `product_id` (`product_id`),
  KEY `store_id` (`store_id`),
  KEY `purchase_order_id` (`purchase_order_id`),
  CONSTRAINT `purchase_requisitions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`),
  CONSTRAINT `purchase_requisitions_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `purchase_requisitions` */

/*Table structure for table `quotation_details` */

DROP TABLE IF EXISTS `quotation_details`;

CREATE TABLE `quotation_details` (
  `id_quotation_details` int NOT NULL AUTO_INCREMENT,
  `quotation_id` int NOT NULL,
  `product_id` int NOT NULL,
  `batch_no` varchar(32) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `discount_rate` smallint DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `vat_rate` smallint DEFAULT NULL,
  `vat_amt` decimal(10,2) DEFAULT NULL,
  `total_amt` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_quotation_details`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `quotation_details` */

/*Table structure for table `quotation_master` */

DROP TABLE IF EXISTS `quotation_master`;

CREATE TABLE `quotation_master` (
  `id_quotation` int NOT NULL AUTO_INCREMENT,
  `quotation_no` varchar(32) NOT NULL,
  `rivision_no` tinyint NOT NULL,
  `customer_id` int NOT NULL,
  `store_id` tinyint NOT NULL,
  `station_id` smallint NOT NULL,
  `note` text,
  `product_amt` decimal(10,2) NOT NULL,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `vat_amt` decimal(10,2) DEFAULT NULL,
  `discount_rate` decimal(10,2) DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `total_amt` decimal(10,2) NOT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` smallint DEFAULT '1',
  PRIMARY KEY (`id_quotation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `quotation_master` */

/*Table structure for table `racks` */

DROP TABLE IF EXISTS `racks`;

CREATE TABLE `racks` (
  `id_rack` smallint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` smallint NOT NULL,
  `code` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_rack`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `racks` */

/*Table structure for table `sale_adjustments` */

DROP TABLE IF EXISTS `sale_adjustments`;

CREATE TABLE `sale_adjustments` (
  `id_sale_adjustment` int unsigned NOT NULL AUTO_INCREMENT,
  `ref_sale_id` int unsigned NOT NULL,
  `type_id` tinyint unsigned NOT NULL COMMENT '1=SalesReturn, 2=SalesReplace',
  `invoice_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `station_id` smallint unsigned NOT NULL,
  `customer_id` int unsigned DEFAULT NULL COMMENT 'NULL if no existing customer',
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional). Note down any important comments here',
  `product_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `vat_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `round_amt` decimal(10,2) DEFAULT '0.00',
  `tot_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `due_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale_adjustment`),
  KEY `ref_sale_id` (`ref_sale_id`),
  KEY `store_id` (`store_id`),
  KEY `type_id` (`type_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_adjustments` */

/*Table structure for table `sale_details` */

DROP TABLE IF EXISTS `sale_details`;

CREATE TABLE `sale_details` (
  `id_sale_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int unsigned NOT NULL,
  `sale_type_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Sale, 2=SaleAdjustment, 3=Delivery, 4=Tailoring',
  `stock_id` int unsigned DEFAULT NULL,
  `product_id` smallint unsigned DEFAULT NULL,
  `product_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'product_code|product_name|Cat_name|Subcat_name',
  `cat_id` smallint unsigned DEFAULT NULL,
  `subcat_id` smallint unsigned DEFAULT NULL,
  `brand_id` smallint unsigned DEFAULT NULL,
  `qty` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Quantity. can be fractional. eg, 2.528 kg Rice',
  `unit_id` tinyint unsigned DEFAULT NULL,
  `qty_multiplier` tinyint(1) DEFAULT NULL COMMENT '-1= Sold, 1=Returned',
  `selling_price_est` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Original Selling Price',
  `selling_price_act` decimal(10,2) DEFAULT NULL COMMENT 'Selling Price After Discount',
  `discount_rate` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Discount Rate',
  `discount_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Discount Amount',
  `vat_rate` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Vat Rate',
  `vat_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Vat Amount',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted, 3=Replaced (Old), 4=Replaced (New)',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale_detail`),
  KEY `sale_id` (`sale_id`),
  KEY `stock_id` (`stock_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_details` */

/*Table structure for table `sale_promotions` */

DROP TABLE IF EXISTS `sale_promotions`;

CREATE TABLE `sale_promotions` (
  `id_sale_promotion` int NOT NULL AUTO_INCREMENT,
  `sale_id` int unsigned NOT NULL COMMENT '`sales`.`id_sale`',
  `sale_detail_id` int unsigned DEFAULT NULL COMMENT '`sale_details`.`id_sale_detail`',
  `product_id` smallint unsigned DEFAULT NULL COMMENT '`products`.`id_product`',
  `stock_id` int unsigned DEFAULT NULL COMMENT '`stocks`.`id_stock`',
  `promotion_id` int DEFAULT NULL,
  `promotion_type_id` tinyint unsigned DEFAULT NULL,
  `discount_rate` decimal(10,2) DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  PRIMARY KEY (`id_sale_promotion`),
  KEY `sale_id` (`sale_id`),
  KEY `sale_detail_id` (`sale_detail_id`),
  KEY `product_id` (`product_id`),
  KEY `stock_id` (`stock_id`),
  KEY `promotion_id` (`promotion_id`),
  KEY `promotion_type_id` (`promotion_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_promotions` */

/*Table structure for table `sale_transaction_details` */

DROP TABLE IF EXISTS `sale_transaction_details`;

CREATE TABLE `sale_transaction_details` (
  `id_sale_transaction_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `sale_transaction_id` int unsigned NOT NULL,
  `sale_id` int unsigned NOT NULL,
  `transaction_type_id` int unsigned NOT NULL DEFAULT '1' COMMENT '1=Sales, 2=Adjastment, 3=Delivery,4=Tailoring,5=Order',
  `amount` decimal(10,2) unsigned NOT NULL,
  `qty_multiplier` tinyint(1) NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale_transaction_detail`),
  KEY `sale_id` (`sale_id`),
  KEY `sale_transaction_id` (`sale_transaction_id`),
  CONSTRAINT `sale_transaction_details_ibfk_1` FOREIGN KEY (`sale_transaction_id`) REFERENCES `sale_transactions` (`id_sale_transaction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_transaction_details` */

/*Table structure for table `sale_transaction_payments` */

DROP TABLE IF EXISTS `sale_transaction_payments`;

CREATE TABLE `sale_transaction_payments` (
  `id_sale_transaction_payment` int unsigned NOT NULL AUTO_INCREMENT,
  `sale_transaction_id` int unsigned NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `qty_multiplier` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'value: 1 or -1',
  `account_id` smallint unsigned NOT NULL COMMENT '`accounts`.`id_account`',
  `payment_method_id` tinyint unsigned DEFAULT NULL COMMENT '1=Cash, 2=Card, 3=Mobile Account, 4=Check',
  `ref_acc_no` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'account_no=>Received Card Payment, check_no=>Received Check Payment, account_no=>Received Mobile Account Payment',
  `ref_bank_id` tinyint unsigned DEFAULT NULL COMMENT '`banks`.`id_bank`',
  `ref_card_id` tinyint unsigned DEFAULT NULL COMMENT '`card_types`.`id_card_type`',
  `ref_trx_no` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Transaction no of card/mobile payment',
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Canceled, 3=Processing, 4=CheckBounced',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale_transaction_payment`),
  KEY `sale_transaction_id` (`sale_transaction_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `sale_transaction_payments_ibfk_1` FOREIGN KEY (`sale_transaction_id`) REFERENCES `sale_transactions` (`id_sale_transaction`),
  CONSTRAINT `sale_transaction_payments_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_transaction_payments` */

/*Table structure for table `sale_transactions` */

DROP TABLE IF EXISTS `sale_transactions`;

CREATE TABLE `sale_transactions` (
  `id_sale_transaction` int unsigned NOT NULL AUTO_INCREMENT,
  `trx_no` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_id` int unsigned DEFAULT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional) Transaction Description',
  `tot_amount` decimal(10,2) unsigned NOT NULL COMMENT '`amount`*`qty_multiplier`',
  `qty_multiplier` tinyint(1) NOT NULL COMMENT '$config[''trx_type_qty_multipliers'']',
  `is_doc_attached` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '1=Yes, 2=No. Indicates if document attached. If yes, check in `documents` table.',
  `dtt_trx` datetime NOT NULL COMMENT 'DateTime of Transaction. Default value current datetime.',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Canceled, 3=Processing, 4=CheckBounced',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale_transaction`),
  KEY `customer_id` (`customer_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sale_transactions` */

/*Table structure for table `sales` */

DROP TABLE IF EXISTS `sales`;

CREATE TABLE `sales` (
  `id_sale` int unsigned NOT NULL AUTO_INCREMENT,
  `ref_id` int unsigned DEFAULT NULL COMMENT 'ref_id=orders.id_order',
  `replace_id` int DEFAULT NULL COMMENT 'sale adjustment id =id_sale_adjustment',
  `gift_sale` int DEFAULT '0',
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'JSon of StoreDetails|CustomerDetails|SupplierDetails for appropriate case',
  `invoice_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `station_id` smallint unsigned NOT NULL,
  `customer_id` int unsigned DEFAULT NULL COMMENT 'NULL if no existing customer',
  `sales_person_id` int DEFAULT NULL,
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional). Note down any important comments here',
  `product_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `vat_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `remit_amt` decimal(10,2) DEFAULT '0.00',
  `round_amt` decimal(10,2) DEFAULT '0.00',
  `tot_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `replace_amt` decimal(10,2) DEFAULT '0.00',
  `settle` int DEFAULT '0' COMMENT '1=settle',
  `due_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `is_replacable` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Yes, 0=No, 2=Replaced, 3=Returned/MoneyBacked',
  `dtt_replace` datetime DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `commission` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=default,2=payment done',
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sale`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sales` */

/*Table structure for table `sales_person` */

DROP TABLE IF EXISTS `sales_person`;

CREATE TABLE `sales_person` (
  `id_sales_person` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  `person_type` int NOT NULL COMMENT '1=users,2=investor,3=supplier,4=customer',
  `commission` float(6,2) DEFAULT NULL,
  `curr_balance` float(10,2) DEFAULT '0.00',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint DEFAULT '1',
  `version` smallint DEFAULT '0',
  PRIMARY KEY (`id_sales_person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sales_person` */

/*Table structure for table `sales_person_comm` */

DROP TABLE IF EXISTS `sales_person_comm`;

CREATE TABLE `sales_person_comm` (
  `id_sales_person_comm` int NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sales_person_id` int NOT NULL,
  `store_id` smallint DEFAULT NULL,
  `notes` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `qty_multiplier` tinyint(1) DEFAULT NULL,
  `comm_rate` decimal(10,2) DEFAULT NULL,
  `invoice_amt` decimal(10,2) DEFAULT '0.00',
  `tot_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` tinyint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` tinyint DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=sataled,2=not sataled',
  PRIMARY KEY (`id_sales_person_comm`),
  KEY `sales_person_id` (`sales_person_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sales_person_comm` */

/*Table structure for table `sales_person_comm_details` */

DROP TABLE IF EXISTS `sales_person_comm_details`;

CREATE TABLE `sales_person_comm_details` (
  `id_sales_person_comm_details` int NOT NULL AUTO_INCREMENT,
  `sales_person_comm_id` int NOT NULL,
  `sale_id` int NOT NULL,
  `invoice_amt` decimal(10,2) DEFAULT NULL,
  `comm_amt` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id_sales_person_comm_details`),
  KEY `comm_id` (`sales_person_comm_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sales_person_comm_details` */

/*Table structure for table `sales_person_type` */

DROP TABLE IF EXISTS `sales_person_type`;

CREATE TABLE `sales_person_type` (
  `id_person_type` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `person_type_id` int DEFAULT NULL,
  `status_id` smallint DEFAULT '1',
  PRIMARY KEY (`id_person_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sales_person_type` */

insert  into `sales_person_type`(`id_person_type`,`type_name`,`person_type_id`,`status_id`) values (1,'User',1,1),(2,'Investor',2,1),(3,'Supplier',3,1),(4,'Customer',4,1);

/*Table structure for table `sms_campaign` */

DROP TABLE IF EXISTS `sms_campaign`;

CREATE TABLE `sms_campaign` (
  `id_campaign` int NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `add_date` date DEFAULT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `message_qty` int DEFAULT NULL,
  `total_sms` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` int DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` int DEFAULT NULL,
  `status_id` smallint DEFAULT '1',
  PRIMARY KEY (`id_campaign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_campaign` */

/*Table structure for table `sms_campaign_details` */

DROP TABLE IF EXISTS `sms_campaign_details`;

CREATE TABLE `sms_campaign_details` (
  `id_campaign_details` int NOT NULL AUTO_INCREMENT,
  `campaign_id` int DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT '1=send,2=invalid',
  PRIMARY KEY (`id_campaign_details`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_campaign_details` */

/*Table structure for table `sms_campaign_person` */

DROP TABLE IF EXISTS `sms_campaign_person`;

CREATE TABLE `sms_campaign_person` (
  `id_campaign_person` int NOT NULL AUTO_INCREMENT,
  `campaign_id` int DEFAULT NULL,
  `set_person_id` int DEFAULT NULL,
  `status_id` smallint DEFAULT '1' COMMENT '1=active,2=inactive',
  PRIMARY KEY (`id_campaign_person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_campaign_person` */

/*Table structure for table `sms_config` */

DROP TABLE IF EXISTS `sms_config`;

CREATE TABLE `sms_config` (
  `id_sms_config` int NOT NULL AUTO_INCREMENT,
  `sms_category` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sms_category_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sms_send` int DEFAULT '0' COMMENT '0=not send,1=send',
  `sms_phone` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `sms_text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status_id` smallint DEFAULT '1' COMMENT '0=deleted,1=active,2=Inactive',
  PRIMARY KEY (`id_sms_config`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_config` */

insert  into `sms_config`(`id_sms_config`,`sms_category`,`sms_category_name`,`sms_send`,`sms_phone`,`sms_text`,`status_id`) values (1,'customer_add','Add New Customer',0,'0',NULL,1),(2,'customer_due','All Due Customer',0,'0',NULL,1),(3,'customer_transaction','Customer Transactions',0,'0',NULL,1),(4,'supplier_transaction','Supplier Transactions',0,'0',NULL,1),(5,'office_transaction','Office Transactions',0,'0',NULL,1),(6,'employee_transaction','Employee Transactions',0,'0',NULL,1),(7,'investor_transaction','Investor Transactions',0,'0',NULL,1),(8,'fund_transfer','Fund Transfer',0,'0',NULL,1),(9,'sales_customer','New Sale All Customers',0,'0',NULL,1),(10,'order_placement_customer','Order Placement Customer',0,'0',NULL,1);

/*Table structure for table `sms_entry_log` */

DROP TABLE IF EXISTS `sms_entry_log`;

CREATE TABLE `sms_entry_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `allocation_id` int DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_entry_log` */

/*Table structure for table `sms_send_details` */

DROP TABLE IF EXISTS `sms_send_details`;

CREATE TABLE `sms_send_details` (
  `id_send_details` int NOT NULL AUTO_INCREMENT,
  `sms_config_id` int DEFAULT NULL,
  `sms_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'ex:customer,sales,supplier',
  `ref_id` int DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_title` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_id` int DEFAULT NULL COMMENT '1=send,2=send error',
  `dtt_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id_send_details`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_send_details` */

/*Table structure for table `sms_set_person` */

DROP TABLE IF EXISTS `sms_set_person`;

CREATE TABLE `sms_set_person` (
  `id_set_person` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` int DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` int DEFAULT NULL,
  `status_id` smallint DEFAULT '1' COMMENT '1=active,2=inactive',
  PRIMARY KEY (`id_set_person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_set_person` */

/*Table structure for table `sms_set_person_details` */

DROP TABLE IF EXISTS `sms_set_person_details`;

CREATE TABLE `sms_set_person_details` (
  `id_set_person_details` int NOT NULL AUTO_INCREMENT,
  `set_person_id` int DEFAULT NULL,
  `type` int DEFAULT NULL COMMENT '1=customer,2=supplier',
  `person_id` int DEFAULT NULL COMMENT 'customer id or supplier id',
  `store_id` int DEFAULT NULL,
  `person_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_id` int DEFAULT '1' COMMENT '1=active,2=inactive,0=deleted',
  PRIMARY KEY (`id_set_person_details`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sms_set_person_details` */

/*Table structure for table `stations` */

DROP TABLE IF EXISTS `stations`;

CREATE TABLE `stations` (
  `id_station` smallint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` tinyint unsigned NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_station`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stations` */

/*Table structure for table `stock_attributes` */

DROP TABLE IF EXISTS `stock_attributes`;

CREATE TABLE `stock_attributes` (
  `id_stock_attribute` int NOT NULL AUTO_INCREMENT,
  `stock_id` int NOT NULL,
  `p_attribute_id` int DEFAULT NULL COMMENT 'product_attribute_id',
  `s_attribute_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `s_attribute_value` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_id` smallint DEFAULT '1',
  PRIMARY KEY (`id_stock_attribute`),
  KEY `idx_stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_attributes` */

/*Table structure for table `stock_audit_details` */

DROP TABLE IF EXISTS `stock_audit_details`;

CREATE TABLE `stock_audit_details` (
  `id_stock_audit_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_audit_id` int unsigned NOT NULL,
  `stock_id` int unsigned NOT NULL,
  `qty_store` decimal(10,2) unsigned NOT NULL,
  `qty_db` decimal(10,2) unsigned NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,2=Deleted, 3=Modified',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_audit_detail`),
  KEY `stock_audit_id` (`stock_audit_id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `stock_audit_details_ibfk_1` FOREIGN KEY (`stock_audit_id`) REFERENCES `stock_audits` (`id_stock_audit`),
  CONSTRAINT `stock_audit_details_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_audit_details` */

/*Table structure for table `stock_audits` */

DROP TABLE IF EXISTS `stock_audits`;

CREATE TABLE `stock_audits` (
  `id_stock_audit` int unsigned NOT NULL AUTO_INCREMENT,
  `audit_no` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `audit_by` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dtt_audit` datetime NOT NULL,
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_doc_attached` tinyint unsigned DEFAULT '2' COMMENT 'Indicates if document attached. If yes, check in `documents` table. 1=Yes, 2=No',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Ongoing,2=Canceled,3=Completed',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_audit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_audits` */

/*Table structure for table `stock_barcodes` */

DROP TABLE IF EXISTS `stock_barcodes`;

CREATE TABLE `stock_barcodes` (
  `id_stock_barcode` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` int unsigned NOT NULL COMMENT '`stocks`.`id_stock`',
  `product_code` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT '`products`.`product_code`',
  `batch_no` int unsigned NOT NULL COMMENT '`stocks`.`batch_no`',
  `token` smallint unsigned NOT NULL COMMENT 'auto increment value starting from 1 upto qty per stock id',
  `qty` decimal(10,2) unsigned DEFAULT NULL COMMENT '1. (optional). weight value from weight machine or piece etc. 2 Unit id will come from products table',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL COMMENT '(Opional) date of sold or stock-out',
  `uid_mod` smallint unsigned DEFAULT NULL COMMENT '(Opional) uid of sold or stock-out',
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Available,2=Sold,3=Customer Return, 4=Supplier Return, 5=Other',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_barcode`),
  KEY `stock_id` (`stock_id`),
  KEY `product_code` (`product_code`),
  CONSTRAINT `stock_barcodes_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id_stock`),
  CONSTRAINT `stock_barcodes_ibfk_2` FOREIGN KEY (`product_code`) REFERENCES `products` (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_barcodes` */

/*Table structure for table `stock_mvt_details` */

DROP TABLE IF EXISTS `stock_mvt_details`;

CREATE TABLE `stock_mvt_details` (
  `id_stock_mvt_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_mvt_id` int unsigned NOT NULL,
  `rack_id` smallint unsigned DEFAULT NULL,
  `batch_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_id` smallint unsigned NOT NULL,
  `product_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'product_code|product_name|Cat_name|Subcat_name',
  `supplier_id` smallint unsigned DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL COMMENT 'Quantity. can be fractional. eg, 2.528 kg Rice',
  `unit_id` tinyint unsigned DEFAULT NULL,
  `purchase_price` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Purchase Price',
  `selling_price_est` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Estimated Selling Price per Unit',
  `selling_price_act` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Actual Selling Price per Unit',
  `discount_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Discount Amount per Unit',
  `discount_rate` decimal(10,2) unsigned DEFAULT NULL,
  `vat_rate` decimal(10,2) unsigned DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `alert_date` date DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_mvt_detail`),
  KEY `stock_mvt_id` (`stock_mvt_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_mvt_details_ibfk_1` FOREIGN KEY (`stock_mvt_id`) REFERENCES `stock_mvts` (`id_stock_mvt`),
  CONSTRAINT `stock_mvt_details_ibfk_6` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_mvt_details` */

/*Table structure for table `stock_mvt_mismatches` */

DROP TABLE IF EXISTS `stock_mvt_mismatches`;

CREATE TABLE `stock_mvt_mismatches` (
  `id_stock_mvt_mismatch` int unsigned NOT NULL AUTO_INCREMENT,
  `stk_tx_snd_id` int unsigned DEFAULT NULL COMMENT '`stock_mvts`.`id_stock_mvt`. Stock Mvts ID Send ID.',
  `stk_tx_snd_detail_id` int unsigned DEFAULT NULL COMMENT '`stock_mvt_details`.`id_stock_mvt_detail`. Stock Transfer Send Details ID.',
  `stk_tx_rcv_id` int unsigned DEFAULT NULL COMMENT '`stock_mvts`.`id_stock_mvt`. Stock Mvts ID Recieve ID.',
  `stk_tx_rcv_detail_id` int unsigned DEFAULT NULL COMMENT '`stock_mvt_details`.`id_stock_mvt_detail`. Stock Transfer Receive Details ID.',
  `mismatch_type_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Shortage, 2=Excess',
  `qty` decimal(10,2) unsigned NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id_stock_mvt_mismatch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_mvt_mismatches` */

/*Table structure for table `stock_mvt_reasons` */

DROP TABLE IF EXISTS `stock_mvt_reasons`;

CREATE TABLE `stock_mvt_reasons` (
  `id_stock_mvt_reason` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mvt_type_id` tinyint unsigned NOT NULL COMMENT '`stock_mvt_types`.`id_stock_mvt_type`',
  `qty_multiplier` tinyint NOT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Active,2=Inactive',
  `version` tinyint DEFAULT '1',
  PRIMARY KEY (`id_stock_mvt_reason`),
  UNIQUE KEY `reason` (`reason`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_mvt_reasons` */

/*Table structure for table `stock_mvt_types` */

DROP TABLE IF EXISTS `stock_mvt_types`;

CREATE TABLE `stock_mvt_types` (
  `id_stock_mvt_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `qty_multiplier` tinyint NOT NULL,
  `is_active` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_mvt_type`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Movement types and quantity modifier(+/-)';

/*Data for the table `stock_mvt_types` */

insert  into `stock_mvt_types`(`id_stock_mvt_type`,`type_name`,`description`,`qty_multiplier`,`is_active`) values (1,'Purchase Receive',NULL,1,1),(2,'Sales',NULL,-1,2),(3,'Sales Replace Old Item',NULL,1,2),(4,'Sales Replace New Item',NULL,-1,2),(5,'Sales Return',NULL,1,2),(6,'Supplier Return',NULL,-1,1),(7,'Stock Transfer Send',NULL,-1,1),(8,'Stock Transfer Receive',NULL,1,1),(9,'Wastage',NULL,-1,2),(10,'Lost',NULL,-1,2),(11,'Expired',NULL,-1,2),(12,'General Stock In',NULL,1,1),(13,'General Stock Out',NULL,-1,1);

/*Table structure for table `stock_mvts` */

DROP TABLE IF EXISTS `stock_mvts`;

CREATE TABLE `stock_mvts` (
  `id_stock_mvt` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_mvt_type_id` tinyint unsigned NOT NULL COMMENT '`stock_mvt_types`.`id_stock_mvt_type`',
  `invoice_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ref_id` int unsigned NOT NULL,
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'JSon of StoreDetails|CustomerDetails|SupplierDetails for appropriate case',
  `store_id` tinyint unsigned DEFAULT NULL,
  `customer_id` int unsigned DEFAULT NULL,
  `supplier_id` smallint unsigned DEFAULT NULL,
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional). Note down any important comments here',
  `stock_mvt_reason_id` tinyint unsigned DEFAULT NULL,
  `is_doc_attached` tinyint unsigned NOT NULL DEFAULT '2' COMMENT 'Indicates if document attached. If yes, check in `documents` table. 1=Yes, 2=No',
  `dtt_stock_mvt` datetime DEFAULT NULL COMMENT 'Date and Time of Stock Movement',
  `tot_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Total Transaction Amount',
  `paid_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Paid Transaction Amount',
  `due_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Due Transaction Amount',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock_mvt`),
  KEY `stock_mvt_type_id` (`stock_mvt_type_id`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `stock_mvts_ibfk_1` FOREIGN KEY (`stock_mvt_type_id`) REFERENCES `stock_mvt_types` (`id_stock_mvt_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_mvts` */

/*Table structure for table `stock_types` */

DROP TABLE IF EXISTS `stock_types`;

CREATE TABLE `stock_types` (
  `id_stock_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `stock_type` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_stock_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stock_types` */

insert  into `stock_types`(`id_stock_type`,`stock_type`,`description`) values (1,'General','Stock identified by product code. `stock_barcodes` tbl not needed.'),(2,'Unique Barcode','Each product have unique Barcode. unique barcodes willbe stored in `stock_barcodes` tbl.'),(3,'Weight Machine','Barcode generated from weight machine. `stock_barcodes` tbl not needed.');

/*Table structure for table `stockmvts_transactions` */

DROP TABLE IF EXISTS `stockmvts_transactions`;

CREATE TABLE `stockmvts_transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `stockmvt_id` int unsigned NOT NULL,
  `trx_detail_id` int unsigned NOT NULL,
  `tot_amt` decimal(10,2) unsigned DEFAULT NULL,
  `paid_amt` decimal(10,2) unsigned DEFAULT NULL,
  `due_amt` decimal(10,2) unsigned DEFAULT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stockmvt_id` (`stockmvt_id`),
  KEY `trx_detail_id` (`trx_detail_id`),
  CONSTRAINT `stockmvts_transactions_ibfk_1` FOREIGN KEY (`stockmvt_id`) REFERENCES `stock_mvts` (`id_stock_mvt`),
  CONSTRAINT `stockmvts_transactions_ibfk_3` FOREIGN KEY (`trx_detail_id`) REFERENCES `transaction_details` (`id_transaction_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stockmvts_transactions` */

/*Table structure for table `stocks` */

DROP TABLE IF EXISTS `stocks`;

CREATE TABLE `stocks` (
  `id_stock` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_mvt_type_id` tinyint unsigned NOT NULL,
  `stock_mvt_id` int unsigned NOT NULL,
  `stock_mvt_detail_id` int unsigned NOT NULL,
  `supplier_id` smallint unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `rack_id` smallint unsigned DEFAULT NULL,
  `batch_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_id` smallint unsigned NOT NULL,
  `qty` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Quantity. can be fractional. eg, 2.528 kg',
  `unit_id` tinyint unsigned DEFAULT NULL COMMENT '`product_units`.`id_product_unit`',
  `purchase_price` decimal(10,2) unsigned NOT NULL COMMENT 'Purchase price',
  `selling_price_est` decimal(10,2) unsigned NOT NULL COMMENT 'Estimated selling price per unit',
  `selling_price_act` decimal(10,2) unsigned NOT NULL COMMENT 'Actual selling price per unit',
  `discount_amt` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Discount amount per unit',
  `discount_rate` decimal(10,2) unsigned DEFAULT NULL,
  `vat_rate` decimal(10,2) unsigned DEFAULT NULL COMMENT 'Vat rate per unit',
  `expire_date` date DEFAULT NULL COMMENT '(Optional)',
  `alert_date` date DEFAULT NULL COMMENT '(Optional)',
  `promotion_id` int unsigned DEFAULT NULL,
  `promotion_detail_id` int unsigned DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stock`),
  KEY `stock_mvt_id` (`stock_mvt_id`),
  KEY `stock_mvt_detail_id` (`stock_mvt_detail_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`),
  KEY `qty` (`qty`),
  KEY `batch_no` (`batch_no`),
  CONSTRAINT `stocks_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`),
  CONSTRAINT `stocks_ibfk_5` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id_store`),
  CONSTRAINT `stocks_ibfk_6` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stocks` */

/*Table structure for table `stores` */

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `id_store` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` varchar(510) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address_line` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `div_id` tinyint unsigned DEFAULT NULL,
  `dist_id` tinyint unsigned DEFAULT NULL,
  `upz_id` smallint unsigned DEFAULT NULL,
  `unn_id` smallint unsigned DEFAULT NULL,
  `city_id` smallint unsigned DEFAULT NULL,
  `area_id` smallint unsigned DEFAULT NULL,
  `store_img` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vat_reg_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `post_code` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `stores` */

/*Table structure for table `supplier_payment_alerts` */

DROP TABLE IF EXISTS `supplier_payment_alerts`;

CREATE TABLE `supplier_payment_alerts` (
  `id_supplier_payment_alert` int unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` smallint unsigned NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `dtt_notification` datetime NOT NULL,
  `dtt_payment_est` datetime NOT NULL COMMENT 'Estimatted payment date',
  `dtt_payment_act` datetime DEFAULT NULL COMMENT 'Actual payment date',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=NotificationAdded, 2=Paid, 3=Unpaid, 4=Cancelled',
  `version` tinyint DEFAULT '1',
  PRIMARY KEY (`id_supplier_payment_alert`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `supplier_payment_alerts_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `supplier_payment_alerts` */

/*Table structure for table `supplier_return_details` */

DROP TABLE IF EXISTS `supplier_return_details`;

CREATE TABLE `supplier_return_details` (
  `id_supplier_return_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `supplier_return_id` int unsigned NOT NULL,
  `purchase_receive_details_id` int DEFAULT NULL,
  `product_id` smallint DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT '0.00',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `adjust_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_supplier_return_detail`),
  KEY `product_id` (`product_id`),
  KEY `supplier_return_id` (`supplier_return_id`),
  CONSTRAINT `supplier_return_details_ibfk_1` FOREIGN KEY (`supplier_return_id`) REFERENCES `supplier_returns` (`id_supplier_return`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `supplier_return_details` */

/*Table structure for table `supplier_returns` */

DROP TABLE IF EXISTS `supplier_returns`;

CREATE TABLE `supplier_returns` (
  `id_supplier_return` int unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `purchase_receive_id` int unsigned NOT NULL,
  `store_id` tinyint unsigned DEFAULT NULL,
  `supplier_id` smallint DEFAULT NULL COMMENT 'Name|Mobile|Email|Address',
  `qty` decimal(10,2) unsigned DEFAULT '0.00',
  `tot_amt` decimal(10,2) unsigned NOT NULL,
  `is_doc_attached` smallint DEFAULT NULL,
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Returned,2=Cancled',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_supplier_return`),
  KEY `purchase_receive_id` (`purchase_receive_id`),
  CONSTRAINT `supplier_returns_ibfk_1` FOREIGN KEY (`purchase_receive_id`) REFERENCES `purchase_receives` (`id_purchase_receive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `supplier_returns` */

/*Table structure for table `supplier_stores` */

DROP TABLE IF EXISTS `supplier_stores`;

CREATE TABLE `supplier_stores` (
  `id_supplier_store` int unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` smallint unsigned NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `version` tinyint unsigned DEFAULT '1',
  PRIMARY KEY (`id_supplier_store`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `supplier_stores` */

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id_supplier` smallint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Unique Code for Supplier',
  `supplier_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Supplier Name',
  `contact_person` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Supplier Phone',
  `email` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Supplier Email',
  `div_id` tinyint unsigned DEFAULT NULL COMMENT 'Division ID of Supplier',
  `dist_id` tinyint unsigned DEFAULT NULL COMMENT 'District ID of Supplier',
  `upz_id` smallint unsigned DEFAULT NULL COMMENT 'Upazila/Thana ID of Supplier',
  `unn_id` smallint unsigned DEFAULT NULL COMMENT 'Union ID of Supplier',
  `city_id` smallint unsigned DEFAULT NULL COMMENT 'City ID of Supplier',
  `area_id` smallint unsigned DEFAULT NULL COMMENT 'Area ID of Supplier',
  `profile_img` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `post_code` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'PostCode/Zip of Supplier',
  `vat_reg_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `addr_line_1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'House/Road/Flat/Region details of Supplier',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit_balance` decimal(10,2) NOT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` smallint unsigned DEFAULT '1',
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id_supplier`,`supplier_code`,`supplier_name`,`contact_person`,`phone`,`email`,`div_id`,`dist_id`,`upz_id`,`unn_id`,`city_id`,`area_id`,`profile_img`,`post_code`,`vat_reg_no`,`note`,`addr_line_1`,`balance`,`credit_balance`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'1',NULL,'Default Person','0','default@supplier.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,NULL,NULL,NULL,NULL,1,1);

/*Table structure for table `tailoring_field_types` */

DROP TABLE IF EXISTS `tailoring_field_types`;

CREATE TABLE `tailoring_field_types` (
  `id_field_type` int NOT NULL AUTO_INCREMENT,
  `field_type_name` varchar(50) NOT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `version` smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_field_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tailoring_field_types` */

insert  into `tailoring_field_types`(`id_field_type`,`field_type_name`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Measurement','2018-03-27 00:00:00',1,NULL,NULL,1,1),(2,'Design','2018-03-27 00:00:00',1,NULL,NULL,1,1),(3,'Bill','2018-03-27 00:00:00',1,NULL,NULL,1,1);

/*Table structure for table `tailoring_fields` */

DROP TABLE IF EXISTS `tailoring_fields`;

CREATE TABLE `tailoring_fields` (
  `id_field` int NOT NULL AUTO_INCREMENT,
  `field_type_id` int DEFAULT NULL COMMENT '`tailoring_field_types`.`id_field_type` for `field_type_id`',
  `service_id` int DEFAULT NULL COMMENT '`tailoring_services`.`id_service` for `service_id` if required',
  `field_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `field_img` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_required` smallint DEFAULT NULL COMMENT '1=Required,2=Non Required',
  `notes` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `version` smallint DEFAULT '1',
  PRIMARY KEY (`id_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `tailoring_fields` */

/*Table structure for table `tailoring_measurements` */

DROP TABLE IF EXISTS `tailoring_measurements`;

CREATE TABLE `tailoring_measurements` (
  `id_measurement` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `order_details_id` int DEFAULT NULL COMMENT '`tailoring_order_details`.`id_order_detail` for `order_details_id`',
  `service_id` int NOT NULL,
  `service_identify` smallint DEFAULT NULL,
  `field_type_id` int DEFAULT NULL,
  `field_id` int DEFAULT NULL COMMENT '`tailoring_fields`.`id_field` FOR `field_id`',
  `field_value` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_measurement`),
  KEY `FK_tailoring_measurements_tailoring_order_details` (`order_details_id`),
  KEY `FK2_field_id` (`field_id`),
  KEY `field_type_id` (`field_type_id`),
  CONSTRAINT `fk3_field_type_id` FOREIGN KEY (`field_type_id`) REFERENCES `tailoring_field_types` (`id_field_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `tailoring_measurements` */

/*Table structure for table `tailoring_order_details` */

DROP TABLE IF EXISTS `tailoring_order_details`;

CREATE TABLE `tailoring_order_details` (
  `id_order_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL COMMENT '`tailoring_orders`.`id_order` FOR `order_id`',
  `service_identify` smallint DEFAULT NULL,
  `service_qty` decimal(10,2) DEFAULT NULL,
  `service_id` int unsigned NOT NULL COMMENT '`tailoring_services`.`id_tailoring_service` FOR `service_id`',
  `service_price` decimal(10,2) NOT NULL COMMENT 'Service Price After Discount',
  `notes` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id_order_detail`),
  KEY `order_id` (`order_id`),
  KEY `FK1_tailoring_type_id` (`service_id`),
  CONSTRAINT `FK1_tailoring_type_id` FOREIGN KEY (`service_id`) REFERENCES `tailoring_services` (`id_service`),
  CONSTRAINT `FK_tailoring_order_details_tailoring_orders` FOREIGN KEY (`order_id`) REFERENCES `tailoring_orders` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `tailoring_order_details` */

/*Table structure for table `tailoring_orders` */

DROP TABLE IF EXISTS `tailoring_orders`;

CREATE TABLE `tailoring_orders` (
  `id_order` int unsigned NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sale_id` int NOT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `customer_id` int unsigned NOT NULL COMMENT 'NULL if no existing customer',
  `notes` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional). Note down any important comments here',
  `tailoring_price_act` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `tot_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `paid_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `due_amt` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `is_replacable` tinyint(1) DEFAULT NULL COMMENT '1=Yes, 0=No, 2=Replaced, 3=Returned/MoneyBacked',
  `dtt_replace` datetime DEFAULT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `ac_delivery_date` date DEFAULT NULL,
  `order_status` smallint DEFAULT NULL COMMENT '1=Pending, 2=Delivered',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive, 2=Deleted',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_order`),
  KEY `store_id` (`store_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `tailoring_orders` */

/*Table structure for table `tailoring_services` */

DROP TABLE IF EXISTS `tailoring_services`;

CREATE TABLE `tailoring_services` (
  `id_service` int unsigned NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint DEFAULT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint DEFAULT NULL,
  `status_id` smallint NOT NULL DEFAULT '1',
  `version` smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `tailoring_services` */

/*Table structure for table `timezones` */

DROP TABLE IF EXISTS `timezones`;

CREATE TABLE `timezones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `timezone` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `timezones` */

insert  into `timezones`(`id`,`name`,`timezone`) values (1,'(GMT-11:00) Midway Island ','Pacific/Midway'),(2,'(GMT-11:00) Samoa ','Pacific/Samoa'),(3,'(GMT-10:00) Hawaii ','Pacific/Honolulu'),(4,'(GMT-09:00) Alaska ','America/Anchorage'),(5,'(GMT-08:00) Pacific Time (US &amp; Canada) ','America/Los_Angeles'),(6,'(GMT-08:00) Tijuana ','America/Tijuana'),(7,'(GMT-07:00) Chihuahua ','America/Chihuahua'),(8,'(GMT-07:00) La Paz ','America/Chihuahua'),(9,'(GMT-07:00) Mazatlan ','America/Mazatlan'),(10,'(GMT-07:00) Mountain Time (US &amp; Canada) ','America/Denver'),(11,'(GMT-06:00) Central America ','America/Managua'),(12,'(GMT-06:00) Central Time (US &amp; Canada) ','America/Chicago'),(13,'(GMT-06:00) Guadalajara ','America/Mexico_City'),(14,'(GMT-06:00) Mexico City ','America/Mexico_City'),(15,'(GMT-06:00) Monterrey ','America/Monterrey'),(16,'(GMT-05:00) Bogota ','America/Bogota'),(17,'(GMT-05:00) Eastern Time (US &amp; Canada) ','America/New_York'),(18,'(GMT-05:00) Lima ','America/Lima'),(19,'(GMT-05:00) Quito ','America/Bogota'),(20,'(GMT-04:00) Atlantic Time (Canada) ','Canada/Atlantic'),(21,'(GMT-04:30) Caracas ','America/Caracas'),(22,'(GMT-04:00) La Paz ','America/La_Paz'),(23,'(GMT-04:00) Santiago ','America/Santiago'),(24,'(GMT-03:30) Newfoundland ','America/St_Johns'),(25,'(GMT-03:00) Brasilia ','America/Sao_Paulo'),(26,'(GMT-03:00) Buenos Aires ','America/Argentina/Buenos_Aires'),(27,'(GMT-03:00) Georgetown ','America/Argentina/Buenos_Aires'),(28,'(GMT-03:00) Greenland ','America/Godthab'),(29,'(GMT-02:00) Mid-Atlantic ','America/Noronha'),(30,'(GMT-01:00) Azores ','Atlantic/Azores'),(31,'(GMT-01:00) Cape Verde Is. ','Atlantic/Cape_Verde'),(32,'(GMT+00:00) Casablanca ','Africa/Casablanca'),(33,'(GMT+00:00) Edinburgh ','Europe/London'),(34,'(GMT+00:00) Dublin ','Europe/Dublin'),(35,'(GMT+00:00) Lisbon ','Europe/Lisbon'),(36,'(GMT+00:00) London ','Europe/London'),(37,'(GMT+00:00) Monrovia ','Africa/Monrovia'),(38,'(GMT+00:00) UTC ','UTC'),(39,'(GMT+01:00) Amsterdam ','Europe/Amsterdam'),(40,'(GMT+01:00) Belgrade ','Europe/Belgrade'),(41,'(GMT+01:00) Berlin ','Europe/Berlin'),(42,'(GMT+01:00) Bern ','Europe/Berlin'),(43,'(GMT+01:00) Bratislava ','Europe/Bratislava'),(44,'(GMT+01:00) Brussels ','Europe/Brussels'),(45,'(GMT+01:00) Budapest ','Europe/Budapest'),(46,'(GMT+01:00) Copenhagen ','Europe/Copenhagen'),(47,'(GMT+01:00) Ljubljana ','Europe/Ljubljana'),(48,'(GMT+01:00) Madrid ','Europe/Madrid'),(49,'(GMT+01:00) Paris ','Europe/Paris'),(50,'(GMT+01:00) Prague ','Europe/Prague'),(51,'(GMT+01:00) Rome ','Europe/Rome'),(52,'(GMT+01:00) Sarajevo ','Europe/Sarajevo'),(53,'(GMT+01:00) Skopje ','Europe/Skopje'),(54,'(GMT+01:00) Stockholm ','Europe/Stockholm'),(55,'(GMT+01:00) Vienna ','Europe/Vienna'),(56,'(GMT+01:00) Warsaw ','Europe/Warsaw'),(57,'(GMT+01:00) West Central Africa ','Africa/Lagos'),(58,'(GMT+01:00) Zagreb ','Europe/Zagreb'),(59,'(GMT+02:00) Athens ','Europe/Athens'),(60,'(GMT+02:00) Bucharest ','Europe/Bucharest'),(61,'(GMT+02:00) Cairo ','Africa/Cairo'),(62,'(GMT+02:00) Harare ','Africa/Harare'),(63,'(GMT+02:00) Helsinki ','Europe/Helsinki'),(64,'(GMT+02:00) Istanbul ','Europe/Istanbul'),(65,'(GMT+02:00) Jerusalem ','Asia/Jerusalem'),(66,'(GMT+02:00) Kyiv ','Europe/Helsinki'),(67,'(GMT+02:00) Pretoria ','Africa/Johannesburg'),(68,'(GMT+02:00) Riga ','Europe/Riga'),(69,'(GMT+02:00) Sofia ','Europe/Sofia'),(70,'(GMT+02:00) Tallinn ','Europe/Tallinn'),(71,'(GMT+02:00) Vilnius ','Europe/Vilnius'),(72,'(GMT+03:00) Baghdad ','Asia/Baghdad'),(73,'(GMT+03:00) Kuwait ','Asia/Kuwait'),(74,'(GMT+03:00) Minsk ','Europe/Minsk'),(75,'(GMT+03:00) Nairobi ','Africa/Nairobi'),(76,'(GMT+03:00) Riyadh ','Asia/Riyadh'),(77,'(GMT+03:00) Volgograd ','Europe/Volgograd'),(78,'(GMT+03:30) Tehran ','Asia/Tehran'),(79,'(GMT+04:00) Abu Dhabi ','Asia/Muscat'),(80,'(GMT+04:00) Baku ','Asia/Baku'),(81,'(GMT+04:00) Moscow ','Europe/Moscow'),(82,'(GMT+04:00) Muscat ','Asia/Muscat'),(83,'(GMT+04:00) St. Petersburg ','Europe/Moscow'),(84,'(GMT+04:00) Tbilisi ','Asia/Tbilisi'),(85,'(GMT+04:00) Yerevan ','Asia/Yerevan'),(86,'(GMT+04:30) Kabul ','Asia/Kabul'),(87,'(GMT+05:00) Islamabad ','Asia/Karachi'),(88,'(GMT+05:00) Karachi ','Asia/Karachi'),(89,'(GMT+05:00) Tashkent ','Asia/Tashkent'),(90,'(GMT+05:30) Chennai ','Asia/Calcutta'),(91,'(GMT+05:30) Kolkata ','Asia/Kolkata'),(92,'(GMT+05:30) Mumbai ','Asia/Calcutta'),(93,'(GMT+05:30) New Delhi ','Asia/Calcutta'),(94,'(GMT+05:30) Sri Jayawardenepura ','Asia/Calcutta'),(95,'(GMT+05:45) Kathmandu ','Asia/Katmandu'),(96,'(GMT+06:00) Almaty ','Asia/Almaty'),(97,'(GMT+06:00) Astana ','Asia/Dhaka'),(98,'(GMT+06:00) Dhaka ','Asia/Dhaka'),(99,'(GMT+06:00) Ekaterinburg ','Asia/Yekaterinburg'),(100,'(GMT+06:30) Rangoon ','Asia/Rangoon'),(101,'(GMT+07:00) Bangkok ','Asia/Bangkok'),(102,'(GMT+07:00) Hanoi ','Asia/Bangkok'),(103,'(GMT+07:00) Jakarta ','Asia/Jakarta'),(104,'(GMT+07:00) Novosibirsk ','Asia/Novosibirsk'),(105,'(GMT+08:00) Beijing ','Asia/Hong_Kong'),(106,'(GMT+08:00) Chongqing ','Asia/Chongqing'),(107,'(GMT+08:00) Hong Kong ','Asia/Hong_Kong'),(108,'(GMT+08:00) Krasnoyarsk ','Asia/Krasnoyarsk'),(109,'(GMT+08:00) Kuala Lumpur ','Asia/Kuala_Lumpur'),(110,'(GMT+08:00) Perth ','Australia/Perth'),(111,'(GMT+08:00) Singapore ','Asia/Singapore'),(112,'(GMT+08:00) Taipei ','Asia/Taipei'),(113,'(GMT+08:00) Ulaan Bataar ','Asia/Ulan_Bator'),(114,'(GMT+08:00) Urumqi ','Asia/Urumqi'),(115,'(GMT+09:00) Irkutsk ','Asia/Irkutsk'),(116,'(GMT+09:00) Osaka ','Asia/Tokyo'),(117,'(GMT+09:00) Sapporo ','Asia/Tokyo'),(118,'(GMT+09:00) Seoul ','Asia/Seoul'),(119,'(GMT+09:00) Tokyo ','Asia/Tokyo'),(120,'(GMT+09:30) Adelaide ','Australia/Adelaide'),(121,'(GMT+09:30) Darwin ','Australia/Darwin'),(122,'(GMT+10:00) Brisbane ','Australia/Brisbane'),(123,'(GMT+10:00) Canberra ','Australia/Canberra'),(124,'(GMT+10:00) Guam ','Pacific/Guam'),(125,'(GMT+10:00) Hobart ','Australia/Hobart'),(126,'(GMT+10:00) Melbourne ','Australia/Melbourne'),(127,'(GMT+10:00) Port Moresby ','Pacific/Port_Moresby'),(128,'(GMT+10:00) Sydney ','Australia/Sydney'),(129,'(GMT+10:00) Yakutsk ','Asia/Yakutsk'),(130,'(GMT+11:00) Vladivostok ','Asia/Vladivostok'),(131,'(GMT+12:00) Auckland ','Pacific/Auckland'),(132,'(GMT+12:00) Fiji ','Pacific/Fiji'),(133,'(GMT+12:00) International Date Line West ','Pacific/Kwajalein'),(134,'(GMT+12:00) Kamchatka ','Asia/Kamchatka'),(135,'(GMT+12:00) Magadan ','Asia/Magadan'),(136,'(GMT+12:00) Marshall Is. ','Pacific/Fiji'),(137,'(GMT+12:00) New Caledonia ','Asia/Magadan'),(138,'(GMT+12:00) Solomon Is. ','Asia/Magadan'),(139,'(GMT+12:00) Wellington ','Pacific/Auckland'),(140,'(GMT+13:00) Nuku\\alofa ','Pacific/Tongatapu');

/*Table structure for table `transaction_categories` */

DROP TABLE IF EXISTS `transaction_categories`;

CREATE TABLE `transaction_categories` (
  `id_transaction_category` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `trx_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parent_id` tinyint unsigned DEFAULT NULL,
  `qty_modifier` tinyint(1) NOT NULL COMMENT '1=Income,-1=Expense',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_transaction_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `transaction_categories` */

/*Table structure for table `transaction_details` */

DROP TABLE IF EXISTS `transaction_details`;

CREATE TABLE `transaction_details` (
  `id_transaction_detail` int unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int unsigned NOT NULL,
  `ref_id` int unsigned DEFAULT NULL,
  `ref_archive` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) unsigned DEFAULT NULL,
  `qty_multiplier` tinyint(1) NOT NULL COMMENT '$config[''trx_type_qty_multipliers'']',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active,2=Inactive',
  `version` tinyint unsigned NOT NULL DEFAULT '1' COMMENT 'Version of partial/full/remaiing portion payment for a particular transation.',
  PRIMARY KEY (`id_transaction_detail`),
  KEY `transaction_id` (`transaction_id`),
  KEY `ref_id` (`ref_id`),
  CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id_transaction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `transaction_details` */

/*Table structure for table `transaction_mvt_types` */

DROP TABLE IF EXISTS `transaction_mvt_types`;

CREATE TABLE `transaction_mvt_types` (
  `id_transaction_mvt_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `qty_modifier` tinyint(1) NOT NULL COMMENT '-1, 1',
  PRIMARY KEY (`id_transaction_mvt_type`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Transaction movement types and quantity modifier(+/-)';

/*Data for the table `transaction_mvt_types` */

insert  into `transaction_mvt_types`(`id_transaction_mvt_type`,`type_name`,`qty_modifier`) values (1,'Purchase Receive',-1),(2,'Sales',1),(3,'Product replace by customer (old item)',-1),(4,'Product replace by customer (new item)',1),(5,'Product return by customer',-1),(6,'Product return to supplier',1),(7,'Transfer to another store',1),(8,'Transfer from another store',-1),(9,'General Stock In',-1),(10,'General Stock Out',1),(101,'Office Transaction',0),(102,'Employee Transaction',0),(103,'Investor Transaction',0),(104,'Fund Transfer',0),(105,'Sales Commission',-1),(106,'Credit Balance',0),(107,'Advance Amount',0),(108,'Refund Amount',0);

/*Table structure for table `transaction_types` */

DROP TABLE IF EXISTS `transaction_types`;

CREATE TABLE `transaction_types` (
  `id_transaction_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `trx_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `trx_with` enum('customer','supplier','office','employee','investor') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Transaction With. Keys of $config[''trx_type_qty_modifier'']',
  `qty_multiplier` tinyint(1) NOT NULL COMMENT '1=Income,-1=Expense',
  `dtt_add` datetime DEFAULT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1',
  `sort_order` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_transaction_type`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `transaction_types` */

insert  into `transaction_types`(`id_transaction_type`,`trx_name`,`trx_with`,`qty_multiplier`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`sort_order`) values (1,'Salary','employee',-1,NULL,0,NULL,NULL,1,1),(2,'Festival Bonus','employee',-1,NULL,0,NULL,NULL,1,1),(3,'Performance Bonus','employee',-1,NULL,0,NULL,NULL,1,1),(4,'Fine','employee',1,NULL,0,NULL,NULL,1,1),(5,'House Rent','office',-1,NULL,0,NULL,NULL,1,1),(6,'Electric Bill','office',-1,NULL,0,NULL,NULL,1,1),(7,'Sublet','office',1,NULL,0,NULL,NULL,1,1),(8,'Advertisement','office',-1,NULL,0,NULL,NULL,1,1),(9,'Internet Bill','office',-1,NULL,0,NULL,NULL,1,1),(10,'Mobile Bill','office',-1,NULL,0,NULL,NULL,1,1),(11,'Invest Money','investor',1,NULL,0,NULL,NULL,1,1),(12,'Buy Share','investor',1,NULL,0,NULL,NULL,1,1),(13,'Withdraw Money','investor',-1,NULL,0,NULL,NULL,1,1),(14,'Sell Share','investor',-1,NULL,0,NULL,NULL,1,1),(15,'Incentive','employee',-1,NULL,0,NULL,NULL,1,1),(16,'Loan','employee',-1,NULL,0,NULL,NULL,1,1),(17,'Others','employee',-1,NULL,0,NULL,NULL,1,5),(18,'Loan Returns','employee',1,NULL,0,NULL,NULL,1,1),(19,'Others','employee',1,NULL,0,NULL,NULL,1,5);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id_transaction` int unsigned NOT NULL AUTO_INCREMENT,
  `trx_no` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `trx_with` enum('customer','supplier','office','employee','investor','sales person') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'Transaction With. Keys of $config[''trx_type_qty_modifier'']',
  `ref_id` int unsigned DEFAULT NULL,
  `ref_archive` varchar(512) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_id` tinyint unsigned NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT '(Optional) Transaction Description',
  `trx_mvt_type_id` tinyint unsigned NOT NULL COMMENT '`transaction_mvt_types`.`id_transaction_mvt_type`. Indicates which Type of Transaction is performing.',
  `tot_amount` decimal(10,2) unsigned NOT NULL COMMENT '`amount`*`qty_multiplier`',
  `qty_multiplier` tinyint(1) NOT NULL COMMENT '$config[''trx_type_qty_multipliers'']',
  `is_doc_attached` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '1=Yes, 2=No. Indicates if document attached. If yes, check in `documents` table.',
  `account_id` smallint unsigned NOT NULL COMMENT '`accounts`.`id_account`',
  `payment_method_id` tinyint unsigned DEFAULT NULL COMMENT '1=Cash, 2=Card, 3=Mobile Account, 4=Check',
  `ref_acc_no` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'account_no=>Received Card Payment, check_no=>Received Check Payment, account_no=>Received Mobile Account Payment',
  `ref_bank_id` tinyint unsigned DEFAULT NULL COMMENT '`banks`.`id_bank`',
  `ref_card_id` tinyint unsigned DEFAULT NULL COMMENT '`card_types`.`id_card_type`',
  `ref_trx_no` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Transaction no ofcard/mobile payment',
  `dtt_trx` datetime NOT NULL COMMENT 'DateTime of Transaction. Default value current datetime.',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Canceled, 3=Processing, 4=CheckBounced',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_transaction`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `trx_mvt_type_id` (`trx_mvt_type_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`trx_mvt_type_id`) REFERENCES `transaction_mvt_types` (`id_transaction_mvt_type`),
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id_account`),
  CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `transactions` */

/*Table structure for table `user_types` */

DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id_user_type` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted',
  `version` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `user_types` */

insert  into `user_types`(`id_user_type`,`type_name`,`description`,`dtt_add`,`uid_add`,`dtt_mod`,`uid_mod`,`status_id`,`version`) values (1,'Employee',NULL,'2017-09-15 00:00:00',1,NULL,NULL,1,1),(2,'Investor',NULL,'2017-09-06 00:00:00',1,NULL,NULL,1,1),(3,'Admin',NULL,'2017-09-20 00:00:00',1,NULL,NULL,0,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` smallint unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Login ID',
  `passwd` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'SHA1(user_password+salt)',
  `salt` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Random String',
  `fullname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nickname` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `job_title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_id` tinyint unsigned DEFAULT NULL,
  `station_id` smallint unsigned DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `resign_date` date DEFAULT NULL,
  `user_type_id` tinyint unsigned NOT NULL COMMENT 'User Type : Employee, Investor, Admin',
  `profile_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'FileName with absoulte FilePath',
  `salary` decimal(10,2) unsigned DEFAULT NULL,
  `nid` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `blood_group` enum('A+','A-','AB+','AB-','B+','B-','O+','O-') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `div_id` tinyint unsigned DEFAULT NULL COMMENT 'Division ID',
  `dist_id` tinyint unsigned DEFAULT NULL COMMENT 'District ID',
  `upz_id` smallint unsigned DEFAULT NULL COMMENT 'Upazila/Thana ID',
  `unn_id` smallint unsigned DEFAULT NULL COMMENT 'Union ID',
  `city_id` smallint unsigned DEFAULT NULL COMMENT 'City ID',
  `area_id` smallint unsigned DEFAULT NULL COMMENT 'Area ID',
  `post_code` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `addr_line_1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'House/Road/Flat/Region details',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dtt_add` datetime NOT NULL,
  `uid_add` smallint unsigned NOT NULL,
  `dtt_mod` datetime DEFAULT NULL,
  `uid_mod` smallint unsigned DEFAULT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active, 2=Deleted, 3=Resigned',
  `version` smallint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  KEY `store_id` (`store_id`),
  KEY `station_id` (`station_id`),
  KEY `div_id` (`div_id`),
  KEY `dist_id` (`dist_id`),
  KEY `upz_id` (`upz_id`),
  KEY `unn_id` (`unn_id`),
  KEY `city_id` (`city_id`),
  KEY `area_id` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `users` */

/* Function  structure for function  `fn_account_name_by_id` */

/*!50003 DROP FUNCTION IF EXISTS `fn_account_name_by_id` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_account_name_by_id`( id SMALLINT(5) ) RETURNS varchar(200) CHARSET utf8mb3 COLLATE utf8mb3_unicode_ci
BEGIN
	DECLARE account_name VARCHAR(200);
	SELECT IF(a.acc_type_id=2
		, a.account_name
		, CONCAT(b.bank_name, ' (', a.account_no, ')')
	) INTO account_name
	FROM accounts a
	LEFT JOIN banks b ON b.id_bank = a.bank_id
	WHERE a.id_account = id;
	RETURN account_name;
   
END */$$
DELIMITER ;

/* Function  structure for function  `split_string` */

/*!50003 DROP FUNCTION IF EXISTS `split_string` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `split_string`(stringToSplit VARCHAR(256), SIGN VARCHAR(12), POSITION INT) RETURNS varchar(256) CHARSET utf8mb3 COLLATE utf8mb3_unicode_ci
BEGIN
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(stringToSplit, SIGN, POSITION), 
LENGTH(SUBSTRING_INDEX(stringToSplit, SIGN, POSITION -1)) + 1), SIGN, '');
    END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_row` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_row` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `delete_row`(IN tbl VARCHAR(84), IN col VARCHAR(84), IN val VARCHAR(84))
BEGIN
DECLARE result INT;
 SET @val := CONCAT("DELETE FROM `", tbl,"` WHERE `", col, "` = '",val,"'");
 PREPARE stmt FROM @val;
 EXECUTE stmt;
 DEALLOCATE PREPARE stmt;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delivery_add` */

/*!50003 DROP PROCEDURE IF EXISTS  `delivery_add` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `delivery_add`(
	 IN d_sale_id		INT(8)
	, IN d_type_id		TINYINT(1)
	, IN d_ref_id 		INT(8)
	, IN d_person_id	INT(8)
	, IN d_cost_id 		INT(8)
	, IN d_cost_details_id 	INT(8)
	, IN d_tot_amt 		DECIMAL(10,2)
	, IN d_paid_amt 	DECIMAL(10,2)
	, IN d_discount_amt 	DECIMAL(10,2)
	, IN d_cod_charge 	DECIMAL(10,2)
	, IN d_trx_no	 	VARCHAR(30)  
	, IN d_customer_id	INT(8)
	, IN d_store_id		INT(8)
	, IN d_account_id	INT(8)
	, IN d_payment_method_id TINYINT(3)
	, IN d_ref_trx_no	VARCHAR(30)
	, IN d_address_id	INT(8)
	, IN d_address	VARCHAR(300)
	, IN d_dtt_add		DATETIME
	, IN d_uid_add		SMALLINT(5)
	, OUT d_delivery_id	INT(10)
	    
)
BEGIN
	DECLARE d_trx_id INT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET d_delivery_id := 0;
		ROLLBACK;
	END;
	SET d_delivery_id := 0;
	SET d_trx_id := 0;
	START TRANSACTION;
		INSERT INTO delivery_orders
		SET
		  sale_id = d_sale_id
		, customer_id =d_customer_id
		, type_id = d_type_id
		, ref_id = d_ref_id
		, person_id = d_person_id
		, cost_id = d_cost_id
		, cost_details_id = d_cost_details_id
		, customer_address_id = d_address_id
		, delivery_address = d_address
		, tot_amt = d_tot_amt
		, paid_amt = d_paid_amt
		, discount_amt = d_discount_amt
		, cod_charge = d_cod_charge
		, order_status = 1
		, dtt_add = d_dtt_add
		, uid_add = d_uid_add
		;
		SELECT LAST_INSERT_ID() INTO d_delivery_id;
		INSERT INTO sale_details
		SET
		  sale_id = d_sale_id
		, sale_type_id = 3
		, selling_price_act = d_tot_amt
		, dtt_add = d_dtt_add
		, uid_add = d_uid_add
		;
		
		-- UPD customer >> point, balance
		-- UPDATE customers c
		-- SET c.balance = c.balance + (d_tot_amt-d_paid_amt)
		-- WHERE c.id_customer = d_customer_id
		-- ;
		
		-- INS sale_transactions TBL and get trx_id
		INSERT INTO sale_transactions
		SET
		  trx_no 		= d_trx_no
		, customer_id 	= d_customer_id
		, store_id 		= d_store_id
		, tot_amount 	= d_tot_amt
		, qty_multiplier = 1
		, dtt_add 		= d_dtt_add
		, uid_add 		= d_uid_add
		;
		
		SET d_trx_id := LAST_INSERT_ID();
		
		-- INS sale_transaction_details TBL
		INSERT INTO sale_transaction_details
		SET
		  sale_transaction_id 	= d_trx_id
		, sale_id 		= d_sale_id
		, transaction_type_id	= 3
		, amount 		= d_tot_amt
		, dtt_add 		= d_dtt_add
		, uid_add 		= d_uid_add
		;
		
	-- chck paid amount not null ;	
	IF  (d_paid_amt!=0) THEN
		INSERT INTO sale_transaction_payments 
		SET
		  sale_transaction_id	=  d_trx_id
		, account_id		= d_account_id
		, payment_method_id	= d_payment_method_id
		, amount		= d_paid_amt
		, ref_trx_no		= d_ref_trx_no	
		;
		-- UPD accounts TBL
		UPDATE accounts AS a
		SET a.curr_balance = a.curr_balance + d_paid_amt
		WHERE a.id_account = d_account_id
		;
	END IF;
	
		
	COMMIT;
END */$$
DELIMITER ;

/* Procedure structure for procedure `delivery_payment` */

/*!50003 DROP PROCEDURE IF EXISTS  `delivery_payment` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `delivery_payment`(
	IN d_sale_id		INT(8)
	, IN d_store_id		INT(8)
	, IN d_customer_id	INT(8)
	, IN p_tot_amt 		DECIMAL(10,2)
	, IN d_tot_amt 		DECIMAL(10,2)
	, IN d_total 		DECIMAL(10,2)
	, IN d_trx_no	 	VARCHAR(30)  
	, IN d_account_id	INT(8)
	, IN d_payment_method_id TINYINT(3)
	, IN d_ref_trx_no	VARCHAR(30)
	, IN d_order_status 	TINYINT(3)
	, IN d_dtt_add		DATETIME
	, IN d_uid_add		SMALLINT(5)
	, IN d_ref_num		VARCHAR(30)
	, OUT d_delivery_id	INT(10)
)
BEGIN
    
    DECLARE d_trx_id INT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET d_delivery_id := 0;
		ROLLBACK;
	END;
	SET d_delivery_id := 0;
	SET d_trx_id := 0;
	START TRANSACTION;
	
	-- INS sale_transactions TBL and get trx_id
	INSERT INTO sale_transactions
	SET
	  trx_no 		= d_trx_no
	, customer_id 		= d_customer_id
	, store_id 		= d_store_id
	, tot_amount 		= p_tot_amt
	, qty_multiplier 	= 1
	, dtt_add 		= d_dtt_add
	, uid_add 		= d_uid_add
	;
	
	SET d_trx_id := LAST_INSERT_ID();
	SET d_delivery_id := LAST_INSERT_ID();
	
	-- INS sale_transaction_details TBL
	INSERT INTO sale_transaction_details
	SET
	  sale_transaction_id 	= d_trx_id
	, sale_id 		= d_sale_id
	, transaction_type_id	= 1
	, amount 		= p_tot_amt
	, dtt_add 		= d_dtt_add
	, uid_add 		= d_uid_add
	;
	INSERT INTO sale_transaction_payments 
	SET
	  sale_transaction_id	=  d_trx_id
	, account_id		= d_account_id
	, payment_method_id	= d_payment_method_id
	, amount		= p_tot_amt
	, ref_trx_no		= d_ref_trx_no	
	;
	-- Delivery INS sale_transactions TBL and get trx_id
	INSERT INTO sale_transactions
	SET
	  trx_no 		= d_trx_no+1
	, customer_id 		= d_customer_id
	, store_id 		= d_store_id
	, tot_amount 		= d_tot_amt
	, qty_multiplier 	= 1
	, dtt_add 		= d_dtt_add
	, uid_add 		= d_uid_add
	;
	
	SET d_trx_id := LAST_INSERT_ID();
	
	-- Delivery INS sale_transaction_details TBL
	INSERT INTO sale_transaction_details
	SET
	  sale_transaction_id 	= d_trx_id
	, sale_id 		= d_sale_id
	, transaction_type_id	= 3
	, amount 		= d_tot_amt
	, dtt_add 		= d_dtt_add
	, uid_add 		= d_uid_add
	;
	INSERT INTO sale_transaction_payments 
	SET
	  sale_transaction_id	=  d_trx_id
	, account_id		= d_account_id
	, payment_method_id	= d_payment_method_id
	, amount		= d_tot_amt
	, ref_trx_no		= d_ref_trx_no	
	;
	-- UPD accounts TBL
	UPDATE accounts AS a
	SET a.curr_balance = a.curr_balance + d_total
	WHERE a.id_account = d_account_id
	;
	-- UPD customer >> point, balance
	UPDATE customers c
	SET c.balance = c.balance - d_total
	WHERE c.id_customer = d_customer_id
	;
	
	-- UPD sales >> paid amount , due amount
	UPDATE sales s
	SET s.paid_amt = s.paid_amt + p_tot_amt
	, s.due_amt = s.due_amt - p_tot_amt
	WHERE s.id_sale = d_sale_id
	;
	-- UPD delivery >> paid amount 
	UPDATE delivery_orders d
	SET d.paid_amt = d.paid_amt + d_tot_amt
	, d.order_status=d_order_status
	, d.reference_num=d_ref_num
	WHERE d.sale_id = d_sale_id
	;
	
	
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `ImportSales` */

/*!50003 DROP PROCEDURE IF EXISTS  `ImportSales` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `ImportSales`(
	IN p_invoice_no 		VARCHAR(32)
	, IN p_store_id			TINYINT(3)
	, IN p_station_id		TINYINT(1)
	, IN p_customer_id 		INT(10)
	, IN p_customer_points	DECIMAL(10,2)
	, IN p_trx_no 			VARCHAR(24)
	, IN p_product_amt 		DECIMAL(10,2)
	, IN p_discount_amt 	DECIMAL(10,2)
	, IN p_tot_amt 			DECIMAL(10,2)
	, IN p_paid_amt 		DECIMAL(10,2)
	, IN p_remit_amt 		DECIMAL(10,2)
	, IN p_round_amt 		DECIMAL(10,2)
	, IN p_due_amt 			DECIMAL(10,2)
	, IN p_dtt_add			DATETIME
	, IN p_uid_add			SMALLINT(5)
	, IN p_note			VARCHAR(500)
	, IN p_sales_person		INT(10)
	, IN p_order_id			INT(10)
	, IN p_order_status		TINYINT(1)
	, IN p_replace_id		INT(10)
	, IN p_replace_amt		DECIMAL(10,2)
	, IN p_gift_sale		INT(1)
	, OUT p_sale_id		INT(10)
	    )
BEGIN
	DECLARE v_trx_id INT;
    
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
	-- DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;
	
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET p_sale_id := 0;
	ROLLBACK;
	END;
	SET p_sale_id := 0;
	SET v_trx_id := 0;
    
	START TRANSACTION;
	
	-- INS sales TBL
	INSERT INTO sales
	SET
	  invoice_no = p_invoice_no
	, ref_id = p_order_id
	, gift_sale = p_gift_sale
	, replace_id = p_replace_id
	, store_id = p_store_id
	, customer_id = p_customer_id
	, sales_person_id = p_sales_person
	, product_amt = p_product_amt
	, discount_amt = p_discount_amt
	, tot_amt = p_tot_amt
	, paid_amt = p_paid_amt
	, replace_amt = p_replace_amt
	, remit_amt = p_remit_amt
	, round_amt = p_round_amt
	, due_amt = p_due_amt
	, notes = p_note
	, station_id = p_station_id
	, dtt_add = p_dtt_add
	, uid_add = p_uid_add
	;
	-- SET p_sale_id = (SELECT LAST_INSERT_ID());
	SELECT LAST_INSERT_ID() INTO p_sale_id;
	
	-- INS sale_details TBL
	INSERT INTO sale_details(
	  sale_id
	, stock_id
	, product_id
	, cat_id
	, subcat_id
	, brand_id
	, qty
	, unit_id
	, selling_price_est
	, selling_price_act
	, discount_rate
	, discount_amt
	, vat_rate
	, vat_amt
	, dtt_add
	, uid_add
	)
	SELECT
	  p_sale_id
	, stock_id
	, product_id
	, cat_id
	, subcat_id
	, brand_id
	, qty
	, unit_id
	, selling_price_est
	, selling_price_act
	, discount_rate
	, discount_amt
	, vat_rate
	, vat_amt
	, p_dtt_add
	, p_uid_add
	FROM tmp_sale_details
	;
	
	-- order update
	IF (p_order_id!=0)THEN
		UPDATE orders
		SET status_id = p_order_status,
		paid_amt=0,
		due_amt=0
		WHERE id_order = p_order_id
		;
		
		UPDATE order_details AS od
		INNER JOIN tmp_order_details AS tod ON tod.product_id = od.product_id AND od.order_id=p_order_id
		SET od.sale_qty = tod.sale_qty
		;
	END IF;
	
	
	-- UPD tmp_sale_details >> sale_id, sale_detail_id
	UPDATE tmp_sale_details 
	SET sale_id = p_sale_id
	;
	UPDATE tmp_sale_details t
	INNER JOIN sale_details d 
		ON d.sale_id = t.sale_id 
		AND d.stock_id = t.stock_id 
		AND t.product_id = d.product_id
		AND d.dtt_add = p_dtt_add
	SET t.sale_detail_id = d.id_sale_detail
	;
	
	-- UPD stocks.qty
	-- UPDATE stocks s
	-- INNER JOIN tmp_sale_details t ON t.stock_id = s.id_stock
	-- SET s.qty = s.qty - t.qty
	-- where s.store_id=p_store_id
	-- ;
	
	-- UPD customer >> point, balance
	UPDATE customers c
	SET c.balance = c.balance + p_due_amt
	, c.points = c.points + p_customer_points
	WHERE c.id_customer = p_customer_id
	;
	
	-- UPD tmp_sale_promotions >> sale_id, sale_detail_id
	UPDATE tmp_sale_promotions p
	SET p.sale_id = p_sale_id
	;
	UPDATE tmp_sale_promotions p
	INNER JOIN tmp_sale_details d 
		ON d.stock_id = p.stock_id
		AND d.product_id = p.product_id
	SET p.sale_detail_id = d.sale_detail_id
	;
	
	-- INS sale_promotions 
	INSERT INTO sale_promotions (
	  sale_id
	, sale_detail_id
	, product_id
	, stock_id
	, promotion_id
	, promotion_type_id
	, discount_rate
	, discount_amt
	)
	SELECT 
	  sale_id
	, sale_detail_id
	, product_id
	, stock_id
	, promotion_id
	, promotion_type_id
	, discount_rate
	, discount_amt
	FROM tmp_sale_promotions
	;
	
	
	-- INS sale_transactions TBL and get trx_id
	INSERT INTO sale_transactions
	SET
	  trx_no 		= p_trx_no
	, customer_id 	= p_customer_id
	, store_id 		= p_store_id
	, tot_amount 	= p_tot_amt
	, qty_multiplier = 1
	, dtt_add 		= p_dtt_add
	, uid_add 		= p_uid_add
	;
	
	SET v_trx_id := LAST_INSERT_ID();
	
	/*UPDATE tmp_sale_transaction_details
	SET 
	  sale_id = p_sale_id
	, sale_transaction_id = v_trx_id
	;*/
	
	-- INS sale_transaction_details TBL
	INSERT INTO sale_transaction_details
	SET
	  sale_transaction_id 	= v_trx_id
	, sale_id 		= p_sale_id
	, amount 		= p_paid_amt
	, dtt_add 		= p_dtt_add
	, uid_add 		= p_uid_add
	;
	
	-- INS sale_transaction_payments TBL
	INSERT INTO sale_transaction_payments (
	  sale_transaction_id
	, account_id
	, payment_method_id
	, amount
	, ref_acc_no
	, ref_bank_id
	, ref_card_id
	, ref_trx_no
	)
	SELECT
	  v_trx_id
	, account_id
	, payment_method_id
	, amount
	, ref_acc_no
	, ref_bank_id
	, ref_card_id
	, ref_trx_no
	FROM tmp_sale_transaction_payments
	;
	
	-- UPD accounts TBL
	UPDATE accounts AS a
	INNER JOIN tmp_sale_transaction_payments AS t ON t.account_id = a.id_account
	SET a.curr_balance = a.curr_balance + t.amount
	;
	
	COMMIT;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_row` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_row` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `insert_row`(IN tableName VARCHAR(50),IN keyData VARCHAR(900),IN valueData VARCHAR(900))
BEGIN
	DECLARE result INT;
	SET @val := CONCAT("INSERT INTO ",tableName,"(`",REPLACE(keyData, ",", "`,`"),"`) VALUES('", REPLACE(valueData, ",", "','"), "');");
	PREPARE stmt FROM @val;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	SET result = LAST_INSERT_ID();
	SELECT result;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `insert_row_new` */

/*!50003 DROP PROCEDURE IF EXISTS  `insert_row_new` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `insert_row_new`(
IN tableName VARCHAR(50)
,IN keyData VARCHAR(9000)
,IN valueData VARCHAR(9000)
,OUT last_id	INT(10))
BEGIN
	SET last_id := 0;
	SET @val := CONCAT("INSERT INTO ",tableName,"(`",REPLACE(keyData, ",", "`,`"),"`) VALUES('", REPLACE(valueData, ",", "','"), "');");
	PREPARE stmt FROM @val;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	SELECT LAST_INSERT_ID() INTO last_id;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `order_add` */

/*!50003 DROP PROCEDURE IF EXISTS  `order_add` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `order_add`(
	IN o_invoice_no 		VARCHAR(32)
	, IN o_store_id			TINYINT(3)
	, IN o_station_id		TINYINT(1)
	, IN o_customer_id 		INT(10)
	, IN o_sales_person		INT(10)
	, IN o_product_amt 		DECIMAL(10,2)
	, IN o_vat_amt 			DECIMAL(10,2)
	, IN o_discount_amt 		DECIMAL(10,2)
	, IN o_tot_amt 			DECIMAL(10,2)
	, IN o_paid_amt 		DECIMAL(10,2)
	, IN o_due_amt 			DECIMAL(10,2)
	, IN o_dtt_add			DATETIME
	, IN o_uid_add			SMALLINT(5)
	, IN o_note			VARCHAR(500)
	, IN o_trx_no			VARCHAR(30)	
	, IN o_account_id 		INT(10)
	, IN o_payment_method_id 	INT(10)
	, IN o_ref_acc_no 		VARCHAR(50)
	, IN o_ref_bank_id 		INT(10)
	, IN o_ref_card_id 		INT(10)
	, IN o_ref_trx_no 		VARCHAR(25)
	, OUT o_order_id		INT(10)
)
BEGIN
	DECLARE v_trx_id INT;
    INSERT INTO orders
	SET
	  invoice_no = o_invoice_no
	, store_id = o_store_id
	, customer_id = o_customer_id
	, sales_person_id = o_sales_person
	, product_amt = o_product_amt
	, vat_amt = o_vat_amt
	, discount_amt = o_discount_amt
	, tot_amt = o_tot_amt
	, paid_amt = o_paid_amt
	, due_amt = o_due_amt
	, notes = o_note
	, station_id = o_station_id
	, dtt_add =o_dtt_add
	, uid_add = o_uid_add
	;
	-- SET p_sale_id = (SELECT LAST_INSERT_ID());
	SELECT LAST_INSERT_ID() INTO o_order_id;
	-- INS sale_details TBL
	INSERT INTO order_details(
	  order_id
	, product_id
	, unit_price
	, qty
	, discount_rate
	, discount_amt
	, promotion_id
	, vat_rate
	, vat_amt
	, total_price
	)
	SELECT
	  o_order_id
	, product_id
	, unit_price
	, qty
	, discount_rate
	, discount_amt
	, promotion_id
	, vat_rate
	, vat_amt
	, total_price
	FROM temp_order_details
	;
	IF (o_paid_amt!=0) THEN
		INSERT INTO sale_transactions
		SET
		  trx_no 		= o_trx_no
		, customer_id 		= o_customer_id
		, store_id 		= o_store_id
		, tot_amount 		= o_tot_amt
		, qty_multiplier 	= 1
		, dtt_add 		= o_dtt_add
		, uid_add 		= o_uid_add
		;
		
		SET v_trx_id := LAST_INSERT_ID();
		
		-- INS sale_transaction_details TBL
		INSERT INTO sale_transaction_details
		SET
		  sale_transaction_id 	= v_trx_id
		, sale_id 		= o_order_id
		, transaction_type_id	= 5
		, amount 		= o_paid_amt
		, dtt_add 		= o_dtt_add
		, uid_add 		= o_uid_add
		;
		-- INS sale_transaction_payments
		INSERT INTO sale_transaction_payments 
		SET
		  sale_transaction_id  	= v_trx_id
		, account_id		= o_account_id
		, payment_method_id	= o_payment_method_id
		, amount		= o_paid_amt
		, ref_acc_no		= o_ref_acc_no
		, ref_bank_id		= o_ref_bank_id
		, ref_card_id		= o_ref_card_id
		, ref_trx_no		= o_ref_trx_no
		;
		
		-- UPD accounts TBL
		UPDATE accounts AS a
		SET a.curr_balance = a.curr_balance + o_paid_amt
		WHERE a.id_account = o_account_id
		;
	
	END IF;
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `order_cancel_data` */

/*!50003 DROP PROCEDURE IF EXISTS  `order_cancel_data` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `order_cancel_data`(
	IN o_trx_no 		VARCHAR(32)
	, IN o_order_id 		INT(10)
	, IN o_store_id			TINYINT(3)
	, IN o_station_id		TINYINT(1)
	, IN o_customer_id 		INT(10)
	, IN o_return_amt 		DECIMAL(10,2)
	, IN o_dtt_add			DATETIME
	, IN o_uid_add			SMALLINT(5)
	, OUT out_order_id		INT(10)
)
BEGIN
	DECLARE v_trx_id INT;
	-- UPD orders
	UPDATE orders
	SET status_id = 2
	WHERE id_order = o_order_id
	;
	INSERT INTO sale_transactions
	SET
	  trx_no 		= o_trx_no
	, customer_id 		= o_customer_id
	, store_id 		= o_store_id
	, tot_amount 		= o_return_amt
	, qty_multiplier 	= -1
	, dtt_add 		= o_dtt_add
	, uid_add 		= o_uid_add
	;
	
	SET v_trx_id := LAST_INSERT_ID();
	
	-- INS sale_transaction_details TBL
	INSERT INTO sale_transaction_details
	SET
	  sale_transaction_id 	= v_trx_id
	, sale_id 		= o_order_id
	, transaction_type_id	= 5
	, qty_multiplier 	= -1
	, amount 		= o_return_amt
	, dtt_add 		= o_dtt_add
	, uid_add 		= o_uid_add
	;
	-- INS sale_transaction_payments
	INSERT INTO sale_transaction_payments 
	SET
	  sale_transaction_id  	= v_trx_id
	, account_id		= o_station_id
	, payment_method_id	= 1
	, amount		= o_return_amt
	, qty_multiplier	= -1
	;
	-- UPD accounts TBL
	UPDATE accounts AS a
	SET a.curr_balance = a.curr_balance - o_return_amt
	WHERE a.id_account = o_station_id
	;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `quotation_master` */

/*!50003 DROP PROCEDURE IF EXISTS  `quotation_master` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `quotation_master`(
	IN `to_quotation_no` VARCHAR(32), 
	IN `to_rivision_no` TINYINT(3), 
	IN `to_customer_id` INT(11), 
	IN `to_store_id` TINYINT(3), 
	IN `to_station_id` SMALLINT(5), 
	IN `to_note` TEXT, 
	IN `to_product_amt` DECIMAL(10,2), 
	IN `to_vat_amt` DECIMAL(10,2), 
	IN `to_discount_amt` DECIMAL(10,2), 
	IN `to_total_amt` DECIMAL(10,2), 
	IN `to_dtt_add` DATETIME, 
	IN `to_uid_add` SMALLINT(5),
	OUT `to_quotation_id` INT(10))
BEGIN
	
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	SET to_quotation_id := 0;
	ROLLBACK;
	END;
	SET to_quotation_id := 0;	
		
	START TRANSACTION;	
	
	-- insert into Quotation master
	INSERT INTO quotation_master
	SET
	quotation_no = to_quotation_no
	, rivision_no = to_rivision_no
	, customer_id = to_customer_id
	, store_id = to_store_id
	, station_id = to_station_id
	, note = to_note
	, product_amt = to_product_amt
	, vat_amt = to_vat_amt
	, discount_amt = to_discount_amt 
	, total_amt = to_total_amt
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	SELECT LAST_INSERT_ID() INTO to_quotation_id;
	
	-- UPD tmp_quotation_details >> quotation_id
	UPDATE `temp_quotation_details` qd
	SET qd.quotation_id = to_quotation_id
	;
	
	-- INS quotation_details 
	INSERT INTO `quotation_details` (
	quotation_id
	, product_id
	, batch_no
	, qty
	, selling_price
	, discount_rate
	, discount_amt
	, vat_rate
	, vat_amt
	, total_amt
	)
	SELECT 
	quotation_id
	, product_id
	, batch_no
	, qty
	, selling_price
	, discount_rate
	, discount_amt
	, vat_rate
	, vat_amt
	, total_amt
	FROM temp_quotation_details
	;
		
	COMMIT;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `sales_person_commission` */

/*!50003 DROP PROCEDURE IF EXISTS  `sales_person_commission` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sales_person_commission`(
	IN s_invoice_no			VARCHAR(30)
	, IN s_trx_no			VARCHAR(30)	
	, IN s_store_id			TINYINT(3)
	, IN s_sales_person		INT(10)
	, IN s_comm_rate 		DECIMAL(10,2)
	, IN s_invoice_amt 		DECIMAL(10,2)
	, IN s_tot_amt 			DECIMAL(10,2)
	, IN s_paid_amt 		DECIMAL(10,2)
	, IN s_due_amt 			DECIMAL(10,2)
	, IN s_account_id 		INT(10)
	, IN s_payment_method_id 	INT(10)
	, IN s_ref_acc_no 		VARCHAR(50)
	, IN s_ref_bank_id 		INT(10)
	, IN s_ref_card_id 		INT(10)
	, IN s_ref_trx_no 		VARCHAR(25)
	, IN s_dtt_add			DATETIME
	, IN s_uid_add			SMALLINT(5)
	, IN s_note			VARCHAR(500)
	, IN s_status_id		SMALLINT(1)
	, IN s_update_id		INT(10)
	, OUT s_sales_comm_id		INT(10)
    )
BEGIN
    DECLARE v_trx_id INT;
    IF (s_update_id != 0) THEN
		-- UPD Sales Person Commission TBL
		UPDATE sales_person_comm
		SET paid_amt 	= paid_amt + s_paid_amt
		, due_amt	=s_due_amt
		, status_id	= s_status_id
		, dtt_mod	= s_dtt_add
		,uid_mod	= s_uid_add
		WHERE id_sales_person_comm = s_update_id
		;
		SET s_sales_comm_id := s_update_id;
	ELSE 
	INSERT INTO sales_person_comm 
	SET
	   invoice_no		= s_invoice_no
	 , sales_person_id	= s_sales_person
	 , store_id		= s_store_id
	 , qty_multiplier	= '-1'
	 , comm_rate		= s_comm_rate
	 , invoice_amt		= s_invoice_amt
	 , tot_amt		= s_tot_amt
	 , paid_amt		= s_paid_amt
	 , due_amt		= s_due_amt
	 , notes		= s_note
	 , dtt_add		= s_dtt_add
	 ,uid_add		= s_uid_add
	 ,status_id		= s_status_id
	;
	SELECT LAST_INSERT_ID() INTO s_sales_comm_id;
	
	-- INSERT Sales Person Commission Details TBL
	INSERT INTO sales_person_comm_details(
	sales_person_comm_id
	, sale_id
	, invoice_amt
	, comm_amt
	, commission
	, dtt_add
	)
	SELECT
	  s_sales_comm_id
	, sale_id
	, invoice_amt
	, comm_amt
	, commission
	, dtt_add
	FROM tmp_sales_person_comm_details
	;
	-- UPD Sales TBL
	UPDATE sales AS s
	INNER JOIN tmp_sales_person_comm_details AS t ON t.sale_id = s.id_sale
	SET s.commission = '2'
	;
	
	
	END IF;	
	INSERT INTO transactions 
	SET
	 trx_no  		= s_trx_no
	 , trx_with		= 'sales person'
	 , ref_id		= s_sales_comm_id
	 , store_id		= s_store_id
	 , trx_mvt_type_id	= '105'
	 ,qty_multiplier	= '-1'
	 , account_id		= s_account_id
	 , payment_method_id	= s_payment_method_id
	 , tot_amount		= s_paid_amt
	 , ref_acc_no		= s_ref_acc_no
	 , ref_bank_id		= s_ref_bank_id
	 , ref_card_id		= s_ref_card_id
	 , ref_trx_no		= s_ref_trx_no
	 , dtt_trx		= s_dtt_add
	 , dtt_add		= s_dtt_add
	 ,uid_add		= s_uid_add
	;
	SET v_trx_id := LAST_INSERT_ID();
	-- UPD accounts TBL
	UPDATE accounts AS a
	SET a.curr_balance = a.curr_balance - s_paid_amt
	WHERE a.id_account = s_account_id
	;
	
	
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `stock_product_list` */

/*!50003 DROP PROCEDURE IF EXISTS  `stock_product_list` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `stock_product_list`(IN p_product_name VARCHAR(50), IN p_store_id TINYINT(3))
BEGIN
	SELECT
	  `b`.`id_product`        AS `id_product`,
	  `b`.`product_code`      AS `product_code`,
	  `b`.`product_name`      AS `product_name`,
	  `a`.`batch_no`          AS `batch_no`,
	  `a`.`selling_price_act` AS `selling_price_est`,
	  GROUP_CONCAT(DISTINCT CONCAT(`sta`.`s_attribute_name`,'=',`sta`.`s_attribute_value`) SEPARATOR ',') AS `attribute_name`
	FROM ((`stocks` `a`
	    JOIN `products` `b`
	      ON ((`a`.`product_id` = `b`.`id_product`)))
	   LEFT JOIN `stock_attributes` `sta`
	     ON ((`a`.`id_stock` = `sta`.`stock_id`)))
	WHERE (`a`.`qty` <> 0)
	AND a.store_id=p_store_id
	AND (b.product_name LIKE CONCAT('%',p_product_name,'%') OR b.product_code LIKE CONCAT('%',p_product_name,'%'))
	GROUP BY `a`.`batch_no`,`a`.`product_id`,`a`.`store_id`
	LIMIT 25;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `tailoring_orders` */

/*!50003 DROP PROCEDURE IF EXISTS  `tailoring_orders` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `tailoring_orders`(
	IN to_customer_id	INT(8)
 , IN to_store_id	INT(8)
 , IN to_receipt_no	VARCHAR(32)
 , IN to_notes	VARCHAR(300)
 , IN to_order_date	DATE
 , IN to_delivery_date	DATE
 , IN to_tot_amt DECIMAL(10,2)
 , IN to_paid_amt DECIMAL(10,2)
 , IN to_discount_rate DECIMAL(10,2)
 , IN to_discount_amt DECIMAL(10,2)
 , IN to_order_status SMALLINT(2)
 , IN to_station_id	TINYINT(5)
 , IN to_invoice_no	VARCHAR(32)
 , IN to_trx_no	VARCHAR(32)
 , IN to_account_id	TINYINT(5)
 , IN to_payment_method_id	TINYINT(1)
 , IN to_ref_acc_no	VARCHAR(30)
 , IN to_ref_bank_id	TINYINT(5)
 , IN to_ref_card_id	VARCHAR(30)
 , IN to_ref_trx_no	VARCHAR(30)
 , IN to_dtt_add	DATETIME
	, IN to_uid_add	SMALLINT(5)
	, OUT to_order_id	INT(10)
 )
BEGIN
 DECLARE v_trx_id INT;
 DECLARE to_sale_id INT;
 DECLARE dueBalance INT;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
	-- DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;
	
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	SET to_order_id := 0;
	ROLLBACK;
	END;
	SET to_sale_id := 0;
	SET v_trx_id := 0;
 
	START TRANSACTION;
	
	-- INS sales TBL
	INSERT INTO sales
	SET
	invoice_no = to_invoice_no
	, store_id = to_store_id
	, customer_id = to_customer_id
	, tot_amt = to_tot_amt
	, paid_amt = to_paid_amt
	, due_amt = (to_tot_amt-to_paid_amt)
	, station_id = to_station_id
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	-- SET p_sale_id = (SELECT LAST_INSERT_ID());
	SELECT LAST_INSERT_ID() INTO to_sale_id;
	
	-- Insert Sale details
	INSERT INTO sale_details
	SET
	sale_id = to_sale_id
	, sale_type_id = 4
	, selling_price_act = to_tot_amt
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	
	-- insert into tailoring orders
	INSERT INTO tailoring_orders
	SET
	receipt_no = to_receipt_no
	,sale_id = to_sale_id
	, store_id = to_store_id
	, customer_id = to_customer_id
	, notes = to_notes
	, tot_amt = to_tot_amt
	, tailoring_price_act=(to_tot_amt+to_discount_amt)
	, discount_rate= to_discount_rate
	, discount_amt= to_discount_amt 
	, order_status= to_order_status
	, paid_amt = to_paid_amt
	, due_amt = (to_tot_amt-to_paid_amt)
	, order_date = to_order_date
	, delivery_date = to_delivery_date
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	SELECT LAST_INSERT_ID() INTO to_order_id;
	
	-- UPD tmp_tailoring_order_details >> order_id
	UPDATE `tmp_tailoring_order_details` od
	SET od.order_id = to_order_id
	;
	
	-- INS tailoring_order_details 
	INSERT INTO `tailoring_order_details` (
	order_id
	, service_id
	, service_identify
	, service_qty
	, service_price
	, notes
	)
	SELECT 
	order_id
	, service_id
	, service_identify
	, service_qty
	, service_price
	, notes
	FROM tmp_tailoring_order_details
	;
	-- UPD tmp_tailoring_measurements >> order_details_id
	UPDATE tmp_tailoring_measurements m
	INNER JOIN tailoring_order_details d 
	ON d.service_identify = m.service_identify
	AND d.order_id = to_order_id
	SET m.order_details_id = d.id_order_detail
	;
	UPDATE tmp_tailoring_measurements 
	SET order_id=to_order_id
	;
	-- INS tailoring_measurements 
	INSERT INTO `tailoring_measurements` (
	order_id
	, order_details_id
	, service_id
	, service_identify
	, field_type_id
	, field_id
	, field_value
	)
	SELECT 
	order_id
	, order_details_id
	, service_id
	, service_identify
	, field_type_id
	, field_id
	, field_value
	FROM tmp_tailoring_measurements
	;
	
	-- INS sale_transactions TBL and get trx_id
	INSERT INTO sale_transactions
	SET
	trx_no = to_trx_no
	, customer_id = to_customer_id
	, store_id = to_store_id
	, tot_amount = to_tot_amt
	, qty_multiplier = 1
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	
	SET v_trx_id := LAST_INSERT_ID();
	
	-- INS sale_transaction_details TBL
	INSERT INTO sale_transaction_details
	SET
	sale_transaction_id = v_trx_id
	, sale_id = to_sale_id
	, transaction_type_id	= 4
	, amount = to_tot_amt
	, dtt_add = to_dtt_add
	, uid_add = to_uid_add
	;
	-- UPD customer >> point, balance
	SET dueBalance=to_tot_amt-to_paid_amt;
	UPDATE customers c
	SET c.balance = c.balance + dueBalance
	WHERE c.id_customer = to_customer_id
	;
	
 IF (to_paid_amt!=0) THEN
	INSERT INTO sale_transaction_payments 
	SET
	sale_transaction_id	= v_trx_id
	, account_id	= to_account_id
	, payment_method_id	= to_payment_method_id
	, amount	= to_paid_amt
	, ref_acc_no	= to_ref_acc_no
	, ref_bank_id	= to_ref_bank_id
	, ref_card_id	= to_ref_card_id
	, ref_trx_no	= to_ref_trx_no	
	;
	-- UPD accounts TBL
	UPDATE accounts AS a
	SET a.curr_balance = a.curr_balance + to_paid_amt
	WHERE a.id_account = to_account_id
	;
	END IF;
	
	COMMIT;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `tailoring_service_add` */

/*!50003 DROP PROCEDURE IF EXISTS  `tailoring_service_add` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `tailoring_service_add`(IN `t_type_name` VARCHAR(50), IN `t_type_price` DECIMAL(10,2), IN `t_dtt_add` DATETIME, IN `t_uid_add` SMALLINT(5), OUT `t_type_id` INT(10))
BEGIN
 DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	SET t_type_id := 0;
	ROLLBACK;
	END;
	SET t_type_id := 0;
 
	START TRANSACTION;
	INSERT INTO tailoring_services
	SET
	service_name = t_type_name
	, service_price = t_type_price
	, dtt_add = t_dtt_add
	, uid_add = t_uid_add
	;
	-- SET t_type_id = (SELECT LAST_INSERT_ID());
	SELECT LAST_INSERT_ID() INTO t_type_id;
	
	-- UPD tailoring_fields
	UPDATE tmp_tailoring_fields f
	SET f.service_id = t_type_id
	;
	-- INS tailoring_fields 
	INSERT INTO tailoring_fields (
	field_type_id
	, service_id
	, field_name
	,field_img
	,is_required
	,notes
	,dtt_add
	,uid_add
	)
	SELECT 
	field_type_id
	, service_id
	, field_name
	,field_img
	,is_required
	,notes
	,dtt_add
	,uid_add
	FROM tmp_tailoring_fields
	;
	
	COMMIT;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `tailoring_service_update` */

/*!50003 DROP PROCEDURE IF EXISTS  `tailoring_service_update` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `tailoring_service_update`(
IN `t_id` INT(10)
, IN `t_type_name` VARCHAR(50)
, IN `t_type_price` DECIMAL(10,2)
, IN `t_dtt_mod` DATETIME
, IN `t_uid_mod` SMALLINT(5)
, IN `t_type` VARCHAR(10)
, OUT `t_type_id` INT(10)
)
BEGIN
	
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
	SET t_type_id := 0;
	ROLLBACK;
	END;
	SET t_type_id := 0;
 
	START TRANSACTION;
	
	-- SET t_type upt= update ;
	IF t_type = 'upt' THEN
	UPDATE tailoring_services
	SET service_name = t_type_name
	, service_price = t_type_price
	, dtt_mod = t_dtt_mod
	, uid_mod = t_uid_mod
	WHERE id_service = t_id
	;
	
	
	
	-- delete table tailoring_fields
	DELETE FROM tailoring_fields 
	WHERE service_id=t_id
	;
	-- INS tailoring_fields 
	INSERT INTO tailoring_fields (
	field_type_id
	, service_id
	, field_name
	,field_img
	,is_required
	,notes
	,dtt_add
	,uid_add
	)
	SELECT 
	field_type_id
	, service_id
	, field_name
	,field_img
	,is_required
	,notes
	,dtt_add
	,uid_add
	FROM tmp_tailoring_fields
	;
	END IF;
	-- SET t_type dt= delete ;	
	IF t_type='dt' THEN
	UPDATE tailoring_services
	SET status_id = 0
	WHERE id_service = t_id
	;
	END IF;
	SET t_type_id = 1; 
	COMMIT;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `temp_order_details` */

/*!50003 DROP PROCEDURE IF EXISTS  `temp_order_details` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `temp_order_details`()
BEGIN
	DROP TABLE IF EXISTS temp_order_details;
	CREATE TEMPORARY TABLE temp_order_details (
	  product_id INT(8) DEFAULT NULL,
	  promotion_id INT(8) DEFAULT NULL,
	  qty DECIMAL(10,2) NOT NULL DEFAULT '0.00',
	  discount_rate DECIMAL(10,2) NOT NULL DEFAULT '0.00',
	  discount_amt DECIMAL(10,2) NOT NULL DEFAULT '0.00',
	  vat_rate DECIMAL(10,2) DEFAULT '0.00',
	  vat_amt DECIMAL(10,2) DEFAULT '0.00',
	  unit_price DECIMAL(10,2) NOT NULL DEFAULT '0.00',
	  total_price DECIMAL(10,2) NOT NULL DEFAULT '0.00'
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `temp_quotation_details` */

/*!50003 DROP PROCEDURE IF EXISTS  `temp_quotation_details` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `temp_quotation_details`()
BEGIN
	
	DROP TABLE IF EXISTS `temp_quotation_details`;
	CREATE TEMPORARY TABLE `temp_quotation_details` (
	`quotation_id` INT(11),
	`product_id` INT(11) DEFAULT NULL,
	`batch_no` VARCHAR(32) DEFAULT NULL,
	`qty` DECIMAL(10,2) DEFAULT NULL,
	`selling_price` DECIMAL(10,2) DEFAULT NULL,
	`discount_rate` SMALLINT(3) DEFAULT NULL,
	`discount_amt` DECIMAL(10,2) DEFAULT NULL,
	`vat_rate` SMALLINT(3) DEFAULT NULL,
	`vat_amt` DECIMAL(10,2) DEFAULT NULL,
	`total_amt` DECIMAL(10,2) DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `temp_sales_table` */

/*!50003 DROP PROCEDURE IF EXISTS  `temp_sales_table` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `temp_sales_table`()
BEGIN
	DROP TABLE IF EXISTS tmp_sale_details;
	CREATE TEMPORARY TABLE tmp_sale_details (
	  sale_id 			INT(10) 		UNSIGNED DEFAULT NULL,
	  sale_detail_id	INT(10) 		UNSIGNED DEFAULT NULL,
	  stock_id 			INT(10) 		UNSIGNED DEFAULT NULL,
	  product_id 		SMALLINT(5) 	UNSIGNED DEFAULT NULL,
	  cat_id 			SMALLINT(5) 	UNSIGNED DEFAULT NULL,
	  subcat_id 		SMALLINT(5) 	UNSIGNED DEFAULT NULL,
	  brand_id 			SMALLINT(5) 	UNSIGNED DEFAULT NULL,
	  qty 				DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  unit_id 			TINYINT(3) 		UNSIGNED DEFAULT NULL,
	  selling_price_est DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  selling_price_act DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  discount_rate 	DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  discount_amt 		DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  vat_rate 			DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  vat_amt 			DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  
	  promotion_id 		INT(11) 		DEFAULT NULL,
	  promotion_type_id TINYINT(1) 		UNSIGNED DEFAULT NULL
	  
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
	
	DROP TABLE IF EXISTS tmp_sale_promotions;
	CREATE TEMPORARY TABLE tmp_sale_promotions (
	  sale_id 			INT(10) 	UNSIGNED DEFAULT NULL
	, sale_detail_id 	INT(10) 	UNSIGNED DEFAULT NULL
	, product_id 		SMALLINT(5) UNSIGNED DEFAULT NULL
	, stock_id 			INT(10) 	UNSIGNED DEFAULT NULL
	, promotion_id 		INT(11) 	DEFAULT NULL
	, promotion_type_id TINYINT(1) 	UNSIGNED DEFAULT NULL
	, discount_rate 	DECIMAL(10,2) DEFAULT NULL
	, discount_amt 		DECIMAL(10,2) DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
	
	DROP TABLE IF EXISTS tmp_sale_transaction_payments;
	CREATE TEMPORARY TABLE tmp_sale_transaction_payments (
	  sale_transaction_id 	INT(10) 		UNSIGNED DEFAULT NULL,
	  amount 				DECIMAL(10,2) 	UNSIGNED DEFAULT NULL,
	  account_id 			SMALLINT(5) 	UNSIGNED DEFAULT NULL,
	  payment_method_id 	TINYINT(3) 		UNSIGNED DEFAULT NULL,
	  ref_acc_no 			VARCHAR(200) 	DEFAULT NULL,
	  ref_bank_id 			TINYINT(3) 		UNSIGNED DEFAULT NULL,
	  ref_card_id 			TINYINT(3) 		UNSIGNED DEFAULT NULL,
	  ref_trx_no 			VARCHAR(24) 	COLLATE utf8_unicode_ci DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
	DROP TABLE IF EXISTS tmp_order_details;
	CREATE TEMPORARY TABLE tmp_order_details (
	  product_id 	INT(10) 		UNSIGNED DEFAULT NULL,
	  order_id	INT(10)			UNSIGNED DEFAULT NULL,
	  sale_qty 				DECIMAL(10,2) 	UNSIGNED DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	    
    END */$$
DELIMITER ;

/* Procedure structure for procedure `temp_tailoring_fields` */

/*!50003 DROP PROCEDURE IF EXISTS  `temp_tailoring_fields` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `temp_tailoring_fields`()
BEGIN
	
	DROP TABLE IF EXISTS `tmp_tailoring_fields`;
	CREATE TEMPORARY TABLE `tmp_tailoring_fields` (
	`field_type_id` INT(8) ,
	`service_id` INT(8) DEFAULT NULL,
	`field_name` VARCHAR(50) DEFAULT NULL,
	`field_img` VARCHAR(50) DEFAULT NULL,
	`is_required` SMALLINT(1) DEFAULT NULL,
	`notes` TINYTEXT NULL,
	`dtt_add` DATETIME DEFAULT NULL,
	`uid_add` SMALLINT(5) DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `temp_tailoring_orders` */

/*!50003 DROP PROCEDURE IF EXISTS  `temp_tailoring_orders` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `temp_tailoring_orders`()
BEGIN
 
	DROP TABLE IF EXISTS `tmp_tailoring_order_details`;
	CREATE TEMPORARY TABLE `tmp_tailoring_order_details` (
	`order_id` INT(10),
	`service_id` INT(8),
	service_identify SMALLINT(3),
	`service_qty` DECIMAL(10,2),
	`service_price` DECIMAL(10,2),
	`notes` TINYTEXT COLLATE utf8_unicode_ci
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
	
	DROP TABLE IF EXISTS `tmp_tailoring_measurements`;
	CREATE TEMPORARY TABLE `tmp_tailoring_measurements` (
	`order_id` INT(8),
	`order_details_id` INT(8),
	`service_id` INT(8),
	service_identify SMALLINT(3),
	`field_type_id` INT(8),
	`field_id` INT(8) ,
	`field_value` VARCHAR(50)
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `tmp_sales_comm_details` */

/*!50003 DROP PROCEDURE IF EXISTS  `tmp_sales_comm_details` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `tmp_sales_comm_details`()
BEGIN
    DROP TABLE IF EXISTS tmp_sales_person_comm_details;
	CREATE TEMPORARY TABLE tmp_sales_person_comm_details (
	  sale_id				INT(10)		DEFAULT NULL,
	  invoice_amt 				DECIMAL(10,2) 	DEFAULT NULL,
	  comm_amt 				DECIMAL(10,2) 	DEFAULT NULL,
	  commission 				DECIMAL(10,2) 	DEFAULT NULL,
	  dtt_add				DATETIME	DEFAULT NULL
	) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `update_row` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_row` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `update_row`(in_table VARCHAR(60),in_set_col VARCHAR(900),in_set_val VARCHAR(900),in_where_col VARCHAR(900),in_where_val VARCHAR(900))
BEGIN
	DECLARE result INT;
	DECLARE X INT DEFAULT 0; 
	DECLARE Y INT DEFAULT 0; 
	DECLARE Z INT DEFAULT 0; 
	SET @resultKeys='';
	SET @resultValues='';
	SELECT LENGTH(in_set_col) - LENGTH(REPLACE(in_set_col, ',', '')) INTO @noOfCommas; 
	SET Y = 1; 
	SET X = @noOfCommas + 1; 
	WHILE Y  <=  X DO 
	   SET @key=split_string(in_set_col, ',', Y); 
	   SET @val=split_string(in_set_val, ',', Y); 
	   #INSERT INTO engineer(NAME) VALUES(@engName); 
	IF Y=1 THEN
	    SET @resultKeys = CONCAT("`",@key,"`=","'",@val,"'");
	ELSE 
	    SET @resultKeys = CONCAT(@resultKeys,",`",@key,"`=","'",@val,"'");
	END IF;
	   SET  Y = Y + 1; 
	END WHILE; 
	SELECT LENGTH(in_where_col) - LENGTH(REPLACE(in_where_col, ',', '')) INTO @noOfValues; 
	SET Y = 1; 
	SET Z = @noOfValues + 1; 
	WHILE Y  <= Z DO 
	   SET @valKey=split_string(in_where_col, ',', Y); 
	   SET @valVal=split_string(in_where_val, ',', Y); 
	   #INSERT INTO engineer(NAME) VALUES(@engName); 
	IF Y=1 THEN
	    SET @resultValues = CONCAT("`",@valKey,"`=","'",@valVal,"'");
	ELSE 
	    SET @resultValues = CONCAT(@resultValues," and `",@valKey,"`=","'",@valVal,"'");
	END IF;
	   SET  Y = Y + 1; 
	END WHILE;
                
                
	SET @dyn_sql=CONCAT(
          'UPDATE ' , in_table ,
            ' SET ' , @resultKeys, '
            WHERE ' , @resultValues);
     PREPARE stmt FROM @dyn_sql;
     EXECUTE stmt;
     DEALLOCATE PREPARE stmt;
     SELECT ROW_COUNT() INTO result;
	SELECT result;
    END */$$
DELIMITER ;

/*Table structure for table `acl_access_module` */

DROP TABLE IF EXISTS `acl_access_module`;

/*!50001 DROP VIEW IF EXISTS `acl_access_module` */;
/*!50001 DROP TABLE IF EXISTS `acl_access_module` */;

/*!50001 CREATE TABLE  `acl_access_module`(
 `id_acl_module` tinyint unsigned ,
 `mod_name` varchar(128) ,
 `mod_icon` varchar(255) ,
 `parent_id` tinyint unsigned ,
 `sort` smallint unsigned ,
 `rel_url` varchar(255) ,
 `status_id` tinyint(1) ,
 `user_id` smallint unsigned 
)*/;

/*Table structure for table `acl_access_pages` */

DROP TABLE IF EXISTS `acl_access_pages`;

/*!50001 DROP VIEW IF EXISTS `acl_access_pages` */;
/*!50001 DROP TABLE IF EXISTS `acl_access_pages` */;

/*!50001 CREATE TABLE  `acl_access_pages`(
 `user_id` smallint unsigned ,
 `page_title` varchar(255) ,
 `page_id` smallint unsigned ,
 `rel_url` varchar(255) ,
 `module_name` varchar(128) ,
 `module_id` tinyint unsigned ,
 `status_id` tinyint unsigned 
)*/;

/*Table structure for table `acl_access_submodule` */

DROP TABLE IF EXISTS `acl_access_submodule`;

/*!50001 DROP VIEW IF EXISTS `acl_access_submodule` */;
/*!50001 DROP TABLE IF EXISTS `acl_access_submodule` */;

/*!50001 CREATE TABLE  `acl_access_submodule`(
 `id_acl_module` tinyint unsigned ,
 `mod_name` varchar(128) ,
 `mod_icon` varchar(255) ,
 `parent_id` tinyint unsigned ,
 `sort` smallint unsigned ,
 `rel_url` varchar(255) ,
 `status_id` tinyint(1) ,
 `user_id` smallint unsigned 
)*/;

/*Table structure for table `customer_address_view` */

DROP TABLE IF EXISTS `customer_address_view`;

/*!50001 DROP VIEW IF EXISTS `customer_address_view` */;
/*!50001 DROP TABLE IF EXISTS `customer_address_view` */;

/*!50001 CREATE TABLE  `customer_address_view`(
 `id_customer_address` int unsigned ,
 `customer_id` int unsigned ,
 `address_type` enum('Present Address','Permanent Address','Shipping Address','Billing Address') ,
 `div_id` tinyint unsigned ,
 `dist_id` tinyint unsigned ,
 `upz_id` smallint unsigned ,
 `unn_id` smallint unsigned ,
 `city_id` smallint unsigned ,
 `area_id` smallint unsigned ,
 `post_code` varchar(4) ,
 `addr_line_1` varchar(255) ,
 `division_name_en` varchar(128) ,
 `division_name_bn` varchar(128) ,
 `district_name_en` varchar(128) ,
 `district_name_bn` varchar(128) ,
 `city_name_en` varchar(128) ,
 `city_name_bn` varchar(128) ,
 `area_name_en` varchar(128) ,
 `area_name_bn` varchar(128) ,
 `union_name_en` varchar(128) ,
 `union_name_bn` varchar(128) ,
 `upazila_name_en` varchar(128) ,
 `upazila_name_bn` varchar(128) 
)*/;

/*Table structure for table `delivery_order_details` */

DROP TABLE IF EXISTS `delivery_order_details`;

/*!50001 DROP VIEW IF EXISTS `delivery_order_details` */;
/*!50001 DROP TABLE IF EXISTS `delivery_order_details` */;

/*!50001 CREATE TABLE  `delivery_order_details`(
 `id_delivery_order` int unsigned ,
 `sale_id` int unsigned ,
 `customer_id` int ,
 `type_id` smallint ,
 `ref_id` int unsigned ,
 `person_id` int unsigned ,
 `cost_id` int unsigned ,
 `cost_details_id` int unsigned ,
 `customer_address_id` int ,
 `delivery_address` tinytext ,
 `reference_num` varchar(30) ,
 `tot_amt` decimal(10,2) ,
 `paid_amt` decimal(10,2) ,
 `discount_amt` decimal(10,2) ,
 `cod_charge` decimal(10,2) ,
 `order_status` smallint ,
 `dtt_add` datetime ,
 `uid_add` smallint ,
 `dtt_mod` datetime ,
 `uid_mod` smallint ,
 `status_id` smallint ,
 `invoice_no` varchar(32) ,
 `agent_name` varchar(164) ,
 `delivery_name` varchar(100) ,
 `gm_from` int unsigned ,
 `gm_to` int unsigned ,
 `price` decimal(7,2) ,
 `customer_name` varchar(128) ,
 `customer_phone` varchar(24) ,
 `customer_code` varchar(128) ,
 `person_name` varchar(50) ,
 `person_ref_id` int unsigned ,
 `person_mobile` varchar(30) 
)*/;

/*Table structure for table `promotion_products_view` */

DROP TABLE IF EXISTS `promotion_products_view`;

/*!50001 DROP VIEW IF EXISTS `promotion_products_view` */;
/*!50001 DROP TABLE IF EXISTS `promotion_products_view` */;

/*!50001 CREATE TABLE  `promotion_products_view`(
 `title` varchar(128) ,
 `dt_from` date ,
 `dt_to` date ,
 `status_id` tinyint unsigned ,
 `type_id` tinyint unsigned ,
 `promotion_id` int unsigned ,
 `store_id` tinyint unsigned ,
 `brand_id` smallint unsigned ,
 `cat_id` smallint unsigned ,
 `subcat_id` smallint unsigned ,
 `product_id` smallint unsigned ,
 `batch_no` varchar(30) ,
 `discount_rate` decimal(10,2) unsigned ,
 `discount_amount` decimal(10,2) unsigned ,
 `min_purchase_amt` decimal(10,2) unsigned 
)*/;

/*Table structure for table `purchase_order_view` */

DROP TABLE IF EXISTS `purchase_order_view`;

/*!50001 DROP VIEW IF EXISTS `purchase_order_view` */;
/*!50001 DROP TABLE IF EXISTS `purchase_order_view` */;

/*!50001 CREATE TABLE  `purchase_order_view`(
 `id_purchase_order` int unsigned ,
 `invoice_no` varchar(64) ,
 `store_id` tinyint unsigned ,
 `supplier_id` smallint unsigned ,
 `supplier_details` varchar(255) ,
 `tot_amt` decimal(10,2) unsigned ,
 `dtt_receive_est` datetime ,
 `dtt_receive_act` datetime ,
 `dtt_add` datetime ,
 `uid_add` smallint unsigned ,
 `dtt_mod` datetime ,
 `uid_mod` smallint unsigned ,
 `status_id` tinyint(1) ,
 `version` tinyint ,
 `store_name` varchar(128) ,
 `supplier_name` varchar(200) 
)*/;

/*Table structure for table `purchase_receive_view` */

DROP TABLE IF EXISTS `purchase_receive_view`;

/*!50001 DROP VIEW IF EXISTS `purchase_receive_view` */;
/*!50001 DROP TABLE IF EXISTS `purchase_receive_view` */;

/*!50001 CREATE TABLE  `purchase_receive_view`(
 `id_purchase_receive` int unsigned ,
 `invoice_no` varchar(64) ,
 `purchase_order_id` int unsigned ,
 `store_id` tinyint unsigned ,
 `supplier_id` smallint unsigned ,
 `ref_archive` varchar(255) ,
 `notes` varchar(512) ,
 `stock_mvt_reason_id` tinyint unsigned ,
 `invoice_amt` decimal(10,2) unsigned ,
 `discount_amt` decimal(10,2) unsigned ,
 `tot_amt` decimal(10,2) unsigned ,
 `paid_amt` decimal(10,2) unsigned ,
 `due_amt` decimal(10,2) unsigned ,
 `is_doc_attached` tinyint unsigned ,
 `dtt_receive` datetime ,
 `dtt_add` datetime ,
 `uid_add` smallint unsigned ,
 `dtt_mod` datetime ,
 `uid_mod` smallint unsigned ,
 `status_id` tinyint unsigned ,
 `version` tinyint unsigned ,
 `store_name` varchar(128) ,
 `supplier_name` varchar(200) ,
 `order_invoice_no` varchar(64) 
)*/;

/*Table structure for table `purchase_requisition_view` */

DROP TABLE IF EXISTS `purchase_requisition_view`;

/*!50001 DROP VIEW IF EXISTS `purchase_requisition_view` */;
/*!50001 DROP TABLE IF EXISTS `purchase_requisition_view` */;

/*!50001 CREATE TABLE  `purchase_requisition_view`(
 `id_purchase_requisition` int unsigned ,
 `product_id` smallint unsigned ,
 `qty` decimal(10,2) unsigned ,
 `store_id` tinyint unsigned ,
 `notes` varchar(200) ,
 `dtt_add` datetime ,
 `uid_add` smallint unsigned ,
 `dtt_mod` datetime ,
 `uid_mod` smallint unsigned ,
 `purchase_order_id` int unsigned ,
 `status_id` tinyint unsigned ,
 `version` tinyint unsigned ,
 `product_name` varchar(128) ,
 `product_code` varchar(20) ,
 `buy_price` decimal(10,2) unsigned ,
 `store_name` varchar(128) ,
 `fullname` varchar(255) 
)*/;

/*Table structure for table `sale_details_view` */

DROP TABLE IF EXISTS `sale_details_view`;

/*!50001 DROP VIEW IF EXISTS `sale_details_view` */;
/*!50001 DROP TABLE IF EXISTS `sale_details_view` */;

/*!50001 CREATE TABLE  `sale_details_view`(
 `id_sale_detail` int unsigned ,
 `sale_id` int unsigned ,
 `stock_id` int unsigned ,
 `product_id` smallint unsigned ,
 `product_archive` varchar(255) ,
 `cat_id` smallint unsigned ,
 `subcat_id` smallint unsigned ,
 `brand_id` smallint unsigned ,
 `qty` decimal(10,2) unsigned ,
 `unit_id` tinyint unsigned ,
 `selling_price_est` decimal(10,2) unsigned ,
 `selling_price_act` decimal(10,2) ,
 `discount_rate` decimal(10,2) unsigned ,
 `discount_amt` decimal(10,2) unsigned ,
 `vat_rate` decimal(10,2) unsigned ,
 `vat_amt` decimal(10,2) unsigned ,
 `dtt_add` datetime ,
 `uid_add` smallint unsigned ,
 `dtt_mod` datetime ,
 `uid_mod` smallint unsigned ,
 `status_id` tinyint(1) ,
 `version` tinyint unsigned ,
 `product_name` varchar(128) ,
 `product_code` varchar(20) ,
 `batch_no` varchar(32) 
)*/;

/*Table structure for table `sale_product_view` */

DROP TABLE IF EXISTS `sale_product_view`;

/*!50001 DROP VIEW IF EXISTS `sale_product_view` */;
/*!50001 DROP TABLE IF EXISTS `sale_product_view` */;

/*!50001 CREATE TABLE  `sale_product_view`(
 `id_stock` int unsigned ,
 `id_product` smallint unsigned ,
 `product_code` varchar(20) ,
 `product_name` varchar(128) ,
 `cat_id` smallint unsigned ,
 `subcat_id` smallint unsigned ,
 `brand_id` smallint unsigned ,
 `unit_id` tinyint unsigned ,
 `is_vatable` tinyint unsigned ,
 `store_id` tinyint unsigned ,
 `batch_no` varchar(32) ,
 `total_qty` decimal(10,2) unsigned ,
 `selling_price_est` decimal(10,2) unsigned ,
 `discount_amt` decimal(10,2) unsigned ,
 `attribute_name` text 
)*/;

/*Table structure for table `stock_audit_details_view` */

DROP TABLE IF EXISTS `stock_audit_details_view`;

/*!50001 DROP VIEW IF EXISTS `stock_audit_details_view` */;
/*!50001 DROP TABLE IF EXISTS `stock_audit_details_view` */;

/*!50001 CREATE TABLE  `stock_audit_details_view`(
 `id_stock_audit` int unsigned ,
 `audit_no` varchar(24) ,
 `is_doc_attached` tinyint unsigned ,
 `dtt_audit` datetime ,
 `audit_by` varchar(255) ,
 `status_id` tinyint unsigned ,
 `id_stock_audit_detail` int unsigned ,
 `qty_store` decimal(10,2) unsigned ,
 `qty_db` decimal(10,2) unsigned ,
 `notes` varchar(255) ,
 `id_product` smallint unsigned ,
 `product_code` varchar(20) ,
 `product_name` varchar(128) ,
 `supplier_name` varchar(200) ,
 `id_stock` int unsigned ,
 `batch_no` varchar(32) ,
 `invoice_no` varchar(32) ,
 `attribute_name` text 
)*/;

/*Table structure for table `stock_details_view` */

DROP TABLE IF EXISTS `stock_details_view`;

/*!50001 DROP VIEW IF EXISTS `stock_details_view` */;
/*!50001 DROP TABLE IF EXISTS `stock_details_view` */;

/*!50001 CREATE TABLE  `stock_details_view`(
 `id_stock_mvt_detail` int unsigned ,
 `rack_id` smallint unsigned ,
 `batch_no` varchar(32) ,
 `product_id` smallint unsigned ,
 `supplier_id` smallint unsigned ,
 `purchase_qty` decimal(10,2) ,
 `current_qty` decimal(10,2) unsigned ,
 `purchase_price` decimal(10,2) unsigned ,
 `selling_price_est` decimal(10,2) unsigned ,
 `selling_price_act` decimal(10,2) unsigned ,
 `expire_date` date ,
 `name` varchar(128) ,
 `product_name` varchar(128) ,
 `product_code` varchar(20) ,
 `brand_name` varchar(128) ,
 `cat_id` smallint unsigned ,
 `subcat_id` smallint unsigned ,
 `cat_name` varchar(128) ,
 `subcat_name` varchar(128) ,
 `is_vatable` tinyint unsigned ,
 `supplier_name` varchar(200) ,
 `id_stock_mvt` int unsigned ,
 `stock_mvt_type_id` tinyint unsigned ,
 `notes` varchar(512) ,
 `dtt_stock_mvt` datetime ,
 `invoice_no` varchar(32) ,
 `store_id` tinyint unsigned ,
 `id_stock` int unsigned ,
 `dtt_add` datetime 
)*/;

/*Table structure for table `vw_accounts` */

DROP TABLE IF EXISTS `vw_accounts`;

/*!50001 DROP VIEW IF EXISTS `vw_accounts` */;
/*!50001 DROP TABLE IF EXISTS `vw_accounts` */;

/*!50001 CREATE TABLE  `vw_accounts`(
 `id_account` smallint unsigned ,
 `acc_type_id` tinyint unsigned ,
 `acc_uses_id` tinyint unsigned ,
 `account_name` varchar(128) ,
 `bank_name` varchar(128) ,
 `account_no` varchar(64) ,
 `stores` text ,
 `status_id` tinyint unsigned 
)*/;

/*Table structure for table `vw_sales_person_list` */

DROP TABLE IF EXISTS `vw_sales_person_list`;

/*!50001 DROP VIEW IF EXISTS `vw_sales_person_list` */;
/*!50001 DROP TABLE IF EXISTS `vw_sales_person_list` */;

/*!50001 CREATE TABLE  `vw_sales_person_list`(
 `id_sales_person` int ,
 `person_id` int ,
 `person_type` int ,
 `commission` float(6,2) ,
 `curr_balance` float(10,2) ,
 `dtt_add` datetime ,
 `uid_add` smallint ,
 `dtt_mod` datetime ,
 `uid_mod` smallint ,
 `status_id` smallint ,
 `version` smallint ,
 `user_name` varchar(255) ,
 `phone` varchar(24) ,
 `type_name` varchar(50) 
)*/;

/*Table structure for table `vw_stock_attr` */

DROP TABLE IF EXISTS `vw_stock_attr`;

/*!50001 DROP VIEW IF EXISTS `vw_stock_attr` */;
/*!50001 DROP TABLE IF EXISTS `vw_stock_attr` */;

/*!50001 CREATE TABLE  `vw_stock_attr`(
 `stock_id` int ,
 `attribute_name` text ,
 `attribute_ids` text 
)*/;

/*View structure for view acl_access_module */

/*!50001 DROP TABLE IF EXISTS `acl_access_module` */;
/*!50001 DROP VIEW IF EXISTS `acl_access_module` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `acl_access_module` AS select `acl_modules`.`id_acl_module` AS `id_acl_module`,`acl_modules`.`mod_name` AS `mod_name`,`acl_modules`.`mod_icon` AS `mod_icon`,`acl_modules`.`parent_id` AS `parent_id`,`acl_modules`.`sort` AS `sort`,`acl_modules`.`rel_url` AS `rel_url`,`acl_modules`.`status_id` AS `status_id`,`acl_user_modules`.`user_id` AS `user_id` from (`acl_user_modules` join `acl_modules` on((`acl_user_modules`.`module_id` = `acl_modules`.`id_acl_module`))) where (`acl_user_modules`.`submodule_id` = 0) order by `acl_modules`.`sort` */;

/*View structure for view acl_access_pages */

/*!50001 DROP TABLE IF EXISTS `acl_access_pages` */;
/*!50001 DROP VIEW IF EXISTS `acl_access_pages` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `acl_access_pages` AS select `a`.`user_id` AS `user_id`,`b`.`page_title` AS `page_title`,`b`.`id_acl_page` AS `page_id`,`b`.`rel_url` AS `rel_url`,`c`.`mod_name` AS `module_name`,`c`.`id_acl_module` AS `module_id`,`b`.`status_id` AS `status_id` from ((`acl_user_pages` `a` join `acl_pages` `b` on((`b`.`id_acl_page` = `a`.`page_id`))) join `acl_modules` `c` on((`c`.`id_acl_module` = `b`.`submodule_id`))) */;

/*View structure for view acl_access_submodule */

/*!50001 DROP TABLE IF EXISTS `acl_access_submodule` */;
/*!50001 DROP VIEW IF EXISTS `acl_access_submodule` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `acl_access_submodule` AS select `acl_modules`.`id_acl_module` AS `id_acl_module`,`acl_modules`.`mod_name` AS `mod_name`,`acl_modules`.`mod_icon` AS `mod_icon`,`acl_modules`.`parent_id` AS `parent_id`,`acl_modules`.`sort` AS `sort`,`acl_modules`.`rel_url` AS `rel_url`,`acl_modules`.`status_id` AS `status_id`,`acl_user_modules`.`user_id` AS `user_id` from (`acl_user_modules` join `acl_modules` on((`acl_user_modules`.`submodule_id` = `acl_modules`.`id_acl_module`))) where ((`acl_user_modules`.`submodule_id` <> 0) and (`acl_modules`.`status_id` = 1)) order by `acl_modules`.`sort` */;

/*View structure for view customer_address_view */

/*!50001 DROP TABLE IF EXISTS `customer_address_view` */;
/*!50001 DROP VIEW IF EXISTS `customer_address_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `customer_address_view` AS select `customer_addresss`.`id_customer_address` AS `id_customer_address`,`customer_addresss`.`customer_id` AS `customer_id`,`customer_addresss`.`address_type` AS `address_type`,`customer_addresss`.`div_id` AS `div_id`,`customer_addresss`.`dist_id` AS `dist_id`,`customer_addresss`.`upz_id` AS `upz_id`,`customer_addresss`.`unn_id` AS `unn_id`,`customer_addresss`.`city_id` AS `city_id`,`customer_addresss`.`area_id` AS `area_id`,`customer_addresss`.`post_code` AS `post_code`,`customer_addresss`.`addr_line_1` AS `addr_line_1`,`loc_divisions`.`division_name_en` AS `division_name_en`,`loc_divisions`.`division_name_bn` AS `division_name_bn`,`loc_districts`.`district_name_en` AS `district_name_en`,`loc_districts`.`district_name_bn` AS `district_name_bn`,`loc_cities`.`city_name_en` AS `city_name_en`,`loc_cities`.`city_name_bn` AS `city_name_bn`,`loc_areas`.`area_name_en` AS `area_name_en`,`loc_areas`.`area_name_bn` AS `area_name_bn`,`loc_unions`.`union_name_en` AS `union_name_en`,`loc_unions`.`union_name_bn` AS `union_name_bn`,`loc_upazilas`.`upazila_name_en` AS `upazila_name_en`,`loc_upazilas`.`upazila_name_bn` AS `upazila_name_bn` from ((((((`customer_addresss` left join `loc_divisions` on((`loc_divisions`.`id_division` = `customer_addresss`.`div_id`))) left join `loc_districts` on((`loc_districts`.`id_district` = `customer_addresss`.`dist_id`))) left join `loc_cities` on((`loc_cities`.`id_city` = `customer_addresss`.`city_id`))) left join `loc_areas` on((`loc_areas`.`id_area` = `customer_addresss`.`area_id`))) left join `loc_unions` on((`loc_unions`.`id_union` = `customer_addresss`.`unn_id`))) left join `loc_upazilas` on((`loc_upazilas`.`id_upazila` = `customer_addresss`.`upz_id`))) */;

/*View structure for view delivery_order_details */

/*!50001 DROP TABLE IF EXISTS `delivery_order_details` */;
/*!50001 DROP VIEW IF EXISTS `delivery_order_details` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `delivery_order_details` AS select `d`.`id_delivery_order` AS `id_delivery_order`,`d`.`sale_id` AS `sale_id`,`d`.`customer_id` AS `customer_id`,`d`.`type_id` AS `type_id`,`d`.`ref_id` AS `ref_id`,`d`.`person_id` AS `person_id`,`d`.`cost_id` AS `cost_id`,`d`.`cost_details_id` AS `cost_details_id`,`d`.`customer_address_id` AS `customer_address_id`,`d`.`delivery_address` AS `delivery_address`,`d`.`reference_num` AS `reference_num`,`d`.`tot_amt` AS `tot_amt`,`d`.`paid_amt` AS `paid_amt`,`d`.`discount_amt` AS `discount_amt`,`d`.`cod_charge` AS `cod_charge`,`d`.`order_status` AS `order_status`,`d`.`dtt_add` AS `dtt_add`,`d`.`uid_add` AS `uid_add`,`d`.`dtt_mod` AS `dtt_mod`,`d`.`uid_mod` AS `uid_mod`,`d`.`status_id` AS `status_id`,`s`.`invoice_no` AS `invoice_no`,`a`.`agent_name` AS `agent_name`,`c`.`delivery_name` AS `delivery_name`,`cd`.`gm_from` AS `gm_from`,`cd`.`gm_to` AS `gm_to`,`cd`.`price` AS `price`,`cus`.`full_name` AS `customer_name`,`cus`.`phone` AS `customer_phone`,`cus`.`customer_code` AS `customer_code`,`p`.`person_name` AS `person_name`,`p`.`ref_id` AS `person_ref_id`,`p`.`person_mobile` AS `person_mobile` from ((((((`delivery_orders` `d` join `sales` `s` on((`d`.`sale_id` = `s`.`id_sale`))) left join `agents` `a` on((`d`.`ref_id` = `a`.`id_agent`))) left join `delivery_costs` `c` on((`d`.`cost_id` = `c`.`id_delivery_cost`))) left join `delivery_persons` `p` on((`d`.`person_id` = `p`.`id_delivery_person`))) left join `delivery_cost_details` `cd` on(((`d`.`cost_details_id` = `cd`.`id_delivery_cost_details`) and (`c`.`id_delivery_cost` = `cd`.`delivery_cost_id`)))) left join `customers` `cus` on((`d`.`customer_id` = `cus`.`id_customer`))) */;

/*View structure for view promotion_products_view */

/*!50001 DROP TABLE IF EXISTS `promotion_products_view` */;
/*!50001 DROP VIEW IF EXISTS `promotion_products_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `promotion_products_view` AS select `b`.`title` AS `title`,`b`.`dt_from` AS `dt_from`,`b`.`dt_to` AS `dt_to`,`b`.`status_id` AS `status_id`,`b`.`type_id` AS `type_id`,`a`.`promotion_id` AS `promotion_id`,`c`.`store_id` AS `store_id`,`a`.`brand_id` AS `brand_id`,`a`.`cat_id` AS `cat_id`,`a`.`subcat_id` AS `subcat_id`,`a`.`product_id` AS `product_id`,`a`.`batch_no` AS `batch_no`,`a`.`discount_rate` AS `discount_rate`,`a`.`discount_amount` AS `discount_amount`,`a`.`min_purchase_amt` AS `min_purchase_amt` from ((`promotion_details` `a` join `promotions` `b` on((`a`.`promotion_id` = `b`.`id_promotion`))) join `promotion_stores` `c` on((`c`.`promotion_id` = `b`.`id_promotion`))) where ((`b`.`dt_from` <= curdate()) and (`b`.`dt_to` >= curdate()) and (`b`.`is_product` <> 1) and (`b`.`status_id` = '1')) */;

/*View structure for view purchase_order_view */

/*!50001 DROP TABLE IF EXISTS `purchase_order_view` */;
/*!50001 DROP VIEW IF EXISTS `purchase_order_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `purchase_order_view` AS select `purchase_orders`.`id_purchase_order` AS `id_purchase_order`,`purchase_orders`.`invoice_no` AS `invoice_no`,`purchase_orders`.`store_id` AS `store_id`,`purchase_orders`.`supplier_id` AS `supplier_id`,`purchase_orders`.`supplier_details` AS `supplier_details`,`purchase_orders`.`tot_amt` AS `tot_amt`,`purchase_orders`.`dtt_receive_est` AS `dtt_receive_est`,`purchase_orders`.`dtt_receive_act` AS `dtt_receive_act`,`purchase_orders`.`dtt_add` AS `dtt_add`,`purchase_orders`.`uid_add` AS `uid_add`,`purchase_orders`.`dtt_mod` AS `dtt_mod`,`purchase_orders`.`uid_mod` AS `uid_mod`,`purchase_orders`.`status_id` AS `status_id`,`purchase_orders`.`version` AS `version`,`stores`.`store_name` AS `store_name`,`suppliers`.`supplier_name` AS `supplier_name` from ((`purchase_orders` join `stores` on((`purchase_orders`.`store_id` = `stores`.`id_store`))) join `suppliers` on((`purchase_orders`.`supplier_id` = `suppliers`.`id_supplier`))) */;

/*View structure for view purchase_receive_view */

/*!50001 DROP TABLE IF EXISTS `purchase_receive_view` */;
/*!50001 DROP VIEW IF EXISTS `purchase_receive_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `purchase_receive_view` AS select `a`.`id_purchase_receive` AS `id_purchase_receive`,`a`.`invoice_no` AS `invoice_no`,`a`.`purchase_order_id` AS `purchase_order_id`,`a`.`store_id` AS `store_id`,`a`.`supplier_id` AS `supplier_id`,`a`.`ref_archive` AS `ref_archive`,`a`.`notes` AS `notes`,`a`.`stock_mvt_reason_id` AS `stock_mvt_reason_id`,`a`.`invoice_amt` AS `invoice_amt`,`a`.`discount_amt` AS `discount_amt`,`a`.`tot_amt` AS `tot_amt`,`a`.`paid_amt` AS `paid_amt`,`a`.`due_amt` AS `due_amt`,`a`.`is_doc_attached` AS `is_doc_attached`,`a`.`dtt_receive` AS `dtt_receive`,`a`.`dtt_add` AS `dtt_add`,`a`.`uid_add` AS `uid_add`,`a`.`dtt_mod` AS `dtt_mod`,`a`.`uid_mod` AS `uid_mod`,`a`.`status_id` AS `status_id`,`a`.`version` AS `version`,`b`.`store_name` AS `store_name`,`c`.`supplier_name` AS `supplier_name`,`o`.`invoice_no` AS `order_invoice_no` from (((`purchase_receives` `a` join `stores` `b` on((`a`.`store_id` = `b`.`id_store`))) join `purchase_orders` `o` on((`a`.`purchase_order_id` = `o`.`id_purchase_order`))) join `suppliers` `c` on((`a`.`supplier_id` = `c`.`id_supplier`))) */;

/*View structure for view purchase_requisition_view */

/*!50001 DROP TABLE IF EXISTS `purchase_requisition_view` */;
/*!50001 DROP VIEW IF EXISTS `purchase_requisition_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `purchase_requisition_view` AS select `purchase_requisitions`.`id_purchase_requisition` AS `id_purchase_requisition`,`purchase_requisitions`.`product_id` AS `product_id`,`purchase_requisitions`.`qty` AS `qty`,`purchase_requisitions`.`store_id` AS `store_id`,`purchase_requisitions`.`notes` AS `notes`,`purchase_requisitions`.`dtt_add` AS `dtt_add`,`purchase_requisitions`.`uid_add` AS `uid_add`,`purchase_requisitions`.`dtt_mod` AS `dtt_mod`,`purchase_requisitions`.`uid_mod` AS `uid_mod`,`purchase_requisitions`.`purchase_order_id` AS `purchase_order_id`,`purchase_requisitions`.`status_id` AS `status_id`,`purchase_requisitions`.`version` AS `version`,`products`.`product_name` AS `product_name`,`products`.`product_code` AS `product_code`,`products`.`buy_price` AS `buy_price`,`stores`.`store_name` AS `store_name`,`users`.`fullname` AS `fullname` from (((`purchase_requisitions` left join `products` on((`purchase_requisitions`.`product_id` = `products`.`id_product`))) left join `stores` on((`purchase_requisitions`.`store_id` = `stores`.`id_store`))) left join `users` on((`users`.`id_user` = `purchase_requisitions`.`uid_add`))) */;

/*View structure for view sale_details_view */

/*!50001 DROP TABLE IF EXISTS `sale_details_view` */;
/*!50001 DROP VIEW IF EXISTS `sale_details_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sale_details_view` AS select `a`.`id_sale_detail` AS `id_sale_detail`,`a`.`sale_id` AS `sale_id`,`a`.`stock_id` AS `stock_id`,`a`.`product_id` AS `product_id`,`a`.`product_archive` AS `product_archive`,`a`.`cat_id` AS `cat_id`,`a`.`subcat_id` AS `subcat_id`,`a`.`brand_id` AS `brand_id`,`a`.`qty` AS `qty`,`a`.`unit_id` AS `unit_id`,`a`.`selling_price_est` AS `selling_price_est`,`a`.`selling_price_act` AS `selling_price_act`,`a`.`discount_rate` AS `discount_rate`,`a`.`discount_amt` AS `discount_amt`,`a`.`vat_rate` AS `vat_rate`,`a`.`vat_amt` AS `vat_amt`,`a`.`dtt_add` AS `dtt_add`,`a`.`uid_add` AS `uid_add`,`a`.`dtt_mod` AS `dtt_mod`,`a`.`uid_mod` AS `uid_mod`,`a`.`status_id` AS `status_id`,`a`.`version` AS `version`,`products`.`product_name` AS `product_name`,`products`.`product_code` AS `product_code`,`stocks`.`batch_no` AS `batch_no` from ((`sale_details` `a` join `products` on((`a`.`product_id` = `products`.`id_product`))) join `stocks` on(((`stocks`.`product_id` = `products`.`id_product`) and (`a`.`stock_id` = `stocks`.`id_stock`)))) */;

/*View structure for view sale_product_view */

/*!50001 DROP TABLE IF EXISTS `sale_product_view` */;
/*!50001 DROP VIEW IF EXISTS `sale_product_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sale_product_view` AS select `a`.`id_stock` AS `id_stock`,`b`.`id_product` AS `id_product`,`b`.`product_code` AS `product_code`,`b`.`product_name` AS `product_name`,`b`.`cat_id` AS `cat_id`,`b`.`subcat_id` AS `subcat_id`,`b`.`brand_id` AS `brand_id`,`b`.`unit_id` AS `unit_id`,`b`.`is_vatable` AS `is_vatable`,`a`.`store_id` AS `store_id`,`a`.`batch_no` AS `batch_no`,`a`.`qty` AS `total_qty`,`a`.`selling_price_act` AS `selling_price_est`,`a`.`discount_amt` AS `discount_amt`,group_concat(distinct concat(`sta`.`s_attribute_name`,'=',`sta`.`s_attribute_value`) separator ',') AS `attribute_name` from ((`stocks` `a` join `products` `b` on((`a`.`product_id` = `b`.`id_product`))) left join `stock_attributes` `sta` on((`a`.`id_stock` = `sta`.`stock_id`))) where (`a`.`qty` <> 0) group by `a`.`batch_no`,`a`.`product_id`,`a`.`store_id` */;

/*View structure for view stock_audit_details_view */

/*!50001 DROP TABLE IF EXISTS `stock_audit_details_view` */;
/*!50001 DROP VIEW IF EXISTS `stock_audit_details_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock_audit_details_view` AS select `stock_audits`.`id_stock_audit` AS `id_stock_audit`,`stock_audits`.`audit_no` AS `audit_no`,`stock_audits`.`is_doc_attached` AS `is_doc_attached`,`stock_audits`.`dtt_audit` AS `dtt_audit`,`stock_audits`.`audit_by` AS `audit_by`,`stock_audits`.`status_id` AS `status_id`,`stock_audit_details`.`id_stock_audit_detail` AS `id_stock_audit_detail`,`stock_audit_details`.`qty_store` AS `qty_store`,`stock_audit_details`.`qty_db` AS `qty_db`,`stock_audit_details`.`notes` AS `notes`,`products`.`id_product` AS `id_product`,`products`.`product_code` AS `product_code`,`products`.`product_name` AS `product_name`,`suppliers`.`supplier_name` AS `supplier_name`,`stocks`.`id_stock` AS `id_stock`,`stocks`.`batch_no` AS `batch_no`,`stock_mvts`.`invoice_no` AS `invoice_no`,group_concat(distinct concat(`sta`.`s_attribute_name`,'=',`sta`.`s_attribute_value`) separator ',') AS `attribute_name` from ((((((`stock_audits` left join `stock_audit_details` on((`stock_audit_details`.`stock_audit_id` = `stock_audits`.`id_stock_audit`))) left join `stocks` on((`stocks`.`id_stock` = `stock_audit_details`.`stock_id`))) left join `stock_mvts` on((`stock_mvts`.`id_stock_mvt` = `stocks`.`stock_mvt_id`))) left join `products` on((`products`.`id_product` = `stocks`.`product_id`))) left join `suppliers` on((`suppliers`.`id_supplier` = `stocks`.`supplier_id`))) left join `stock_attributes` `sta` on((`sta`.`stock_id` = `stocks`.`id_stock`))) group by `stock_audit_details`.`id_stock_audit_detail` order by `stock_audits`.`id_stock_audit` desc */;

/*View structure for view stock_details_view */

/*!50001 DROP TABLE IF EXISTS `stock_details_view` */;
/*!50001 DROP VIEW IF EXISTS `stock_details_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock_details_view` AS select `stock_mvt_details`.`id_stock_mvt_detail` AS `id_stock_mvt_detail`,`stock_mvt_details`.`rack_id` AS `rack_id`,`stock_mvt_details`.`batch_no` AS `batch_no`,`stock_mvt_details`.`product_id` AS `product_id`,`stock_mvt_details`.`supplier_id` AS `supplier_id`,`stock_mvt_details`.`qty` AS `purchase_qty`,`stocks`.`qty` AS `current_qty`,`stock_mvt_details`.`purchase_price` AS `purchase_price`,`stock_mvt_details`.`selling_price_est` AS `selling_price_est`,`stock_mvt_details`.`selling_price_act` AS `selling_price_act`,`stock_mvt_details`.`expire_date` AS `expire_date`,`racks`.`name` AS `name`,`products`.`product_name` AS `product_name`,`products`.`product_code` AS `product_code`,`pb`.`brand_name` AS `brand_name`,`products`.`cat_id` AS `cat_id`,`products`.`subcat_id` AS `subcat_id`,`pc`.`cat_name` AS `cat_name`,`psc`.`cat_name` AS `subcat_name`,`products`.`is_vatable` AS `is_vatable`,`suppliers`.`supplier_name` AS `supplier_name`,`stock_mvts`.`id_stock_mvt` AS `id_stock_mvt`,`stock_mvts`.`stock_mvt_type_id` AS `stock_mvt_type_id`,`stock_mvts`.`notes` AS `notes`,`stock_mvts`.`dtt_stock_mvt` AS `dtt_stock_mvt`,`stock_mvts`.`invoice_no` AS `invoice_no`,`stocks`.`store_id` AS `store_id`,`stocks`.`id_stock` AS `id_stock`,`stocks`.`dtt_add` AS `dtt_add` from ((((((((`stock_mvt_details` left join `racks` on((`racks`.`id_rack` = `stock_mvt_details`.`rack_id`))) left join `products` on((`products`.`id_product` = `stock_mvt_details`.`product_id`))) left join `suppliers` on((`suppliers`.`id_supplier` = `stock_mvt_details`.`supplier_id`))) left join `stock_mvts` on((`stock_mvts`.`id_stock_mvt` = `stock_mvt_details`.`stock_mvt_id`))) left join `stocks` on(((`stocks`.`batch_no` = `stock_mvt_details`.`batch_no`) and (`stocks`.`product_id` = `stock_mvt_details`.`product_id`)))) left join `product_brands` `pb` on((`pb`.`id_product_brand` = `products`.`brand_id`))) left join `product_categories` `pc` on((`pc`.`id_product_category` = `products`.`cat_id`))) left join `product_categories` `psc` on((`psc`.`id_product_category` = `products`.`subcat_id`))) group by `stock_mvt_details`.`id_stock_mvt_detail` order by `stock_mvt_details`.`id_stock_mvt_detail` desc */;

/*View structure for view vw_accounts */

/*!50001 DROP TABLE IF EXISTS `vw_accounts` */;
/*!50001 DROP VIEW IF EXISTS `vw_accounts` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_accounts` AS select `a`.`id_account` AS `id_account`,`a`.`acc_type_id` AS `acc_type_id`,`a`.`acc_uses_id` AS `acc_uses_id`,`a`.`account_name` AS `account_name`,`b`.`bank_name` AS `bank_name`,`a`.`account_no` AS `account_no`,group_concat(`st`.`store_name` separator ',') AS `stores`,`a`.`status_id` AS `status_id` from (((`accounts` `a` left join `banks` `b` on((`b`.`id_bank` = `a`.`bank_id`))) left join `accounts_stores` `accst` on((`accst`.`account_id` = `a`.`id_account`))) left join `stores` `st` on((`st`.`id_store` = `accst`.`store_id`))) group by `a`.`id_account` */;

/*View structure for view vw_sales_person_list */

/*!50001 DROP TABLE IF EXISTS `vw_sales_person_list` */;
/*!50001 DROP VIEW IF EXISTS `vw_sales_person_list` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_sales_person_list` AS select `sp`.`id_sales_person` AS `id_sales_person`,`sp`.`person_id` AS `person_id`,`sp`.`person_type` AS `person_type`,`sp`.`commission` AS `commission`,`sp`.`curr_balance` AS `curr_balance`,`sp`.`dtt_add` AS `dtt_add`,`sp`.`uid_add` AS `uid_add`,`sp`.`dtt_mod` AS `dtt_mod`,`sp`.`uid_mod` AS `uid_mod`,`sp`.`status_id` AS `status_id`,`sp`.`version` AS `version`,(case `sp`.`person_type` when '1' then `u`.`fullname` when '2' then `u`.`fullname` when '3' then `s`.`supplier_name` when '4' then `c`.`full_name` end) AS `user_name`,(case `sp`.`person_type` when '1' then `u`.`mobile` when '2' then `u`.`mobile` when '3' then `s`.`phone` when '4' then `c`.`phone` end) AS `phone`,`spt`.`type_name` AS `type_name` from ((((`sales_person` `sp` left join `users` `u` on(((`u`.`id_user` = `sp`.`person_id`) and ((`sp`.`person_type` = 1) or (`sp`.`person_type` = 2))))) left join `suppliers` `s` on(((`s`.`id_supplier` = `sp`.`person_id`) and (`sp`.`person_type` = 3)))) left join `customers` `c` on(((`c`.`id_customer` = `sp`.`person_id`) and (`sp`.`person_type` = 4)))) left join `sales_person_type` `spt` on((`sp`.`person_type` = `spt`.`person_type_id`))) where (`sp`.`status_id` = '1') order by `sp`.`id_sales_person` desc */;

/*View structure for view vw_stock_attr */

/*!50001 DROP TABLE IF EXISTS `vw_stock_attr` */;
/*!50001 DROP VIEW IF EXISTS `vw_stock_attr` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_stock_attr` AS select `stock_attributes`.`stock_id` AS `stock_id`,group_concat(concat(`stock_attributes`.`s_attribute_name`,'=',`stock_attributes`.`s_attribute_value`) separator ', ') AS `attribute_name`,group_concat(distinct `stock_attributes`.`p_attribute_id` order by `stock_attributes`.`p_attribute_id` ASC separator ', ') AS `attribute_ids` from `stock_attributes` group by `stock_attributes`.`stock_id` order by `stock_attributes`.`stock_id` desc */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
SET SESSION sql_require_primary_key = 1;