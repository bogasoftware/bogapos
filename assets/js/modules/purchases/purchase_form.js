if (localStorage.getItem('pcmethod') == 'add' && localStorage.getItem('store') == 'all') {
    showModalNotKeyboard('store');
}
if (localStorage.getItem('pcproducts')) {
    products = JSON.parse(localStorage.getItem('pcproducts'));
} else {
    products = {};
}
if (localStorage.getItem('pcdate')) {
    $('#date').val(get_date(localStorage.getItem('pcdate')));
}
if (localStorage.getItem('pccode')) {
    $('#code').val(localStorage.getItem('pccode'));
}
if (localStorage.getItem('pcsupplier')) {
    $('#supplier').val(localStorage.getItem('pcsupplier'));
}
if (localStorage.getItem('pcsupplier_name')) {
    $('#supplier_name').val(localStorage.getItem('pcsupplier_name'));
}
if (localStorage.getItem('pcshipping')) {
    $('#shipping-form').show();
    $('#shipping_check').iCheck('check');
}
if (localStorage.getItem('pcshipping_cost')) {
    $('#shipping').val(localStorage.getItem('pcshipping_cost'));
}
if (localStorage.getItem('pcdiscount')) {
    $('#discount').val(localStorage.getItem('pcdiscount'));
}
if (localStorage.getItem('pctax')) {
    $('#tax').val(localStorage.getItem('pctax'));
}
if (localStorage.getItem('pccash')) {
    $('#cash').val(localStorage.getItem('pccash'));
}
if (localStorage.getItem('pcnote')) {
    $('#note').val(localStorage.getItem('pcnote'));
}
loadProducts();
updateTotal();

//change field
$('#date').on('change', function (e) {
    localStorage.setItem('pcdate', $(this).val());
});
$('#code').on('change', function (e) {
    localStorage.setItem('pccode', $(this).val());
});
$('#note').on('change', function (e) {
    localStorage.setItem('pcnote', $(this).val());
});

//supplier autocomplete
$('#supplier_autocomplete').on('selectitem.uk.autocomplete', function (e, data, ac) {
    $('#supplier').val(data.value);
    localStorage.setItem('pcsupplier', data.value);
    localStorage.setItem('pcsupplier_name', data.name);
    $('#supplier_name').attr('disabled', 'disabled');
    $('#supplier_autocomplete').addClass('uk-input-group');
    $('#supplier_change').show();
    ac.input.val(data.name);
    data.value = null;
});
//change supplier
function change_supplier() {
    localStorage.removeItem('pcsupplier');
    localStorage.removeItem('pcsupplier_name');
    $('#supplier').val('');
    $('#supplier_name').val('');
    $('#supplier_name').removeAttr('disabled');
    $('#supplier_change').hide();
    $('#supplier_autocomplete').removeClass('uk-input-group');
    $('#supplier_name').parent('div.md-input-wrapper').removeClass('md-input-wrapper-disabled md-input-filled');
}

//shipping checked
$('#shipping_check').on('ifChecked', function (event) {
    $('#shipping-form').show();
    localStorage.setItem('pcshipping', '1');
});
$('#shipping_check').on('ifUnchecked', function (event) {
    $('#shipping-form').hide();
    localStorage.removeItem('pcshipping');
    updateTotal();
});

//update discount, tax, shipping
$('#discount, #tax, #shipping').keyup(function (e) {
    e.preventDefault();
    localStorage.setItem('pcdiscount', $('#discount').val());
    localStorage.setItem('pctax', $('#tax').val());
    localStorage.setItem('pcshipping_cost', $('#shipping').val());
    updateTotal();
});

//update cash
$('#cash').keyup(function (e) {
    e.preventDefault();
    localStorage.setItem('pccash', $(this).val());
    updateCredit();
});

//search product
$('body').on('keyup', '#searchProduct', function (e) {
    e.preventDefault();
    if (e.keyCode == 13) {
        var text = $(this).val();
        showModal('products');
        $('#modal-products').find("#products-list").load(base_url + 'purchases/modal_products/' + text);
    }
});

//select product
function selectProduct(product) {
    var product = JSON.parse(product);
    if (products[product.id]) {
        products[product.id].quantity = parseFloat(products[product.id].quantity) + 1;
        localStorage.setItem('pcproducts', JSON.stringify(products));
    } else {
        var data_product = Object();
        data_product.id = product.id;
        data_product.code = product.code;
        data_product.name = product.name;
        data_product.price = product.cost;
        data_product.image = product.image;
        data_product.discount = 0;
        data_product.quantity = 1;
        products[product.id] = data_product;
        localStorage.setItem('pcproducts', JSON.stringify(products));
    }
    loadProducts();
    hideModal('products');
}

function removeProduct(id) {
    $("#products tr#row-" + id).fadeOut(300, function () {
        $(this).remove();
        products = JSON.parse(localStorage.getItem('pcproducts'));
        delete products[id];
        if (Object.keys(products).length == 0) {
            localStorage.removeItem('pcproducts', JSON.stringify(products));
        } else {
            localStorage.setItem('pcproducts', JSON.stringify(products));
        }
        updateTotal();
    });
    $('#searchProduct').focus();
}

