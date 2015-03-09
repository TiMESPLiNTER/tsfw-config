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
			$this->loadedConfig = self::mergeConfigs($this->loadedConfig, $resource->load());
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

	public function getAll()
	{
		return $this->loadedConfig;
	}
	
	/**
	 * @param ConfigCacheStrategyInterface $cacheStrategy
	 */
	/*public function setCacheStrategy(ConfigCacheStrategyInterface $cacheStrategy)
	{
	    $this->cacheStrategy = $cacheStrategy;
	}*/

	/**
	 * Merges two config arrays recursive
	 * 
	 * @param array $oldConfig
	 * @param array $newConfig
	 *
	 * @return array
	 */
	public static function mergeConfigs($oldConfig, $newConfig)
	{
		foreach($newConfig as $key => $value) {
			$newValue = $value;
			
			if(is_int($key) === true) {
				$oldConfig[] = $newValue;
			} else {
				if(is_array($value) === true) {
					$newValue = isset($oldConfig[$key]) ? self::mergeConfigs($oldConfig[$key], $value) : $value;
				}
				
				$oldConfig[$key] = $newValue;
			}
		}
			
		reset($oldConfig);
		
		return $oldConfig;
	}
}

/* EOF */