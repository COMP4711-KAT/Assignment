<?php
/**
 * The Transactions model is responsible for the transactions table in the database.
 */
class Transactions extends MY_Model {
    /**
     * Transactions constructor.
     * Takes the table name (Transactions) and primary key (Player) as arguments.
     */
    function __construct() {
        parent::__construct('Transactions', 'Player');
    }

    /**
     * This creates bogus data for the current holdings of each player starting
     * at 0. And increments if they had bought any stock and decrements if they
     * have greater than 0 units in that stock and they had been selling that
     * stock.
     * @param $what the column of the table
     * @param $which the value to search in column
     * @return array array of objects
     */
    public function get_player_stocks($what, $which)
    {
        //Stocks that are each initialized to 0
        //This should be set in the database
        $stocks = array(
            array('stock' => 'BOND', 'name' => 'Bonds', 'value' => 0),
            array('stock' => 'GOLD', 'name' => 'Gold', 'value' => 0),
            array('stock' => 'GRAN', 'name' => 'Grain', 'value' => 0),
            array('stock' => 'IND', 'name' => 'Industrial', 'value' => 0),
            array('stock' => 'OIL', 'name' => 'Oil', 'value' => 0),
            array('stock' => 'TECH', 'name' => 'Tech', 'value' => 0)
        );

        //Finds the transactions the player has made
        $this->db->order_by($this->_keyField, 'asc');

        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else {
            $this->db->where($what, $which);
        }

        $query = $this->db->get($this->_tableName);

        //Increments current holding of player by amount they bought
        //Decrements current holding of player by amount they sold
        foreach ($query->result() as $row) {
            if($row->Trans == 'buy') {
                $key = array_search($row->Stock, array_column($stocks, 'Stock'));
                if ($key != null) {
                    $stocks[$key]['value'] += $row->Quantity;
                }
            } else if($row->Trans == 'sell') {
                $key = array_search($row->Stock, array_column($stocks, 'Stock'));
                if($key != null) {
                    if($stocks[$key]['value']  > 0) {
                        $stocks[$key]['value'] -= $row->Quantity;
                    }
                }
            }
        }

        return $stocks;
    }

    /**
     * Returns an array of objects in descending order
     * @param $what the column of the table
     * @param $which the value to find in column
     * @return mixed array of objects
     */
    function some_desc($what, $which) {
        $this->db->order_by('DateTime', 'desc');
        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else
            $this->db->where($what, $which);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    /**
     * Using the movements recent method to get recently moved stock
     * in order to get the transactions related to that stock that
     * is made by the users.
     * @return mixed an array of objects
     */
    function some_recent() {
        $CI = & get_instance();
        $stock = $CI->movements->recent();
        $this->db->order_by('DateTime', 'desc');
        $this->db->where('Stock', $stock[0]->Code); // special treatment for period
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }
}