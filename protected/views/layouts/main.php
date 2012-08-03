<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
	
		<!-- blueprint CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen" /> 
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css" media="screen" />  
		<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
		<![endif]-->
	
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		
	</head>
	<body>
	    <div class="container box">
	        <div id="header" class="span-24">
<?php
			if ($this->beginCache("header", array('duration'=>Yii::app()->params['cacheDuration'])))
			{
?>			
				<div class="span-24">
		            <img class="left" alt="Library" src="<?php echo Yii::app()->request->baseUrl; ?>/images/library-icon.png" />
		            <h1>DIGITAL LIBRARY</h1>
				</div>	
<?php	
				$this->endCache();
			}				
			
			/* $this in a view refers to the active controller */
			if (strcasecmp($this->module->name, "admin") == 0)
			{
				if (!Yii::app()->user->isGuest)
				{
					//If the logged in user belongs to the admin role
					$authManager = Yii::app()->authManager;
					$roles = $authManager->getRoles(Yii::app()->user->id);
					if (array_key_exists("admin", array_change_key_case($roles)))
//					if (array_key_exists("admin", $roles))
					{
						if ($this->beginCache("admin_menu", array('duration'=>Yii::app()->params['cacheDuration'])))
						{
					
?>				
						<div id="navigation" class="span-21">
							<ul>
								<li><a href="<?php echo Yii::app()->createUrl('admin/book');?>"><span>Books</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/author');?>"><span>Authors</span></a></li>					
								<li><a href="<?php echo Yii::app()->createUrl('admin/category');?>"><span>Categories</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/issue');?>"><span>Issues</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/publisher');?>"><span>Publishers</span></a></li>					
								<li><a href="<?php echo Yii::app()->createUrl('admin/request');?>"><span>Requests</span></a></li>					
								<li><a href="<?php echo Yii::app()->createUrl('admin/user');?>"><span>Admin Users</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/member');?>"><span>Members</span></a></li>							
								<li><a href="<?php echo Yii::app()->createUrl('admin/role');?>"><span>Roles</span></a></li>							
							</ul>
							
						</div>

<?php
						$this->endCache();
						}
					}
					elseif (array_key_exists("supervisor", array_change_key_case($roles)))					
					//elseif (array_key_exists("supervisor", $roles))  //If (s)he belongs to the supervisor role, allow only restricted access
					{
						if ($this->beginCache("supervisor_menu", array('duration'=>Yii::app()->params['cacheDuration'])))
						{
					
?>					
						<div id="navigation" class="span-21">
							<ul>
								<li><a href="<?php echo Yii::app()->createUrl('admin/book');?>"><span>Books</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/author');?>"><span>Authors</span></a></li>					
								<li><a href="<?php echo Yii::app()->createUrl('admin/category');?>"><span>Categories</span></a></li>
								<li><a href="<?php echo Yii::app()->createUrl('admin/publisher');?>"><span>Publishers</span></a></li>					
							</ul>
						</div>
<?php
						$this->endCache();
						}

					}
						if ($this->beginCache("login_menu", array('duration'=>Yii::app()->params['cacheDuration'])))
						{
					
?>					
					<div id="navigation" class="span-1">
						<ul>
							<li><a href="<?php echo Yii::app()->createUrl('admin/default/logout');?>"><span>Logout</span></a></li>
						</ul>
					</div>
					
<?php
						$this->endCache();
						}

				}
?>
			
<?php				
			}
			elseif (strcasecmp($this->module->name, "library") == 0) //User is accessing the public-facing module
			{
				if (Yii::app()->user->isGuest) //hasn't logged in yet
				{
?>
					<div id="navigation" class="span-21">
						<ul>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/index');?>"><span>Home</span></a></li>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/viewReqCart');?>"><span>Request Cart</span></a></li>
						</ul>
					</div>
					<div id="navigation" class="span-1">
						<ul>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/login');?>"><span>Login</span></a></li>
						</ul>
					</div>
					
<?php				
				}
				else
				{
?>	
					<div id="navigation" class="span-21">
						<ul>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/index');?>"><span>Home</span></a></li>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/viewReqCart');?>"><span>Request Cart</span></a></li>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/Contact');?>"><span>Contact Admin</span></a></li>						
						</ul>
					</div>
					<div id="navigation" class="span-1">
						<ul>
							<li><a href="<?php echo Yii::app()->createUrl('library/default/logout');?>"><span>Logout</span></a></li>
						</ul>
					</div>
			
<?php				
				}
			}
?>			
	        </div>
			<div id="StatusMsg">
<?php
				if (Yii::app()->user->hasFlash('message'))
				{
?> 
					<div class="msg msg-ok push-1 span-21  prepend-top"><p><strong><?php echo Yii::app()->user->getFlash('message');?></strong></p></div>		
<?php			
				}
				elseif (Yii::app()->user->hasFlash('error') )
				{
?>
					<div class="msg msg-error push-1 span-21  prepend-top"><p><strong><?php echo Yii::app()->user->getFlash('error');?></strong></p></div>		
<?php			
				}
				elseif(Yii::app()->user->hasFlash('contact'))			
				{
?>
					<div class="msg msg-ok push-1 span-21  prepend-top">
						<p><strong><?php echo Yii::app()->user->getFlash('contact'); ?></strong></p>
					</div>
<?php				
				}
?>		
			</div>
			<div class='push-1 span-21'>
<?php
				echo $content;  //Display the page content
?> 
			</div>
<?php
			if ($this->beginCache("footer", array('duration'=>Yii::app()->params['cacheDuration'])))
			{
				
?>			
				<div id="footer" class="span-24">
				    <div class="span-5 push-1">
				    	<p>Developed by <b>Krish Chandra</b></> </p>
					</div>
					<div class="span-12 push-7">
						<div>
							Design by <a href="http://chocotemplates.com" target="_blank" title="The Sweetest CSS Templates WorldWide">Chocotemplates.com</a>
							|
							A couple of icons taken from <a href="http://www.famfamfam.com/lab/icons/silk/" target="_blank" title="Silk icon set by Mark James">Silk icon set 1.3</a>
						</div>
					</div>
				</div>
<?php
				$this->endCache();
			}				
?>				
		</div>
	</body>
</html>
