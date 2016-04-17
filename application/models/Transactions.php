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
        parent::__construct('transactions', 'Player');
    }

    /**
     *
     * Gets the list of transactions made by the player
     * @param $player the player specified
     * @return array list of transactions by player
     */
    function get_player_transactions($player) {
        $this->db->where("Player", $player);
        $query = $this->db->get("transactions");

        if($query->num_rows() != 0){
            return $query->result_array();

        }
        else{
            echo "No results";
        }
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
        $stock = $CI->movements->get_most_recent_stock();
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
            if($assocData[$i]["stock"] == $stock[0]["code"]) {
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
            for ($i = count($assocData) - 1; $i >= 0; $i--) {
                array_push($filtered_array, $assocData[$i]);

                if (count($filtered_array) >= 10) {
                    break;
                }
            }
        }

        return $filtered_array;
    }
}