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

    /**
     * Updates the certificates for a stock in the database by deleting the existing ones and inserting
     * a new record.
     *
     * @param $agent string agent name
     * @param $player string player name
     * @param $stock string stock code
     * @param $quantity the amount of remaining stock
     * @param $certificate string the certificate for the remaining stock
     */
    function update_certificates($agent, $player, $stock, $quantity, $certificate) {
        // Delete the exiting records
         $this->delete_certificates($agent, $player, $stock);

        // Insert a new record
        $stock = array('agent' => $agent, 'player' => $player,
                       'stock' => $stock, 'amount' => $quantity,
                       'token' => $certificate, 'id' => null,
                       'datetime' => date());

        $this->db->insert($this->_tableName, $stock);
    }

    /**
     * Deletes the certificates for a stock in the database.
     *
     * @param $agent string agent name
     * @param $player string player name
     * @param $stock string stock code
     */
    function delete_certificates($agent, $player, $stock) {
        // Delete the exiting records
        $this->db->where('agent', $agent);
        $this->db->where('player', $player);
        $this->db->where('stock', $stock);

        $this->db->delete($this->_tableName);
    }
}