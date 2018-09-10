<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$base_url = base_url();
?>
    <script type="text/javascript" src="<?php echo $base_url; ?>js/tinymce/tinymce.min.js"></script>

    <script type="text/javascript">

        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontselect fontsizeselect",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt"
        });
    </script>

<h1>Herb Define</h1>
<?php
$herb_attributes = array("id" => "herb_data", "action" => "herb/saveHerb");
?>
<div id="herb" class="data_blocks">


    <?php
    echo form_open('herb', $herb_attributes);
    echo '<div id="button_bar_id" class="button_bar">';
    echo form_submit('save_herb', 'Save Herb');
    echo '</div>';
    ?>
    <?php
    $id = array(
        'name'        => 'id',
        'id'          => 'id',
        'value'       => $herb_data['id'],
        'size'        => '5',
        'style'       => 'disabled: disabled'
    );
    $name = array(
        'name'        => 'description',
        'id'          => 'description',
        'value'       => $herb_data['description'],
        'size'        => '100',
    );
    $benefits = array(
        'name'        => 'benefits',
        'id'          => 'benefits',
        'value'       => $herb_data['benefits'],
        'class'       => 'tinymce',
        'rows'        => '20',
        'cols'        => '150'
    );

    $upload = array(
        'name'        => 'image',
        'id'          => 'image',
        'size'        => '20',
    );

    ?>

    <table id="herb_input_data" class="input_tables">
        <tr>
            <td>ID</td><td><?php echo form_input($id); ?></td>
        </tr>
        <tr>
            <td>Herb Picture</td><td><?php echo form_upload($upload); ?></td>
        </tr>
        <tr>
            <td>Name</td><td><?php echo form_input($name); ?></td>
        </tr>
        <tr>
            <td>Benefits</td><td><?php echo form_textarea($benefits); ?></td>
        </tr>

    </table>

    <?php
    echo form_close();
    ?>

</div>

