
var state = {
    items: [],
    item: {
        line_item_no: 0,
        code: "",
        name: "",
        account_code: "",
        qty: 0,
        price: 0,
        discount: 0,
        vat_rate: 0,
        vat_amt: 0,
        pre_vat_amt: 0,
        wht_rate: 0,
        wht_amt: 0,
        description: ""
    },
    summary: {
        grand_total: 0,
        total_vat_amt: 0,
        total_exm_amt: 0,
        total_zer_amt: 0,
        total_std_amt: 0,
        total_wht_amt: 0,
    }

};

function resetStateItemVal() {
    state.item = {
        line_item_no: 0,
        code: "",
        name: "",
        account_code: "",
        qty: 0,
        price: 0,
        discount: 0,
        vat_rate: 0,
        vat_amt: 0,
        pre_vat_amt: 0,
        wht_rate: 0,
        wht_amt: 0,
        description: ""
    };
}
function resetSummary(){
    state.summary = {
        grand_total: 0,
        total_vat_amt: 0,
        total_exm_amt: 0,
        total_zer_amt: 0,
        total_std_amt: 0,
        total_wht_amt: 0,
    }
}   

// =========== auto complete
var inputSearch = $('#inputSearch');
inputSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(productList, function(item) {
            return matcher.test(item);
        }));
    },
    response: function(event, ui) {
        if (ui.content.length == 1) {
            var data = ui.content[0].value;
            $(this).autocomplete("close");
            getProductCode(data);
        };
    },
    select: function(event, ui) {
        var data = ui.item.value;
        getProductCode(data);
    }
});

// =========== get product code
function getProductCode(data) {
    let productCode = [];
    data = data.split('(');
    productCode.push(data[0].replace(' ', ''));
    productSearch(productCode);
}

// =========== get product item
function productSearch(productCode) {
    $.ajax({
        type: 'GET',
        url: "/sale_ledger/quotation/getProduct",
        data: {
            productCode
        },
        success: function(product) {
            $("#inputSearch").val('');
            rowItemTable(product);
        }
    });
}

function rowItemTable(product) {
    var flag = 1;
    if (!setStateItem(product))
        return;

    if(flag){
        var newRow = $(`<tr class="${product.code}" data-rowindex="${product.code}">`);
        var cols = "";
        cols += `<td class="text-center p-0 line_item_no"></td>`;
        cols += `<td>${product.code +" - "+ product.name}
                    <button type="button" class="edit-product btn btn-link"
                        data-toggle="modal" data-target="#editModal" onclick="editRowItem('${product.code}')">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                </td>`;
        cols += `<td class="account">${product.account_code}</td>`;
        cols += `<td class="text-right p-0">
                    <input 
                        type="number"
                        class="form-control border-0 text-primary qty"
                        min=0
                        step="any" 
                    />
                </td>`;
        cols += `<td class="text-right price">${product.price}</td>`;
        cols += `<td class="text-right discount">${product.discount}</td>`;
        cols += `<td class="text-right vat">0.00</td>`;
        cols += `<td class="text-right preVatAmt">0.00</td>`;
        cols += `<td class="text-right wht">0.00</td>`;
        cols += `<td class="text-center p-0">
                    <button type="button" class="ibtnDel btn btn-sm btn-secondary">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>`;

        newRow.append(cols);
        $("table#itemTable tbody").append(newRow);
        setStateItem(product);
    }
}

function setStateItem(product) {
    resetStateItemVal();
    state.item.code = product.code;
    state.item.name = product.name;
    state.item.account_code = product.account_code;
    state.item.price = product.price;
    state.item.discount = product.discount;
    state.item.qty = product.qty;
    state.item.vat_rate = product.vat_rate;
    state.item.wht_rate = product.wht_rate;
    state.item.vat_amt = product.vat_amt;
    state.item.wht_amt = product.wht_amt;
    state.item.description = product.description;
    return setState();
}

function setState() {
    const filter = state.items.filter(i => i.code === state.item.code);
    if (filter.length > 0) {
        const index = state.items.indexOf(filter[0]);
        state.item.price = state.items[index].price;
        state.item.discount = state.items[index].discount;
        state.item.vat_rate = state.items[index].vat_rate;
        state.item.wht_rate = state.items[index].wht_rate;
        state.item.account_code = state.items[index].account_code;

        updateRowItem(index);
        return false;
    }
    state.items.push(state.item);
    return true;
}

function updateRowItem(index) {
    let rowline_item_no = $("table#itemTable tbody tr." + state.item.code + " td.line_item_no");
    let rowAccCode = $("table#itemTable tbody tr." + state.item.code + " td.account");
    let rowQty = $("table#itemTable tbody tr." + state.item.code + " input.qty");
    let rowPrice = $("table#itemTable tbody tr." + state.item.code + " td.price");
    let rowDiscount = $("table#itemTable tbody tr." + state.item.code + " td.discount");
    let rowPreVatAmt = $("table#itemTable tbody tr." + state.item.code + " td.preVatAmt");
    let rowVatAmt = $("table#itemTable tbody tr." + state.item.code + " td.vat");
    let rowWhtAmt = $("table#itemTable tbody tr." + state.item.code + " td.wht");

    // calculate sub total
    
    let subTotal = (state.item.price - state.item.discount) * state.item.qty;
    let pre_vat_amt = isNaN(subTotal) ? 0 : subTotal;
    let vat_amt = (pre_vat_amt * state.item.vat_rate) / 100;
    let wht_amt = (pre_vat_amt * state.item.wht_rate) / 100;
    let line_item_no = index + 1; //getline_item_no();

    // set table row
    rowline_item_no.text(line_item_no);
    rowAccCode.text(state.item.account_code);
    rowQty.val(state.item.qty);
    rowPrice.text(state.item.price.toFixed(2));
    rowDiscount.text(state.item.discount.toFixed(2));
    rowPreVatAmt.text(pre_vat_amt.toFixed(2));

    let vatCell = `${vat_amt.toFixed(2)} <small class="text-secondary">${state.item.vat_rate}%</small>`;
    let whtCell = `${wht_amt.toFixed(2)} <small class="text-secondary">${state.item.wht_rate}%</small>`;
    rowVatAmt.html(vatCell);
    rowWhtAmt.html(whtCell);

    // set state array
    state.items[index].line_item_no = line_item_no;
    state.items[index].account_code = state.item.account_code;
    state.items[index].qty = state.item.qty;
    state.items[index].price = state.item.price;
    state.items[index].discount = state.item.discount;
    state.items[index].pre_vat_amt = pre_vat_amt;
    state.items[index].vat_amt = vat_amt;
    state.items[index].wht_amt = wht_amt;
    state.items[index].vat_rate = state.item.vat_rate;
    state.items[index].wht_rate = state.item.wht_rate;
    state.items[index].description = state.item.description;

    console.log(state.items);
    summary();
}

