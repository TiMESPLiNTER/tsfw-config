<?php

namespace timesplinter\tsfw\config\loader;

use timesplinter\tsfw\common\JsonException;
use timesplinter\tsfw\common\JsonUtils;
use timesplinter\tsfw\config\exception\LoadException;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
class JsonLoader implements Loader
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
	    try {
		    return JsonUtils::decodeFile($filePath, true);
	    } catch(JsonException $e) {
		    throw new LoadException('Could not parse JSON data', 0, $e);
	    }
    }

	/**
	 * {@inheritdoc}
	 */
	public function supports($filePath)
	{
		return !(is_string($filePath) === false || pathinfo($filePath, PATHINFO_EXTENSION) !== 'json');
	}
}

/* EOF */