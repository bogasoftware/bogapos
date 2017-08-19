if (localStorage.getItem('store') == 'all') {
    showModalNotKeyboard('store');
}
$('#searchProduct').focus();
if (localStorage.getItem('posproducts')) {
    products = JSON.parse(localStorage.getItem('posproducts'));
} else {
    products = {};
}
if (localStorage.getItem('poscustomer')) {
    $('#customer').val(localStorage.getItem('poscustomer'));
    $('#customer_name').attr('disabled', 'disabled');
    $('#customer_change').show();
}
if (localStorage.getItem('poscustomer_name')) {
    $('#customer_name').val(localStorage.getItem('poscustomer_name'));
}
if (localStorage.getItem('posdiscount')) {
    $('#discount').val(localStorage.getItem('posdiscount'));
}
if (localStorage.getItem('postax')) {
    $('#tax').val(localStorage.getItem('postax'));
}
loadProducts();
updateTotal();

//customer autocomplete
$('#customer_autocomplete').on('selectitem.uk.autocomplete', function (e, data, ac) {
    $('#customer').val(data.value);
    localStorage.setItem('poscustomer', data.value);
    localStorage.setItem('poscustomer_name', data.name);
    $('#customer_name').attr('disabled', 'disabled');
    $('#customer_autocomplete').addClass('uk-input-group');
    $('#customer_change').show();
    ac.input.val(data.name);
    data.value = null;
});
//change customer
function change_customer() {
    localStorage.removeItem('poscustomer');
    localStorage.removeItem('poscustomer_name');
    $('#customer').val('');
    $('#customer_name').val('');
    $('#customer_name').removeAttr('disabled');
    $('#customer_change').hide();
    $('#customer_autocomplete').removeClass('uk-input-group');
    $('#customer_name').parent('div.md-input-wrapper').removeClass('md-input-wrapper-disabled md-input-filled');
}

//update discount, tax, shipping
$('#discount, #tax').keyup(function (e) {
    e.preventDefault();
    localStorage.setItem('posdiscount', $('#discount').val());
    localStorage.setItem('postax', $('#tax').val());
    updateTotal();
});

//cash
$('#cash').keyup(function (e) {
    e.preventDefault();
    if (e.keyCode == 13) {
        submit();
    } else {
        updateCredit();
    }
});

//search product
$('body').on('keyup', '#searchProduct', function (e) {
    var row = (new Date).getTime();
    e.preventDefault();
    if (e.keyCode == 13) {
        var text = $(this).val();
        if (text.length > 0) {
            $.post(base_url + 'sales/pos/get_product/', {code: text}, function (response) {
                var data = JSON.parse(response);
                if (data.success == true) {
                    selectProduct(data.data);
                } else {
                    showModal('products');
                    $('#modal-products').find("#products-list").load(base_url + 'sales/modal_products/' + text);
                }
            });
        } else {
            showModal('products');
            $('#modal-products').find("#products-list").load(base_url + 'sales/modal_products/' + text);
        }
    }
});

//select product
function selectProduct(product) {
    var product = JSON.parse(product);
    if (products[product.id]) {
        products[product.id].quantity = parseFloat(products[product.id].quantity) + 1;
        localStorage.setItem('posproducts', JSON.stringify(products));
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
        localStorage.setItem('posproducts', JSON.stringify(products));
    }
    $('#searchProduct').val('');
    loadProducts();
    hideModal('products');
}

