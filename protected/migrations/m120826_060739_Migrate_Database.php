<?php
//
// There are 3 versions of the DL app corresponding to the 3 branches of the app in Git
// Version 1(master branch): Allows a book to have only one author and category only. No caching is supported 
// Version 2('Caching-and-Many-Many-relations' branch):
//	- Allows a book to have a maximum of 3 authors and categories each
//	- Caching is enabled
// Version 3
//	- Uses Yii's RBAC for access control
//  - The app's Role component is not used to manage roles
// Each version has a different database schema
// You have to run yiic migrate down to run this safeDown function to bring the database to be in sync with Version 1 of the app provided
//	1. You have currently checked out the master branch of the app
//  2. Your database schema belongs to Version 2 of the app
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