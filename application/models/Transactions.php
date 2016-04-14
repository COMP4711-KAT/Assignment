<?php
/**
 * The Transactions model is responsible for the transactions table in the database.
 */
class Transactions extends MY_Model {

    //Current Holdings that are each initialized to 0
     var $stocks = array(
        array('stock' => 'BOND', 'name' => 'Bonds', 'value' => 0),
        array('stock' => 'GOLD', 'name' => 'Gold', 'value' => 0),
        array('stock' => 'GRAN', 'name' => 'Grain', 'value' => 0),
        array('stock' => 'IND', 'name' => 'Industrial', 'value' => 0),
        array('stock' => 'OIL', 'name' => 'Oil', 'value' => 0),
        array('stock' => 'TECH', 'name' => 'Tech', 'value' => 0)
    );

    /**
     * Transactions constructor.
     * Takes the table name (Transactions) and primary key (Player) as arguments.
     */
    function __construct() {
        parent::__construct('transactions', 'Player');
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
                $key = array_search($row->Stock, array_column($this->stocks, 'stock'));
                if(isset($key)) {
                    $this->stocks[$key]['value'] += $row->Quantity;
                }
            } else if($row->Trans == 'sell') {
                $key = array_search($row->Stock, array_column($this->stocks, 'stock'));
                if(isset($key)) {
                    if($this->stocks[$key]['value']  > 0) {
                        $this->stocks[$key]['value'] -= $row->Quantity;
                    }
                }
            }
        }

        return $this->stocks;
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

    /**
     * Gets the list of transactions made by the player
     * @param $player the player specified
     * @return array list of transactions by player
     */
    function get_player_transactions($player) {
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/transactions", "r")) !== FALSE) {
            $rowCounter = 0;
            while (($rowData = fgetcsv($handle, 0, ",")) !== FALSE) {
                if( 0 === $rowCounter) {
                    $headerRecord = $rowData;
                } else {
                    foreach( $rowData as $key => $value) {
                        if($value == "")
                            $assocData[ $rowCounter - 1][ $headerRecord[ $key] ] = $value;
                    }
                }
                $rowCounter++;
            }
            fclose($handle);
        }

        for ($i = 0; $i < count($assocData); $i ++) {
            if($assocData[$i]["player"] == $player) {
                array_push($filtered_array, $assocData[$i]);
            }
        }

        return $filtered_array;
    }

    /**
     * Gets a list of transactions specified by a stock
     * @param $which the stock to look for
     * @return array list of stock transactions made by players
     */
    function get_stock_transactions($which) {

        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/transactions", "r")) !== FALSE) {
            $rowCounter = 0;
            while (($rowData = fgetcsv($handle, 0, ",")) !== FALSE) {
                if( 0 === $rowCounter) {
                    $headerRecord = $rowData;
                } else {
                    foreach( $rowData as $key => $value) {
                        if($value == "")
                            $assocData[ $rowCounter - 1][ $headerRecord[ $key] ] = $value;
                    }
                }
                $rowCounter++;
            }
            fclose($handle);
        }

        for ($i = 0; $i < count($assocData); $i ++) {
            if($assocData[$i]["stock"] == $which) {
                array_push($filtered_array, $assocData[$i]);
            }
        }

        return $filtered_array;
    }

    function get_most_recent_transactions_stock() {
        $CI = & get_instance();
        $stock = $CI->stocks->get_most_recent_stock();
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/transactions", "r")) !== FALSE) {
            $rowCounter = 0;
            while (($rowData = fgetcsv($handle, 0, ",")) !== FALSE) {
                if( 0 === $rowCounter) {
                    $headerRecord = $rowData;
                } else {
                    foreach( $rowData as $key => $value) {
                        $assocData[ $rowCounter - 1][ $headerRecord[ $key] ] = $value;
                    }
                }
                $rowCounter++;
            }
            fclose($handle);
        }

        for ($i = 0; $i < count($assocData); $i ++) {
            if($assocData[$i]["code"] == $stock[0]["code"]) {
                array_push($filtered_array, $assocData[$i]);
            }
        }

        return $filtered_array;
    }

    /**
     * Gets list of recent transactions for the homepage
     * @return array list of most recent transactions
     */
    function get_most_recent_transactions_stock_home() {
        $CI = & get_instance();
        $stock = $CI->stocks->get_most_recent_stock();
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/transactions", "r")) !== FALSE) {
            $rowCounter = 0;
            while (($rowData = fgetcsv($handle, 0, ",")) !== FALSE) {
                if( 0 === $rowCounter) {
                    $headerRecord = $rowData;
                } else {
                    foreach( $rowData as $key => $value) {
                        $assocData[ $rowCounter - 1][ $headerRecord[ $key] ] = $value;
                    }
                }
                $rowCounter++;
            }
            fclose($handle);
        }

        if(count($assocData) != 0) {
            for ($i = 0; $i < count($assocData); $i++) {
                if ($assocData[$i]["code"] == $stock[0]["code"]) {
                    array_push($filtered_array, $assocData[$i]);
                }

                if (count($filtered_array) >= 10) {
                    break;
                }
            }
        }

        return $filtered_array;
    }
}