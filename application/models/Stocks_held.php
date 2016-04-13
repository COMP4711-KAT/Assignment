<?php
/**
 * The Stocks_held model is responsible for the stocks_held table in the database.
 */
class Stocks_held extends MY_Model {
    /**
     * Stocks_held constructor.
     * Takes the table name (stocks_held) and primary key (id) as arguments.
     */
    function __construct() {
        parent::__construct('stocks_held', 'id');
    }

    /**
     * Returns an array of certificates for a certain stock (if it exists).
     *
     * @param $agent string agent name
     * @param $player string player name
     * @param $stock string stock code
     * @return mixed false if there are no certificates, or an array of the certificates.
     */
    function get_certificates($agent, $player, $stock) {
        $this->db->where('agent', $agent);
        $this->db->where('player', $player);
        $this->db->where('stock', $stock);

        $query = $this->db->get($this->_tableName);

        if ($query->num_rows() < 1)
            return false;

        $certificates = array();
        foreach($query->result() as $row) {
            array_push($certificates, $row->token);
        }

        return $certificates;
    }
}