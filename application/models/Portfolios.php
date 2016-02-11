<?php
/**
 * The Transactions model is responsible for the players table in the database.
 */
class Portfolios extends MY_Model {
    /**
     * Portfolios constructor.
     * Takes the table name (Transactions) and primary key (Player) as arguments.
     */
    function __construct() {
        parent::__construct('Transactions', 'Player');
    }

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
                $key = array_search($row->Stock, array_column($stocks, 'stock'));
                if ($key != null) {
                    $stocks[$key]['value'] += $row->Quantity;
                }
            } else if($row->Trans == 'sell') {
                $key = array_search($row->Stock, array_column($stocks, 'stock'));
                if($key != null) {
                    if($stocks[$key]['value']  > 0) {
                        $stocks[$key]['value'] -= $row->Quantity;
                    }
                }
            }
        }

        return $stocks;
    }


}