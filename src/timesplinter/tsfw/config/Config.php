<?php

namespace timesplinter\tsfw\config;

use timesplinter\tsfw\config\resource\Resource;

class Config
{
	/** @var Resource[] */
	protected $resources;
	protected $loadedConfig;
	/** @var ConfigCacheStrategyInterface */
	protected $cacheStrategy;

	/**
	 * @param Resource|Resource[] $resources
	 */
	public function __construct($resources)
	{
		$this->resources = is_array($resources) ? $resources : array($resources);
	}

	public function load()
	{
		$this->loadedConfig = array();

		foreach($this->resources as $resource) {
			$this->loadedConfig = array_merge_recursive($resource->load(), $this->loadedConfig);
		}
	}

	/**
	 * @param string $key The array to the config value using dots (.) to separate levels
	 * @return mixed The corresponding value
	 */
	public function get($key)
	{
		return array_reduce(
			explode('.', $key),
			function (array $value, $key) {
				return $value[$key];
			},
			$this->loadedConfig
		);
	}

	/**
	 * @param ConfigCacheStrategyInterface $cacheStrategy
	 */
	/*public function setCacheStrategy(ConfigCacheStrategyInterface $cacheStrategy)
	{
	    $this->cacheStrategy = $cacheStrategy;
	}*/
}

/* EOF */