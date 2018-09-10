<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/5/15
 * Time: 9:37 PM
 */

class Inventory_audit_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    function writeAudit($p_herb_id, $p_source, $p_qty)
    {

        $auditParams = array(NULL, $p_herb_id, $p_source, $p_qty);
        $insert = "INSERT INTO herb_management.inventory_adjustments
                   (id, herb_id, inventory_adjustment_source_id, qty)
                   values(?, ?, ?, ?)";
        $insert_handle = $this->db->query($insert, $auditParams);

    }
}