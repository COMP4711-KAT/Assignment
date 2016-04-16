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
        $this->load->model('stocks');
        $this->load->model('stocks_held');
        $this->load->library('form_validation');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    /**
     * Shows the player whose currently logged in and if not logged,
     * shows Donald. Uses a different pagebody for a user profile as
     */
    function index() {

        //If there is no user logged in just picks a random profile from database
        if($this->session->userdata('user') == null) {
            $players = $this->players->all();
            $randomNumber = rand(0, count($players) - 1);
            $player = $players[$randomNumber];
            $stocks_held = $this->stocks_held->get_player_stocks($player->Player);

            $this->data['pageTitle'] = 'Profile of ' . $player->Player ;
            // this is the view we want shown
            $this->data['pagebody'] = 'profile';

            //Data to fill in dropdown menu
            $this->data['player_names'] = $players;

            $this->data['transactions'] = $this->transactions->get_player_transactions($player);

            //active stocks
            $this->data['stocks']= $this->stocks->get_stocks();

            $this->data['cash'] = $player->Cash;

            if($stocks_held == null) {
                $this->data['stocks_held'] = array(array("stock" => '', "amount" => ''));

            } else {
                $this->data['stocks_held'] = $stocks_held;
            }


            $this->render();
        } else {
            $this -> one($this->session->userdata('user')["name"]);
        }
    }

    /**
     * Shows the data for one player
     * @param $player the name of the player
     */
    function one($player) {
        $name = ucfirst($player);
        $currentPlayer = $this->players->get_player($player);
        $stocks_held = $this->stocks_held->get_player_stocks($player);

        $this->data['pageTitle'] = 'Profile of ' . $name;

        // this is the view we want shown
        $this->data['pagebody'] = 'profile';

        //Data to fill in dropdown menu
        $this->data['player_names'] = $this->players->all();

        //Data to fill transactions table
        $this->data['transactions'] = $this->transactions->get_player_transactions($player);

        //Active Stocks
        $this->data['stocks']= $this->stocks->get_stocks();

        //get current player
        $this->data['cash'] = $currentPlayer->Cash;

        //Player's current holdings in each stock
        if($stocks_held == null) {
            $this->data['stocks_held'] = array(array("stock" => '', "amount" => ''));
        } else {
            $this->data['stocks_held'] = $stocks_held;
        }

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
        $userId = $this->input->post('UserId');
        $player = $this->players->get($userId);
        if ($player != null && password_verify($this->input->post('Password'), $player->Password)) {
            $this->session->set_userdata('user'
                    , ["name"=>$player->Player, "avatar"=>$player->Avatar, "role"=>$player->UserRole, "userId"=>$userId]);
            redirect('/welcome');
        } else {
            $this->session->set_flashdata('message', 'Incorrect Username or Password.');
            $this->login();
        }
    }

    /**
     * Prompts the user to register an account
     */
    function register() {
        $this->data['pageTitle'] = 'Register';

        // this is the view we want shown
        $this->data['pagebody'] = 'register';

        $this->render();
    }

    /**
     * Validates the registration input and either creates a new user in the DB or sends an error.
     */
    function verify_register() {
        $this->form_validation->set_rules('UserId', 'Username', 'required|callback_duplicate_entry');
        $this->form_validation->set_rules('Password', 'Password', 'required|min_length[1]|max_length[60]');
        $this->form_validation->set_rules('Player', 'Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {
            $this->session->set_flashdata('success', 'Thanks for registering!');
            $user = array();
            $user['UserId'] = $this->input->post('UserId');
            $user['Player'] = $this->input->post('Player');
            $user['Password'] = password_hash($this->input->post('Password'), PASSWORD_DEFAULT);
            $user['Cash'] = 5000;
            $user['UserRole'] = 'user';
            if (!file_exists('./data/avatars')) {
                mkdir('./data/avatars', 0777, true);
            }
            $config['upload_path'] = './data/avatars/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            $this->upload->do_upload('Avatar');

            $upload = $this->upload->data();
            if($upload['is_image']) {
                $user['Avatar'] = $upload['file_name'];
            } else {
                $this->form_validation->set_message('Avatar', "Your avatar must have one of the three
                        extensions: .gif | .jpg | .png");
                $this->register();
            }
            $this->players->add($user);

            $this->login();
        }
    }
    /**
     * Returns false if the userId is used for another account.
     */
    function duplicate_entry($userId) {
        $result = $this->players->get($userId);
        if ($result == null) {
            return TRUE;
        } else {
            $this->form_validation->set_message('duplicate_entry', 'Username is already in use.');
            return false;
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