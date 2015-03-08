<?php

namespace timesplinter\tsfw\config\loader;

class PhpLoader implements Loader
{
	/**
	 * @param string $filePath
	 *
	 * @return array
	 */
    public function load($filePath)
    {
        $config = array();

	    require $filePath;

	    return $config;
    }

	/**
	 * {@inheritdoc}
	 */
	public function supports($filePath)
	{
		return !(is_string($filePath) === false || pathinfo($filePath, PATHINFO_EXTENSION) !== 'php');
	}
}

/* EOF */