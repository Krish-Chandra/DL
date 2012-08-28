<?php
//
//
// There are 3 versions of the DL app corresponding to the 3 branches of the app in Git
// Version 1(master branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have only one author and category each.
//	- No support for caching
// Version 2('Caching-and-Many-Many-relations' branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have a maximum of 3 authors and categories each
//	- Caching is enabled
// Version 3('Use-Yii-RBAC'):
//	- Uses Yii's RBAC for access control
//	- Allows the books catalog to be searched based on title or author
//  - Doesn't use the role table. It's there only to make the database backwards compatible
//
//
// Each version has a different database schema
// This version of (Version 2) of the app has 2 migration files
//	- This one needs to be used when you are coming down from Version 3 ('use-Yii-RBAC' branch)
// 		- To use this migration, type: yiic migrate down at the command prompt to make the DB schema in sync with this version, provided:
//			1. You have checked out Version 2 ('Caching-and-Many-Many-relations') of the app
//			2. Your DB schema belongs to Vesion 3 
//
// 
// 	The function does the following:
//		1. Drops the 3 tables required for Yii's RBAC
//
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