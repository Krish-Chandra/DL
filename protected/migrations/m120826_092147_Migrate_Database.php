<?php
//
//
// There are 3 versions of the DL app corresponding to the 3 branches of the app in Git
// Version 1(master branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have only one author and category each.
//	- Doesn't support caching
// Version 2('Caching-and-Many-Many-relations' branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have a maximum of 3 authors and categories each
//	- Caching is enabled
// Version 3('Use-Yii-RBAC' branch):
//	- Uses Yii's RBAC for access control
//	- Allows the books catalog to be searched based on title or author
//  - Doesn't use the role table
//		- It's there only to make the database backwards compatible
//
//
// Each version has a different database schema
//	- Use this migration when you are coming up from Version 2 ('Caching-and-Many-Many-relations' branch)
// 		- To run this migration, type: yiic migrate at the command prompt to make the DB schema in sync with this version, provided:
//			1. You have checked out Version 3 ('Use-Yii-RBAC') of the app
//			2. Your DB schema belongs to Version 2 
//
//	The function does the following:
//	1. Inserts an 'AdminDefault' role into the Role table
//		By default, any admin user added to the system using this version of the app is assigned to the AdminDefault role - the least privileged role in the system
//		Even though this version of the app doesn't use the role table, the admin_user table's role_id still refers to it
//		In order for an admin user to be successfully added to the system, AdminDefault role has to be added to the role table
//	2. Creates the 3 tables required for Yii RBAC
//
//
class m120826_092147_Migrate_Database extends CDbMigration
{
	public function safeUp()
	{

		//Add the AdminDefault role to the role table
		$this->insert('role', array('rolename' => 'AdminDefault', 'description' => 'The least privileged role in this version of the app. Admin users belonging to this RBAC role have access only to the landing page of the admin module!'));
		$this->createTable('authitem',
								array
								(
									'name' => 'varchar(64) NOT NULL',
									'type' => 'INT(11) NOT NULL',
									'description' => 'text',						
									'bizrule' => 'text',
									'data' => 'text',
									'PRIMARY KEY (name)',
								)
							);
		$this->createTable('authassignment',
							array
							(
							  'itemname' => 'varchar(64) NOT NULL',
							  'userid' => 'mediumint(8) unsigned NOT NULL',
							  'bizrule' => 'text',
							  'data' => 'text',
							  'PRIMARY KEY (itemname,userid)',
							  'KEY FK_authassignment_admin_user (userid)',
							  'CONSTRAINT authassignment_ibfk_1 FOREIGN KEY (itemname) REFERENCES authitem (name) ON DELETE CASCADE ON UPDATE CASCADE',
							  'CONSTRAINT FK_authassignment_admin_user FOREIGN KEY (userid) REFERENCES admin_user (id) ON DELETE CASCADE ON UPDATE CASCADE'
							
							)
						  	
						  );
		$this->createTable('authitemchild',
							array
							(
							  'parent' => 'varchar(64) NOT NULL',
							  'child' => 'varchar(64) NOT NULL',
							  'PRIMARY KEY (parent, child)',
							  'KEY child (child)',
							  'CONSTRAINT authitemchild_ibfk_1 FOREIGN KEY (parent) REFERENCES authitem (name) ON DELETE CASCADE ON UPDATE CASCADE',
							  'CONSTRAINT authitemchild_ibfk_2 FOREIGN KEY (child) REFERENCES authitem (name) ON DELETE CASCADE ON UPDATE CASCADE'
							
							)
						  	
						  );
						  

	}
	public function safeDown()	
	{
		
	}
}