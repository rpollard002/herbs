<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
// Include jQuery UI library...
echo "<script type='text/javascript' src='" . base_url() . "htdocs/js/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='" . base_url() . "htdocs/themes/default/js/stickyfloat.js'></script>";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
?>

<h1>Inventory</h1>
<?php
$form_attributes = array("id" => "formula_inventory_adjustment");
echo form_open('receive', $form_attributes);
?>
<div id="button_bar_id" class="button_bar">
    <?php
    $data = array(
        'name' => 'save_inventory',
        'id' => 'save_inventory',
        'value' => 'Save Formula Production',
        'type' => 'button',
        'content' => 'Save Formula Production'
    );
    echo form_submit('save_ir', 'Save Inventory Received');
    ?>
</div>
<div id="inventory_list_block" class="inventory_list_class">

    <table id="receive_list_data" border="1" cellpadding="4" cellspacing="2" class="list_views">
        <tr><th>id_input</th></th><th>ID</th><th>Description</th><th>Qty</th><th>Qty Received</th></tr>
        <?php
        $curr_row = 1;
        foreach($inventory_data as $inventory_row)
        {
            $curr_code = '<tr>
                    <td><input name="herb_id_' . $curr_row . '" value="' . $inventory_row[0] . '" /></td><td>' . $inventory_row[0] . '</td><td>' . $inventory_row[1] . '</td><td><div>' . $inventory_row[2] . '</div></td><td class="qty_received"><div><input id="qty_received_' . $curr_row . '" name="qty_received_' . $curr_row . '" class="qty_received_input" /></div></td>
                  </tr>';
            echo $curr_code;
            $curr_row++;
        }
        //        id="inv_mgmt_' . $curr_row . '"
        echo "<input id='total_rows' type='hidden' name='total_rows' value='" . $curr_row . "' />";
        ?>

    </table>
</div>

<?php
echo form_close();
?>