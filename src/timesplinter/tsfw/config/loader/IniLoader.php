<?php

namespace timesplinter\tsfw\config\loader;

use timesplinter\tsfw\config\exception\LoadException;

class IniLoader implements Loader
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
        if(($iniData = parse_ini_file($filePath, true)) === false)
	        throw new LoadException('Cold not parse INI file: ' . $filePath);

	    return $iniData;
    }

	/**
	 * {@inheritdoc}
	 */
	public function supports($filePath)
	{
		return !(is_string($filePath) === false || pathinfo($filePath, PATHINFO_EXTENSION) !== 'ini');
	}
}

/* EOF */