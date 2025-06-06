(function ($) {
    "use strict";
    var HT = {};
    // var $document = $(document);

    HT.getLocation = () => {
        $(document).on("change", ".location", function () {
            let _this = $(this);
            let option = {
                'data': {
                    'location_id': _this.val(),
                },
                'target': _this.attr('data-target')
            };
            
            HT.sendDataTogetLocation(option);
        });
    };

    HT.sendDataTogetLocation = (option) => {
        $.ajax({
            url: "http://127.0.0.1:8000/admin/ajax/location/getlocation",
            type: "GET",
            data: option,
            dataType: "json",
            success: function (res) {;
                $("."+option.target).html(res.html);

                if(district_id != '' && option.target == 'districts') {
                    $('.districts').val(district_id).trigger('change');
                }

                if(ward_id != '' && option.target == 'wards') {
                    $('.wards').val(ward_id).trigger('change');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("lỗi" + textStatus + " " + errorThrown);
            },
        });
    };

    HT.locadCity = () => {
        if(province_id != ''){
            $('.province').val(province_id).trigger('change');
        }
    };

    $(document).ready(function () {
        HT.getLocation();
        HT.locadCity();
    });
})(jQuery);
