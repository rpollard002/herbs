<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 10/16/15
 * Time: 9:13 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Herb extends Public_Controller {

    /**
     * Constructor
     */
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
                    "/htdocs/themes/default/js/herbs.js",
                    "/htdocs/themes/default/js/navbar_fixed.js"
                ));
        // Initialize classes...
        $this->load->library('table');
        $this->load->database();
        $this->load->model('Herb_model');
        $this->load->library('session');
        $this->load->helper('url');

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

        $herb_id = "";
        $herb_name = "";
        $herb_description = "";
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;




        if($this->input->post('save_herb'))
        {
            $this->Herb_model->saveHerb();
        }

        $herb_data = $this->Herb_model->getHerbList();

        // $content_data['herb_data'] = $this->table->generate($herb_data);
        $tmpl2 = array (
            'table_open'          => '<table id="herb_list_data" border="1" cellpadding="4" cellspacing="2" class="herb_list_data">',

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

        $content_data['herb_data'] = $herb_data;
        // $content_data['herb_data'] = $this->table->generate($herb_data);

        // load views
        $data['content'] = $this->load->view('herb_list_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function detail()
    {

        $herb_id = "";
        $herb_name = "";
        $herb_description = "";
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );

        $data = $this->includes;

        $a_herb_id = $this->uri->uri_to_assoc();
        if(count($a_herb_id) > 0)
        {
            // Check to see if formula data exists...

            $p_herb_id = $a_herb_id['id'];

            $herb_data = $this->Herb_model->getHerbData($p_herb_id);
        }
        $content_data['herb_data'] = $herb_data;
        // $content_data['herb_data'] = $this->table->generate($herb_data);

        // load views
        $data['content'] = $this->load->view('herb_view', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function saveHerb()
    {

        $this->Herb_model->saveHerbs();
    }
}