<?php

class Movements extends MY_Model {

    function __construct() {
        parent::__construct('Movements', 'Datetime');
    }

    // Return filtered records as an array of records
    function some_desc($what, $which) {
        $this->db->order_by($this->_keyField, 'desc');
        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else
            $this->db->where($what, $which);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }
}

