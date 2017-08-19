<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Rekap</a>
        <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Detail</a>
        <a href="<?php echo site_url('reports/profit_loss/net'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Laba Bersih</a>
    </div>
    <h1>Grafik Labar/Rugi</h1>
    <span class="uk-text-small">Periode tanggal 01 Januari <span class="year"></span> - 31 Desember <span class="year"></span></span>
</div>
<div id="page_content_inner">
    <div class="uk-grid uk-grid-small">
        <div class="uk-width-1-1">
            <div class="md-card">
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <div class="uk-float-right">
                            <select id="select-year">
                                <?php
                                if ($years) {
                                    foreach ($years->result() as $year) {
                                        echo '<option value="' . $year->year . '" ' . ($year->year == date('Y') ? 'selected' : '') . '>' . $year->year . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <h3 class="md-card-toolbar-heading-text">
                        Laba/Rugi /Bulan
                    </h3>
                </div>
                <div class="md-card-content">
                    <div id="profit-loss-monthly-chart" class="c3chart"></div>
                </div>
            </div>
        </div>
        <!--        <div class="uk-width-1-2">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <h3 class="md-card-toolbar-heading-text">
                                Persentase Laba/Rugi /Bulan
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <div id="profit-loss-percentage-monthly-chart" class="c3chart"></div>
                        </div>
                    </div>
                </div>-->
    </div>
</div>