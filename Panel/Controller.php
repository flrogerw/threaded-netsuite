<?php

/**
 *
 * @author gWilli
 *
 */
class Panel_Controller {

	protected $_model;

	public function __construct( $params ){
		$this->params = $params;
		$this->_model = new Panel_Model();
		$this->view = new Panel_View();
	}
	
	public function userlogAction(){
		$this->view->aOrders = $this->_model->getUserLogView();
		$this->view->queueStats = $this->_model->getUserStats();
		$this->view->show(__FUNCTION__);
	}

	public function indexAction(){

		$this->view->aOrders = $this->_model->getProcessLogView();
		$this->view->queueStats = $this->_model->getProcessStats();
		$this->view->show(__FUNCTION__);
	}
	
	public function searchAction(){

		$this->view->aOrders = $this->_model->getSearchLogView( '%'.$this->params['q'].'%' );
		$this->view->queueStats = $this->_model->getProcessStats();
		$this->view->show('indexAction');
	}
	
	public function posAction(){
	
		$this->view->show('indexAction');
	}
	
	public function orderqueueAction(){
	
		$this->view->aOrders = $this->_model->getOrderQueueView();
		$this->view->queueStats = $this->_model->getQueueStats();
		$this->view->show(__FUNCTION__);
	}

	public function viewrecordAction(){
				
		$aOrder = $this->_model->getOrderInfo( $this->params['q']);
		$this->view->aOrder = json_decode($aOrder[0]['order_json'], true);
		$this->view->aCustomer = json_decode($aOrder[0]['customer_json'], true);
		$this->view->show(__FUNCTION__);
	}

}

