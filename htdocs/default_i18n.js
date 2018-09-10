/**
 * Default theme functions
 */
$(document).ready(function() {
    $("#herb_ingredients td").click(function(e) {

        var rowIndex = $(this).parent().parent().children().index($(this).parent());
        var tdIndex = $(this).parent().children().index($(this));
        alert('Row Number: ' + (rowIndex) + '\nColumn Number: ' + (tdIndex));

        // alert($(this).text());
    });

//    $("#herb_table td").click(function(e) {
//
//        var cellText = $(this).text();
//        var rowIndex = $(this).parent().parent().children().index($(this).parent());
//        var cellID = $(this).find('td:first').text();
//        // var cellID = $(this).parent().firstChild().text());
//        // alert('Cell Text: ' + cellText);
//        // alert('Cell Text: ' + cellID);
//        var previousValue = '';
//    });

    $('#herb_table tbody tr').click( function (e) {
        herb_id = $(this).find('td').eq(0).text();
        herb_description = $(this).find('td').eq(2).text();
        // alert("Herb ID: " + herb_id + " Herb Description: " + herb_description);
        Add(herb_description, 1);
    });
    $('#herb_table tbody tr').hover(function() {
        alert($(this).find('td').eq(1).text());
    });
    $("#last_row_number").val($('#herb_ingredients tr').length - 1);

    $('#herb_table td:nth-child(1)').hide();
    $('#herb_table th:nth-child(1)').hide();
    $('#herb_table td:nth-child(2)').hide();
    $('#herb_table th:nth-child(2)').hide();
});
// $("#tableId").last().append("<tr><td>New row</td></tr>");
// "<td><img src='images/disk.png' class='btnSave'><img src='images/delete.png' class='btnDelete'/></td>"+
// $(".btnSave").bind("click", Save);
// $(".btnDelete").bind("click", Delete);
function Add(p_herb){
    var p_last_element = $('#herb_ingredients tr').length - 1;
    $("#last_row_number").val(p_last_element);

    $("#herb_ingredients tbody").append(
        "<tr name='row_" + p_last_element + "'>"+
            "<td class='input_1'><img id='delete_row_" + p_last_element + "' src='/assets/button-delete_icon.png'></td>"+
            "<td>" + p_herb + "</td>"+
            "<td><input id='mg_per_dose_" + p_last_element + "' class='input_3' type='text' value=''></td>"+
            "<td id='grams_per_bottle_" + p_last_element + "'></td>"+
            "<td id='bottle_per_kilo_" + p_last_element + "'></td>"+
            "<td><input id='cost_per_kilo_" + p_last_element + "'  class='input_6' type='text' value=''></td>"+
            "<td id='cost_per_bottle_" + p_last_element + "'></td>"+
            "<td id='cost_per_dose_" + p_last_element + "'></td>"+
            "<td id='cost_per_thousand_" + p_last_element + "'></td>"+
            "<td id='cost_per_ten_thousand_" + p_last_element + "'></td>"+
            "<td id='kilos_per_thousand_" + p_last_element + "'></td>"+
            "<td><input id='kilos_to_order_" + p_last_element + "'  class='input_12' type='text' value=''></td>"+
            "<td id='cost_per_order_" + p_last_element + "'></td>"+
         "</tr>"
    );

//    $('#add').click(function(e) {
//
//        $('#table-name').append('<tr><td>Ray</td><td>Smith</td></tr>');
//
//    });
//
//
//    $('#table-name').on('click', 'tr', function() {
//
//        alert('clicked!');
//
//    });
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
//    var cost_per_order = number_format(($row->order_qty * $row->cost_per_kilo), 2, ".", ",");

    $("#herb_ingredients tr:last td input.input_3").bind("change", function(e){

        var grams_per_bottle = (($(this).val() * C_CONTAINER_MULTIPLIER) / C_CASE_MULTIPLIER);
        grams_per_bottle = parseFloat(Math.round(grams_per_bottle * 100) / 100).toFixed(2);
        $("#grams_per_bottle_" + p_last_element).text(grams_per_bottle);
        bottle_per_kilo =  C_CASE_MULTIPLIER / grams_per_bottle;
        bottle_per_kilo = parseFloat(Math.round(bottle_per_kilo * 100) / 100).toFixed(2);
        $("#bottle_per_kilo_" + p_last_element).text(bottle_per_kilo);

        // console.log(this);

    });
    $("#herb_ingredients tr:last td input.input_6").bind("change", function(e){
        cost_per_kilo = $(this).val();
        var cost_per_bottle = parseFloat(cost_per_kilo) / parseFloat(bottle_per_kilo);
        alert("cost_per_kilo: " + cost_per_kilo + " bottle_per_kilo: " + bottle_per_kilo + " Result is: " + cost_per_bottle);
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
    $("#herb_ingredients tr:last td input.input_12").bind("change", function(e){
        kilos_to_order = $(this).val();
        cost_per_order = (kilos_to_order * cost_per_kilo);
        cost_per_order = parseFloat(Math.round(cost_per_order * 100) / 100).toFixed(2);
        $("#cost_per_order_" + p_last_element).text(cost_per_order);

        // console.log(this);

    });
//    $("#herb_ingredients td").click(function(e) {
//
//        var rowIndex = $(this).parent().parent().children().index($(this).parent());
//        var tdIndex = $(this).parent().children().index($(this));
//        alert('Row Number: ' + (rowIndex) + '\nColumn Number: ' + (tdIndex));
//
//    });
};

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