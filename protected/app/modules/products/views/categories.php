<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <h1><?php echo lang('product_list_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('product_list_subheading'); ?></span>
</div>
<div id="page_content_inner">
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap tablesorter tablesorter-altair" id="table" data-url="<?php echo site_url('products/categories/get_list'); ?>">
                    <thead>
                        <tr>
                            <th class="filter-false remove sorter-false" style="width: 10px;">1</th>
                            <th>2</th>
                            <th>3</th>
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
    <a class="md-fab md-fab-accent" href="#" id="btn-add">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>
<div class="uk-modal" id="modal-form">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title"><?php echo lang('menu_categories_label'); ?></h3>
        </div> 
        <form class="uk-form-stacked" id="form" action="<?php echo site_url('products/categories/save'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="save_method" name="save_method">
            <input type="hidden" id="id" name="id">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-8-10">
                    <div class="parsley-row">
                        <label for="name"><?php echo lang('categories_name_label'); ?></label>
                        <input type="text" name="name" id="name" required class="md-input" />
                    </div>
                </div>
                <div class="uk-width-2-10">
                    <div class="parsley-row">
                        <input type="checkbox" data-switchery data-switchery-color="#1e88e5" checked id="status" name="status"/>
                        <span class="uk-form-help-block"><?php echo lang('categories_status_label'); ?></span>
                    </div>
                </div>
            </div>

            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close"><?php echo lang('action_cancel_button'); ?></button>
                <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary"><?php echo lang('action_save_button'); ?></button>
            </div>
        </form>
    </div>
</div>