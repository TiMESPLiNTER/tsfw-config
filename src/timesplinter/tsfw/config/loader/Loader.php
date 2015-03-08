<?php

namespace timesplinter\tsfw\config\loader;

use timesplinter\tsfw\config\exception\LoadException;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
interface Loader
{
	/**
	 * @param mixed $resource
	 *
	 * @return array
	 *
	 * @throws LoadException
	 */
	public function load($resource);

	/**
	 * @param mixed $resource
	 *
	 * @return array
	 */
	public function supports($resource);
}

/* EOF */