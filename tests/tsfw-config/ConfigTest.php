<?php

namespace timesplinter\test;
use timesplinter\tsfw\config\Config;
use timesplinter\tsfw\config\source\Resource;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $mockConfigSource;

	protected function setUp()
	{
		$this->mockConfigSource = $this->getMockBuilder(Resource::class)->getMock();
	}

	public function testGetValue()
	{
		$sampleArray = array('foo', 'bar', 'baz');

		$configArray = array(
			'string' => 'foo bar',
			'nested' => array(
				'array' => $sampleArray,
				'int' => PHP_INT_MAX
			)
		);

		$this->mockConfigSource->expects($this->any())->method('load')->will($this->returnValue($configArray));

		$config = new Config($this->mockConfigSource);
		$config->load();

		$this->assertEquals('foo bar', $config->get('string'), 'Returns top level value');
		$this->assertEquals($sampleArray, $config->get('nested.array'), 'Returns nested value of type array');
		$this->assertEquals('bar', $config->get('nested.array.1'), 'Returns specific array value');
		$this->assertEquals(PHP_INT_MAX, $config->get('nested.int'), 'Returns nested value of type int');
	}
}

/* EOF */