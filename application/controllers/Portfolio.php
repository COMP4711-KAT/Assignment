<?php
/**
 * NEED TO ASK --- How to do current holdings since Donald sells
 * one of his holdings but don't know initial value...lame
 * Was thinking of adding and substracting to get total
 * value for each holding and if no transactions, they have 0 in that
 * holding.
 * Requirement is "Current holdings should show the quantity
 * held for each stock on the BSX"
 *  -Kamil (Just something to think about)
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

        $this->load->model('portfolios');
        $this->load->model('players');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    /**
     * Shows the player whose currently logged in and if not logged,
     * shows ____(something), right now just shows all player transactions
     */
    function index() {
        $this->data['pageTitle'] = 'Profile';
        // this is the view we want shown
        $this->data['pagebody'] = 'profile';

        //Data to fill in dropdown menu
        $this->data['player_names'] = $this->players->all();

        //Data to fill transactions table
        $this->data['players'] = $this->portfolios->all();

        $this->render();
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
        $this->data['players'] = $this->portfolios->some("Player", $player);


        $this->render();
    }
}