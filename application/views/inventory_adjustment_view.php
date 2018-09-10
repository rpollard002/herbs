<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// In case the captcha table gets lost again...
//CREATE TABLE captcha (
//    captcha_id bigint(13) unsigned NOT NULL auto_increment,
// captcha_time int(10) unsigned NOT NULL,
// ip_address varchar(16) default '0' NOT NULL,
// word varchar(20) NOT NULL,
// PRIMARY KEY `captcha_id` (`captcha_id`),
// KEY `word` (`word`)
//);
?>

<?php
// Include jQuery UI library...
echo "<script type='text/javascript' src='" . base_url() . "htdocs/js/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='" . base_url() . "htdocs/themes/default/js/stickyfloat.js'></script>";
?>

<h1>Inventory Project/Adjust</h1>

<?php
$form_attributes = array("id" => "formula_inventory_adjustment");
echo form_open('formula', $form_attributes);
?>
<div id="formula" class="data_blocks">
    <?php
    $formula_field = '';
    echo "<table id='formula_data'>";
    // The first index "1" is the Description field
    foreach($formula_data as $value)
    {
        if(isset($value[0]))
        {
            $value[1]['value'] = $parameters[$value[1]['id']];
        }
        $formula_field .= '<tr><td style="font-weight:bold; padding: 2px;">' . $value[0] . '</td><td style="font-weight:bold; padding: 2px;">' . form_input($value[1]) . '</td></tr>';
    }
    echo $formula_field;
    echo "</table>";
    ?>
</div>
<div id="button_bar_id" class="button_bar">
<?php
$data = array(
    'name' => 'save_inventory',
    'id' => 'save_inventory',
    'value' => 'Save Formula Production',
    'type' => 'button',
    'content' => 'Save Formula Production'
);
echo form_submit('save_inventory', 'Save Formula Production');
echo '<LABEL for="formula_qty">Formula Quantity</LABEL>';
$name = array(
    'name'        => 'formula_qty',
    'id'          => 'formula_qty',
    'size'        => '20',
);
echo form_input($name);
?>
</div>

<div id="inventory_wrapper" class="inventory_wrapper_class">

        <?php

        $curr_row = 0;
        $data = '<table id="formula_inventory" border="1" cellpadding="4" cellspacing="2"  class="list_views">';

        $data .= "<tr id='ingredient_header'>";
        $data .= "<th>Formula/Herb ID</th>";
        $data .= "<th>Herb ID</th>";
        $data .= "<th>Herb</th>";
        $data .= "<th>Mg Per Dose</th>";
        $data .= "<th>Qty Needed</th>";
        $data .= "<th>Qty Available</th>";
        $data .= "<th>Qty Remaining</th>";
        $data .= "</tr>";

        foreach($table_data as $table_row)
        {
            $data .= "<tr id='ingredients_row_" . $curr_row . "'>";

            $data .= "<td id='formula_herb_id_" . $curr_row . "' class='ingredient_herb_class' type='text'>" . $table_row[0] . "</td>";
            $data .= '<td id="herb_id_' . $curr_row . '" class="ingredient_herb_class" style="width: 30px;"><input id="herb_id_input_' . $curr_row . '" name="herb_id_input_' . $curr_row . '" type="hidden" size="5" value="' . $table_row[1] . '">' . $table_row[1] . '</td>';
            $data .= "<td id='herb_description_" . $curr_row . "' class='ingredient_herb_class'>" . $table_row[2] . "</td>";
            $data .= "<td id='mg_per_dose_" . $curr_row . "' class='ingredient_herb_class'>" . $table_row[4] . "</td>";
            $data .= "<td id='qty_needed_" . $curr_row . "' class='ingredient_herb_class'></td>";
            $data .= "<td id='qty_" . $curr_row . "' class='ingredient_herb_class'>" . $table_row[3] . "</td>";
            $data .= '<td id="qty_remaining_' . $curr_row . '" class="ingredient_herb_class" style="width: 104px;"><input id="qty_remaining_input_' . $curr_row . '" name="qty_remaining_input_' . $curr_row . '" type="hidden" size="10" value=""></td>';
            $data .= "</tr>";

            $curr_row++;
        }
        $data .= "</table>";
        echo $data;
        echo "Current row is: " . $curr_row;
        echo '<input id="number_rows" name="number_rows" value="' . $curr_row . '" type="hidden" />';

        ?>

</div>
<?php
echo form_close();
?>
