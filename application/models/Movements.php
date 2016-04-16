<?php

/**
 * The Movements model is responsible for the movements table in the database.
 */
class Movements extends MY_Model {

    /**
     * Movements constructor.
     * Takes the table name (Movements) and primary key (Datetime) as arguments.
     */
    function __construct() {
        parent::__construct('movements', 'Datetime');
    }

    /**
     * Return query result as an array of objects in descending order.
     * @param $what the column of the table
     * @param $which the value it looks for in the table
     * @return mixed array of objects found within table
     */
    function some_desc($what, $which) {
        $this->db->order_by($this->_keyField, 'desc');
        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else
            $this->db->where($what, $which);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    /**
     * Uses the recent movement of a stock and gets the history of that stock.
     * @return mixed array of objects that relate to recent movement
     */
    function some_recent() {
        $stock = $this->recent();
        $this->db->order_by($this->_keyField, 'desc');
        $this->db->where('Code', $stock[0]->Code); // special treatment for period
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    /**
     * Gets the most recent stock
     * @return array most recent stock
     */
    public function get_most_recent_stock() {
        $max = -1;
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        $index_of_recent = 0;
        if( ($handle = fopen( "http://bsx.jlparry.com/data/movement", "r")) !== FALSE) {
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
            for ($i = 0; $i < count($assocData); $i ++) {
                if($assocData[$i]["datetime"] > $max) {
                    $max = $assocData[$i]["datetime"];
                    $index_of_recent = $i;
                }
            }

            array_push($filtered_array, $assocData[$index_of_recent]);
        }

        return $filtered_array;
    }

    /**
     * Gets the list of movements according to a specified stock
     * @param $which the stock specified
     * @return array list of movements related to stock
     */
    function get_movements($which) {

        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/movement", "r")) !== FALSE) {
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
            if($assocData[$i]["code"] == $which) {
                array_push($filtered_array, $assocData[$i]);
            }
        }

        return $filtered_array;
    }

    /**
     * Gets the list of movements of stocks in which it was the most recent
     * @return array list of stocks that was most recent
     */
    function get_most_recent_movements_stock() {
        $CI = & get_instance();
        $stock = $CI->movements->get_most_recent_stock();
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/movement", "r")) !== FALSE) {
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
     * Gets the list of movements of stocks in which it was the most recent
     * @return array list of stocks that was most recent
     */
    function get_most_recent_movements_stock_home() {
        $assocData = array();
        $headerRecord = array();
        $filtered_array = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/movement", "r")) !== FALSE) {
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
            for ($i = count($assocData) - 1; $i >= 0; $i --) {
                array_push($filtered_array, $assocData[$i]);

                if(count($filtered_array) >= 10) {
                    break;
                }
            }

        }

        return $filtered_array;
    }
}

