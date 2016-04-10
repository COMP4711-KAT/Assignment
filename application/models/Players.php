<?php
/**
 * The Players model is responsible for the players table in the database.
 */
class Players extends MY_Model {
    /**
     * Players constructor.
     * Takes the table name (Players) and primary key (Player) as arguments.
     */
    function __construct() {
        parent::__construct('Players', 'UserId');
    }
}