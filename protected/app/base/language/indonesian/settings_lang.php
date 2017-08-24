<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$lang['setting_title'] = 'Pengaturan';
$lang['setting_code_title'] = 'Pengaturan Kode Transaksi';

$lang['setting_name_label'] = 'Nama Toko';
$lang['setting_address_label'] = 'Alamat Toko';
$lang['setting_phone_label'] = 'No. Telepon';
$lang['setting_default_customer_label'] = 'Pelanggan Default';
$lang['setting_default_supplier_label'] = 'Penyuplai Default';
$lang['setting_language_label'] = 'Bahasa';
$lang['setting_enable_tax_label'] = 'Aktifkan Pajak';
$lang['setting_timezone_label'] = 'Timezone';
$lang['setting_duedate_label'] = 'Jatuh Tempo';
$lang['setting_number_decimal_label'] = 'Jumlah Digit Angka';
$lang['setting_code_format_sales_label'] = 'Penjualan';
$lang['setting_code_format_purchase_label'] = 'Pembelian';
$lang['setting_code_format_pos_label'] = 'Penjualan Kasir';
$lang['setting_code_format_cash_in_label'] = 'Kas Masuk';
$lang['setting_code_format_cash_out_label'] = 'Kas Keluar';

$lang['setting_enable_tax_help'] = 'Akan ditampilkan form isian pajak pada penjualan dan pembelian';
$lang['setting_code_help'] = '<p>Silahkan isi semua format kode transaksi.</p>
                        <p>Kode yang otomatis akan dibuat :</p>
                        <ul>
                            <li>[IN] = Urutan transaksi dalam 1 tahun</li>
                            <li>[MONTH] = Bulan 2 digit</li>
                            <li>[YEAR] = Tahun 2 digit</li>
                            <li>[MY] = Tahun Bulan 4 digit</li>
                        </ul>
                        <p>Tambahan kode dan karakter dapat di ketik sendiri.</p>
                        <p>Pastikan hasil kode tidak melebihi dari 40 karakter.</p>';

$lang['setting_save_success_message'] = "Pengaturan berhasil disimpan.";
$lang['setting_save_failed_message'] = "Pengaturan gagal disimpan.";
