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
//	- This one needs to be used when you are coming up from Version 1 (i.e., master branch)
// 		- Type yiic migrate up 1 at the command prompt to make the DB schema to be in sync with this version, provided:
//			1. You have checked out Version 2 ('Caching-and-Many-Many-relations') version of the app
//			2. Your DB schema belongs to Vesion 1 (master)
//
// 
// 	Since this version supports Many_Many relations, the author_id and category_id columns in book table are no longer useful. Now there are 2
//	junction tables - one for book/author and the other for book/category. 
//
//	The function does the following:
//	1. Reads the values of these 2 columns from the book 
//	2. Dros those 2 columns from the book table
//	3. Creates 2 junction tables
//	4. Inserts values obtained in step 1 into the appropriate tables
//
class m120826_060739_Migrate_Database extends CDbMigration
{


	public function safeUp()
	{
		$author = array();
		$category = array();
		
		$conn = Yii::app()->db;		
		$sql = "SELECT id, author_id, category_id  FROM book";
		$cmd = $conn->createCommand($sql);				
		$reader = $cmd->query();
		$reader->bindColumn(1, $bookId);
		$reader->bindColumn(2, $authorId);		
		$reader->bindColumn(3, $categoryId);
		while($reader->read())
		{
			$author[$bookId]	= $authorId;
			$category[$bookId]	= $categoryId;
		}

			
		$this->dropForeignKey('FK_book_author',		'book');
		$this->dropForeignKey('FK_book_category',	'book');		
	
		$this->dropIndex('FK_books_authors',	'book');
		$this->dropIndex('FK_books_categories', 'book');		
		
		$this->dropColumn('book', 'author_id');
		$this->dropColumn('book', 'category_id');		
		
		$this->addColumn('author',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');	
		$this->addColumn('book',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
		$this->addColumn('admin_user',	'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');		
		$this->addColumn('category',	'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');		
		$this->addColumn('issue',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');		
		$this->addColumn('publisher',	'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');	
		$this->addColumn('request',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
		$this->addColumn('role',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');	
		$this->addColumn('user',		'update_time', 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');			
		
		$this->createTable('book_author',
								array
								(
									'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
									'book_id' => 'INT(10) UNSIGNED NOT NULL',
									'author_id' => 'INT(10) UNSIGNED NOT NULL',						
									'PRIMARY KEY (id)',
									'INDEX FK_book_author_book (book_id)',
									'INDEX FK_book_author_author (author_id)',
									'CONSTRAINT FK_book_author_author FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE',
									'CONSTRAINT FK_book_author_book FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE',
								)
							);
		$this->createTable('book_category',
								array
								(
									'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
									'book_id' => 'INT(10) UNSIGNED NOT NULL',
									'category_id' => 'INT(10) UNSIGNED NOT NULL',						
									'PRIMARY KEY (id)',
									'INDEX FK_book_category_book (book_id)',
									'INDEX FK_book_category_category (category_id)',
									'CONSTRAINT FK_book_category_book FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE',
									'CONSTRAINT FK_book_category_category FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE',
								)
							);

		$cmd->setText("INSERT INTO book_author (book_id, author_id) VALUES (:bId, :aId)");											
		foreach($author as $bookId => $authorId)		
		{
			$aId = intval($authorId);
			$bId = $bookId;
			$cmd->bindParam(":bId", $bId, PDO::PARAM_INT);
			$cmd->bindParam(":aId", $aId, PDO::PARAM_INT);				
			$cmd->execute();
		}
			
		$cmd->setText("INSERT INTO book_category (book_id, category_id) VALUES (:bId, :cId)");		
		foreach($category as $bookId => $categoryId)
		{
			$cId = intval($categoryId);
			$cmd->bindParam(":bId", $bookId, PDO::PARAM_INT);
			$cmd->bindParam(":cId", $cId, PDO::PARAM_INT);				
			$cmd->execute();
		}
	}
}