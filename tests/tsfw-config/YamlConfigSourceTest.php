<?php

namespace timesplinter\test;

use timesplinter\tsfw\config\ConfigException;
use timesplinter\tsfw\config\source\YamlConfigResource;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
class YamlConfigSourceTest extends \PHPUnit_Framework_TestCase
{
	public function testLoadInvalidFile()
	{
		$this->setExpectedException(ConfigException::class);

		$configSource = new YamlConfigResource(__DIR__ . '/../configs/not/existing/sample.yml');
		$configSource->load();
	}

	public function testLoadValidFile()
	{
		$configSource = new YamlConfigResource(__DIR__ . '/../configs/sample.yml');

		$expectedConfig = array(
			'receipt' => 'Oz-Ware Purchase Invoice',
			'date' => 1344204000,
			'customer' => array(
			    'given' => 'Dorothy',
			    'family' => 'Galer'
			)
		);

		$this->assertEquals($expectedConfig, $configSource->load(), 'Test parsing');
	}
}