function loadProducts() {
    $("#products tbody").empty();
    if (Object.keys(products).length > 0) {
        $.each(products, function () {
            var product = this;
            var id = product.id;
            var total = parseFloat(product.quantity) * parseFloat(product.price);
            var discount = total * parseFloat(product.discount) / 100;
            total = total - discount;
            var newTr = $('<tr id="row-' + id + '"></tr>');
            tr_html = '<td><a href="javascript:removeProduct(\'' + id + '\');" class="delete" id="delete-' + id + '" data-uk-tooltip title="' + lang.button.delete + '" onclick="return confirm(' + lang.message.confirm.delete_product + ')"><i class="md-icon material-icons">clear</i></a></td>';
            tr_html += '<td><a class="image" href="' + base_url + product.image + '" data-uk-lightbox=""><img class="md-user-image" src="' + base_url + product.image + '"></a><input type="hidden" name="product_id[]" id="product_id-' + id + '" value="' + id + '"><a class="product-name">' + product.name + ' (' + product.code + ')' + '</a></td>';
            tr_html += '<td><input type="text" class="input-number" id="price-' + id + '" name="product_price[]" value="' + product.price + '"></td>';
            tr_html += '<td><input type="text" class="input-number" id="quantity-' + id + '" name="product_quantity[]" value="' + product.quantity + '"></td>';
            tr_html += '<td><input type="text" class="input-number" id="discount-' + id + '" name="product_discount[]" value="' + product.discount + '"></td>';
            tr_html += '<td><input type="text" disabled id="total-' + id + '" class="input-number total" value="' + total + '"></td>';
            newTr.html(tr_html);
            newTr.prependTo("#products");
            calculateRow(id);
            updateRowTotal(id, product.price, product.quantity, product.discount);
            $('.input-number').number(true, decimal_digit, decimal_separator, thousand_separator);
        });
        $('#products').append(newRow());
        $('#searchProduct').focus();
    } else {
        removeSession();
        newRow().prependTo("#products");
        $('#searchProduct').focus();
    }
}

function newRow() {
    var newTr = $('<tr></tr>');
    tr_html = '<td colspan="7"><input type="text" id="searchProduct" placeholder="' + lang.message.search_product + '"></td>';
    newTr.html(tr_html);
    return newTr;
}

function calculateRow(row) {
    $('#quantity-' + row).keyup(function () {
        var qty = $(this).val();
        var price = $('#price-' + row).val();
        var discount = $('#discount-' + row).val();
        if (!isNaN(qty)) {
            updateRowTotal(row, price, qty, discount);
        }
        products[row].quantity = qty;
        localStorage.setItem('pcproducts', JSON.stringify(products));
    });
    $('#price-' + row).keyup(function () {
        var price = $(this).val();
        var qty = $('#quantity-' + row).val();
        var discount = $('#discount-' + row).val();
        if (!isNaN(price)) {
            updateRowTotal(row, price, qty, discount);
        }
        products[row].price = price;
        localStorage.setItem('pcproducts', JSON.stringify(products));
    });
    $('#discount-' + row).keyup(function () {
        var discount = $(this).val();
        var qty = $('#quantity-' + row).val();
        var price = $('#price-' + row).val();
        if (!isNaN(discount)) {
            updateRowTotal(row, price, qty, discount);
        }
        products[row].discount = discount;
        localStorage.setItem('pcproducts', JSON.stringify(products));
    });
}
function updateRowTotal(row, price, qty, discount) {
    var total = qty * price;
    discount = total * discount / 100;
    total = total - discount;
    $('#total-' + row).val(total);
    updateTotal();
    updateCredit();
}
function updateTotal() {
    var subtotal = 0;
    var tbl = $('#products');
    tbl.find('.total').each(function (index, elem) {
        var val = parseFloat($(elem).val());
        if (!isNaN(val)) {
            subtotal += val;
        }
    });
    $("#subtotal").val(subtotal);
    var total = subtotal;
    var discount = $('#discount').val();
    if (discount > 0)
        total = total - parseFloat(discount);
    var tax = $('#tax').val();
    if (tax > 0) {
        tax = total * tax / 100;
        $('#tax-value').val(tax);
        total = total + tax;
    } else {
        $('#tax-value').val(0);
    }
    var shipping_cost = 0;
    if (localStorage.getItem('pcshipping')) {
        shipping_cost = $('#shipping').val();
        total = total + parseFloat(shipping_cost);
    }
    $('#total').val(total);
    updateCredit();
}
function updateCredit() {
    var total = $('#total').val();
    var cash = $('#cash').val();
    if (parseFloat(cash) > parseFloat(total)) {
        $('#change-form').show();
        var change = cash - total;
        $('#change').val(change);
    } else {
        $('#change-form').hide();
        $('#change').val(0);
    }
    var credit = total - cash;
    if (credit < 0)
        credit = 0;
    $('#credit').val(credit);
}

//save button
$('body').on('click', '#save', function (e) {
    e.preventDefault();
    $('#form').ajaxSubmit({
        success: function (data) {
            data = JSON.parse(data);
            showNotify(data.message, data.status);
            if (data.status == 'success') {
                removeSession();
                window.setTimeout(function () {
                    window.location = base_url + 'purchases';
                }, 1000);
            }
        }
    });
    return false;
});
$('body').on('click', '#cancel', function (e) {
    e.preventDefault();
    removeSession();
    window.location.href = base_url + 'purchases';
});

//remove session
function removeSession() {
    localStorage.removeItem('pcdate');
    localStorage.removeItem('pccode');
    localStorage.removeItem('pcshipping');
    localStorage.removeItem('pcshipping_cost');
    localStorage.removeItem('pcsupplier');
    localStorage.removeItem('pcsupplier_name');
    localStorage.removeItem('pcproducts');
    localStorage.removeItem('pcnote');
    localStorage.removeItem('pcdiscount');
    localStorage.removeItem('pccash');
    localStorage.removeItem('pctax');
}