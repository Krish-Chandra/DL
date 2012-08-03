<?php
	class CDLDataColumn extends CDataColumn
	{
		protected function renderDataCellContent($row, $data)
		{
			if (strcasecmp($this->name, "Categories") == 0 )
			{
				$count = sizeof($data->categories);
				$catValue = $data->categories[0]->categoryname;
				for ($indx = 1; $indx < $count - 1; $indx++)
				{
					$catValue .= '<br/>' . $data->categories[$indx]->categoryname;
				}
				if ($indx == ($count - 1))
					echo $catValue . '<br/>' . $data->categories[$indx]->categoryname;
				else
					echo $catValue;
			}
			else if (strcasecmp($this->name, "Authors") == 0 )
			{
				$count = sizeof($data->authors);
				$authValue = $data->authors[0]->authorname;
				for ($indx = 1; $indx < $count - 1; $indx++)
				{
					$authValue .= '<br/>' . $data->authors[$indx]->authorname;
				}
				if ($indx == ($count - 1))
					echo $authValue . '<br/>' . $data->authors[$indx]->authorname;
				else
					echo $authValue;
			}
		} 
	}
?>