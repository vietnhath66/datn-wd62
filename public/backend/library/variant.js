(function ($) {
    "use strict";
    var HT = {};
    let finalAlbum = [];
    HT.setupProductVariant = () => {
        if ($(".turnOnVariant").length) {
            $(document).on("click", ".turnOnVariant", function () {
                let _this = $(this);
                let price = $('input[name="price"]').val();
                let code = $('input[name="code"]').val();
                if (price == "" || code == "") {
                    alert("Vui lòng nhập giá tiền");
                } else {
                    if (_this.siblings("input:checked").length == 0) {
                        $(".variant-wrapper").removeClass("hidden");
                    } else {
                        $(".variant-wrapper").addClass("hidden");
                    }
                }
            });
        }
    };

    HT.addVariant = () => {
        if ($(".add-variant").length) {
            $(document).on("click", ".add-variant", function () {
                let html = HT.renderVariantItem(attributeCatalogue);
                $(".variant-body").append(html);
                $(".variantTable thead").html("");
                $(".variantTable tbody").html("");
                HT.checkMaxAttributeGroup(attributeCatalogue);
                HT.disabledAttributeCatalogueChoose();
            });
        }
    };

    HT.renderVariantItem = (attributeCatalogue) => {
        let html = "";
        html = html + '<div class="row mb20 variant-item">';
        html = html + '<div class="col-lg-3">';
        html = html + '<div class="attribute-catalogue">';
        html =
            html +
            '<select name="attributeCatalogue[]" id="" class="choose-attribute niceSelect">';
        html = html + '<option value="">Chọn Nhóm thuộc tính</option>';
        for (let i = 0; i < attributeCatalogue.length; i++) {
            html =
                html +
                '<option value="' +
                attributeCatalogue[i].id +
                '">' +
                attributeCatalogue[i].name +
                "</option>";
        }
        html = html + "</select>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + '<div class="col-lg-8">';
        html =
            html +
            '<input type="text" name="" disabled class="fake-variant form-control">';
        html = html + "</div>";
        html = html + '<div class="col-lg-1">';
        html =
            html +
            '<button type="button" class="remove-attribute btn btn-danger"><svg data-icon="TrashSolidLarge" aria-hidden="true" focusable="false" width="15" height="16" viewBox="0 0 15 16" class="bem-Svg" style="display: block;"><path fill="currentColor" d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z"></path></svg></button>';
        html = html + "</div>";
        html = html + "</div>";

        return html;
    };

    HT.chooseVariantGroup = () => {
        $(document).on("change", ".choose-attribute", function () {
            let _this = $(this);
            let attributeCatalogueId = _this.val();
            if (attributeCatalogueId != 0) {
                _this
                    .parents(".col-lg-3")
                    .siblings(".col-lg-8")
                    .html(HT.select2Variant(attributeCatalogueId));
                $(".selectVariant").each(function (key, index) {
                    HT.getSelect2($(this));
                });
            } else {
                _this
                    .parents(".col-lg-3")
                    .siblings(".col-lg-8")
                    .html(
                        '<input type="text" name="attribute[' +
                            attributeCatalogueId +
                            '][]" disabled="" class="fake-variant form-control">'
                    );
            }

            HT.disabledAttributeCatalogueChoose();
        });
    };

    HT.createProductVariant = () => {
        $(document).on("change", ".selectVariant", function () {
            let _this = $(this);
            HT.createVariant();
        });
    };

    HT.createVariant = () => {
        let attributes = [];
        let variants = [];
        let attributeTitle = [];

        $(".variant-item").each(function () {
            let _this = $(this);
            let attr = [];
            let attrVariant = [];
            const attributeCatalogueId = _this.find(".choose-attribute").val();
            const optionText = _this
                .find(".choose-attribute option:selected")
                .text();
            const attribute = $(".variant-" + attributeCatalogueId).select2(
                "data"
            );

            for (let i = 0; i < attribute.length; i++) {
                let item = {};
                let itemVariant = {};
                item[optionText] = attribute[i].text;
                itemVariant[attributeCatalogueId] = attribute[i].id;
                attr.push(item);
                attrVariant.push(itemVariant);
            }
            attributeTitle.push(optionText);
            attributes.push(attr);
            variants.push(attrVariant);
        });

        attributes = attributes.reduce((a, b) =>
            a.flatMap((d) => b.map((e) => ({ ...d, ...e })))
        );

        variants = variants.reduce((a, b) =>
            a.flatMap((d) => b.map((e) => ({ ...d, ...e })))
        );

        HT.createTableHeader(attributeTitle);

        let trClass = [];
        attributes.forEach((item, index) => {
            let $row = HT.createVariantRow(item, variants[index]);
            let classModified =
                "tr-variant-" +
                Object.values(variants[index]).join(", ").replace(/, /g, "-");
            trClass.push(classModified);
            if (!$("table.variantTable tbody tr").hasClass(classModified)) {
                $("table.variantTable tbody").append($row);
            }
        });

        $("table.variantTable tbody tr").each(function () {
            const $row = $(this);
            const rowClasses = $row.attr("class");
            if (rowClasses) {
                const rowClassArray = rowClasses.split(" ");
                let shouldRemove = false;
                rowClassArray.forEach((rowClass) => {
                    if (rowClass == "variant-row") {
                        return;
                    } else if (!trClass.includes(rowClass)) {
                        shouldRemove = true;
                    }
                });
                if (shouldRemove) {
                    $row.remove();
                }
            }
        });

        // let html = HT.renderTableHtml(attributes, attributeTitle, variants);
        // $('table.variantTable').html(html)
    };

    HT.createVariantRow = (attributeItem, variantItem) => {
        let attributeString = Object.values(attributeItem).join(", ");
        let attributeId = Object.values(variantItem).join(", ");
        let classModified = attributeId.replace(/, /g, "-");

        let $row = $("<tr>").addClass(
            "variant-row tr-variant-" + classModified
        );
        let $td;

        $td = $("<td>").append(
            $("<span>")
                .addClass("image img-cover")
                .append(
                    $("<img>")
                        .attr(
                            "src",
                            "https://aothun24h.vn/UserFile/editor/ao-thun-co-do-sao-vang-A0028.jpg"
                        )
                        .addClass("imageSrc")
                )
        );
        $row.append($td);

        Object.values(attributeItem).forEach((value) => {
            $td = $("<td>").text(value);
            $row.append($td);
        });

        $td = $("<td>").addClass("hidden td-variant");
        let mainPrice = $("input[name=price]").val();
        let mainSku = $("input[name=code]").val();

        let inputHiddenFields = [
            { name: "variant[quantity][]", class: "variant_quantity" },
            {
                name: "variant[sku][]",
                class: "variant_sku",
                value: mainSku + "-" + classModified,
            },
            {
                name: "variant[price][]",
                class: "variant_price",
                value: mainPrice,
            },
            { name: "variant[barcode][]", class: "variant_barcode" },
            { name: "variant[file_name][]", class: "variant_filename" },
            { name: "variant[file_url][]", class: "variant_fileurl" },
            { name: "variant[album][]", class: "variant_album" },
            { name: "productVariant[name][]", value: attributeString },
            { name: "productVariant[id][]", value: attributeId },
        ];

        $.each(inputHiddenFields, function (_, field) {
            let $input = $("<input>")
                .attr("type", "text")
                .attr("name", field.name)
                .addClass(field.class);
            if (field.value) {
                $input.val(field.value);
            }
            $td.append($input);
        });

        $row.append($("<td>").addClass("td-quantity").text("-"))
            .append($("<td>").addClass("td-price").text(mainPrice))
            // .append(
            //     $("<td>")
            //         .addClass("td-sku")
            //         .text(mainSku + "_" + classModified)
            // )
            .append($td);
        return $row;
    };

    HT.createTableHeader = (attributeTitle) => {
        let $thead = $("table.variantTable thead");
        let $row = $("<tr>");
        $row.append($("<td>").text("Hình Ảnh"));
        for (let i = 0; i < attributeTitle.length; i++) {
            $row.append($("<td>").text(attributeTitle[i]));
        }

        $row.append($("<td>").text("Số lượng"));
        $row.append($("<td>").text("Giá tiền"));
        // $row.append($("<td>").text("SKU"));

        $thead.html($row);
        return $thead;
    };

    HT.renderTableHtml = (attributes, attributeTitle, variants) => {
        let html = "";

        html = html + "<thead>";
        html = html + "<tr>";
        // html = html + '<td>Hình ảnh</td>'
        for (let i = 0; i < attributeTitle.length; i++) {
            html = html + "<td>" + attributeTitle[i] + "</td>";
        }

        html = html + "<td>Số lượng</td>";
        html = html + "<td>Giá tiền</td>";
        // html = html + "<td>SKU</td>";
        html = html + "</tr>";
        html = html + "</thead>";
        html = html + "<tbody>";

        for (let j = 0; j < attributes.length; j++) {
            html = html + '<tr class="variant-row">';
            let attributeArray = [];
            let attributeIdArray = [];
            $.each(attributes[j], function (index, value) {
                html = html + "<td>" + value + "</td>";
                attributeArray.push(value);
            });

            $.each(variants[j], function (index, value) {
                attributeIdArray.push(value);
            });

            let attributeString = attributeArray.join(", ");
            let attributeId = attributeIdArray.join(", ");

            html = html + '<td class="td-quantity">-</td>';
            html = html + '<td class="td-price">-</td>';
            // html = html + '<td class="td-sku">-</td>';
            html = html + '<td class="hidden td-variant">';
            html =
                html +
                '<input type="text" name="variant[quantity][]" class="variant_quantity">';
            html =
                html +
                '<input type="hidden" name="variant[sku][]" class="variant_sku">';
            html =
                html +
                '<input type="text" name="variant[price][]" class="variant_price">';
            html =
                html +
                '<input type="text" name="attribute[name][]" value="' +
                attributeString +
                '">';
            html =
                html +
                '<input type="text" name="attribute[id][]" value="' +
                attributeId +
                '">';
            html = html + "</td>";
            html = html + "</tr>";
        }

        html = html + "</tbody>";
        return html;
    };

    HT.getSelect2 = (object) => {
        let option = {
            attributeCatalogueId: object.attr("data-catid"),
        };

        $(object).select2({
            minimumInputLength: 1,
            placeholder: "Nhập tối thiểu 1 kí tự để tìm kiếm",
            ajax: {
                url: "http://127.0.0.1:8000/admin/ajax/attribute/getAttribute",
                type: "GET",
                dataType: "json",
                deley: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        option: option,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items,
                    };
                },
                cache: true,
            },
        });
    };

    HT.niceSelect = () => {
        $(".niceSelect").niceSelect();
    };

    HT.destroyNiceSelect = () => {
        if ($(".niceSelect").length) {
            $(".niceSelect").niceSelect("destroy");
        }
    };

    HT.disabledAttributeCatalogueChoose = () => {
        let id = [];
        $(".choose-attribute").each(function () {
            let _this = $(this);
            let selected = _this.find("option:selected").val();
            if (selected != 0) {
                id.push(selected);
            }
        });

        $(".choose-attribute").find("option").removeAttr("disabled");
        for (let i = 0; i < id.length; i++) {
            $(".choose-attribute")
                .find("option[value=" + id[i] + "]")
                .prop("disabled", true);
        }
        HT.destroyNiceSelect();
        HT.niceSelect();
        $(".choose-attribute").find("option:selected").removeAttr("disabled");
    };

    HT.checkMaxAttributeGroup = (attributeCatalogue) => {
        let variantItem = $(".variant-item").length;
        if (variantItem >= attributeCatalogue.length) {
            console.log(attributeCatalogue);

            $(".add-variant").remove();
        } else {
            $(".variant-foot").html(
                '<button type="button" class="add-variant">Thêm phiên bản mới</button>'
            );
        }
    };

    HT.removeAttribute = () => {
        $(document).on("click", ".remove-attribute", function () {
            let _this = $(this);
            _this.parents(".variant-item").remove();
            HT.checkMaxAttributeGroup(attributeCatalogue);
            HT.createVariant();
        });
    };

    HT.select2Variant = (attributeCatalogueId) => {
        let html =
            '<select class="selectVariant variant-' +
            attributeCatalogueId +
            ' form-control" name="attribute[' +
            attributeCatalogueId +
            '][]" multiple data-catid="' +
            attributeCatalogueId +
            '"></select>';
        return html;
    };

    HT.variantAlbum = () => {
        $(document).on("click", ".click-to-upload-variant", function (e) {
            HT.browseVariantServerAlbum();
            e.preventDefault();
        });
    };

    HT.browseVariantServerAlbum = (album) => {
        console.log(album);

        var type = "Images";
        var finder = new CKFinder();

        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            let html = "";
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url;
                html += '<li class="ui-state-default">';
                html += ' <div class="thumb">';
                html += ' <span class="span image img-scaledown">';
                html += '<img src="' + image + '" alt="' + image + '">';
                html +=
                    '<input type="hidden" name="variantAlbum[]" value="' +
                    image +
                    '">';
                html += "</span>";
                html +=
                    '<button class="variant-delete-image"><i class="fa fa-trash"></i></button>';
                html += "</div>";
                html += "</li>";
            }

            $(".click-to-upload-variant").addClass("hidden");
            $("#sortable2").append(html);
            $(".upload-variant-list").removeClass("hidden");
        };
        finder.popup();
    };

    HT.deleteVariantAlbum = () => {
        $(document).on("click", ".variant-delete-image", function () {
            let _this = $(this);
            _this.parents(".ui-state-default").remove();
            if ($(".ui-state-default").length == 0) {
                $(".click-to-upload-variant").removeClass("hidden");
                $(".upload-variant-list").addClass("hidden");
            }
        });
    };

    HT.switchChange = () => {
        $(document).on("change", ".js-switch", function () {
            let _this = $(this);
            let isChecked = _this.prop("checked");
            if (isChecked == true) {
                _this
                    .parents(".col-lg-2")
                    .siblings(".col-lg-10")
                    .find(".disabled")
                    .removeAttr("disabled");
            } else {
                _this
                    .parents(".col-lg-2")
                    .siblings(".col-lg-10")
                    .find(".disabled")
                    .attr("disabled", true);
            }
        });
    };

    HT.updateVariant = () => {
        $(document).on("click", ".variant-row", function () {
            let _this = $(this);
            let variantData = {};
            _this
                .find(".td-variant input[type=text][class^='variant_']")
                .each(function () {
                    let className = $(this).attr("class");
                    variantData[className] = $(this).val();
                });
                console.log(variantData);
                
            let updateVariantBox = HT.updateVariantHtml(variantData);

            if ($(".updateVariantTr").length == 0) {
                _this.after(updateVariantBox);
                HT.switchery();
            }
        });
    };

    HT.switchery = () => {
        $(".js-switch").each(function () {
            var switchery = new Switchery(this, {
                color: "#1AB394",
                size: "small",
            });
        });
    };

    HT.variantAlbumList = () => {
        const album = finalAlbum;
        let html = "";
        if (album.length && album[0] !== "") {
            for (let i = 0; i < album.length; i++) {
                html = html + '<li class="ui-state-default"> ';
                html = html + '<div class="thumb"> ';
                html = html + '<span class="span image img-scaledown">';
                html =
                    html +
                    '<img src="' +
                    album[i] +
                    '" alt="' +
                    album[i] +
                    '">';
                html =
                    html +
                    '<input type="hidden" name="variantAlbum[]" value="' +
                    album[i] +
                    '">';
                html = html + "</span>";
                html =
                    html +
                    '<button class="variant-delete-image"><i class="fa fa-trash"></i>';
                html = html + "</button>";
                html = html + "</div>";
                html = html + "</li>";
            }
        }
        return html;
    };

    HT.updateVariantHtml = (variantData) => {
        console.log(variantData);
        
        let variantAlbum = variantData.variant_album.split(",");
        let variantAlbumItem = HT.variantAlbumList(variantAlbum);
        let html = "";
        html = html + '<tr class="updateVariantTr">';
        html = html + '<td colspan="6">';
        html = html + '<div class="updateVariant ibox">';
        html = html + '<div class="ibox-title">';
        html =
            html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
        html = html + "<h5>Cập nhật thông tin phiên bản</h5>";
        html = html + '<div class="button-group">';
        html = html + '<div class="uk-flex uk-flex-middle">';
        html =
            html +
            '<button type="button" class="cancleUpdate btn btn-danger mr10">Hủy bỏ</button>';
        html =
            html +
            '<button type="button" class="saveUpdateVariant btn btn-success">Lưu lại</button>';
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + '<div class="ibox-content">';
        html = html + '<div class="row mt20 uk-flex uk-flex-middle">';
        html = html + '<div class="col-lg-2 uk-flex uk-flex-middle">';
        html = html + '<label for="" class="mr10">Tồn kho</label>';
        html =
            html +
            '<input type="checkbox" class="js-switch" ' +
            (variantData.variant_quantity !== "" ? "checked" : "") +
            ' data-target="variantQuantity">';
        html = html + "</div>";
        html = html + '<div class="col-lg-10">';
        html = html + '<div class="row">';
        html = html + '<div class="col-lg-3">';
        html = html + '<label for="" class="control-label">Số lượng</label>';
        html =
            html +
            '<input type="text" ' +
            (variantData.variant_quantity == "" ? "disabled" : "") +
            '  name="variant_quantity" value="' +
            variantData.variant_quantity +
            '" class="form-control ' +
            (variantData.variant_quantity == "" ? "disabled" : "") +
            ' int">';
        html = html + "</div>";
        html = html + '<div class="col-lg-3">';
        html = html + '<label for="" class="control-label">SKU</label>';
        html =
            html +
            '<input type="hidden" name="variant_sku" value="' +
            variantData.variant_sku +
            '" class="form-control text-right">';
        html = html + "</div>";
        html = html + '<div class="col-lg-3">';
        html = html + '<label for="" class="control-label">Giá</label>';
        html =
            html +
            '<input type="text" name="variant_price" value="' +
            HT.addCommas(variantData.variant_price) +
            '" class="form-control int">';
        html = html + "</div>";
        html = html + '<div class="col-lg-3">';
        // html = html + '<label for="" class="control-label">Barcode</label>';
        // html =
        //     html +
        //     '<input type="text" name="variant_barcode" value="' +
        //     variantData.variant_barcode +
        //     '" class="form-control text-right">';
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</div>";
        html = html + "</td>";
        html = html + "</tr>";

        return html;
    };

    HT.cancleVariantUpdate = () => {
        $(document).on("click", ".cancleUpdate", function () {
            HT.closeUpdateVariantBox();
        });
    };

    HT.closeUpdateVariantBox = () => {
        $(".updateVariantTr").remove();
    };

    HT.addCommas = (nStr) => {
        nStr = String(nStr);
        nStr = nStr.replace(/\./gi, "");
        let str = "";
        for (let i = nStr.length; i > 0; i -= 3) {
            let a = i - 3 < 0 ? 0 : i - 3;
            str = nStr.slice(a, i) + "." + str;
        }
        str = str.slice(0, str.length - 1);
        return str;
    };

    HT.saveVariantUpdate = () => {
        $(document).on("click", ".saveUpdateVariant", function () {
            let variant = {
                quantity: $("input[name=variant_quantity]").val(),
                sku: $("input[name=variant_sku]").val(),
                price: $("input[name=variant_price]").val(),
                barcode: $("input[name=variant_barcode]").val(),
                filename: $("input[name=variant_file_name]").val(),
                fileurl: $("input[name=variant_file_url]").val(),
                album: $("input[name='variant_album']")
                    .map(function () {
                        const replace = "C:\\fakepath\\";
                        const replaceWith = "products/";
                        const result = $(this)
                            .val()
                            .split(replace)
                            .join(replaceWith);
                        return result;
                    })
                    .get(),
            };
            $.each(variant, function (index, value) {
                $(".updateVariantTr")
                    .prev()
                    .find(".variant_" + index)
                    .val(value);
            });
            HT.addAlbum(variant.album);
            HT.previewVariantTr(variant);
            HT.closeUpdateVariantBox();
        });
    };

    HT.addAlbum = (album) => {
        finalAlbum.push(album[0]);
    };

    HT.previewVariantTr = (variant) => {
        let option = {
            quantity: variant.quantity,
            price: variant.price,
            sku: variant.sku,
        };
        $.each(option, function (index, value) {
            $(".updateVariantTr")
                .prev()
                .find(".td-" + index)
                .html(value);
        });
        $(".updateVariantTr")
            .prev()
            .find(".imageSrc")
            .attr("src", variant.album[0]);
    };

    HT.setupSelectMultiple = (callback) => {
        if ($(".selectVariant").length) {
            let count = $(".selectVariant").length;
            console.log(count);
            $(".selectVariant").each(function () {
                let _this = $(this);
                let attributeCatalogueId = _this.attr("data-catid");

                console.log(attributeCatalogueId);

                if (attribute != "") {
                    // console.log(attribute);

                    $.get(
                        "http://127.0.0.1:8000/admin/ajax/attribute/loadAttribute",
                        {
                            attribute: attribute,
                            attributeCatalogueId: attributeCatalogueId,
                        },
                        function (json) {
                            if (
                                json.items != "undefined" &&
                                json.items.length
                            ) {
                                for (let i = 0; i < json.items.length; i++) {
                                    var option = new Option(
                                        json.items[i].text,
                                        json.items[i].id,
                                        true,
                                        true
                                    );
                                    _this.append(option).trigger("change");
                                }
                            }
                            if (--count === 0 && callback) {
                                callback();
                            }
                        }
                    );
                }
                HT.getSelect2(_this);
            });
        }
    };

    HT.productVariant = () => {
        variant = JSON.parse(atob(variant));

        console.log(variant);
        // const findIndexVariantBySku = (sku) => variant.sku.findIndex((item) => item === sku)

        $(".variant-row").each(function (index, value) {
            console.log(123);

            let _this = $(this);
            let variantKey = _this
                .attr("class")
                .match(/tr-variant-(\d+-\d+)/)[1];
            let dataIndex = variant.sku.findIndex((sku) =>
                sku.includes(variantKey)
            );

            console.log(variantKey, dataIndex);

            if (dataIndex !== -1) {
                let inputHiddenFields = [
                    {
                        name: "variant[quantity][]",
                        class: "variant_quantity",
                        value: variant.quantity[dataIndex],
                    },
                    {
                        name: "variant[sku][]",
                        class: "variant_sku",
                        value: variant.sku[dataIndex],
                    },
                    {
                        name: "variant[price][]",
                        class: "variant_price",
                        value: variant.price[dataIndex],
                    },                
                ];

                for (let i = 0; i < inputHiddenFields.length; i++) {
                    _this
                        .find("." + inputHiddenFields[i].class)
                        .val(inputHiddenFields[i].value);
                    // console.log('.' + inputHiddenFields[i].class).val(inputHiddenFields[i].value);
                }

                _this
                    .find(".td-quantity")
                    .html(HT.addCommas(variant.quantity[dataIndex]));
                _this
                    .find(".td-price")
                    .html(HT.addCommas(variant.price[dataIndex]));
                _this
                    .find(".td-sku")
                    .html(HT.addCommas(variant.sku[dataIndex]));
            }
        });
    };

    $(document).ready(function () {
        HT.setupProductVariant();
        HT.addVariant();
        HT.niceSelect();
        HT.chooseVariantGroup();
        HT.removeAttribute();
        HT.createProductVariant();
        HT.variantAlbum();
        HT.deleteVariantAlbum();
        HT.switchChange();
        HT.updateVariant();
        HT.cancleVariantUpdate();
        HT.saveVariantUpdate();
        HT.setupSelectMultiple(() => {
            HT.productVariant();
        });
    });
})(jQuery);
