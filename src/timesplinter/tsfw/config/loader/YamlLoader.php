<?php

namespace timesplinter\tsfw\config\loader;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use timesplinter\tsfw\config\exception\LoadException;

class YamlLoader implements Loader
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
           return Yaml::parse($filePath, false, true);
        } catch(ParseException $e) {
            throw new LoadException('Could not parse config data', 0, $e);
        }
    }

	/**
	 * {@inheritdoc}
	 */
	public function supports($filePath)
	{
		return !(is_string($filePath) === false || pathinfo($filePath, PATHINFO_EXTENSION) !== 'yml');
	}
}

/* EOF */