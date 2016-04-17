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

    function get_single_stock($which) {
        $filtered_array = array();
        $assocData = array();
        $headerRecord = array();
        $single_stock = null;
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

        for ($i = 0; $i < count($assocData); $i ++) {
            if($assocData[$i]["code"] == $which) {
                array_push($filtered_array, $assocData[$i]);
                break;
            }
        }

        $single_stock = $filtered_array[0];
        return $single_stock;
    }
}