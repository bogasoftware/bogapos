<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <div class="heading_actions">
        <a href="<?php echo site_url('reports/profit_loss'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Grafik</a>
        <a href="<?php echo site_url('reports/profit_loss/recap'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Rekap</a>
        <a href="<?php echo site_url('reports/profit_loss/detail'); ?>" class="md-btn md-btn-wave waves-effect waves-button">Detail</a>
    </div>
    <h1>Detail Laba/Rugi Bersih</h1>
    <span class="uk-text-small">Periode tanggal <span id="date-start-display"></span> - <span id="date-end-display"></span></span>
</div>
<div id="page_content_inner">
    <div class="md-card uk-margin-small-bottom" id="filter-form">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
                <i class="md-icon material-icons md-card-toggle" id="filter-form-toggle">&#xE316;</i>
            </div>
            <h3 class="md-card-toolbar-heading-text">
                Filter Laporan
            </h3>
        </div>
        <div class="md-card-content">
            <div class="uk-grid">
                <div class="uk-width-medium-7-10">
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-2">
                            <label>Periode Mulai</label>
                            <input type="text" id="date-start" readonly="" class="md-input" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo date('Y-m-01'); ?>" />
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label>Periode Akhir</label>
                            <input type="text" id="date-end" readonly="" class="md-input" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo date('Y-m-t'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-3-10">
                    <a href="javascript:void(0);" id="generate" class="md-btn md-btn-primary md-btn-wave waves-effect waves-button">Hasilkan</a>
                </div>
            </div>
        </div>
    </div>
    <div class="md-card  uk-margin-small-top">
        <div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap" id="table">
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>