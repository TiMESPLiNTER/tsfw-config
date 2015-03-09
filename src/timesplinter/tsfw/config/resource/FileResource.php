<?php

namespace timesplinter\tsfw\config\resource;

use timesplinter\tsfw\config\Config;
use timesplinter\tsfw\config\exception\LoadException;
use timesplinter\tsfw\config\loader\Loader;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2015 by TiMESPLiNTER Webdevelopment
 */
class FileResource implements Resource
{
	protected $filePathPattern;
	/** @var Loader[] */
	protected $fileLoaders;

	public function __construct($filePathPattern)
	{
		$this->filePathPattern = $filePathPattern;
		$this->fileLoaders = array();
	}

	public function load()
	{
		$config = array();

		foreach(glob($this->filePathPattern, GLOB_BRACE) as $filePath) {
			if(($loader = $this->resolveLoader($filePath)) === null)
				throw new LoadException('No available loader can load the file: ' . $filePath);

			$baseDir = dirname($filePath);
			$loadedConfig = $loader->load($filePath);

			if(isset($loadedConfig['imports']) === true) {
				foreach($loadedConfig['imports'] as $import) {
					$importResource = new FileResource($baseDir . DIRECTORY_SEPARATOR . $import);
					$importResource->setLoaders($this->fileLoaders);

					$config = Config::mergeConfigs($config, $importResource->load());
				}

				unset($loadedConfig['imports']);
			}

			$config = Config::mergeConfigs($config, $loadedConfig);
		}

		return $config;
	}

	/**
	 * @param string $filePath
	 * @return Loader|null
	 */
	protected function resolveLoader($filePath)
	{
		foreach($this->fileLoaders as $loader) {
			if($loader->supports($filePath) === false)
				continue;

			return $loader;
		}

		return null;
	}

	/**
	 * @param Loader $loader
	 */
	public function addLoader(Loader $loader)
	{
		$this->fileLoaders[get_class($loader)] = $loader;
	}

	/**
	 * @param Loader[] $loaders
	 */
	public function setLoaders(array $loaders)
	{
		foreach($loaders as $loader) {
			$this->addLoader($loader);
		}
	}
}