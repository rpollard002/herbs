<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/5/15
 * Time: 9:29 PM
 */

class Inventory_audit {

    protected $CI;

    function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->model('Inventory_audit_model');

    }

    public function updateAudit($p_herb_id, $p_source, $p_qty)
    {
        $this->CI->Inventory_audit_model->writeAudit($p_herb_id, $p_source, $p_qty);

    }
}