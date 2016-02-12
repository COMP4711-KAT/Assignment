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
        parent::__construct('Movements', 'Datetime');
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
     * Returns a row of the recently moved stock.
     * @return mixed an array containing one object
     */
    function recent() {
        $this->db->order_by($this->_keyField, 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }
}

