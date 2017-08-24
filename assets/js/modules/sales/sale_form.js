if (localStorage.getItem('slproducts')) {
    products = JSON.parse(localStorage.getItem('slproducts'));
} else {
    products = {};
}
if (localStorage.getItem('sldate')) {
    $('#date').val(get_date(localStorage.getItem('sldate')));
}
if (localStorage.getItem('slcode')) {
    $('#code').val(localStorage.getItem('slcode'));
}
if (localStorage.getItem('slcustomer')) {
    $('#customer').val(localStorage.getItem('slcustomer'));
}
if (localStorage.getItem('slcustomer_name')) {
    $('#customer_name').val(localStorage.getItem('slcustomer_name'));
}
if (localStorage.getItem('slshipping')) {
    $('#shipping-address-form').show();
    $('#shipping-form').show();
    $('#shipping_check').iCheck('check');
}
if (localStorage.getItem('slshipping_cost')) {
    $('#shipping').val(localStorage.getItem('slshipping_cost'));
}
if (localStorage.getItem('sldiscount')) {
    $('#discount').val(localStorage.getItem('sldiscount'));
}
if (localStorage.getItem('sltax')) {
    $('#tax').val(localStorage.getItem('sltax'));
}
if (localStorage.getItem('slcash')) {
    $('#cash').val(localStorage.getItem('slcash'));
}
if (localStorage.getItem('slshippingdate')) {
    $('#shipping_date').val(get_date(localStorage.getItem('slshippingdate')));
}
if (localStorage.getItem('slshippingrecipient')) {
    $('#shipping_recipient').val(localStorage.getItem('slshippingrecipient'));
}
if (localStorage.getItem('slshippingaddress')) {
    $('#shipping_address').val(localStorage.getItem('slshippingaddress'));
}
if (localStorage.getItem('slnote')) {
    $('#note').val(localStorage.getItem('slnote'));
}
loadProducts();
updateTotal();

//change field
$('#date').on('change', function (e) {
    localStorage.setItem('sldate', $(this).val());
});
$('#code').on('change', function (e) {
    localStorage.setItem('slcode', $(this).val());
});
$('#shipping_date').on('change', function (e) {
    localStorage.setItem('slshippingdate', $(this).val());
});
$('#shipping_recipient').on('change', function (e) {
    localStorage.setItem('slshippingrecipient', $(this).val());
});
$('#shipping_address').on('change', function (e) {
    localStorage.setItem('slshippingaddress', $(this).val());
});
$('#note').on('change', function (e) {
    localStorage.setItem('slnote', $(this).val());
});

//customer autocomplete
$('#customer_autocomplete').on('selectitem.uk.autocomplete', function (e, data, ac) {
    $('#customer').val(data.value);
    localStorage.setItem('slcustomer', data.value);
    localStorage.setItem('slcustomer_name', data.name);
    $('#customer_name').attr('disabled', 'disabled');
    $('#customer_autocomplete').addClass('uk-input-group');
    $('#customer_change').show();
    ac.input.val(data.name);
    data.value = null;
});
//change customer
function change_customer() {
    localStorage.removeItem('slcustomer');
    localStorage.removeItem('slcustomer_name');
    $('#customer').val('');
    $('#customer_name').val('');
    $('#customer_name').removeAttr('disabled');
    $('#customer_change').hide();
    $('#customer_autocomplete').removeClass('uk-input-group');
    $('#customer_name').parent('div.md-input-wrapper').removeClass('md-input-wrapper-disabled md-input-filled');
}

//shipping checked
$('#shipping_check').on('ifChecked', function (event) {
    $('#shipping-address-form').show();
    $('#shipping-form').show();
    localStorage.setItem('slshipping', '1');
    updateTotal();
});
$('#shipping_check').on('ifUnchecked', function (event) {
    $('#shipping-address-form').hide();
    $('#shipping-form').hide();
    localStorage.removeItem('slshipping');
    updateTotal();
});

//update discount, tax, shipping
$('#discount, #tax, #shipping').keyup(function (e) {
    e.preventDefault();
    localStorage.setItem('sldiscount', $('#discount').val());
    localStorage.setItem('sltax', $('#tax').val());
    localStorage.setItem('slshipping_cost', $('#shipping').val());
    updateTotal();
});

