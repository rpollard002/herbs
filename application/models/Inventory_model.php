<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/7/15
 * Time: 10:43 PM
 */

class Inventory_model extends CI_Model{

    function __construct()
    {
        parent::__construct();

    }
    function loadInventoryList()
    {
        $data = array();
        $curr_row = 0;
        $sql_query = "  select
                        id
                        , description
                        , qty
                        from herb_management.herb
                     ";
        $query = $this->db->query($sql_query);
        $num_columns = $query->num_fields();
        $num_rows = $query->num_rows();
        foreach ($query->result() as $row)
        {
                array_push($data, array($row->id, $row->description, $row->qty));
        }

        return $data;

    }
    function saveHerbQuantity($p_herb_id, $p_qty)
    {
        $update_query = "UPDATE herb_management.herb
                             SET qty = " . $p_qty . "
                             WHERE  id = " . $p_herb_id;
        $this->db->query($update_query);
    }
} 