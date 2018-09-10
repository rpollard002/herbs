<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 6/16/15
 * Time: 1:31 PM
 */

class Formula_model extends CI_Model{
    public $C_CASE_MULTIPLIER = 1000;
    public $C_CONTAINER_MULTIPLIER = 30;
    private $CI;

    function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        $this->CI->load->library('Inventory_audit');
    }

    function calculateSets()
    {
        $parameters = $this->parameters;
    }
    function getParameterData()
    {
        $param_data = array();
        array_push($param_data, array('', array(
                'name'        => 'formula_id',
                'id'          => 'formula_id',
                'type'        => 'hidden',
                'value'       => '',
                'maxlength'   => '5',
                'size'        => '5'))
        );
        array_push($param_data, array('Formula Name', array(
            'name'        => 'formula_name',
            'id'          => 'formula_name',
            'value'       => '',
            'maxlength'   => '100',
            'size'        => '50'))
        );
        array_push($param_data, array('Formula Description', array(
            'name'        => 'formula_description',
            'id'          => 'formula_description',
            'value'       => '',
            'maxlength'   => '500',
            'size'        => '100'))
        );
        return $param_data;
    }
    function getHerbIngredients($herb_id)
    {

        $curr_row = 0;
        $data = '<table id="herb_ingredients" border="1" cellpadding="4" cellspacing="2" class="herb_formula_class">';

        $data .= "<tr id='ingredient_header'>";
        $data .= "<th></th>";
        $data .= "<th>Formula/Herb ID</th>";
        $data .= "<th>Herb ID</th>";
        $data .= "<th>Herb</th>";
        $data .= "<th class='mg_per_dose'>Mg/Dose</th>";
        $data .= "<th>Grams/Bottle</th>";
        $data .= "<th>Bottles/Kilo</th>";
        $data .= "<th>Cost/Kilo</th>";
        $data .= "<th>Cost/Bottle</th>";
        $data .= "<th>Cost/Dose</th>";
        $data .= "<th>Cost/1000 Bottles</th>";
        $data .= "<th>Cost/10,000 Bottles</th>";
        $data .= "<th>Kilos/1000</th>";
        $data .= "<th>Kilos To Order</th>";
        $data .= "<th>Cost/Order</th>";
        $data .= "</tr>";

        if($herb_id != '')
        {
            $sql_query = "SELECT herb_management.fh.id as formula_herb_id
                            , herb_management.h.id as herb_id
                            , h.description as herb_description
                            , fh.mg_per_dose
                            , fh.cost_per_kilo
                            , fh.order_qty
                            FROM herb_management.formula f
                            join herb_management.formula_herb fh on f.id = fh.formula_id
                            join herb_management.herb h on h.id = fh.herb_id
                            WHERE f.id = ?";
            $query = $this->db->query($sql_query, array($herb_id));
            $num_rows = $query->num_rows();
            if($num_rows > 0)
            {

            // Brain Formula / Ingredient	Mg/Dose	Grams/Bottle	Bottles/Kilo	Cost/Kilo	Cost/Bottle	Cost/Dose	Cost/1000 Bottles	Cost/10,000	kilos/1000	Kilos to order	Cost/order

            foreach ($query->result() as $row)
            {

                $grams_per_bottle = (($row->mg_per_dose * $this->C_CONTAINER_MULTIPLIER) / $this->C_CASE_MULTIPLIER);
                $bottle_per_kilo = number_format(($this->C_CASE_MULTIPLIER/$grams_per_bottle), 2, ".", ",");
                $cost_per_bottle = number_format(($row->cost_per_kilo/$bottle_per_kilo), 7, ".", ",");
                $cost_per_dose = number_format(($cost_per_bottle/$this->C_CONTAINER_MULTIPLIER), 2, ".", ",");
                $cost_per_thousand = number_format(($cost_per_bottle * $this->C_CASE_MULTIPLIER), 2, ".", ",");
                $cost_per_ten_thousand = number_format(($cost_per_thousand * 10), 2, ".", ",");
                $kilos_per_thousand = number_format(($cost_per_thousand/$row->cost_per_kilo), 2, ".", ",");
                $cost_per_order = number_format(($row->order_qty * $row->cost_per_kilo), 2, ".", ",");

                if($curr_row == 0)
                {

                    //  array_push($data, array('', 'Herb', 'Mg/Dose', 'Grams/Bottle', 'Bottles/Kilo', 'Cost/Kilo', 'Cost/Bottle', 'Cost/Dose', 'Cost/1000 Bottles', 'Cost/10,000 Bottles', 'Kilos/1000', 'Kilos To Order', 'Cost/Order'));

                    $curr_row++;
                    $data .= "<tr id='ingredients_row_" . $curr_row . "'>";
                    // $minus_icon = '<img id="delete_row_' . $curr_row . '" src="/assets/button-delete_icon.png" />';
                    // $data .= "<tr id='ingredients_row_" . $curr_row . "'>";

                    $data .= '<td><img id="delete_row_' . $curr_row . '" src="/assets/button-delete_icon.png" /></td>';
                    $data .= "<td><input id='formula_herb_id_" . $curr_row . "' class='input_1' type='text' name='formula_herb_id_" . $curr_row . "' value='" . $row->formula_herb_id . "'></td>";
                    $data .= "<td><input id='herb_id_" . $curr_row . "' class='input_2' type='text' name='herb_id_" . $curr_row . "' value='" . $row->herb_id . "'></td>";
                    $data .= "<td class='ingredient_herb_class'>$row->herb_description</td>";
                    $data .= "<td><input id='mg_per_dose_" . $curr_row . "' class='input_3' type='text' name='mg_per_dose_" . $curr_row . "' value='" . $row->mg_per_dose . "'></td>";
                    $data .= "<td id='grams_per_bottle_" . $curr_row . "'>" . $grams_per_bottle . "</td>";
                    $data .= "<td id='bottle_per_kilo_" . $curr_row . "'>" . $bottle_per_kilo . "</td>";
                    $data .= "<td><input id='cost_per_kilo_" . $curr_row . "' class='input_4' type='text' name='cost_per_kilo_" . $curr_row . "' value='" . $row->cost_per_kilo . "'></td>";
                    $data .= "<td id='cost_per_bottle_" . $curr_row . "'>" . $cost_per_bottle . "</td>";
                    $data .= "<td id='cost_per_dose_" . $curr_row . "'>" . $cost_per_dose . "</td>";
                    $data .= "<td id='cost_per_thousand_" . $curr_row . "'>" . $cost_per_thousand . "</td>";
                    $data .= "<td id='cost_per_ten_thousand_" . $curr_row . "'>" . $cost_per_ten_thousand ."</td>";
                    $data .= "<td id='kilos_per_thousand_" . $curr_row . "'>" . $kilos_per_thousand . "</td>";
                    $data .= "<td><input id='order_qty_" . $curr_row . "' class='input_5' type='text' name='order_qty_" . $curr_row . "' value='" . $row->order_qty . "'></td>";
                    $data .= "<td id='cost_per_order_" . $curr_row . "'>" . $cost_per_order . "</td>";
                    $data .= "</tr>";
                } else {
                    $data .= "<tr id='ingredients_row_" . $curr_row . "'>";
                    $data .= '<td><img id="delete_row_' . $curr_row . '" src="/assets/button-delete_icon.png" /></td>';
                    $data .= "<td><input id='formula_herb_id_" . $curr_row . "' class='input_1' type='text' name='formula_herb_id_" . $curr_row . "' value='" . $row->formula_herb_id . "'></td>";
                    $data .= "<td><input id='herb_id_" . $curr_row . "' class='input_2' type='text' name='herb_id_" . $curr_row . "' value='" . $row->herb_id . "'></td>";
                    $data .= "<td class='ingredient_herb_class'>$row->herb_description</td>";
                    $data .= "<td><input id='mg_per_dose_" . $curr_row . "' class='input_3' type='text' name='mg_per_dose_" . $curr_row . "' value='" . $row->mg_per_dose . "'></td>";
                    $data .= "<td id='grams_per_bottle_" . $curr_row . "'>" . $grams_per_bottle . "</td>";
                    $data .= "<td id='bottle_per_kilo_" . $curr_row . "'>" . $bottle_per_kilo . "</td>";
                    $data .= "<td><input id='cost_per_kilo_" . $curr_row . "' class='input_4' type='text' name='cost_per_kilo_" . $curr_row . "' value='" . $row->cost_per_kilo . "'></td>";
                    $data .= "<td id='cost_per_bottle_" . $curr_row . "'>" . $cost_per_bottle . "</td>";
                    $data .= "<td id='cost_per_dose_" . $curr_row . "'>" . $cost_per_dose . "</td>";
                    $data .= "<td id='cost_per_thousand_" . $curr_row . "'>" . $cost_per_thousand . "</td>";
                    $data .= "<td id='cost_per_ten_thousand_" . $curr_row . "'>" . $cost_per_ten_thousand ."</td>";
                    $data .= "<td id='kilos_per_thousand_" . $curr_row . "'>" . $kilos_per_thousand . "</td>";
                    $data .= "<td><input id='order_qty_" . $curr_row . "' class='input_5' type='text' name='order_qty_" . $curr_row . "' value='" . $row->order_qty . "'></td>";
                    $data .= "<td id='cost_per_order_" . $curr_row . "'>" . $cost_per_order . "</td>";
                    $data .= "</tr>";
                }
                $curr_row++;
                }

            }
        }
        $data .= "</table>";
        return $data;

    }
    function getHerbSelectList()
    {
        $data = array();
        $curr_row = 0;
        $sql_query = "  select
                        id
                        , description
                        , benefits
                        from herb
                     ";
        $query = $this->db->query($sql_query);
        $num_columns = $query->num_fields();
        $num_rows = $query->num_rows();
        foreach ($query->result() as $row)
        {
            {
                $balloon_code = "<div id='" . $curr_row . "'>" . $row->benefits . "</div>";
                $info_icon = '<div id="info_' . $curr_row . '"><img src="/assets/information-icon.png" /></div> ';
                $description = "<div id='herb_description_" . $curr_row . "'>" . $row->description . "</div>";
                if($curr_row == 0)
                {
                    array_push($data, array('ID', 'Benefits', '', 'Herb'));
                    array_push($data, array($row->id, $balloon_code, $info_icon, $description));
                } else {
                    array_push($data, array($row->id, $balloon_code, $info_icon, $description));
                }
            }

            $curr_row++;
        }

        return $data;
    }
    function loadFormulaList()
    {
        $data = array();
        $curr_row = 0;
        $sql_query = "  select
                        id
                        , name
                        , description
                        from herb_management.formula
                     ";
        $query = $this->db->query($sql_query);
        $num_columns = $query->num_fields();
        $num_rows = $query->num_rows();
        foreach ($query->result() as $row)
        {
            array_push($data, array($row->id, $row->name, $row->description));
        }

        return $data;

    }
    function loadFormula($p_id)
    {

        $sql_query = "  select
                        id
                        , name
                        , description
                        from herb_management.formula
                        where id = " . $p_id . "
                     ";
        $query = $this->db->query($sql_query);

        return $query->row();

    }
    function saveIngredients()
    {
        // Check to see if formula data exists...
        $f_id = $this->input->post('formula_id');
        $f_name = $this->input->post('formula_name');
        $f_description = $this->input->post('formula_description');
        $v_number_ingredients = $this->input->post('last_row_number');

        if($f_id == "")
        {
            $f_id = "NULL";
            $formula_sql_statement = "INSERT INTO herb_management.formula (id, name, description) values(" . $f_id . ", '" . $f_name . "', '" . $f_description . "')";
        } else {
            $formula_sql_statement = "UPDATE herb_management.formula  SET name = '" . $f_name . "', description = '" . $f_description . "' WHERE id = " . $f_id;
        }
        $this->db->query($formula_sql_statement);
        if($f_id == "NULL")
        {
            $f_id = $this->db->insert_id();
        }

        $sql_values = "";
        $values = "";
        $sql_statement_list = array();
        for($curr_row = 1; $curr_row <= $v_number_ingredients; $curr_row++)
        {

            $v_ingredient_id_index = 'formula_herb_id_' . $curr_row;
            if(isSet($_POST[$v_ingredient_id_index]))
            {
                $values = "";
                $ingredient_id = $this->input->post($v_ingredient_id_index);
                $herb_id = $this->input->post('herb_id_' . $curr_row);
                $mg_per_dose = $this->input->post('mg_per_dose_' . $curr_row);
                $cost_per_kilo = $this->input->post('cost_per_kilo_' . $curr_row);
                $order_qty = $this->input->post('order_qty_' . $curr_row);

                //  The ingredient_id value will determine the type of SQL statement to build
                if(strlen($ingredient_id) == 0)
                {
                    $ingredient_id = "NULL";
                    $mode = "Add";

                } else {
                    $mode = "Modify";
                }

                if($mode == "Add")
                {
                    $fields = "(id, formula_id, herb_id, mg_per_dose, cost_per_kilo, order_qty)";
                    $values = "values (" . $ingredient_id . ", " . $f_id . ", " . $herb_id . ", " . $mg_per_dose . ", " . $cost_per_kilo . ", " . $order_qty . ")";

                    $sql_values = "INSERT INTO herb_management.formula_herb " . $fields . " " . $values;
                    $sql_statement_list[] = $sql_values;
                } elseif($mode == "Modify")
                {
                    $values = "herb_id = " . $herb_id . ", mg_per_dose = " . $mg_per_dose . ", cost_per_kilo = " . $cost_per_kilo . ", order_qty = " . $order_qty;
                    $sql_values = "UPDATE herb_management.formula_herb SET " . $values . " WHERE id = " . $ingredient_id;
                    $sql_statement_list[] = $sql_values;
                }
            }
        }
        if($this->input->post('deleted_ingredients') != '')
        {
            $sql_values = "DELETE FROM herb_management.formula_herb WHERE id in (" . $this->input->post('deleted_ingredients') . ")";
            $sql_statement_list[] = $sql_values;
        }
        if(count($sql_statement_list) > 0)
        {
            foreach($sql_statement_list as $statement)
            {
                $this->db->query($statement);
            }
        }
    }
    function getInventoryList($herb_id)
    {
        if($herb_id != '')
        {
            $sql_query = "SELECT herb_management.fh.id as formula_herb_id
                            , herb_management.h.id as herb_id
                            , h.description as herb_description
                            , h.qty as qty
                            , fh.mg_per_dose
                            FROM herb_management.formula f
                            join herb_management.formula_herb fh on f.id = fh.formula_id
                            join herb_management.herb h on h.id = fh.herb_id
                            WHERE f.id = ?";
            $query = $this->db->query($sql_query, array($herb_id));
            $num_rows = $query->num_rows();
            $a_data = array();
            if($num_rows > 0)
            {
                foreach ($query->result() as $row)
                {
                    array_push($a_data, array($row->formula_herb_id, $row->herb_id, $row->herb_description, $row->qty, $row->mg_per_dose));
                }

            }
        }
        return $a_data;
    }
    public function createFormulaBatch()
    {
        $v_formula_id = $this->input->post('formula_id');
        $v_formula_name = $this->input->post('formula_name');
        // $v_batch_string = $this->createBatchString($v_formula_name);
        $v_batch_string = strtoupper(substr( md5(rand()), 0, 10));
        // $v_number_string = printf( "%010d", $v_formula_id );
        return $v_batch_string;

    }
    public function createBatchString($p_formula_name)
    {
        preg_match_all('/[a-zA-Z]+[\w]*/', $p_formula_name, $a_strings);
        return implode('', $a_strings[0]);
    }
    function saveInventoryAdjustment()
    {
        $formula_id = $this->input->post('formula_id');
        $formula_qty = $this->input->post('formula_qty');
        $v_number_rows = $this->input->post('number_rows');
        for($curr_row = 0; $curr_row < $v_number_rows; $curr_row++)
        {
            $v_herb_id = $this->input->post("herb_id_input_" . $curr_row);
            $v_qty = $this->input->post("qty_remaining_input_" . $curr_row);


            $sql = "SELECT qty FROM herb_management.herb
                WHERE  id = " . $v_herb_id;
            $query = $this->db->query($sql);
            $v_orig_qty = $query->row()->qty;
            $v_diff_qty = $v_orig_qty - $v_qty;

            $update_query = "UPDATE herb_management.herb
                             SET qty = " . $v_qty . "
                             WHERE  id = " . $v_herb_id;
            $this->db->query($update_query);

            $this->CI->inventory_audit->updateAudit($v_herb_id, 1, $v_diff_qty);

        }
        // Save the Formula audit here
        $batch_id = $this->createFormulaBatch();
        $batch_sql = "INSERT INTO herb_management.order_fullfillment
                          (id, formula_id, batch_id, qty)
                          values(NULL, " . $formula_id . ", '" . $batch_id . "', " . $formula_qty . ")";
        $this->db->query($batch_sql);


    }
}