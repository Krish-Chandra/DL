<?php
	class CDLButtonColumn extends CButtonColumn
	{
		protected function renderDataCellContent($row, $data)
		{
			$grid = $this->grid;			
			if ($grid->id == 'requestsGrid')
			{
				//A Book can't be issued if there are no copies available
	            if($data->book->available_copies < 1) 
					$this->template = ""; //Easy way is to change the column template
				else
					$this->template = "{delete}"; //Set the template otherwise
			}
			elseif ($grid->id == 'rolesGrid')
			{
				//'admin' and 'supervisor' roles can't be deleted
	            if((strcasecmp($data->name, 'admin') == 0) || (strcasecmp($data->name, 'supervisor') == 0)) 
					$this->template = ""; //Easy way is to change the column template
				else
					$this->template = "{update} {delete}"; //Set the template otherwise
			}
			elseif ($grid->id == 'usersGrid')
			{
				//'administrator' user can't be deleted
	            if(strcasecmp($data->username, 'administrator') == 0) 
					$this->template = ""; //Easy way is to change the column template
				else
					$this->template = "{update} {delete}"; //Set the template otherwise
			}
			
			parent::renderDataCellContent($row, $data);	//Let the base class do the rest
		} 
	}
?>