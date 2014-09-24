<?php
require_once('Aco_DataGrid.php');
$dataGrid = new Aco_DataGrid;


class PruebaTest extends PHPUnit_Framework_TestCase
{	

	protected $datagrid;

	protected function setUp(){
		$this->datagrid = new Aco_DataGrid;
	}

	/**
     * @covers Aco_DataGrid::test_1
     */
    public function test_1()
    {
        $this->assertTrue( $this->datagrid->test_1() );
    }

    public function testPrueba2()
    {
        $this->assertTrue(true);
    }
}