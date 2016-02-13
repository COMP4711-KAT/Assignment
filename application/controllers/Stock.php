<?php

/**
 * This is the stock controller that is used to pass data to the
 * stocks history page.
 * Class Stock
 */
class Stock extends Application {

    /**
     * Stock constructor.
     */
    function __construct() {

        parent::__construct();

        $this->load->model('movements');
        $this->load->model('transactions');
        $this->load->model('stocks');
    }

    /**
     * Shows the most recently moved stock's histroy and transactions
     * made by other players.
     */
    function index(){
        $this->data['pageTitle'] = 'Stocks';
        $this->data['pagebody'] = 'stocks';

        $this->data['stocks_list'] = $this->stocks->all();
        $this->data['stocks'] = $this->movements->some_recent();
        $this->data['transactions'] = $this->transactions->some_recent();

        $this->render();

    }


    /**
     * Shows the selected stock's history and transactions made by players.
     * @param $stockName the name of the stock
     */
    function history($stockName){

        $this->data['pageTitle'] = 'Stocks';
        $this->data['pagebody'] = 'stocks';
        $this->data['stocks_list'] = $this->stocks->all();
        $this->data['stocks'] = $this->movements->some_desc('Code', $stockName);
        $this->data['transactions'] = $this->transactions->some_desc('Stock', $stockName);
        $this->render();
    }

}