/**
 * Default theme functions
 */



var C_CASE_MULTIPLIER = 1000;
var C_CONTAINER_MULTIPLIER = 30;
var bottle_per_kilo = 0;
var cost_per_dose = 0;
var cost_per_thousand = 0;
var cost_per_ten_thousand = 0;
var kilos_per_thousand = 0;
var cost_per_order = 0;
// Inputs
var mg_per_dose = 0;
var cost_per_kilo = 0;
var kilos_to_order = 0;


$(document).ready(function()
{
    //    $("#herb_ingredients td").click(function(e) {
    //
    //        var rowIndex = $(this).parent().parent().children().index($(this).parent());
    //        var tdIndex = $(this).parent().children().index($(this));
    //        alert('Row Number: ' + (rowIndex) + '\nColumn Number: ' + (tdIndex));
    //
    //        // alert($(this).text());
    //    });

    //  NOTES
        //  1.  This code will find the record id of the Herb table:
        //      $('td:nth-child(1)', this).text()

    // Initialize an array to track the selected herb row numbers
    var a_selected_herb_list = new Array();

    $("#deleted_ingredients").val('');

    $('#herb_ingredients tr:not(:has(th))').each(function () {
        v_selected_herb_id = $('td:nth-child(3)', this).find('input').val();
        var v_current_row = 0;
        $('#herb_table tr:not(:has(th))').each(function () {
            v_available_herb_id = $('td:nth-child(1)', this).text();
            v_current_row++;
            if(v_selected_herb_id == v_available_herb_id)
            {
                $('td:nth-child(4)', this).css("color","#BCB9BC");
                var selected_herb_last_element = a_selected_herb_list.length;
                a_selected_herb_list[selected_herb_last_element] = v_selected_herb_id;
                // console.log("Selected herb id: " + a_selected_herb_list);
            }
        });
    });

    // Set up event trap for adding herbs to the selected list
    $('#herb_table tbody tr').click( function (e) {
        herb_id = $(this).find('td').eq(0).text();
        herb_description = $(this).find('td').eq(3).text();
        // Dim herb description to indicate it has been selected
        $(this).find('td').eq(3).find('div').css("color","#BCB9BC");
        selected_herb_list = $("#selected_herbs").val();
        // console.log($(this)) //.index('tr'));
        var selected_herb_last_element = a_selected_herb_list.length;
        var selected_herb_row_number = $(this).prevAll().length;
        var inSelectedArray = parseInt($.inArray(herb_id, a_selected_herb_list));
        if (inSelectedArray < 0)
        {
            a_selected_herb_list[selected_herb_last_element] = herb_id;
            Add(a_selected_herb_list[selected_herb_last_element], herb_description);

        }
    });
    // Set up event trap for detailed herb information dialog
    $('#herb_table tbody tr td img').hover(function() {
        current_herb_info = ($(this).parent().parent().parent().find('td').next('td').find('div').text());
        $("#herb_name_benefits").html(current_herb_info);
        $("#herb_name_info").html("Hello");
        $("#herb_name_common_names").html("Common Names like whatever");
        $("#herb_detail_info").css("visibility", "visible");
        $("#herb_detail_info").dialog({closeBtn: "right"});
        $("#herb_detail_info").position({
            my: "left top",
            at: "left top",
            of: "#targetElement"
        });

    });

//  Removes the ingredient row, updates the array and re-highlights the herb to be selectable
    $('#herb_ingredients').delegate("tbody tr td img", "click", function() {
        v_formula_herb_id = ($(this).parent().parent().find('td').eq(1).find('input').val());
        v_selected_herb_id = ($(this).parent().parent().find('td').eq(2).find('input').val());
        v_ingredient_row_id = ($(this).parent().parent().attr('id'));
        // v_ingredient_row_id = ($(this).parent().parent().find('td').eq(2).text());
        $("#" + v_ingredient_row_id).remove();
        var v_current_row = 0;
        $('#herb_table tr:not(:has(th))').each(function () {
            v_available_herb_id = $('td:nth-child(1)', this).text();
            v_available_herbs = $('td:nth-child(4)', this).text();
            v_current_row++;
            if(v_selected_herb_id == v_available_herb_id)
            {
                $(this).find('td').eq(3).find('div').css("color","#000000");
                a_selected_herb_list.splice( $.inArray(v_selected_herb_id, a_selected_herb_list), 1 );

                if(v_ingredient_row_id != "")
                {
                    storeDeletedIngredients(v_formula_herb_id);
                }

            }
        });
    });

    function storeDeletedIngredients(p_ingredient_id)
    {
        if(parseInt($("#deleted_ingredients").val().length) > 0)
        {
            $("#deleted_ingredients").val($("#deleted_ingredients").val() + ',' + p_ingredient_id);
        } else {
            $("#deleted_ingredients").val(p_ingredient_id);
        }
    }

    $("#last_row_number").val($('#herb_ingredients tr').length);


// Hide the Herb ID and Balloon (detail data) columns
    $('#herb_table td:nth-child(1)').hide();
    $('#herb_table th:nth-child(1)').hide();
    $('#herb_table td:nth-child(2)').hide();
    $('#herb_table th:nth-child(2)').hide();
// Hide Ingredients ID and Herb ID columns
////
    $('#herb_ingredients td:nth-child(2)').hide();
    $('#herb_ingredients th:nth-child(2)').hide();
    $('#herb_ingredients td:nth-child(3)').hide();
    $('#herb_ingredients th:nth-child(3)').hide();

    $("#herb_ingredients tr td input.input_3").bind("change", function(e){
// Get the current row
        p_last_element = ($(this).parent().parent().prevAll().length);

        var grams_per_bottle = (($(this).val() * C_CONTAINER_MULTIPLIER) / C_CASE_MULTIPLIER);
        grams_per_bottle = parseFloat(Math.round(grams_per_bottle * 100) / 100).toFixed(2);
        $("#grams_per_bottle_" + p_last_element).text(grams_per_bottle);
        bottle_per_kilo =  C_CASE_MULTIPLIER / grams_per_bottle;
        bottle_per_kilo = parseFloat(Math.round(bottle_per_kilo * 100) / 100).toFixed(2);
        $("#bottle_per_kilo_" + p_last_element).text(bottle_per_kilo);

        // console.log(this);

    });
    $("#herb_ingredients tr td input.input_4").bind("change", function(e){
        p_last_element = ($(this).parent().parent().prevAll().length);
        cost_per_kilo = $(this).val();
        bottle_per_kilo = $("#bottle_per_kilo_" + p_last_element).text();
        cost_per_bottle = parseFloat(cost_per_kilo) / parseFloat(bottle_per_kilo);
        cost_per_bottle = parseFloat(cost_per_bottle.toFixed(7));
        $("#cost_per_bottle_" + p_last_element).text(cost_per_bottle);

        cost_per_dose = (cost_per_bottle / C_CONTAINER_MULTIPLIER);
        cost_per_dose = parseFloat(Math.round(cost_per_dose * 100) / 100).toFixed(2);
        $("#cost_per_dose_" + p_last_element).text(cost_per_dose);

        cost_per_thousand = (cost_per_bottle * C_CASE_MULTIPLIER);
        cost_per_thousand = parseFloat(Math.round(cost_per_thousand * 100) / 100).toFixed(2);
        $("#cost_per_thousand_" + p_last_element).text(cost_per_thousand);

        cost_per_ten_thousand = (cost_per_thousand * 10);
        cost_per_ten_thousand = parseFloat(Math.round(cost_per_ten_thousand * 100) / 100).toFixed(2);
        $("#cost_per_ten_thousand_" + p_last_element).text(cost_per_ten_thousand);

        kilos_per_thousand = (cost_per_thousand / $(this).val());
        kilos_per_thousand = parseFloat(Math.round(kilos_per_thousand * 100) / 100).toFixed(2);
        $("#kilos_per_thousand_" + p_last_element).text(kilos_per_thousand);

        // console.log(this);

    });
    $("#herb_ingredients tr td input.input_5").bind("change", function(e){
        p_last_element = ($(this).parent().parent().prevAll().length);
        kilos_to_order = $(this).val();
        cost_per_order = (kilos_to_order * cost_per_kilo);
        cost_per_order = parseFloat(Math.round(cost_per_order * 100) / 100).toFixed(2);
        $("#cost_per_order_" + p_last_element).text(cost_per_order);

        // console.log(this);

    });
    $('#formula_list_data tbody tr td:not(:has(img))').click( function (e) {
        v_formula_id = ($(this).parent().find('td').eq(0).text());
        $(location).attr('href','/formula/build/id/' + v_formula_id);

    });
    $('#formula_list_data tbody tr td img').click( function (e) {
        v_selected_row = $(this).parent().parent().index();
        v_formula_id = ($(this).parent().parent().find('td').eq(0).text());
        v_img_id = ($(this).attr("id"));
        v_class = ($(this).attr("class"));
        if(v_class == 'mgmt')
        {
            $(location).attr('href','/formula/inventory_adjust/id/' + v_formula_id);
        }
        if(v_class == 'prod')
        {
            $(location).attr('href','/formula/inventory_receive/id/' + v_formula_id);
        }

    });
    $( '#add_formula').on( 'click', function() {
        $(location).attr('href','/formula/build/');
        return false;
    });
    $('#herb_list_data tbody tr td').click( function (e) {
        v_herb_id = ($(this).parent().find('td').eq(0).text());
        $(location).attr('href','/herb/detail/id/' + v_herb_id);

    });
    $( '#add_herb').on( 'click', function() {
        $(location).attr('href','/herb/detail/id');
        return false;
    });
//    $('#add_formula').bind( function (e) {
//        $(location).attr('href','/formula/build/');
//
//    });

});


function Add(p_herb_id,p_herb)
{


    var p_last_element = $('#herb_ingredients tr').length;
    $("#last_row_number").val(p_last_element);

    $("#herb_ingredients tbody").append(
        "<tr id='ingredients_row_" + p_last_element + "'>"+
            "<td><img id='delete_row_" + p_last_element + "' src='/assets/button-delete_icon.png'></td>"+
            "<td><input id='formula_herb_id_" + p_last_element + "' name='formula_herb_id_" + p_last_element + "' class='input_1' type='text' value=''></td>"+
            "<td><input id='herb_id_" + p_last_element + "' name='herb_id_" + p_last_element + "' class='input_2' type='text' value='" + p_herb_id + "'></td>"+
            "<td>" + p_herb + "</td>"+
            "<td><input id='mg_per_dose_" + p_last_element + "'  name='mg_per_dose_" + p_last_element + "' class='input_3' type='text' value=''></td>"+
            "<td id='grams_per_bottle_" + p_last_element + "'></td>"+
            "<td id='bottle_per_kilo_" + p_last_element + "'></td>"+
            "<td><input id='cost_per_kilo_" + p_last_element + "'   name='cost_per_kilo_" + p_last_element + "' class='input_4' type='text' value=''></td>"+
            "<td id='cost_per_bottle_" + p_last_element + "'></td>"+
            "<td id='cost_per_dose_" + p_last_element + "'></td>"+
            "<td id='cost_per_thousand_" + p_last_element + "'></td>"+
            "<td id='cost_per_ten_thousand_" + p_last_element + "'></td>"+
            "<td id='kilos_per_thousand_" + p_last_element + "'></td>"+
            "<td><input id='order_qty_" + p_last_element + "'   name='order_qty_" + p_last_element + "' class='input_5' type='text' value=''></td>"+
            "<td id='cost_per_order_" + p_last_element + "'></td>"+
         "</tr>"
    )
    $("#last_row_number").val($('#herb_ingredients tr').length);
    console.log($("#last_row_number").val());
// Hide Ingredients ID and Herb ID columns
    $('#herb_ingredients td:nth-child(2)').hide();
    $('#herb_ingredients th:nth-child(2)').hide();
    $('#herb_ingredients td:nth-child(3)').hide();
    $('#herb_ingredients th:nth-child(3)').hide();

    $("#herb_ingredients tr:last td input.input_3").bind("change", function(e){
        var grams_per_bottle = (($(this).val() * C_CONTAINER_MULTIPLIER) / C_CASE_MULTIPLIER);
        console.log("Container multiplier is: " + C_CONTAINER_MULTIPLIER);
        grams_per_bottle = parseFloat(Math.round(grams_per_bottle * 100) / 100).toFixed(2);
        $("#grams_per_bottle_" + p_last_element).text(grams_per_bottle);
        bottle_per_kilo =  C_CASE_MULTIPLIER / grams_per_bottle;
        bottle_per_kilo = parseFloat(Math.round(bottle_per_kilo * 100) / 100).toFixed(2);
        $("#bottle_per_kilo_" + p_last_element).text(bottle_per_kilo);

        // console.log(this);

    });
    $("#herb_ingredients tr:last td input.input_4").bind("change", function(e){
        cost_per_kilo = $(this).val();
        var cost_per_bottle = parseFloat(cost_per_kilo) / parseFloat(bottle_per_kilo);
        cost_per_bottle = parseFloat(cost_per_bottle.toFixed(7));
        $("#cost_per_bottle_" + p_last_element).text(cost_per_bottle);

        cost_per_dose = (cost_per_bottle / C_CONTAINER_MULTIPLIER);
        cost_per_dose = parseFloat(Math.round(cost_per_dose * 100) / 100).toFixed(2);
        $("#cost_per_dose_" + p_last_element).text(cost_per_dose);

        cost_per_thousand = (cost_per_bottle * C_CASE_MULTIPLIER);
        cost_per_thousand = parseFloat(Math.round(cost_per_thousand * 100) / 100).toFixed(2);
        $("#cost_per_thousand_" + p_last_element).text(cost_per_thousand);

        cost_per_ten_thousand = (cost_per_thousand * 10);
        cost_per_ten_thousand = parseFloat(Math.round(cost_per_ten_thousand * 100) / 100).toFixed(2);
        $("#cost_per_ten_thousand_" + p_last_element).text(cost_per_ten_thousand);

        kilos_per_thousand = (cost_per_thousand / $(this).val());
        kilos_per_thousand = parseFloat(Math.round(kilos_per_thousand * 100) / 100).toFixed(2);
        $("#kilos_per_thousand_" + p_last_element).text(kilos_per_thousand);

        // console.log(this);

    });
    $("#herb_ingredients tr:last td input.input_5").bind("change", function(e){
        kilos_to_order = $(this).val();
        cost_per_order = (kilos_to_order * cost_per_kilo);
        cost_per_order = parseFloat(Math.round(cost_per_order * 100) / 100).toFixed(2);
        $("#cost_per_order_" + p_last_element).text(cost_per_order);

        // console.log(this);

    });
}


