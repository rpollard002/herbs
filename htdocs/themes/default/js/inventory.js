$(document).ready(function () {


    $('#inventory_list_data tbody tr').click( function (e) {
        herb_id = $(this).find('td').eq(0).text();
        herb_description = $(this).find('td').eq(1).text();
        herb_qty = $(this).find('td').eq(2).text();

        $(location).attr('href','/inventory/inventory_levels/id/' + herb_id);
    });

    $('#save_inventory').click( function (e) {
        herb_id = $('#id').val();
        herb_qty = $('#qty').val();
        herb_old_qty = $('#old_qty').val();
        createQtyChangeAudit(herb_id, herb_qty, herb_old_qty);

    });

    $('#receive_list_data td:nth-child(1)').hide();
    $('#receive_list_data th:nth-child(1)').hide();

});
function createQtyChangeAudit(p_herb_id, p_herb_qty, p_old_qty)
{

    $.ajax({
        url: '/audit',
        data: "herb_id=" + p_herb_id + "&herb_qty=" + p_herb_qty + "&old_qty=" + p_old_qty,
        success: function(data) {
            data = data.trim();
            $("#inventory_herb").submit();
        },
        error: function (x, e) {
            jQuery("#first_layer").css("visibility","hidden");
            if (x.status==0) {
                alert('You are offline!!\n Please Check Your Network.');
            } else if(x.status==404) {
                alert('Requested URL not found.');
            } else if(x.status==500) {
                alert('Internel Server Error.');
            } else if(e=='parsererror') {
                alert('Error.\nParsing JSON Request failed.');
            } else if(e=='timeout'){
                alert('Request Time out.');
            } else {
                alert('Unknow Error.\n'+x.responseText);
            }
        }
    });

}