<?php

class Users extends MY_Model {
    public function __construct() {
        parent::__construct('users', 'id');
    }
}