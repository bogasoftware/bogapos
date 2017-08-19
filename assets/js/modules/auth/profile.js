$(function () {
    $('body').on('submit', '#form-profile', function (e) {
        e.preventDefault();
        $('#form-profile').ajaxSubmit({
            success: function (data) {
                data = JSON.parse(data);
                showNotify(data.message, data.status);
            }
        });
        return false;
    });
    $("#jabatan").selectize({
        onDropdownOpen: function (t) {
            t.hide().velocity("slideDown", {begin: function () {
                    t.css({"margin-top": "0"})
                }, duration: 200, easing: easing_swiftOut})
        },
        onDropdownClose: function (t) {
            t.show().velocity("slideUp", {complete: function () {
                    t.css({"margin-top": ""})
                }, duration: 200, easing: easing_swiftOut})
        },
        onChange: function (t) {
            getGolongan()
        }
    });
    $("#golongan").selectize({
        onDropdownOpen: function (t) {
            t.hide().velocity("slideDown", {begin: function () {
                    t.css({"margin-top": "0"})
                }, duration: 200, easing: easing_swiftOut})
        },
        onDropdownClose: function (t) {
            t.show().velocity("slideUp", {complete: function () {
                    t.css({"margin-top": ""})
                }, duration: 200, easing: easing_swiftOut})
        }
    });
    $('body').on('change', '#tanda_tangan', function (e) {
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("tanda_tangan-image").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
});
function getGolongan() {
    var jabatan = $('#jabatan').val();
    var selectize = $("#golongan")[0].selectize;
    selectize.clear();
    selectize.clearOptions();
    if (jabatan == 'Guru Pertama') {
        selectize.addOption({value: 'IIIA', text: 'IIIA'});
        selectize.addOption({value: 'IIIB', text: 'IIIB'});
    } else if (jabatan == 'Guru Muda') {
        selectize.addOption({value: 'IIIC', text: 'IIIC'});
        selectize.addOption({value: 'IIID', text: 'IIID'});
    } else if (jabatan == 'Guru Madya') {
        selectize.addOption({value: 'IVA', text: 'IVA'});
        selectize.addOption({value: 'IVB', text: 'IVB'});
        selectize.addOption({value: 'IVC', text: 'IVC'});
    } else if (jabatan == 'Guru Utama') {
        selectize.addOption({value: 'IVD', text: 'IVD'});
        selectize.addOption({value: 'IVE', text: 'IVE'});
    }
}
altair_forms.parsley_validation_config();
$maskedInput = $(".masked_input"), $maskedInput.length && $maskedInput.inputmask();
$(function () {
    altair_form_validation.init()
}), altair_form_validation = {
    init: function ()
    {
        var i = $("#form-profile");
        i.parsley().on("form:validated", function () {
            altair_md.update_input(i.find(".md-input-danger"))
        }).on("field:validated", function (i) {
            $(i.$element).hasClass("md-input") && altair_md.update_input($(i.$element))
        }), window.Parsley.on("field:validate", function () {
            var i = $(this.$element).closest(".md-input-wrapper").siblings(".error_server_side");
            i && i.hide()
        })
    }
};