<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'defaultController'=>'library/default',
	'name'=>'Digital Library',
	'timezone' => 'Asia/Calcutta',
	// preloading 'log' component
	'preload'=>array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.CAdvancedArBehavior',
        'application.modules.srbac.controllers.SBaseController'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
/*		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'test',
			
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),*/
		'admin',
		'library',
        'srbac' => array
        (
            'userclass' => 'User',
            'userid' => 'id',
            'username' => 'username',
            'debug' => false,
            'delimeter'=>"@",
            'pageSize' => 10,
            'superUser' => 'admin',
            'css' => 'srbac.css',
            'layout' => 'application.views.layouts.main',
            'notAuthorizedView' => 'admin.views.default.error',
            'alwaysAllowed'=>array('admin@DefaultLogin', 'admin@DefaultLogout', 'library@DefaultIndex', 'library@DefaultAddtoreqcart',
            						'library@DefaultViewreqcart', 'library@DefaultRemovefromreqcart', 'library@DefaultLogin',
            						'library@DefaultLogout', 'library@DefaultRegister', 'library@DefaultActions'),
            'userActions' => array('show', 'View', 'List', 'Login'),
            'listBoxNumberOfLines' => 15,
            'imagesPath' => 'srbac.images',
            'imagesPack' => 'tango',
            'iconText' => false,
            'header' => 'srbac.views.authitem.header',
            'footer' => 'srbac.views.authitem.footer',
            'showHeader' => true,
            'showFooter' => true,
            'alwaysAllowedPath' => 'srbac.components',
        ),
	
	),

	// application components
	'components'=>array(
        'authManager' => array
        (
            'class' => 'srbac.components.SDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'authitem',
            'assignmentTable' => 'authassignment',
            'itemChildTable' => 'authitemchild',
        ),

		'cache'=>require dirname(__FILE__).'/cache.php',
		'session'=>array('autoStart'=>true,),
		'user'=>array(
			'class'=>'CDLUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' =>'false',
			'caseSensitive' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
	/*	'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=digital_library',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array
		(
			// use 'site/error' action to display errors
            'errorAction'=>'admin/default/error',
        ), 
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@localhost.com',
		'salt'=>'9462e8eee0',
		'cacheDuration' => -1, //Cache for 3 minutes
	),
);