function removeProduct(id) {
    $("#products tr#row-" + id).fadeOut(300, function () {
        $(this).remove();
        products = JSON.parse(localStorage.getItem('posproducts'));
        delete products[id];
        if (Object.keys(products).length == 0) {
            localStorage.removeItem('posproducts', JSON.stringify(products));
        } else {
            localStorage.setItem('posproducts', JSON.stringify(products));
        }
        updateTotal();
    });
    if (Object.keys(products).length == 1) {
        var newTr = $('<tr id="no-product"></tr>');
        tr_html = '<td colspan="5" align="center"><h2>' + lang.message.empty_product + '</h2></td>';
        newTr.html(tr_html);
        newTr.prependTo("#products");
    }
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
            $('.input-number').number(true, 0, ',', '.');
        });
        $('#searchProduct').focus();
    } else {
        removeSession();
        var newTr = $('<tr id="no-product"></tr>');
        tr_html = '<td colspan="5" align="center"><h2>' + lang.message.empty_product + '</h2></td>';
        newTr.html(tr_html);
        newTr.prependTo("#products");
        $('#searchProduct').focus();
    }
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
        localStorage.setItem('posproducts', JSON.stringify(products));
    });
    $('#price-' + row).keyup(function () {
        var price = $(this).val();
        var qty = $('#quantity-' + row).val();
        var discount = $('#discount-' + row).val();
        if (!isNaN(price)) {
            updateRowTotal(row, price, qty, discount);
        }
        products[row].price = price;
        localStorage.setItem('posproducts', JSON.stringify(products));
    });
    $('#discount-' + row).keyup(function () {
        var discount = $(this).val();
        var qty = $('#quantity-' + row).val();
        var price = $('#price-' + row).val();
        if (!isNaN(discount)) {
            updateRowTotal(row, price, qty, discount);
        }
        products[row].discount = discount;
        localStorage.setItem('posproducts', JSON.stringify(products));
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
    $("#subtotal").text($.number(subtotal, 0, ',', '.'));
    $('#subtotal-value').val(subtotal);
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
    $('#total-value').val(total);
    $('#total').text($.number(total, 0, ',', '.'));
    $('#payment-total').text($.number(total, 0, ',', '.'));
    updateCredit();
}
function updateCredit() {
    var total = $('#total-value').val();
    var cash = $('#cash').val();
    $('#cash-value').val(cash);
    if (parseFloat(cash) >= parseFloat(total)) {
        $('#change').show();
        $('#credit').hide();
        var change = cash - total;
        $('#payment-change').text($.number(change, 0, ',', '.'));
        $('#payment-credit').text(0);
    } else {
        $('#change').hide();
        $('#credit').show();
        $('#payment-change').text(0);
        var credit = total - cash;
        if (credit < 0)
            credit = 0;
        $('#payment-credit').text($.number(credit, 0, ',', '.'));
    }
}

//payment button
$('body').on('click', '#payment', function (e) {
    if (Object.keys(products).length > 0) {
        showModal('payment');
        $('#cash').focus();
    } else {
        showNotify(lang.message.empty_product, 'danger');
    }
});
//save button
$('body').on('click', '#save', function (e) {
    e.preventDefault();
    submit();
});
//cancel button
$('body').on('click', '#cancel', function (e) {
    e.preventDefault();
    removeSession();
    window.location.reload();
});

function submit() {
    var cash = $('#cash-value').val();
    var total = $('#total-value').val();
    if (cash < total) {
        showNotify(lang.message.less_payment, 'danger');
    } else {
        $('#form').ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                showNotify(data.message, data.status);
                if (data.status == 'success') {
                    removeSession();
                    var url = base_url + 'sales/pos/receipt/' + data.id;
                    var popup2 = checkPopup2(url);
                    if (popup2 == true) {
                        window.location.reload();
                    } else {
                        window.location.href = url + '?back=1';
                    }
                }
            }
        });
    }
    return false;
}

function checkPopup2(url) {
    var popup_window = window.open(url, '_blank');
    var result = false;
    try {
        popup_window.focus();
        result = true;
    } catch (e) {
        result = false;
        alert("Popup Blocker is on! For print receipt runs normally, please this url app in exception list.");
    }
    return result;
}
//remove session
function removeSession() {
    localStorage.removeItem('poscustomer');
    localStorage.removeItem('poscustomer_name');
    localStorage.removeItem('posproducts');
    localStorage.removeItem('posdiscount');
    localStorage.removeItem('poscash');
    localStorage.removeItem('postax');
}