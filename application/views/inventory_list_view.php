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

<div id="inventory_list_block" class="inventory_list_class">

    <table id="inventory_list_data" border="1" cellpadding="4" cellspacing="2" class="list_views">
        <tr><th>ID</th><th>Description</th><th>Qty</th></tr>
        <?php

        foreach($inventory_data as $inventory_row)
        {
            $curr_code = '<tr>
                    <td>' . $inventory_row[0] . '</td><td>' . $inventory_row[1] . '</td><td><div>' . $inventory_row[2] . '</div></td>
                  </tr>';
            echo $curr_code;
        }
        //        id="inv_mgmt_' . $curr_row . '"
        ?>

    </table>
</div>
