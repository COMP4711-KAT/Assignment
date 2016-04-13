<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright   2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	protected $data = array();	  // parameters for view components
	protected $id;				  // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['title'] = 'Stock Ticker';	// our default title
		$this->errors = array();
		$this->data['pageTitle'] = 'Stock Ticker';   // our default page
                
		// check for user log in then change navbar accordingly
		$this->load->library('session');
		$navbar = $this->config->item('menu_choices');
		if ($this->session->userdata('user') !== null) {
			if ($this->session->userdata('user')['role'] == 'admin') {
				$navbar['menudata'][3] = array('name' => 'Agent Management', 'link' => '/agent');
				$navbar['menudata'][4] = array('name' => 'Logout', 'link' => '/logout');
			} else {
				$navbar['menudata'][3] = array('name' => 'Logout', 'link' => '/logout');
			}
		} else {
			$navbar['menudata'][3] = array('name' => 'Login', 'link' => '/login');
			$navbar['menudata'][4] = array('name' => 'Register', 'link' => '/register');
		}
		$this->config->set_item('menu_choices', $navbar);
	}

	/**
	 * Render this page
	 */
	function render()
	{
		// Show an error message if we have one
		if ($this->session->userdata('message') != null) {
			$this->data['message'] = "<div class='alert alert-danger'>" . $this->session->userdata('message') ."</div>";
		} else if ($this->session->userdata('success') != null) {
            $this->data['message'] = "<div class='alert alert-success'>" . $this->session->userdata('success') ."</div>";
        } else {
            $this->data['message'] = "";
        }

		$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);
		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

		// finally, build the browser page!
		$this->data['data'] = &$this->data;
		$this->parser->parse('_template', $this->data);
	}

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */