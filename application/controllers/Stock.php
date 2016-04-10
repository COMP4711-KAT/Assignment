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

        $stockName = "APPL";
        $this->data['stocks_list'] = $this->stocks->getCSVStockResults();
        $this->data['movement'] = $this->movements->getCSVMovementResults($stockName);
        $this->data['transactions'] = $this->transactions->getCSVTransactionResults($stockName);

        $this->render();

    }


    /**
     * Shows the selected stock's history and transactions made by players.
     * @param $stockName the name of the stock
     */
    function history($stockName){

        $this->data['pageTitle'] = 'Stocks';
        $this->data['pagebody'] = 'stocks';
        $this->data['stocks_list'] = $this->stocks->getCSVStockResults();
        $this->data['movement'] = $this->movements->getCSVMovementResults($stockName);
        $this->data['transactions'] = $this->transactions->getCSVTransactionResults($stockName);
        $this->render();
    }

}