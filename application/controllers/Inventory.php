<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/7/15
 * Time: 9:56 PM
 */

class Inventory extends Public_Controller
{
    function __construct()
    {
        parent::__construct();

        $this
            ->add_external_css(
                array(
                    "//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css",
                    "//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css",
                    "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css",
                    "/htdocs/themes/core/css/core.css"
                ))
            ->add_external_js(
                array(
                    "//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js",
                    "//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js",
                    "/htdocs/themes/default/js/inventory.js",
                    "/htdocs/themes/default/js/navbar_fixed.js"
                ));

        $this->load->library('table');
        $this->load->database();
        $this->load->model('Inventory_model');
        $this->load->model('Herb_inventory_model');
        $this->load->library('session');
        $this->load->helper('url');
    }
    public function index()
    {

        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        if($this->input->post('id'))
        {
            $v_id = $this->input->post('id');
            $v_qty = $this->input->post('qty');
            $v_old_qty = $this->input->post("old_qty");
            $this->Inventory_model->saveHerbQuantity($v_id, $v_qty, $v_old_qty);
        }

        $inventory_data = $this->Inventory_model->loadInventoryList();

        // The parameters array contains the Formula related data which is the parent to the formula ingredients
        $content_data['inventory_data'] = $inventory_data;
        // $content_data['formula_data'] = $this->table->generate($formula_data);

        //        $content_data['table_data'] = $this->table->generate($table_data);
        // $content_data['table_data'] = $table_data;

        // load views
        $data['content'] = $this->load->view('inventory_list_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    public function inventory_levels()
    {
        $id = "";
        $description = "";
        $qty = "";
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        // set content data
        $content_data = array(
            'welcome_message' => $this->settings->welcome_message
        );

        $v_herb_id = $this->uri->uri_to_assoc();
        $a_herb = $this->Herb_inventory_model->loadHerb($v_herb_id);

        $a_inventory_history = $this->Herb_inventory_model->loadHerbInventoryHistory($v_herb_id);
        $content_data['inventory_data'] = $a_herb[0];
        $content_data['change_history'] = $a_inventory_history;

        // load views
        $data['content'] = $this->load->view('herb_inventory_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
}