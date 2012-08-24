<?php
	class CDLHelper
	{
		//Get an array of tasks for the role, including the tasks for children roles, if any
		public static function getPermissionsArray($role)
		{
		 
		    $retArray = array();
		 
		    if (isset($role))
			{
		        $children = Yii::app()->authManager->getItemChildren($role);
		 
		        foreach ($children as $child) 
				{
		            $type = '';
		            if ($child->type == 1)
					{
						$retArray[$child->name] =  $child->name;
					}
					else
					{
						$retArray = array_merge($retArray, self::getPermissionsArray($child->name));
					}
				}
			}	 
		    return $retArray;
		}
/*
	public static function getPermissionsArray($role, $hierarchy = '') {
	 
	    $retArray = array('operations' => array(), 'roles' => array(), 'tasks' => array());
	 
	    if (isset($role)) {
	        $children = Yii::app()->authManager->getItemChildren($role);
	 
	        foreach ($children as $child) {
	 
	            $type = '';
	            if (!$child->type == CAuthItem::TYPE_OPERATION) { //if the child is a role or task, recurse
	                if ($child->type == CAuthItem::TYPE_ROLE) { //a role
	                    $type = 'roles';
	                } else {//a task
	                    $type = 'tasks';
	                }
	                $retArray = array_merge_recursive($retArray, self::getPermissionsArray(
	                                $child->name, $hierarchy . '|' . $child->name
	                                . ':type=' . $child->type
	                                . ':description=' . $child->description
	                        ));
	            } else { //this is an operation, base level
	                $type = 'operations';
	            }
	 
	            if (substr($hierarchy, 0, 1) == '|') { //removes leading slash
	                $hierarchy = substr($hierarchy, 1);
	            }
	 
	            $retArray[$type][$child->name] = $hierarchy;
	        }
	    }
	 
	    return $retArray;
	}
*/		
	}
?>