<?php 

class Thread_Worker extends Worker {

	public function __construct($name) {
		$this->name = $name;
		$this->data = array();
		$this->setup = false;
		$this->attempts = 0;
	}
	public function run(){
		$this->setName(sprintf("%s (%lu)", $this->getName(), $this->getThreadId()));
	}
	
	public function setSetup($setup){
		$this->setup = $setup;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function addAttempt(){
		$this->attempts++;
	}
	
	public function getAttempts(){
		return $this->attempts;
	}
	
	public function setData($data){
		$this->data = $data;
	}
	
	public function addData($data){
		$this->data = array_merge($this->data, array($data));
	}
	
	public function getData(){
		return $this->data;
	}
}
