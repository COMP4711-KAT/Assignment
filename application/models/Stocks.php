<?php
/**
 * The Stocks model is responsible for the stocks table in the database.
 */
class Stocks extends MY_Model {
    /**
     * Stocks constructor.
     * Takes the table name (stocks) and primary key (Stock) as arguments.
     */
    function __construct() {
        parent::__construct('stocks', 'Code');
    }

    /**
     * Gets active stocks from BSX server
     * @return array list of active stocks from server
     */
    function get_stocks() {

        $assocData = array();
        $headerRecord = array();
        if( ($handle = fopen( "http://bsx.jlparry.com/data/stocks", "r")) !== FALSE) {
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

        return $assocData;
    }

    /**
     * Gets the most recent stock
     * @return array most recent stock
     */
    function get_most_recent_stock() {
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

        for ($i = 0; $i < count($assocData); $i ++) {
            if($assocData[$i]["datetime"] > $max) {
                $max = $assocData[$i]["datetime"];
                $index_of_recent = $i;
            }
        }

        array_push($filtered_array, $assocData[$index_of_recent]);

        return $filtered_array;
    }
}