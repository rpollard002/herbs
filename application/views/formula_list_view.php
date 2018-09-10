<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
// Include jQuery UI library...
echo "<script type='text/javascript' src='" . base_url() . "htdocs/js/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='" . base_url() . "htdocs/themes/default/js/stickyfloat.js'></script>";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
?>

<h1>Formula</h1>

<div id="formula_block" class="herb_formula_class">
    <div id="button_bar_id" class="button_bar">
    <?php
    $data = array(
        'name' => 'add_formula',
        'id' => 'add_formula',
        'value' => 'true',
        'type' => 'button',
        'content' => 'Add Formula'
    );
    echo form_button($data);
    ?>
    </div>

    <table id="formula_list_data" border="1" cellpadding="4" cellspacing="2" class="list_views">
        <tr><th>ID</th><th>Actions</th></th><th>Name</th><th>Description</th></tr>
        <?php
        $curr_row = 0;
        $icon_inv_mgmt = '<img class="mgmt" src="/assets/inventory_maintenance_24.png" />';
        $icon_inv_prod = '<img class="prod" src="/assets/packing_24.png" />';
        foreach($formula_data as $formula_row)
        {
            $curr_code = '<tr>
                    <td>' . $formula_row[0] . '</td><td>' . $icon_inv_mgmt . $icon_inv_prod . '</td><td>' . $formula_row[1] . '</td><td><div>' . $formula_row[2] . '</div></td>
                  </tr>';
            echo $curr_code;
            $curr_row++;
        }
//        id="inv_mgmt_' . $curr_row . '"
        ?>

    </table>
</div>
