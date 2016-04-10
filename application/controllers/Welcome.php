<?php

/**
 * Our homepage. Show a table of all the author pictures. Clicking on one should show their quote.
 * Our quotes model has been autoloaded, because we use it everywhere.
 *
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();

        $this->load->model('stocks');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['pageTitle'] = 'Homepage';
        // this is the view we want shown
        $this->data['pagebody'] = 'homepage';

        $this->data['players'] = $this->players->all();
        $this->data['stocks'] = $this->stocks->all();

        $this->render();
    }
}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */