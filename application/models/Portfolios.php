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

}