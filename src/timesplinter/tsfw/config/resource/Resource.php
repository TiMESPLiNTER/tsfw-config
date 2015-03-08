<?php

namespace timesplinter\tsfw\config\resource;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
interface Resource
{
	/**
	 * @return array
	 */
	public function load();
}