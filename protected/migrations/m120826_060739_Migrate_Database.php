<?php
//
//
// There are 3 versions of the DL app corresponding to the 3 branches of the app in Git
// Version 1(master branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have only one author and category each
//	- Doesn't support caching
//
// Version 2('Caching-and-Many-Many-relations' branch):
//	- Uses PHP script file for authorization data and access control filters for RBAC
//	- Allows a book to have a maximum of 3 authors and categories each
//	- Caching is enabled
//
// Version 3('Use-Yii-RBAC'):
//	- Uses Yii's RBAC for access control
//	- Allows the books catalog to be searched based on title or author
//  - Doesn't use the role table. It's there only to make the database backwards compatible
//
// Each version has a different database schema
//	- This migration needs to be used when you are coming down from Version 2 of the app
//		To run this migration, type: yiic migrate down at the command prompt to bring the database to be in sync with Version 1 of the app provided
//			1. You have currently checked out Version 1 of the app
//  		2. Your database schema belongs to Version 2 of the app
//
//	Note of Caution: Version 2 of the app supports MANY_MANY relations between book and author/category, meaning a book can have mutiple authors(a max of 3)
//	and can fall into multiple categories (again a max of 3). Version 1, on the other hand, restricts a book to have only one author and Category.
//	So, when you migrate down from Version 2 to Version 1, there will be loss of info - a book that has multiple authors and categories will be forced to 
//	have only one author and category each. 
//
//	The function does the following:
//		1. Adds columns author_id and category_id back to the book table (instead of MANY_MANY, we now have a BELONGS_TO relation)
//		2. Adds indexes and foreign key constraints to these two columns
//		3. Queries the book and author info from the junction table and updates the corresponding book with the first author it retrieves
//		4. Does the same thing for categories
// 		5. Drops the update_time col from all tables (needed for caching in Version 2)
//		6. Drops the two junction tables
//
//
class m120826_060739_Migrate_Database extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
/*	public function safeUp()
	{
	
	}*/

	public function safeDown()
	{
	
		$this->addColumn('book', 'author_id', 'int(10) unsigned NOT NULL');
		$this->addColumn('book', 'category_id', 'int(10) unsigned NOT NULL');		
		
		$this->createIndex('FK_books_authors',		'book', 'author_id');	
		$this->createIndex('FK_books_categories',	'book', 'category_id');		

		$conn = Yii::app()->db;		
		$sql = "SELECT book_id, author_id  FROM book_author";
		$cmd = $conn->createCommand($sql);				
		$reader = $cmd->query();
		$reader->bindColumn(1, $bookId);
		$reader->bindColumn(2, $authorId);		
		$cmd->setText("UPDATE book SET author_id=:aId WHERE id=:bId");											
		$bId = 0;
		
		while($reader->read())
		{
			if ($bId == $bookId)
				continue;
			$aId = intval($authorId);
			$bId = intval($bookId);
			$cmd->bindParam(":bId", $bId, PDO::PARAM_INT);
			$cmd->bindParam(":aId", $aId, PDO::PARAM_INT);				
			$cmd->execute();
		}		

		$cmd->setText("SELECT book_id, category_id  FROM book_category");
		//$cmd = $conn->createCommand($sql);				
		$reader = $cmd->query();
		$reader->bindColumn(1, $bookId);
		$reader->bindColumn(2, $categoryId);		
		$cmd->setText("UPDATE book SET category_id=:cId WHERE id=:bId");											
		$bId = 0;
		
		while($reader->read())
		{
			if ($bId == $bookId)
				continue;
			$cId = intval($categoryId);
			$bId = intval($bookId);
			$cmd->bindParam(":bId", $bId, PDO::PARAM_INT);
			$cmd->bindParam(":cId", $cId, PDO::PARAM_INT);				
			$cmd->execute();
		}		
		
		$this->dropColumn('author',		'update_time');	
		$this->dropColumn('book',		'update_time');
		$this->dropColumn('admin_user', 'update_time');		
		$this->dropColumn('category',	'update_time');		
		$this->dropColumn('issue',		'update_time');		
		$this->dropColumn('publisher',	'update_time');	
		$this->dropColumn('request',	'update_time');
		$this->dropColumn('role',		'update_time');	
		$this->dropColumn('user',		'update_time');			
		
		$this->dropTable('book_author');
		$this->dropTable('book_category');
							
		$this->addForeignKey('FK_book_author',		'book', 'author_id',   'author',   'id', 'CASCADE');
		$this->addForeignKey('FK_book_category',	'book', 'category_id', 'category', 'id', 'CASCADE');		
	}
}