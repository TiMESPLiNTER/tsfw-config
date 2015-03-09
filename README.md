tsfw-config
===========

This component allows you to load settings from different sources. By default it can read YAML, XML, JSON, INI and native PHP config files.

But you can easily extend the component to read configurations from a database or a webservice.

```php
<?php

$resource = new FileResource('../configs/*.yml');
$resource->setLoaders(array(
	new YamlLoader()
));

$config = new Config($resource);

$config->load();

echo $config->get('selector.for.value');
```