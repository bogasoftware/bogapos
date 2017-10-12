<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
    <h1><?php echo lang('product_list_heading'); ?></h1>
    <span class="uk-text-small"><?php echo lang('product_list_subheading'); ?></span>
</div>
<div id="page_content_inner">
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
                <table class="uk-table uk-table-align-vertical uk-table-hover uk-table-nowrap tablesorter tablesorter-altair" id="table" data-url="<?php echo site_url('products/get_list'); ?>">
                    <thead>
                        <tr>
                            <th class="filter-false remove sorter-false" style="width: 10px;">1</th>
                            <th class="filter-false remove sorter-false text-center" style="width: 8px">2</th>
                            <th class="sortable-handler">3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
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

    <div class="md-fab-wrapper md-fab-in-card md-fab-speed-dial">
         <a class="md-fab md-fab-primary" href="javascript:void(0)"><i class="material-icons">&#xE145;</i></a>
            <div class="md-fab-wrapper-small">
                <a class="md-fab md-fab-small md-fab-warning" id="btn-add"><i class="material-icons">&#xE89C;</i></a>
                <a class="md-fab md-fab-small md-fab-success" id="btn-import"><i class="material-icons">&#xE2C3;</i></a>
            </div>  
    </div>


<div class="uk-modal" id="modal-import">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Import Data</h3>
        </div>        
        <form class="uk-form-stacked" id="form" action="<?php echo current_url(); ?>/import" method="post" enctype="multipart/form-data">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                   <input type="file" id="import_data" name="import_data" class="dropify" data-height="100"/>
                </div>
            </div>


            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Batal</button>
                <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Import</button>
            </div>
        </form>
    </div>
</div>



<div class="uk-modal" id="modal-form">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <form class="uk-form-stacked" id="form" action="<?php echo site_url('products/save'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="save_method" name="save_method">
            <input type="hidden" id="id" name="id">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                    <div class="parsley-row">
                        <label for="code"><?php echo lang('product_code_label'); ?></label>
                        <input type="text" name="code" id="code" required class="md-input" />
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="parsley-row">
                        <label for="name"><?php echo lang('product_name_label'); ?></label>
                        <input type="text" name="name" id="name" required class="md-input" />
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="parsley-row">
                        <label for="description"><?php echo lang('product_description_label'); ?></label>
                        <textarea cols="30" rows="2" class="md-input" id="description" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-2">
                    <div class="parsley-row">
                        <label for="cost"><?php echo lang('product_cost_label'); ?></label>
                        <input type="text" name="cost" id="cost" required class="md-input input-number" />
                    </div>
                </div>
                <div class="uk-width-medium-1-2">
                    <div class="parsley-row">
                        <label for="price"><?php echo lang('product_price_label'); ?></label>
                        <input type="text" name="price" id="price" required class="md-input input-number" />
                    </div>
                </div>
            </div>
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-2-3">
                    <div class="parsley-row">
                        <select id="categories" class="md-input" data-uk-tooltip="{pos:'top'}" name="category" title="<?php echo lang('product_category_label'); ?>">
                            <option value="0" selected hidden><?php echo lang('product_category_label'); ?></option>
                            <?php foreach($categories as $category){ ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php }?>
                        </select>
                        <span class="uk-form-help-block"><?php echo lang('product_category_label'); ?></span>
                    </div>
                </div>
                <div class="uk-width-medium-1-3" id="quantity-form">
                    <div class="parsley-row">
                        <label for="quantity"><?php echo lang('product_stock_label'); ?></label>
                        <input type="text" name="quantity" id="quantity" class="md-input" />
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="uk-form-row parsley-row">
                        <label for="image" class="uk-form-label"><?php echo lang('product_image_label'); ?></label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <img id="image-image" style="height: 50px;" />
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close"><?php echo lang('action_cancel_button'); ?></button>
                <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary"><?php echo lang('action_save_button'); ?></button>
            </div>
        </form>
    </div>
</div>