//update cash
$('#cash').keyup(function (e) {
    e.preventDefault();
    localStorage.setItem('slcash', $(this).val());
    updateCredit();
});

//search product
$('body').on('keyup', '#searchProduct', function (e) {
    e.preventDefault();
    if (e.keyCode == 13) {
        var text = $(this).val();
        showModal('products');
        $('#modal-products').find("#products-list").load(base_url + 'sales/modal_products/' + text);
    }
});

//select product
function selectProduct(product) {
    var product = JSON.parse(product);
    if (products[product.id]) {
        products[product.id].quantity = parseFloat(products[product.id].quantity) + 1;
        localStorage.setItem('slproducts', JSON.stringify(products));
    } else {
        var data_product = Object();
        data_product.id = product.id;
        data_product.code = product.code;
        data_product.name = product.name;
        data_product.price = product.price;
        data_product.image = product.image;
        data_product.discount = 0;
        data_product.quantity = 1;
        products[product.id] = data_product;
        localStorage.setItem('slproducts', JSON.stringify(products));
    }
    loadProducts();
    hideModal('products');
}

function removeProduct(id) {
    $("#products tr#row-" + id).fadeOut(300, function () {
        $(this).remove();
        products = JSON.parse(localStorage.getItem('slproducts'));
        delete products[id];
        if (Object.keys(products).length == 0) {
            localStorage.removeItem('slproducts', JSON.stringify(products));
        } else {
            localStorage.setItem('slproducts', JSON.stringify(products));
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
            tr_html = '<td><a href="javascript:removeProduct(\'' + id + '\');" class="delete" id="delete-' + id + '" data-uk-tooltip title="Hapus" onclick="return confirm(' + lang.message.confirm.delete_product + ')"><i class="md-icon material-icons">clear</i></a></td>';
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
        var row = (new Date).getTime();
        newRow(row).prependTo("#products");
        $('.input-number').number(true, decimal_digit, decimal_separator, thousand_separator);
        $('#product-' + row).focus();
    }
}

function newRow() {
    var newTr = $('<tr></tr>');
    tr_html = '<td colspan="7"><input type="text" id="searchProduct" placeholder="' + lang.message.search_product + '"></td>';
    newTr.html(tr_html);
    return newTr;
}

function calculateRow(id) {
    $('#quantity-' + id).keyup(function () {
        var qty = $(this).val();
        var price = $('#price-' + id).val();
        var discount = $('#discount-' + id).val();
        if (!isNaN(qty)) {
            updateRowTotal(id, price, qty, discount);
        }
        products[id].quantity = qty;
        localStorage.setItem('slproducts', JSON.stringify(products));
    });
    $('#price-' + id).keyup(function () {
        var price = $(this).val();
        var qty = $('#quantity-' + id).val();
        var discount = $('#discount-' + id).val();
        if (!isNaN(price)) {
            updateRowTotal(id, price, qty, discount);
        }
        products[id].price = price;
        localStorage.setItem('slproducts', JSON.stringify(products));
    });
    $('#discount-' + id).keyup(function () {
        var discount = $(this).val();
        var qty = $('#quantity-' + id).val();
        var price = $('#price-' + id).val();
        if (!isNaN(discount)) {
            updateRowTotal(id, price, qty, discount);
        }
        products[id].discount = discount;
        localStorage.setItem('slproducts', JSON.stringify(products));
    });
}
function updateRowTotal(id, price, qty, discount) {
    var total = qty * price;
    discount = total * discount / 100;
    total = total - discount;
    $('#total-' + id).val(total);
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
    if (localStorage.getItem('slshipping')) {
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
                    window.location = base_url + 'sales';
                }, 1000);
            }
        }
    });
    return false;
});

//remove session
function removeSession() {
    localStorage.removeItem('sldate');
    localStorage.removeItem('slcode');
    localStorage.removeItem('slshipping');
    localStorage.removeItem('slshippingdate');
    localStorage.removeItem('slshippingrecipient');
    localStorage.removeItem('slshippingaddress');
    localStorage.removeItem('slshipping_cost');
    localStorage.removeItem('slcustomer');
    localStorage.removeItem('slcustomer_name');
    localStorage.removeItem('slproducts');
    localStorage.removeItem('slnote');
    localStorage.removeItem('sldiscount');
    localStorage.removeItem('slcash');
    localStorage.removeItem('sltax');
}