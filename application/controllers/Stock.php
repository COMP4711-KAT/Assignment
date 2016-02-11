<?php

class Stock extends Application {

    function __construct() {

        parent::__construct();

        $this->load->model('movements');
        $this->load->model('portfolios');
        $this->load->model('stocks');
    }

    function index(){
        $this->data['pageTitle'] = 'Stocks';
        $this->data['pagebody'] = 'stocks';

        $this->data['stocks'] = $this->movements->recent();
        $this->data['stocks_list'] = $this->stocks->all();

        $this->render();

    }


    function stock($stockName){

        $this->data['pageTitle'] = 'Stocks';
        $this->data['pagebody'] = 'stocks';
        $this->data['stocks'] = $this->movements->some_desc( 'Code' ,$stockName);
        $this->data['stocks_list'] = $this->stocks->all();
        $this->data['transactions'] = $this->portfolios->some('Stock', $stockName);
        $this->render();
    }

}