// Start Formula List Section




//    var cost_per_order = number_format(($row->order_qty * $row->cost_per_kilo), 2, ".", ",");
//$("#herb_ingredients tr:last td input.input_3").bind("change", function(e){
//    alert("Whats up...");
//    var grams_per_bottle = (($(this).val() * C_CONTAINER_MULTIPLIER) / C_CASE_MULTIPLIER);
//    grams_per_bottle = parseFloat(Math.round(grams_per_bottle * 100) / 100).toFixed(2);
//    $("#grams_per_bottle_" + p_last_element).text(grams_per_bottle);
//    bottle_per_kilo =  C_CASE_MULTIPLIER / grams_per_bottle;
//    bottle_per_kilo = parseFloat(Math.round(bottle_per_kilo * 100) / 100).toFixed(2);
//    $("#bottle_per_kilo_" + p_last_element).text(bottle_per_kilo);
//
//    // console.log(this);
//
//});


//    $("#herb_ingredients td").click(function(e) {
//
//        var rowIndex = $(this).parent().parent().children().index($(this).parent());
//        var tdIndex = $(this).parent().children().index($(this));
//        alert('Row Number: ' + (rowIndex) + '\nColumn Number: ' + (tdIndex));
//
//    });

function Save(){
    var par = $(this).parent().parent(); //tr
    var tdName = par.children("td:nth-child(1)");
    var tdPhone = par.children("td:nth-child(2)");
    var tdEmail = par.children("td:nth-child(3)");
    var tdButtons = par.children("td:nth-child(4)");

    tdName.html(tdName.children("input[type=text]").val());
    tdPhone.html(tdPhone.children("input[type=text]").val());
    tdEmail.html(tdEmail.children("input[type=text]").val());
    tdButtons.html("<img src='images/delete.png' class='btnDelete'/><img src='images/pencil.png' class='btnEdit'/>");

    $(".btnEdit").bind("click", Edit);
    $(".btnDelete").bind("click", Delete);
};

function Edit(){
    var par = $(this).parent().parent(); //tr
    var tdName = par.children("td:nth-child(1)");
    var tdPhone = par.children("td:nth-child(2)");
    var tdEmail = par.children("td:nth-child(3)");
    var tdButtons = par.children("td:nth-child(4)");

    tdName.html("<input type='text' id='txtName' value='"+tdName.html()+"'/>");
    tdPhone.html("<input type='text' id='txtPhone' value='"+tdPhone.html()+"'/>");
    tdEmail.html("<input type='text' id='txtEmail' value='"+tdEmail.html()+"'/>");
    tdButtons.html("<img src='images/disk.png' class='btnSave'/>");

    $(".btnSave").bind("click", Save);
    $(".btnEdit").bind("click", Edit);
    $(".btnDelete").bind("click", Delete);
};

function Delete(){
    var par = $(this).parent().parent(); //tr
    par.remove();
};
$(function(){
    //Add, Save, Edit and Delete functions code
    $(".btnEdit").bind("click", Edit);
    $(".btnDelete").bind("click", Delete);
    $("#btnAdd").bind("click", Add);
});

// http://mrbool.com/how-to-add-edit-and-delete-rows-of-a-html-table-with-jquery/26721