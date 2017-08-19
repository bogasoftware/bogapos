<div id="page_content_inner">
    <div class="uk-grid uk-grid-medium uk-grid-width-medium-1-2 uk-grid-width-large-1-3" data-uk-grid="{gutter: 30}">
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_sales); ?>                                
                        <span><?php echo lang('report_sale_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/sales'); ?>" class="md-list-content">
                                <span class="md-list-heading">Grafik Penjualan</span>
                                <span class="uk-text-small uk-text-muted">Menampilkan laporan penjualan dalam bentuk grafik</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/sales/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading">Rekap Penjualan</span>
                                <span class="uk-text-small uk-text-muted">Rekapitulasi daftar penjualan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/sales/daily'); ?>" class="md-list-content">
                                <span class="md-list-heading">Penjualan Harian</span>
                                <span class="uk-text-small uk-text-muted">Daftar penjualan ditampilkan per hari</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_profit_loss); ?>                                
                        <span><?php echo lang('report_profit_loss_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss'); ?>" class="md-list-content">
                                <span class="md-list-heading">Grafik Laba</span>
                                <span class="uk-text-small uk-text-muted">Menampilkan laporan laba/rugi dalam bentuk grafik</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading">Rekap Laba Kotor Penjualan</span>
                                <span class="uk-text-small uk-text-muted">Rekapitulasi laba kotor per penjualan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-list-content">
                                <span class="md-list-heading">Detail Laba Penjualan</span>
                                <span class="uk-text-small uk-text-muted">Menghasilkan perhitungan laba per produk yang dijual</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/profit_loss/net'); ?>" class="md-list-content">
                                <span class="md-list-heading">Laba Rugi Bersih</span>
                                <span class="uk-text-small uk-text-muted">Laba rugi bersih perusahaan dalam rentang waktu</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <h3 class="md-card-head-text uk-text-center md-color-white">
                        <?php echo number($total_purchase); ?>                                
                        <span><?php echo lang('report_profit_loss_heading') . get_month(date('F')); ?></span>
                    </h3>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/purchase'); ?>" class="md-list-content">
                                <span class="md-list-heading">Grafik Pembelian</span>
                                <span class="uk-text-small uk-text-muted">Menampilkan laporan pembelian dalam bentuk grafik</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/purchase/recap'); ?>" class="md-list-content">
                                <span class="md-list-heading">Rekap Pembelian</span>
                                <span class="uk-text-small uk-text-muted">Rekapitulasi daftar pembelian</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/purchase/daily'); ?>" class="md-list-content">
                                <span class="md-list-heading">Pembelian Harian</span>
                                <span class="uk-text-small uk-text-muted">Daftar pembelian ditampilkan per hari</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-head md-bg-light-blue-700 reports">
                    <div class="uk-grid">
                        <div class="uk-width-1-3">
                            <h3 class="md-card-head-text uk-text-center md-color-white">
                                <?php echo number($total_products); ?>                                
                                <span>Produk</span>
                            </h3>
                        </div>
                        <div class="uk-width-1-3">
                            <h3 class="md-card-head-text uk-text-center md-color-white">
                                <?php echo number($total_customers); ?>                                
                                <span>Konsumen</span>
                            </h3>
                        </div>
                        <div class="uk-width-1-3">
                            <h3 class="md-card-head-text uk-text-center md-color-white">
                                <?php echo number($total_suppliers); ?>                                
                                <span>Pemasok</span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="md-card-content">
                    <ul class="md-list md-list-outside">
                        <li>
                            <a href="<?php echo site_url('reports/master/products'); ?>" class="md-list-content">
                                <span class="md-list-heading">Daftar Produk</span>
                                <span class="uk-text-small uk-text-muted">Daftar lengkap produk</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/master/customers'); ?>" class="md-list-content">
                                <span class="md-list-heading">Daftar Pelanggan</span>
                                <span class="uk-text-small uk-text-muted">Daftar lengkap pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('reports/master/suppliers'); ?>" class="md-list-content">
                                <span class="md-list-heading">Daftar Pemasok</span>
                                <span class="uk-text-small uk-text-muted">Daftar lengkap pemasok</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
