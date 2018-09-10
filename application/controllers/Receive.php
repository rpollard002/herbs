<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/7/15
 * Time: 9:56 PM
 */

class Receive extends Public_Controller
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
        $this->load->model('Receive_model');
        $this->load->library('session');
        $this->load->helper('url');
    }
    public function index()
    {

        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;
        $total_rows = $this->input->post('total_rows');
        if(count($_POST)  > 0)
        {
            $this->Receive_model->saveHerbsReceived($_POST, $total_rows);
        }



        $inventory_data = $this->Receive_model->loadReceiveList();

        // The parameters array contains the Formula related data which is the parent to the formula ingredients
        $content_data['inventory_data'] = $inventory_data;
        // $content_data['formula_data'] = $this->table->generate($formula_data);

        //        $content_data['table_data'] = $this->table->generate($table_data);
        // $content_data['table_data'] = $table_data;

        // load views
        $data['content'] = $this->load->view('receive_list_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
}