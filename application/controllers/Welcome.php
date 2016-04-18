<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 *
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();

        $this->load->model('players');
        $this->load->model('stocks');
        $this->load->model('movements');
        $this->load->model('transactions');
        $this->load->library('bsx');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $user = $this->session->user;
        $this->data['pageTitle'] = 'Welcome to Kitty Kats Stock Exchanger Brokerage!';
        // this is the view we want shown
        $this->data['pagebody'] = 'homepage';
        $status = $this->bsx->get_status();
        switch ($status->state) {
            case 0:
                $this->data['state'] = "Game is not active";
        break;
            case 1:
                $this->data['state'] = "The stocks for the next round are being generated";
        break;
            case 2:
                $this->data['state'] = "Stocks have been generated! Stock Marker is OPEN!";
        break;
            case 3:
                $this->data['state'] = "Game is Active!";
        break;
            case 4:
                $this->data['state'] = "The current round has concluded! :(";
        break;
            default:
                $this->data['state'] = "Unknown state";
        }
        if(isset($user)) {
            $this->data['player_name'] = $user['name'];
            if ($user['avatar'] != null) {
                $this->data['player_avatar'] = "/data/avatars/" . $user['avatar'];
            } else {
                $this->data['player_avatar'] = "http://fanexpovancouver.com/wp-content/uploads/2013/12/550w_soaps_silhouettesm.jpg";
            }
        } else {
            $this->data['player_name'] = "Guest";
            $this->data['player_avatar'] = "http://fanexpovancouver.com/wp-content/uploads/2013/12/550w_soaps_silhouettesm.jpg";
        }
        $this->data['round'] = $status->round;
        $this->data['players'] = $this->players->all();
        $this->data['stockscsv'] = $this->stocks->get_stocks();
        $this->data['movement'] = $this->movements->get_most_recent_movements_stock_home();
        $this->data['transactions'] = $this->transactions->get_most_recent_transactions_stock_home();

        // Prepare players for display
        $players = array();
        foreach ($this->data['players'] as $player) {
            // Fix avatar images
            if ($player->Avatar != null) {
                $player->Avatar = "/data/avatars/" . $player->Avatar;
            } else {
                $player->Avatar = "http://fanexpovancouver.com/wp-content/uploads/2013/12/550w_soaps_silhouettesm.jpg";
            }

            // Get their equity
            $player = (array)$player;
            $player['Equity'] = $this->players->get_equity($player['UserId']);
            array_push($players, $player);
        }
        $this->data['players'] = $players;

        $this->render();
    }
}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */