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
	
	public function orderqueueAction(){
	
		$this->view->aOrders = $this->_model->getOrderQueueView();
		$this->view->queueStats = $this->_model->getQueueStats();
		$this->view->show(__FUNCTION__);
	}

	public function viewrecordAction(){		

		$this->view->aOrder = $this->_model->getOrderInfo( $this->params['q']);
		//$this->nstestAction( $this->_model->getOrderInfo( $this->params['q']) );
		$this->view->show(__FUNCTION__);
	}

}

