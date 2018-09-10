<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }


    /**
	 * Default
     */
	function index()
	{
        // setup page header data
        $this->set_title( sprintf(lang('core title welcome'), $this->settings->site_name) );
 
        $data = $this->includes;

        // set content data
        $content_data = array(
            'welcome_message' => $this->settings->welcome_message
            , 'Notes' => "<b>DEVELOPER NOTES:<br></b>
                          1.    Need to build a model to load the herb data when adjusting Inventory levels.  Can't use the URI to send the data...<br>
                          2.    Change style of tables to use single pixel lines<br>
                          3.    Create placeholder blocks for widgets on home page
                          4.    Create the audits for batches
                          5.    Use the difference between the current inventory qty and the new inventory quantity when making adjustments directly or through the Formula"
        );

        // load views
        $data['content'] = $this->load->view('welcome', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

}
