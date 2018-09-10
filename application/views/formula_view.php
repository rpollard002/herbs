<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
// Include jQuery UI library...
echo "<script type='text/javascript' src='" . base_url() . "htdocs/js/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='" . base_url() . "htdocs/themes/default/js/stickyfloat.js'></script>";
?>

<h1>Formula Define</h1>
<?php
$form_attributes = array("id" => "formula_data");
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
    <div id="button_bar_id" class="button_bar">
    <?php
    echo form_submit('save_formula', 'Save Formula');
    ?>
    </div>
</div>
<div id="herb_selector">
    <div id="herb_block" class="herb_list">
        <?php
        echo $herb_data;
        ?>
    </div>
    <div id="herb_detail_info" data-close-btn="right">
        <div id="herb_detail_headings">
            <div class="herb_name_info_heading">Family Name</div>
            <div class="herb_name_info_heading">Common Names</div>
            <div class="herb_name_info_heading">Benefits</div>
        </div>
        <div id="herb_detail_data">
            <div id="herb_name_info"></div>
            <div id="herb_name_common_names"></div>
            <div id="herb_name_benefits"></div>
        </div>
    </div>
    <div id="detail" class="data_blocks">
        <?php
        // $ingredient_form_attributes = array("id" => "ingredient_data");
        // echo form_open('quote', $ingredient_form_attributes);
        echo $table_data;
        echo "<input id='last_row_number' name='last_row_number' type='hidden' value=''>";
        echo "<input id='selected_herbs' name='selected_herbs' type='hidden' value=''>";
        echo "<input id='deleted_ingredients' name='deleted_ingredients' type='hidden' value=''>";

        echo form_close();
        ?>
    </div>
</div>