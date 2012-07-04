<?php
	class AdminModel
	{
		/**
		*  Issuing a book involves the following steps:
		*	- Inserting a record in the issue table for the book/user
		* 	- Deleting the corresponding request record from the request table
		* 	- Decrementing the available number of copies of the book and updating the respective book record in the book table
		**/
		public function issueBook($requestId, $BookId, $UserId)
		{
			$conn = Yii::app()->db;		
			$trans = $conn->beginTransaction();
			try
			{
				$issueDate = date("y/m/d");
				$dueDate = Date('y/m/d', strtotime("+14 days"));

				$sql = "INSERT INTO issue (user_id, book_id, issue_date, due_date) VALUES (:uId, :bId, :iDate, :dDate)";
				$command = $conn->createCommand($sql);
				$command->bindParam(":uId", $UserId, PDO::PARAM_INT);
				$command->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$command->bindParam(":iDate", $issueDate, PDO::PARAM_STR);	
				$command->bindParam(":dDate", $dueDate, PDO::PARAM_STR);							
				$command->execute();
				
				$sql = "DELETE FROM request WHERE Id = :reqId";
				$command_1 = $conn->createCommand($sql);
				$command_1->bindParam(":reqId", $requestId, PDO::PARAM_INT);
				$command_1->execute();
				
				$sql = "SELECT available_copies FROM book WHERE Id=:bId";
				$command_2 = $conn->createCommand($sql);				
				$command_2->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$availableCopies = $command_2->queryScalar();
				$availableCopies--;
				
				$sql = "UPDATE book SET available_copies=:aCopies WHERE Id=:bId";	
				$command_3 = $conn->createCommand($sql);
				$command_3->bindParam(":aCopies", $availableCopies, PDO::PARAM_INT);
				$command_3->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$command_3->execute();

				$trans->commit();
				$retVal = TRUE;				
			}	
			catch(Exception $e)
			{
				$trans->rollBack();
				$retVal = FALSE;
				
			}
			return $retVal;
		}

		/**
		*  Returning a book involves the following steps:
		*	- Deleting the record from the issue table for the book/user
		* 	- Inecrementing the available number of copies of the book and updating the respective book record in the book table
		**/
		
		public function returnBook($BookId, $UserId)
		{
			$conn = Yii::app()->db;		
			$trans = $conn->beginTransaction();
			try
			{

				$sql = "DELETE FROM issue WHERE user_id = :uId AND  book_id = :bId";
				$command=$conn->createCommand($sql);
				$command->bindParam(":uId", $UserId, PDO::PARAM_INT);
				$command->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$command->execute();
				
				$sql = "SELECT available_copies FROM book WHERE id=:bId";
				$command_2 = $conn->createCommand($sql);				
				$command_2->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$availableCopies = $command_2->queryScalar();
				$availableCopies++;
				
				$sql = "UPDATE book SET available_copies=:aCopies WHERE Id=:bId";	
				$command_3 = $conn->createCommand($sql);
				$command_3->bindParam(":aCopies", $availableCopies, PDO::PARAM_INT);
				$command_3->bindParam(":bId", $BookId, PDO::PARAM_INT);				
				$command_3->execute();

				$trans->commit();
				$retVal = TRUE;				
			}	
			catch(Exception $e)
			{
				$trans->rollBack();
				$retVal = FALSE;
			}
			return $retVal;
		}
	}
?>