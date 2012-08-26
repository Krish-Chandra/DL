<?php

class m120826_092147_Migrate_Database extends CDbMigration
{
	public function safeDown()
	{
	
/*		$this->addColumn('book', 'author_id');
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
*/
		$this->dropTable('authassignment');		
		$this->dropTable('authitemchild');		
		$this->dropTable('authitem');
	}

}