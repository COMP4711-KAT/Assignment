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
     * @return string token or false
     */
    public function register_agent() {
        $agent = $this->_ci->agents->get(1);

        // Make sure we have an agent
        if ($agent == null) {
            return false;
        }

        // Post data
        $data = array('team' => $agent->team, 'name' => $agent->name, 'password' => PASSWORD);

        // Grab the status of the game
        $status = $this->get_status();

        // Make sure the game is in the open or register state
        if ($status->state == 2 || $status->state == 3) {
            $this->_ci->rest->initialize(array('server' => 'http://bsx.jlparry.com'));

            $answer = $this->_ci->rest->post('register', $data);

            return $answer['token'];
        } else {
            return false;
        }
    }
}