<?php
//
// There are 3 versions of the DL app corresponding to the 3 branches of the app in Git
// Version 1(master branch): Allows a book to have only one author and category each. No caching is supported 
// Version 2('Caching-and-Many-Many-relations' branch):
//	- Allows a book to have a maximum of 3 authors and categories each
//	- Caching is enabled
// Version 3
//	- Uses Yii's RBAC for access control
//  - The app's Role component is not used to manage roles
//
// Each version has a different database schema
// This version of (Version 2) of the app has 2 migration files
//	- This one needs to be used when you are coming down from Version 3 (i.e., 'use-Yii-RBAC' branch)
// 		- Type yiic migrate down at the command prompt to make the DB schema to be in sync with this version, provided:
//			1. You have checked out Version 2 ('Caching-and-Many-Many-relations') version of the app
//			2. Your DB schema belongs to Vesion 3 
//
// 
// 	Here the job is easier
//	Just drop the 3 tables required for Yii's RBAC
//

class m120826_092147_Migrate_Database extends CDbMigration
{
	public function safeDown()
	{
	
		$this->dropTable('authassignment');		
		$this->dropTable('authitemchild');		
		$this->dropTable('authitem');
	}

}