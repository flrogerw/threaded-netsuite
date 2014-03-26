<?php
interface Netsuite_Interface_IRecord
{
	
    public function run();
    public function isOk();
    public function getErrors();

}