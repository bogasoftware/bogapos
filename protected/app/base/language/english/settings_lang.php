<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$lang['setting_title'] = 'Settings';

$lang['setting_name_label'] = 'Store Name';
$lang['setting_address_label'] = 'Address';
$lang['setting_phone_label'] = 'Telephone';
$lang['setting_default_customer_label'] = 'Default Customer';
$lang['setting_default_supplier_label'] = 'Default Supplier';
$lang['setting_language_label'] = 'Language';
$lang['setting_enable_tax_label'] = 'Enable Tax';
$lang['setting_timezone_label'] = 'Timezone';
$lang['setting_duedate_label'] = 'Due Date Day';
$lang['setting_number_decimal_label'] = 'Number of Digits Numbers';
$lang['setting_code_format_sales_label'] = 'Sales';
$lang['setting_code_format_purchases_label'] = 'Purchase';
$lang['setting_code_format_pos_label'] = 'Cashier Sales';
$lang['setting_code_format_cash_in_label'] = 'Cash In';
$lang['setting_code_format_cash_out_label'] = 'Cash Out';

$lang['setting_enable_tax_help'] = 'Will display the form of tax on the sales and purchase';
$lang['setting_code_help'] = '<p>Please fill in all transaction code formats.</p>
                        <p>Auto-generated code :</p>
                        <ul>
                            <li>[IN] = Sequence of transactions in one year</li>
                            <li>[MONTH] = Month 2 digit</li>
                            <li>[YEAR] = Year 2 digit</li>
                            <li>[MY] = Year Month 4 digit</li>
                        </ul>
                        <p>Additional codes and characters can be typed by themselves.</p>
                        <p>Make sure the code results do not exceed 40 characters.</p>';

$lang['setting_save_success_message'] = "Settings has been successfully saved.";
$lang['setting_save_failed_message'] = "Settings failed to save.";
