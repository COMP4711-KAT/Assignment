<?php
/**
 * The Stocks model is responsible for the stocks table in the database.
 */
class Stocks extends MY_Model {
    /**
     * Stocks constructor.
     * Takes the table name (Stocks) and primary key (Stock) as arguments.
     */
    function __construct() {
        parent::__construct('Stocks', 'Code');
    }
}