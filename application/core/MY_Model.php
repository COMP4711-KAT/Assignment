<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Generic data access abstraction.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2014, James L. Parry
 * ------------------------------------------------------------------------
 */
interface Active_record {
//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size();

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields();

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------
    /**
     * Create a new data object.
     * Only use this method if intending to create an empty record and then populate it.
     * @return object   An object with all its fields in place.
     */
    function create();

    /**
     * Add a record to the DB.
     * Request fails if the record already exists.
     * @param mixed $record The record to add, either an object or an associative array.
     */
    function add($record);

    /**
     * Retrieve an existing DB record as an object.
     * @param string $key Primary key of the record to return.
     * @return object The requested record, null if not found.
     */
    function get($key);

    /**
     * Update an existing DB record.
     * Method fails if the record does not exist.
     * @param mixed $record The record to update, either an object or an associative array.
     */
    function update($record);

    /**
     * Delete an existing DB record.
     * Method fails if the record does not exist.
     * @param string $key Primary key of the record to delete.
     */
    function delete($key);

    /**
     * Determine if a record exists.
     * @param string $key Primary key of the record sought.
     * @return boolean True if the record exists, false otherwise.
     */
    function exists($key);

    /**
     * Determine the highest key used.
     * @return string The highest key
     */
    function highest();

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    /**
     * Retrieve all DB records.
     * @return array(object) All the records in the table.
     */
    function all();

    /**
     * Retrieve all DB records, but as a result set.
     * @return mixed The DB query result set.
     */
    function results();

    /**
     * Retrieve some of the DB records, namely those for which the
     * value of the field $what matches $which.
     * @param string    $what   Name of the field being matched.
     * @param   mixed   $which  Value sought.
     * @return mixed The selected records, as an array of records
     */
    function some($what, $which);

}

/**
 * Generic data access model, for an RDB.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2014, James L. Parry
 * ------------------------------------------------------------------------
 */
class MY_Model extends CI_Model implements Active_Record {

    protected $_tableName;            // Which table is this a model for?
    protected $_keyField;             // name of the primary key field

//---------------------------------------------------------------------------
//  Housekeeping methods
//---------------------------------------------------------------------------

    /**
     * Constructor.
     * @param string $tablename Name of the RDB table
     * @param string $keyfield  Name of the primary key field
     */
    function __construct($tablename = null, $keyfield = 'id') {
        parent::__construct();

        if ($tablename == null)
            $this->_tableName = get_class($this);
        else
            $this->_tableName = $tablename;

        $this->_keyField = $keyfield;
    }

//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size() {
        $query = $this->db->get($this->_tableName);
        return $query->num_rows();
    }

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields() {
        return $this->db->list_fields($this->_tableName);
    }

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------
    // Create a new data object.
    // Only use this method if intending to create an empty record and then
    // populate it.
    function create() {
        $names = $this->db->list_fields($this->_tableName);
        $object = new StdClass;
        foreach ($names as $name)
            $object->$name = "";
        return $object;
    }

    // Add a record to the DB
    function add($record) {
        // convert object to associative array, if needed
        if (is_object($record)) {
            $data = get_object_vars($record);
        } else {
            $data = $record;
        }
        // update the DB table appropriately
        $key = $data[$this->_keyField];
        $object = $this->db->insert($this->_tableName, $data);
    }

    // Retrieve an existing DB record as an object
    function get($key) {
        $this->db->where($this->_keyField, $key);
        $query = $this->db->get($this->_tableName);
        if ($query->num_rows() < 1)
            return null;
        return $query->row();
    }

    // Update a record in the DB
    function update($record) {
        // convert object to associative array, if needed
        if (is_object($record)) {
            $data = get_object_vars($record);
        } else {
            $data = $record;
        }
        // update the DB table appropriately
        $key = $data[$this->_keyField];
        $this->db->where($this->_keyField, $key);
        $object = $this->db->update($this->_tableName, $data);
    }

    // Delete a record from the DB
    function delete($key, $key2 = null) {
        $this->db->where($this->_keyField, $key);
        $object = $this->db->delete($this->_tableName);
    }

    // Determine if a key exists
    function exists($key) {
        $this->db->where($this->_keyField, $key);
        $query = $this->db->get($this->_tableName);
        if ($query->num_rows() < 1)
            return false;
        return true;
    }

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    // Return all records as an array of objects
    function all() {
        $this->db->order_by($this->_keyField, 'asc');
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    // Return all records as a result set
    function results() {
        $this->db->order_by($this->_keyField, 'asc');
        $query = $this->db->get($this->_tableName);
        return $query;
    }

    // Return filtered records as an array of records
    function some($what, $which) {
        $this->db->order_by($this->_keyField, 'asc');
        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else
            $this->db->where($what, $which);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    // Determine the highest key used
    function highest() {
        $this->db->select_max($this->_keyField);
        $query = $this->db->get($this->_tableName);
        var_dump($query);
        $result = $query->result();
        var_dump($result);
        if (count($result) > 0)
            return $result[0]->Code;
        else
            return null;
    }

    // Returns most recent records.
    function recent() {
        $this->db->order_by('Datetime', 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }
}
