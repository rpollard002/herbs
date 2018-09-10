<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formula extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        // Override to add files to load...
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
                    "/htdocs/themes/default/js/herbs.js",
                    "/htdocs/themes/default/js/navbar_fixed.js"
                ));
        $this->load->library('table');
        $this->load->database();
        $this->load->model('Formula_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('inventory_audit');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {

        $formula_id = "";
        $formula_name = "";
        $formula_description = "";
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        // Initialize classes...
//        $this->load->library('table');
//        $this->load->database();
//        $this->load->model('Formula_model');
//        $this->load->library('session');
//        $this->load->helper('url');

        if($this->input->post('save_formula'))
        {
            $this->Formula_model->saveIngredients();
        }
        if($this->input->post('save_inventory'))
        {
            $this->Formula_model->saveInventoryAdjustment();
        }

        $formula_data = $this->Formula_model->loadFormulaList();

        /* $content_data['formula_data'] = $this->table->generate($formula_data);
        $tmpl2 = array (
            'table_open'          => '<table id="formula_list_data" border="1" cellpadding="4" cellspacing="2" class="formula_list_data">',

            'heading_row_start'   => '<tr>',
            'heading_row_end'     => '</tr>',
            'heading_cell_start'  => '<th>',
            'heading_cell_end'    => '</th>',

            'row_start'           => '<tr>',
            'row_end'             => '</tr>',
            'cell_start'          => '<td>',
            'cell_end'            => '</td>',

            'row_alt_start'       => '<tr>',
            'row_alt_end'         => '</tr>',
            'cell_alt_start'      => '<td>',
            'cell_alt_end'        => '</td>',

            'table_close'         => '</table>'
        );

        $this->table->set_template($tmpl2);
        */
        // The parameters array contains the Formula related data which is the parent to the formula ingredients
        $content_data['formula_data'] = $formula_data;
        // $content_data['formula_data'] = $this->table->generate($formula_data);

        //        $content_data['table_data'] = $this->table->generate($table_data);
        // $content_data['table_data'] = $table_data;

        // load views
        $data['content'] = $this->load->view('formula_list_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    public function build()
    {
        $formula_id = "";
        $formula_name = "";
        $formula_description = "";
        $p_formula_id = '';
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        // set content data
        $content_data = array(
            'welcome_message' => $this->settings->welcome_message
        );
        // Initialize classes...
//        $this->load->library('table');
//        $this->load->helper('form');
//        $this->load->database();
//        $this->load->model('Formula_model');
//        $this->load->library('session');
//        $this->load->helper('url');


        if($this->input->post('save_formula'))
        {
            $this->Formula_model->saveIngredients();
        }

        $a_formula_id = $this->uri->uri_to_assoc();
        if(count($a_formula_id) > 0)
        {
            // Check to see if formula data exists...

            $p_formula_id = $a_formula_id['id'];

            $a_formula_data = $this->Formula_model->loadFormula($p_formula_id);
            if(count($a_formula_data) > 0)
            {
                $formula_id = $a_formula_data->id;
                $formula_name = $a_formula_data->name;
                $formula_description = $a_formula_data->description;
            }
        }

        $table_data = $this->Formula_model->getHerbIngredients($p_formula_id);
        $content_data['table_data'] = $table_data;

        $formula_data = $this->Formula_model->getParameterData();
        $herb_data = $this->Formula_model->getHerbSelectList();

// The parameters array contains the Formula related data which is the parent to the formula ingredients
        $content_data['parameters'] = array('formula_id' => $formula_id, 'formula_name' => $formula_name, 'formula_description' => $formula_description);
        $content_data['formula_data'] = $formula_data;
        $tmpl1 = array ('table_open' => '<table id="herb_table" border="1" cellpadding="4" cellspacing="2" class="herb_formula_class">');
        $this->table->set_template($tmpl1);
        $content_data['herb_data'] = $this->table->generate($herb_data);
        $tmpl2 = array (
            'table_open'          => '<table id="herb_ingredients" border="1" cellpadding="4" cellspacing="2" class="herb_formula_class">',

            'heading_row_start'   => '<tr>',
            'heading_row_end'     => '</tr>',
            'heading_cell_start'  => '<th>',
            'heading_cell_end'    => '</th>',

            'row_start'           => '<tr>',
            'row_end'             => '</tr>',
            'cell_start'          => '<td>',
            'cell_end'            => '</td>',

            'row_alt_start'       => '<tr>',
            'row_alt_end'         => '</tr>',
            'cell_alt_start'      => '<td>',
            'cell_alt_end'        => '</td>',

            'table_close'         => '</table>'
        );
        $this->table->set_template($tmpl2);
//        $content_data['table_data'] = $this->table->generate($table_data);

        // load views
        $data['content'] = $this->load->view('formula_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    public function inventory_adjust()
    {
        $formula_id = "";
        $formula_name = "";
        $formula_description = "";
        $p_formula_id = '';
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        // set content data
        $content_data = array(
            'welcome_message' => $this->settings->welcome_message
        );


        if($this->input->post('save'))
        {
            $this->Formula_model->saveIngredients();
        }

        $a_formula_id = $this->uri->uri_to_assoc();
        if(count($a_formula_id) > 0)
        {
            // Check to see if formula data exists...

            $p_formula_id = $a_formula_id['id'];

            $a_formula_data = $this->Formula_model->loadFormula($p_formula_id);
            if(count($a_formula_data) > 0)
            {
                $formula_id = $a_formula_data->id;
                $formula_name = $a_formula_data->name;
                $formula_description = $a_formula_data->description;
            }
        }

        $table_data = $this->Formula_model->getInventoryList($p_formula_id);
        $content_data['table_data'] = $table_data;

        $formula_data = $this->Formula_model->getParameterData();

// The parameters array contains the Formula related data which is the parent to the formula ingredients
        $content_data['parameters'] = array('formula_id' => $formula_id, 'formula_name' => $formula_name, 'formula_description' => $formula_description);
        $content_data['formula_data'] = $formula_data;


        // load views
        $data['content'] = $this->load->view('inventory_adjustment_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
}