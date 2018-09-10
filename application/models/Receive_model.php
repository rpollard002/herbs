<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/7/15
 * Time: 10:43 PM
 */

class Receive_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->CI =& get_instance();
        $this->load->library('Inventory_audit');

    }
    function loadReceiveList()
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

    function saveHerbsReceived($a_herb_quantities, $p_total_rows)
    {
        $update_qty_sql = "";
        for($curr_row = 1; $curr_row < $p_total_rows; $curr_row++)
        {
            $herb_index = 'herb_id_' . $curr_row;
            $received_qty_index = 'qty_received_' . $curr_row;
            $herb_id = $a_herb_quantities[$herb_index];
            $qty_received = $a_herb_quantities[$received_qty_index];
            if($qty_received > 0)
            {
                $update_qty_sql = "UPDATE herb_management.herb
                                       SET  qty = qty + " . $qty_received . "
                                       WHERE id = " . $herb_id . ";"
                ;

                $this->db->query($update_qty_sql);

                $this->inventory_audit->updateAudit($herb_id, 3, $qty_received);
            }
        }
    }
} 