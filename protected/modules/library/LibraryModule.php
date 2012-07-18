<?php

class LibraryModule extends CWebModule
{
	public $defaultController = "default";
	public $homeUrl = "";

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array('library.models.*', 'library.components.*'));
		$this->homeUrl = Yii::app()->createUrl('library/default');	

	}
}
