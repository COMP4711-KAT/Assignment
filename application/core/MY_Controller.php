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
		$this->load->library('bsx');
        $this->load->model('agents');

		$this->data = array();
		$this->data['title'] = 'Stock Ticker';	// our default title
		$this->errors = array();
		$this->data['pageTitle'] = 'Stock Ticker';   // our default page
                
		// check for user log in then change navbar accordingly
		$navbar = $this->config->item('menu_choices');
		if ($this->session->userdata('user') !== null) {
			if ($this->session->userdata('user')['role'] == ROLE_ADMIN) {
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
		// Get the current game status so we can display it at the top of the page
        $status = $this->bsx->get_status();
        $this->data['game_status'] = "<div class='alert alert-info'><b>Round " . $status->round ."!</b> The stock exchange is " . $status->desc ." for " . $status->countdown . " more seconds.</div>";

        // Check the agents last round to see if we need to reset game data
        $agent = $this->agents->get(1);
        if ($agent != null) {
            if ($agent->round != $status->round) {
                // Reset the game
                $this->bsx->reset_game();

                // Update the agents round
                $agent->round = $status->round;
                $this->agents->update($agent);
            }
        }

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

    /**
     * Restricts user access they do not have the role in roleNeeded
     * @param null $roleNeeded
     */
	function restrict($roleNeeded = null) {
		$userRole = $this->session->userdata('userRole');

		if ($roleNeeded != null) {
			if (is_array($roleNeeded)) {
				if (!in_array($userRole, $roleNeeded)) {
					redirect("/");
					return;
				}
			} else if ($userRole != $roleNeeded) {
				redirect("/");
				return;
			}
		}
	}

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */