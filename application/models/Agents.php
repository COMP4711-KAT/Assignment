<?php
/**
 * The Agents model is responsible for the agents table in the database.
 */
class Agents extends MY_Model {
    /**
     * Agents constructor.
     * Takes the table name (agents) and primary key (id) as arguments.
     */
    function __construct() {
        parent::__construct('agents', 'id');
    }
}