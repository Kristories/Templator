<?php

class TemplatorTest extends \PHPUnit_Framework_TestCase {

	// To be continued..
	public function testTemplator()
	{
		$templator 	= new \Templator\Templator();
		$check 		= is_object($templator);

		$this->assertTrue($check);
	}

}