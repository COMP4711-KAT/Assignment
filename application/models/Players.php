<?php
/**
 * The Players model is responsible for the players table in the database.
 */
class Players extends MY_Model {
    /**
     * Players constructor.
     * Takes the table name (players) and primary key (Player) as arguments.
     */
    function __construct() {
        parent::__construct('players', 'UserId');
        $this->load->model('stocks');
    }

    function get_player($player) {
        $query = $this->db->get_where($this->_tableName, array('Player' => $player));

        if ($query->num_rows() > 1)
            return false;

        $player = null;
        foreach($query->result() as $row) {
            $player = $row;
        }

        return $player;
    }

    function get_equity($player) {
        $this->db->where('player', $player);
        $query = $this->db->get('stocks_held');

        $equity = 0;
        foreach($query->result() as $row) {
            $stock = $this->stocks->get_single_stock($row->stock);

            $equity += $stock['value'] * $row->amount;
        }

        return $equity;
    }
}