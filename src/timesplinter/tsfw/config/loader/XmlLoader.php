<?php

namespace timesplinter\tsfw\config\loader;

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
		$json = json_encode($xml);

		return json_decode($json, true);
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