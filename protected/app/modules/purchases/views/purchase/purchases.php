<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <h1><?php echo lang('purchase_list_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('purchase_list_subheading'); ?></span>
</div>
<div id="page_content_inner">
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap tablesorter tablesorter-altair" id="table" data-url="<?php echo site_url('purchases/get_list'); ?>">
                    <thead>
                        <tr>
                            <th class="filter-false remove sorter-false uk-text-center" style="width: 10px;">1</th>
                            <th class="uk-text-center">2</th>
                            <th class="uk-text-center">3</th>
                            <th class="uk-text-center">4</th>
                            <th class="uk-text-center">5</th>
                            <th class="uk-text-center">6</th>
                            <th class="uk-text-center">7</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <ul class="uk-pagination ts_pager">
                <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                <li><span class="pagedisplay"></span></li>
                <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                <li data-uk-tooltip title="Page Size">
                    <select class="pagesize ts_selectize">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="<?php echo site_url('purchases/add'); ?>">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>
<div class="uk-modal" id="modal-form">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
    </div>
</div>