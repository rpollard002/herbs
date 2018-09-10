$(document).ready(function () {


    $('input:submit').addClass("button_enabled");
    $("#formula_qty").bind("change", function(e){
       calculateQty($(this).val());
    });

    function calculateQty(p_qty_needed)
    {
        // p_qty_needed = (number of bottles)
        // v_dose_multiplier = (number of doses per bottle)
        v_dose_multipler = 30;
        v_mg_kilogram = 1000000;
        // For 100 bottles * 30 doses = 3000 doses
        v_dose_total = parseFloat(p_qty_needed) * parseFloat(v_dose_multipler);
        $('input:submit').attr("disabled", false);
        v_negative_amount_found = false;
        v_curr_row = 0;
        $('#formula_inventory tr:not(:has(th))').each(function () {
            v_mg_per_dose = parseFloat($('td:nth-child(4)', this).text());
            v_qty_needed = ((v_dose_total * v_mg_per_dose) / v_mg_kilogram);
            v_qty_available = parseFloat($('td:nth-child(6)', this).text());
            parseFloat($('td:nth-child(5)', this).text(v_qty_needed));
            v_deficit = parseFloat((v_qty_available - v_qty_needed));
            if(v_deficit < 0)
            {
                $('td:nth-child(7)', this).addClass("negative_amount");
                v_negative_amount_found = true;

            } else {
                $('td:nth-child(7)', this).removeClass("negative_amount");
            }            // $('td:nth-child(7)', this).find('input').val(parseFloat(v_deficit));

            v_input = '<td><input id="qty_remaining_input_' + v_curr_row + '" name="qty_remaining_input_' + v_curr_row + '" type="hidden" size="10" value="' + v_deficit + '"></input></td>';
            $(this).append(v_input);
            parseFloat($('td:nth-child(7)', this).html(v_deficit));
            $('td:nth-child(7)', this).find('input').val(parseFloat(v_deficit));

            // console.log("Input is: " + $("#qty_remaining_input_" + v_curr_row).val() + " and input name is: " + "#qty_remaining_input_" + v_curr_row);
            // $("input[name='qty_remaining_input_" + v_curr_row + "']").val(parseFloat(v_deficit));
            v_curr_row++;
        });

        $('#formula_inventory td:nth-child(8)').hide();
        if(v_negative_amount_found)
        {
            $('input:submit').addClass("button_disabled");
            $('input:submit').removeClass("button_enabled");
            $('input:submit').attr("disabled", true);
        } else {
            $('input:submit').removeClass("button_disabled");
            $('input:submit').addClass("button_enabled");
        }
    }

});