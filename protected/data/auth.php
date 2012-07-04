<?php
return array(
    'admin' => array
	(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Administrator - Only users belonging to this role can access the entire backend',
        'bizRule'=>'',
        'data'=>'',
/*		'assignments'=>array
		(
			'1'=>array('bizRule'=>'', 'data'=>'', ),
		),*/
		
	),
 
    'members' => array
	(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Users belonging to this role can browse the library and make requests for books',
        'bizRule'=>'',
        'data'=>''
    ),
	
    'supervisor' => array
	(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>'Users belonging to this role are less powerful than admin',
        'bizRule'=>'',
        'data'=>''
    ),
/*    'Assistant Librarian' => array
	(
        'type'=>CAuthItem::TYPE_ROLE,
        'description'=>"Don't have any access in the Admin area",
        'bizRule'=>'',
        'data'=>'',
		'assignments'=>array
		(
			'1'=>array('bizRule'=>'', 'data'=>'', ),
		),
		
	),*/
	
 
);

?>