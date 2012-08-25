<?php

class m120824_131051_Upgrade_db_for_Caching_and_Many_Many_Relations extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	// Run the yiic migrate command at the command prompt to run this safeUp function
	// This function needs to be called when you have the basic digital_library database (the database setup in the master branch) and want to have
	// caching and many-to-many relations between book and author/category enabled
	public function safeUp()
	{
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
							
		foreach($author as $bookId => $authorId)		
		{
			$aId = intval($authorId);
			$cmd->setText("INSRERT INTO book_author (book_id, author_id) VALUES (:bId, :aId)");
			$cmd->bindParam(":bId", $bookId, PDO::PARAM_INT);
			$cmd->bindParam(":aId", $aId, PDO::PARAM_INT);				
			$cmd->execute();
		}
		
		foreach($category as $bookId => $categoryId)
		{
			$cId = intval($categoryId);
			$cmd->setText("INSRERT INTO book_category (book_id, category_id) VALUES (:bId, :cId)");
			$cmd->bindParam(":bId", $bookId, PDO::PARAM_INT);
			$cmd->bindParam(":cId", $cId, PDO::PARAM_INT);				
			$cmd->execute();
		}
	}


	public function safeDown()
	{
	
		$this->addColumn('book', 'author_id');
		$this->addColumn('book', 'category_id');		
		
		$this->addForeignKey('FK_book_author',		'book', 'author_id',   'author',   'id', 'CASCADE');
		$this->addForeignKey('FK_book_category',	'book', 'category_id', 'category', 'id', 'CASCADE');		
	
		$this->createIndex('FK_books_authors',		'book', 'author_id');	
		$this->createIndex('FK_books_categories',	'book', 'category_id');		
		
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
							
	}
}