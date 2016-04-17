<?php

//set timezone
date_default_timezone_set(America/Vancouver);

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
        $this->load->model('stocks');
        $this->load->model('transactions');
        $this->load->model('stocks_held');
        $this->load->model('players');
        $this->load->library('bsx');
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
            $this->data['agent-info']   = "<div class='alert alert-warning'>You need to create an agent to participate in the BSX.</div>";

            $this->data['team']      = '';
            $this->data['name']      = '';
            $this->data['frequency'] = 30;
            $this->data['button']    = 'Create';
        } else {
            $this->data['agent-info']   = "<div class='alert alert-success'>You are ready to participate in the BSX.</div>";

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

    /**
     * Both buy and sell stock from the BSX. The specific action is determined by which submit button what pressed.
     */
    function exchange() {
        $date = date('Y-m-d H:i:s');
        // If the user is not logged in, redirect to home
        if ($this->session->userdata('user') == null) {
            redirect('/');
        }
        // buy is true if BUY button was pressed, else it's false and we are SELLING
        $buy      = isset($_POST['buy']);
        $stock    = $this->input->post('stock');
        $quantity = $this->input->post('quantity');
        $player   = $this->session->userdata('user')['name'];
        $stockValue = $this->input->post('value');
        // This both registers the agent and makes sure the game is open
        if ($this->bsx->register_agent()) {
            if ($this->bsx->get_status()->state != 3) {
                $this->session->set_flashdata('message', 'You must wait until the game is OPEN.');
                redirect('/profile');
            }

            $agent = $this->agents->get(1);

            if ($buy) {
                // Buying stocks
                $response = $this->bsx->buy_stock($agent->team, $player, $stock, $quantity, $agent->token);

                if (is_array($response)) {
                    if (array_key_exists('message', $response)) {
                        $this->session->set_flashdata('message', $response['message']);
                    } else {
                        $this->stocks_held->add($response);

                        // need to also add to transaction history
                        $data = array('DateTime' => $date, 'Player' => $player, 'Stock' => $stock, 'Quantity' => $quantity, 'Trans' => 'buy');
                        $this->transactions->add($data);

                        //deduct cash from player
                        $currentPlayer = $this->players->get($this->session->userdata('user')['userId']);
                        $currentPlayer->Cash = $currentPlayer->Cash - ($quantity * $stockValue);
                        $this->players->update($currentPlayer);

                        $this->session->set_flashdata('success', 'Stock purchased successfully.');
                    }
                } else {
                    // The server is broken (AGAIN). Just give an innocent error message
                    $this->session->set_flashdata('message', 'Something went wrong. The server is probably broken.');
                }
            } else {
                // Selling stocks
                $certificates = $this->stocks_held->get_certificates($agent->team, $player, $stock);

                if ($certificates) {
                    $response = $this->bsx->sell_stock($agent->team, $player, $stock, $quantity, $agent->token, $certificates);
                    if (is_array($response)) {

                        //add cash to player
                        $currentPlayer = $this->players->get($this->session->userdata('user')['userId']);
                        $currentPlayer->Cash = $currentPlayer->Cash + ($quantity * $stockValue);
                        $this->players->update($currentPlayer);


                        if (array_key_exists('message', $response)) {
                            // We sold all of the stocks for this code, just delete from the database
                            $this->stocks_held->delete_certificates($agent->team, $player, $stock);

                            $this->session->set_flashdata('success', $response['message']);
                        } else {
                            // update the stocks_held
                            $this->stocks_held->update_certificates($agent->team, $player, $stock, $response['amount'], $response['token']);

                            // need to also add to transaction history
                            $data = array('DateTime' => date(), 'Player' => $player, 'Stock' => $stock, 'Quantity' => $quantity, 'Trans' => 'sell');
                            $this->transactions->add($data);

                            $this->session->set_flashdata('success', 'Stock sold successfully.');
                        }
                    } else {
                        // The server is broken (AGAIN). Just give an innocent error message
                        $this->session->set_flashdata('message', 'Something went wrong. The server is probably broken.');
                    }
                }
            }
        }

        redirect('/profile');
    }
}