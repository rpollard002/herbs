<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Herb Inventory</h1>

<div id="button_bar_id" class="button_bar">
    <?php
    $form_attributes = array("id" => "inventory_herb");
    echo form_open('inventory', $form_attributes);
    $attributes = array(
        'name' => 'save_inventory',
        'id' => 'save_inventory',
        'value' => 'true',
        'type' => 'button',
        'content' => 'Save Inventory Item'
    );
    echo form_button($attributes);
    ?>
</div>
    <?php
$herb_attributes = array("id" => "herb_inventory_data");
?>
<div id="herb_inventory" class="input_tables">

    <?php
    $id = array(
        'name'        => 'id',
        'id'          => 'id',
        'value'       => $inventory_data['id'],
        'size'        => '5',
        'style'       => 'disabled: disabled'
    );
    $description = array(
        'name'        => 'description',
        'id'          => 'description',
        'value'       => $inventory_data['description'],
        'size'        => '100',
    );
    $qty = array(
        'name'        => 'qty',
        'id'          => 'qty',
        'value'       => $inventory_data['qty'],
        'size'        => '10'
    );
    $old_qty = array(
        'name'        => 'old_qty',
        'id'          => 'old_qty',
        'type'        => 'hidden',
        'value'       => $inventory_data['qty'],
        'size'        => '10'
    );


    ?>

    <table id="herb_inventory_input_data" class="input_tables">
        <tr>
            <td>ID</td><td><?php echo form_input($id); ?></td>
        </tr>
        <tr>
            <td>Description</td><td><?php echo form_input($description); ?></td>
        </tr>
        <tr>
            <td>Quantity</td><td><?php echo form_input($qty); ?></td>
        </tr>

    </table>
    <?php
    echo form_input($old_qty);
    echo form_close();
    ?>
    <div id="inventory_change_history">
        <?php
            if(count($change_history) > 0)
            {
                $v_row = "<table class='list_views'>";
                $v_row .= "<th>Date</th><th>Qty</th><th>Source</th>";
                foreach($change_history as $a_row)
                {
                    $v_row .= "<tr><td>" . $a_row[0] . "</td><td>" . $a_row[1] . "</td><td>" . $a_row[2] . "</td></tr>";
                }
                echo $v_row;

            } else {
                echo "No Quantity Change History";
            }
        ?>
    </div>

</div>

