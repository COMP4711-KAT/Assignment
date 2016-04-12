<?php

/**
 * This is the agent controller that is used to interact with the BSX server.
 * Class Agent
 */
class Agent extends Application {

    /**
     * Agent constructor.
     */
    function __construct() {
        parent::__construct();

        $this->load->model('agents');
    }

    /**
     * Shows the agent management page.
     */
    function index(){
        // If the user is not logged in and not an admin, redirect to home
        if ($this->session->userdata('user') == null || $this->session->userdata('user')['role'] != "admin") {
            redirect('/');
        }

        $this->data['pageTitle'] = 'Agent Management';
        $this->data['pagebody'] = 'agent_management';

        $agent = $this->agents->get(1);
        if ($agent == null) {
            $this->data['message']     = "<div class='alert alert-warning'>You need to create an agent to participate in the BSX.</div>";

            $this->data['team']      = '';
            $this->data['name']      = '';
            $this->data['frequency'] = 30;
            $this->data['button']    = 'Create';
        } else {
            $this->data['message']     = "<div class='alert alert-success'>You are ready to participate in the BSX.</div>";

            $this->data['team']      = $agent->team;
            $this->data['name']      = $agent->name;
            $this->data['frequency'] = $agent->frequency;
            $this->data['button']    = 'Update';
        }

        $this->render();
    }

    /**
     * Creates a new agent or updates one if existing (there can only ever be one agent).
     */
    function create() {
        // If the user is not logged in and not an admin, redirect to home
        if ($this->session->userdata('user') == null || $this->session->userdata('user')['role'] != "admin") {
            redirect('/');
        }

        // Get the POST data
        $team      = $this->input->post('team');
        $name      = $this->input->post('name');
        $frequency = $this->input->post('frequency');

        $agent = array('id' => 1, 'team' => $team, 'name' => $name, 'frequency' => $frequency);

        // If there is no agent, create it. Otherwise, update the existing one. (There's only ever one agent).
        if ($this->agents->get(1) == null) {
            $this->agents->add($agent);
        } else {
            $this->agents->update($agent);
        }

        redirect('/agent');
    }
}