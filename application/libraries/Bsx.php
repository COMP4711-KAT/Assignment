<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Bsx
 *
 * Responsible for interacting with the BSX server.
 */
class Bsx {
    protected $_ci;
    public function __construct() {
        $this->_ci =& get_instance();

        $this->_ci->load->model('agents');
        $this->_ci->load->library('rest');

        $this->_ci->rest->initialize(array('server' => 'http://bsx.jlparry.com'));
    }

    /**
     * Gets the status of the game and returns it as a SimpleXMLElement
     *
     * @return SimpleXMLElement
     */
    public function get_status() {
        $status = simplexml_load_file("http://bsx.jlparry.com/status");

        return $status;
    }

    /**
     * Registers your agent and returns the registration token, or false if an error occured.
     *
     * @return bool success
     */
    public function register_agent() {
        $agent = $this->_ci->agents->get(1);

        // Make sure we have an agent
        if ($agent == null) {
            $this->_ci->session->set_flashdata('message',
                                               "There is no existing agent. Ask the admin to create one in the agent management portal.");
            return false;
        }

        // Post data
        $data = array('team' => $agent->team, 'name' => $agent->name, 'password' => PASSWORD);

        // Grab the status of the game
        $status = $this->get_status();

        // Make sure the game is in the open or register state
        if ($status->state == 2 || $status->state == 3) {
            $response = $this->_ci->rest->post('register', $data);

            $agent->token = $response['token'];

            $this->_ci->agents->update($agent);

            return true;
        } else {
            $this->_ci->session->set_flashdata('message', "There game is currently closed. Try again later.");
            return false;
        }
    }

    public function buy_stock($team, $player, $stock, $quantity, $token) {
        $data = array('team' => $team,
                      'player' => $player,
                      'stock' => $stock,
                      'quantity' => $quantity,
                      'token' => $token);

        $response = $this->_ci->rest->post('buy', $data);

        return $response;
    }
}