function getline_item_no() {
    const items = [...state.items];
    let maxItem = items.reduce((max, item) => max.line_item_no > item.line_item_no ? max : item);
    let nextline_item_no = maxItem.line_item_no + 1;

    return nextline_item_no;
}

function deleteRowItem() {
    const filter = state.items.filter(i => i.code === state.item.code);
    if (filter.length > 0) {
        const index = state.items.indexOf(filter[0]);
        state.items.splice(index, 1);
    }
    summary();
}

$(document).on('change', 'input.qty', function() {
    const code = $(this).parents('tr').attr("data-rowindex");
    resetStateItemVal();
    state.item.code = code;
    state.item.qty = parseFloat($(this).val());
    setState();
});
$(document).on('keyup', 'input.qty', function() {
    const code = $(this).parents('tr').attr("data-rowindex");
    resetStateItemVal();
    state.item.qty = parseFloat($(this).val()); 
    setState();
    state.item.code = code;
});
$(document).on('click', '.ibtnDel', function() {
    const code = $(this).parents('tr').attr("data-rowindex");
    resetStateItemVal();
    state.item.code = code;
    deleteRowItem();
    $(this).parents('tr').remove();
});

function editRowItem(code) {
    resetStateItemVal();
    const filter = state.items.filter(i => i.code === code);
    if (filter.length > 0) {
        state.item.code = filter[0].code;
        state.item.name = filter[0].name;
        state.item.account_code = filter[0].account_code;
        state.item.qty = filter[0].qty;
        state.item.price = filter[0].price;
        state.item.discount = filter[0].discount;
        state.item.vat_rate = filter[0].vat_rate;
        state.item.wht_rate = filter[0].wht_rate;
        state.item.description = filter[0].description;

        $('#editModal #title').text(state.item.code + " - " + state.item.name);
        $('#editModal #price').val(state.item.price);
        $('#editModal #discount').val(state.item.discount);
        $('#editModal #description').val(state.item.description);
        $('#editModal #account option[value="' + state.item.account_code + '"]').prop('selected', 'selected');
        $('#editModal #vat_rate option[value="' + state.item.vat_rate + '"]').prop('selected', 'selected');
        $('#editModal #wht_rate option[value="' + state.item.wht_rate + '"]').prop('selected', 'selected');
    }
}

$(document).on('click', '#editModal #btnSubmitModal', function() {
    state.item.price = parseFloat($('#editModal #price').val());
    state.item.discount = parseFloat($('#editModal #discount').val());
    state.item.vat_rate = parseFloat($('#editModal #vat_rate').val());
    state.item.wht_rate = parseFloat($('#editModal #wht_rate').val());
    state.item.description = $('#editModal #description').val();
    state.item.account_code = $('#editModal #account').val();

    const filter = state.items.filter(i => i.code === state.item.code);
    if (filter.length > 0) {
        const index = state.items.indexOf(filter[0]);
        updateRowItem(index);
    }
});

function summary() {
    const items = [...state.items];
    resetSummary();

    if (items.length > 0) {
        items.forEach(item => {
            state.summary.grand_total += item.pre_vat_amt+item.vat_amt
            state.summary.total_vat_amt += item.vat_amt;
            state.summary.total_wht_amt += item.wht_amt;
    
            if (item.vat_rate == 0)
                state.summary.total_zer_amt += item.pre_vat_amt;
    
            if (item.vat_rate > 0)
                state.summary.total_std_amt += item.pre_vat_amt;
    
            // if (item.vat_rate == '')
            //     state.summary.total_exm_amt += item.pre_vat_amt;
        });
    
        $('#totalVatAmt').text(state.summary.total_vat_amt.toFixed(2));
        $('#grandTotal').text(state.summary.grand_total.toFixed(2));
        $('#totalExmAmt').text(state.summary.total_exm_amt.toFixed(2));
        $('#totalZerAmt').text(state.summary.total_zer_amt.toFixed(2));
        $('#totalStdAmt').text(state.summary.total_std_amt.toFixed(2));
        
        if (state.summary.total_wht_amt > 0) {
            let totalPayAmt = state.summary.grand_total - state.summary.total_wht_amt;
            $('#totalWhtAmt').text(state.summary.total_wht_amt.toFixed(2));
            $('#totalPayAmt').text(totalPayAmt.toFixed(2));
            $('#totalWhtAmt').parents('li').removeClass('d-none');
            $('#totalPayAmt').parents('li').removeClass('d-none');
        }else{
            $('#totalWhtAmt').parents('li').addClass('d-none');
            $('#totalPayAmt').parents('li').addClass('d-none');
        }
    }
    
}