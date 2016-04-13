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
}