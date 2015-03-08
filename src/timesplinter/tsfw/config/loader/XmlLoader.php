<?php

namespace timesplinter\tsfw\config\loader;

use timesplinter\tsfw\common\StringUtils;
use timesplinter\tsfw\config\exception\LoadException;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
class XmlLoader implements Loader
{
	/**
	 * @param string $filePath
	 *
	 * @return array
	 *
	 * @throws LoadException
	 */
	public function load($filePath)
	{
		$xml = simplexml_load_file($filePath, null, LIBXML_NOCDATA);

		return $this->loadRecursive($xml);
	}

	protected function loadRecursive(\SimpleXMLElement $xml)
	{
		$config = array();

		foreach($xml as $section => $data) {
			/** @var \SimpleXMLElement $data */
			if($data->count() === 0) {
				// leaf
				$strValue = (string)$data;

				$config[$section] = StringUtils::isInt($strValue) ? (int) $strValue : (StringUtils::isFloat($strValue) ? (float) $strValue : $strValue);
			} else {
				// collection
				$config[$section][] = $this->loadRecursive($data);

				if(is_array($config[$section][0]) === false || count($config[$section][0]) !== 1 || is_array($config[$section][0][key($config[$section][0])]) === false)
					continue;

				$config[$section] = $config[$section][0][key($config[$section][0])];
			}
		}

		return $config;
	}

	/**
	 * @param string $filePath
	 *
	 * @return array
	 */
	public function supports($filePath)
	{
		return !(is_string($filePath) === false || pathinfo($filePath, PATHINFO_EXTENSION) !== 'xml');
	}
}

/* EOF */