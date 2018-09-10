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

<h1>Herb List</h1>

<div id="button_bar_id" class="button_bar">
<?php
$data = array(
    'name' => 'add_herb',
    'id' => 'add_herb',
    'value' => 'true',
    'type' => 'button',
    'content' => 'Add Herb'
);
echo form_button($data);
?>
</div>

<div id="herb_list_wrapper" class="herb_formula_class">

    <table id="herb_list_data" border="1" cellpadding="4" cellspacing="2" class="list_views">
    <tr><th>ID</th><th>Description</th><th>Benefits</th></tr>
    <?php
        foreach($herb_data as $herb_row)
        {
            echo '<tr>
                    <td>' . $herb_row[0] . '</td><td>' . $herb_row[1] . '</td><td><div class="herb_benefits_height">' . $herb_row[2] . '</div></td>
                  </tr>';
        }
    ?>

    </table>
</div>
