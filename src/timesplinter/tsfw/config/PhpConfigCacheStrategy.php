<?php
/**
 * Created by PhpStorm.
 * User: Pascal
 * Date: 04.06.14
 * Time: 13:48
 */

namespace timesplinter\config;


class PhpConfigCacheStrategy implements ConfigCacheStrategyInterface {
    protected $cacheBaseDir;

    public function __construct($cacheBaseDir) {
        $this->cacheBaseDir = $cacheBaseDir;
    }

    public function store($cacheFileName, $data) {
        $cacheFilePath = $this->cacheBaseDir . $cacheFileName;

        file_put_contents($cacheFilePath, '<?php $configCache = ' . var_export($data, true) . ';');
    }

    public function load($cacheFileName, $lastConfigChange = null) {
        $cacheFilePath = $this->cacheBaseDir . $cacheFileName;
        $configCache = null;

        if(file_exists($cacheFilePath) === false)
            return $configCache;

        if($lastConfigChange !== null && $lastConfigChange > filectime($cacheFilePath))
            return $configCache;

        require $cacheFilePath;

        return $configCache;
    }
}