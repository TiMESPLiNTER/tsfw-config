<?php
/**
 * Created by PhpStorm.
 * User: Pascal
 * Date: 04.06.14
 * Time: 13:46
 */

namespace timesplinter\config;


interface ConfigCacheStrategyInterface {
    public function store($cacheFileName, $data);
    public function load($cacheFileName);
} 