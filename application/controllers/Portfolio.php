<?php
/**
 * This is the portfolio(profile) controller used to pass data
 * to display profile information.
 */

class Portfolio extends Application {

    /**
     * Grabs both models to use one for the transactions and
     * since if a player has no transactions, use player model
     * to get player table values to fill in dropdown
     * Portfolio constructor.
     */
    function __construct() {

        parent::__construct();

        $this->load->model('transactions');
        $this->load->model('players');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    /**
     * Shows the player whose currently logged in and if not logged,
     * shows Donald. Uses a different pagebody for a user profile as
     */
    function index() {

        //If there is no user logged in
        if($this->session->userdata('user') == null) {
            $this->data['pageTitle'] = 'Profile of Donald' ;
            // this is the view we want shown
            $this->data['pagebody'] = 'profile';

            //Data to fill in dropdown menu
            $this->data['player_names'] = $this->players->all();

            //Data to fill transactions table, Donald for now
            $this->data['players'] = $this->transactions->some("Player", 'Donald');

            //Player's current holdings in each stock, Donald for now
            $this->data['stocks']= $this->transactions->get_player_stocks("Player", 'Donald');

            $this->render();
        } else {
            $this -> one($this->session->userdata('user'));
        }
    }

    /**
     * Shows the data for one player
     * @param $player the name of the player
     */
    function one($player) {

        $name = ucfirst($player);

        $this->data['pageTitle'] = 'Profile of ' . $name;

        // this is the view we want shown
        $this->data['pagebody'] = 'profile';

        //Data to fill in dropdown menu
        $this->data['player_names'] = $this->players->all();

        //Data to fill transactions table
        $this->data['players'] = $this->transactions->some("Player", $player);

        //Player's current holdings in each stock
        $this->data['stocks']= $this->transactions->get_player_stocks("Player", $player);

        $this->render();
    }
    
    /**
     * Prompts the user to log in with a username
     */
    function login() {
        $this->data['pageTitle'] = 'Login';

        // this is the view we want shown
        $this->data['pagebody'] = 'login';

        $this->render();
    }
    
    /**
     * Prompts the user to log in with a username
     */
    function verify_login() {
        if ($this->input->post('username') !== null) {
            $this->session->set_userdata('user', $this->input->post('username'));
            redirect('/welcome');
        } else {
            $this->login();
        }
    }
    
    /**
     * Clears the session data of the logged in user
     */
    function logout() {
        $this->session->unset_userdata('user');
        redirect('/welcome');
    }
}