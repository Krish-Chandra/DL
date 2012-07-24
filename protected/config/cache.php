<?php

$default = array(
	'class' => 'system.caching.CDummyCache'
);
if(defined('YII_DEBUG') && YII_DEBUG === true)
	return $default;
$cacheOrder = array('CMemCache', 'CApcCache', 'CXCache',  'CZendDataCache', 'CDbCache', 'CFileCache');
$providerInfo = array();
foreach($cacheOrder as $position=>$provider)
{
	switch($provider)
	{
		case 'CMemCache':
			if(class_exists('Memcache', false))
			{
				$providerInfo = array(
					'class' => 'system.caching.'.$provider,
					'servers'=>array(
						array(
							'host'=>'127.0.0.1', 'port'=>11211, 'weight'=>60
						),
					),
					'keyPrefix' => substr(md5(dirname(__FILE__)),1,7),
				);
			}
			break;
		case 'CApcCache':
			if(function_exists('apc_cache_info'))
			{
				$providerInfo = array(
					'class' => 'system.caching.'.$provider,
					'keyPrefix' => substr(md5(dirname(__FILE__)),1,7),
				);
			}
			break;
		case 'CXCache':
			if(function_exists('xcache_get'))
			{
				$providerInfo = array(
					'class' => 'system.caching.'.$provider,
					'keyPrefix' => substr(md5(dirname(__FILE__)),1,7),
				);
			}
			break;
		case 'CZendDataCache':
			if(function_exists('zend_shm_cache_fetch'))
			{
				$providerInfo = array(
					'class' => 'system.caching.'.$provider,
					'keyPrefix' => substr(md5(dirname(__FILE__)),1,7),
				);				
			}		
			break;
		case 'CDBCache':
		case 'CFileCache':
				$providerInfo = array(
					'class' => 'system.caching.'.$provider,
					'keyPrefix' => substr(md5(dirname(__FILE__)),1,7),
				);
			break;
	}
	if(!empty($providerInfo))
		break;
}

return !empty($providerInfo)?$providerInfo:$default;