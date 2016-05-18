<?php 
class Thread_Pool {

	/**
	 *  Hold worker threads 
	 */
	public $workers;

	/* to hold exit statuses */
	public $status;

	/**
	 *  prepare $size workers
	 *  
	 *  @param int $size
	 *  @return void 
	 */
	public function __construct( $size = 10 ) {
		$this->size = $size;
	}

	/** 
	 *  Submit Stackable to Worker
	 *  
	 *   @return mixed
	 */
	public function submit( Stackable $stackable ) {
		
		if (count($this->workers)<$this->size) {
			$id = count($this->workers);
			$this->workers[$id] = new Thread_Worker(sprintf("Worker [%d]", $id));
			$this->workers[$id]->start();

			if ($this->workers[$id]->stack($stackable)) {
				return $stackable;
				//return $id;
			} else trigger_error(sprintf("failed to push Stackable onto %s", $this->workers[$id]->getName()), E_USER_WARNING);
		}
		if (($select = $this->workers[array_rand($this->workers)])) {

			if ($select->stack($stackable)) {
				return $stackable;
				//return $id;
			} else trigger_error(sprintf("failed to stack onto selected worker %s", $select->getName()), E_USER_WARNING);
		} else trigger_error(sprintf("failled to select a worker for Stackable"), E_USER_WARNING);

		return false;
	}

	/** Shutdown the pool of threads cleanly, 
	 * retaining exit status locally 
	 * 
	 * @access public
	 * @return void
	 */
	public function shutdown() {
		foreach($this->workers as $worker) {
			$this->status[$worker->getThreadId()]=$worker->shutdown();
		}
	}
}