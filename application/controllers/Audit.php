<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/9/15
 * Time: 10:01 PM
 */

class Audit extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Inventory_audit');
        $this->load->helper('url');
    }

    function index()
    {
        $v_herb_id = $this->input->get('herb_id');
        $v_source = 2;
        $v_qty = $this->input->get('herb_qty');
        $v_old_qty = $this->input->get('old_qty');
        $v_diff_qty = $v_qty - $v_old_qty;
        $this->inventory_audit->updateAudit($v_herb_id, $v_source, $v_diff_qty);
    }
} 