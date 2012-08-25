<?php
	//To run this console app, type: php index-console.php Create
	class CreateCommand extends CConsoleCommand
	{
		public function run($args)
		{
			$authMgr = Yii::app()->authManager;
			
			$adminRole = $authMgr->createRole('Admin', 'Omnipotent role - Users belonging to this role have full access to the Admin module!');

			$asstRole = $authMgr->createRole('AssistantLibrarian', 'Less powerful than admin role - Users belonging to this role have restricted access to the Admin module!');
			$adminRole->addChild('AssistantLibrarian');

			//AdminDefault is the least privileged admin-module role
			//Every admin-module user belongs to this role by default
			//They are assigned to this role when they are added to the system
			$adminDefRole = $authMgr->createRole('AdminDefault', 'Users belonging to this role have no access to the admin module except the landing page!');			
			//Add AdminDefault as the child of AssistantLibrarian(a child of Admin)
			$asstRole->addChild('AdminDefault');						
			//administrator user is created automatically at the time of database creation
			//Add administrator user to the Admin role
			//Assumes the primaray key value of administrator user row in admin_user table is 1
			$authMgr->assign('Admin', 1);  

			//Create Operations and add them to the appropriate tasks
			//Operation name follows the srbac's default syntax
			$authMgr->createOperation('admin@AuthorIndex', 'View List of Authors');
			$authMgr->createOperation('admin@AuthorCreateAuthor', 'Add a new Author to the Library');
			$authMgr->createOperation('admin@AuthorUpdateAuthor', "Update a Author's Details");			
			$authMgr->createOperation('admin@AuthorDeleteAuthor', 'Delete an Author');

			$authMgr->createOperation('admin@BookIndex', 'View Books Catalog');
			$authMgr->createOperation('admin@BookCreateBook', 'Add a new Book to the Library');
			$authMgr->createOperation('admin@BookUpdateBook', "Update a Book's Details");			
			$authMgr->createOperation('admin@BookdeleteBook', 'Delete a Book');
			
			$authMgr->createOperation('admin@CategoryIndex', 'View List of Categories');
			$authMgr->createOperation('admin@CategoryCreateCategory', 'Add a new Category to the Library');
			$authMgr->createOperation('admin@CategoryUpdateCategory', "Update a Category's Details");			
			$authMgr->createOperation('admin@CategorydeleteCategory', 'Delete a Category');

			$authMgr->createOperation('admin@DefaultError', 'Error Action');
			
			$authMgr->createOperation('admin@IssueIndex', 'View List of Issues');
			$authMgr->createOperation('admin@IssuereturnBook', 'Return a Book to the Library');

			$authMgr->createOperation('admin@PublisherIndex', 'View List of Publishers');
			$authMgr->createOperation('admin@PublisherCreatePublisher', 'Add a new Publisher to the Library');
			$authMgr->createOperation('admin@PublisherUpdatePublisher', "Update a Publisher's Details");			
			$authMgr->createOperation('admin@PublisherdeletePublisher', 'Delete a Publisher');

			$authMgr->createOperation('admin@RequestIndex', 'View List of Requests');
			$authMgr->createOperation('admin@RequestissueBook', 'Issue Book to Member');

			$authMgr->createOperation('admin@MemberIndex', 'View List of Library Members');
			$authMgr->createOperation('admin@MemberupdateMember', "Update a Member's Details");
			$authMgr->createOperation('admin@MemberdeleteMember', 'Delete a Library Member');

			$authMgr->createOperation('admin@UserIndex', 'View List of Admin Users');
			$authMgr->createOperation('admin@UserCreateUser', 'Add an Admin User');
			$authMgr->createOperation('admin@UserupdateUser', "Update an Admin User's details");
			$authMgr->createOperation('admin@UserusersInRole',"View List of Admin Users in a Role");
			$authMgr->createOperation('admin@UserdeleteUser', 'Delete an Admin User');
			
			$authMgr->createOperation('admin@DefaultIndex', 'Landing page for the Admin module!');			
			$authMgr->createOperation('admin@BookSearch', 'Search the Library!');			
			
			$authMgr->createOperation('srbac@DefaultIndex', 'Front page of SRBAC module!');						

			//Create the Tasks and add appropriate operations
			$Ad_Users = $authMgr->createTask('AdminUser', 'Manage(Add/update/delete) Admin Users');
			$Ad_Users->addChild('admin@UserIndex');
			$Ad_Users->addChild('admin@UserCreateUser');
			$Ad_Users->addChild('admin@UserupdateUser');
			$Ad_Users->addChild('admin@UserusersInRole');
			$Ad_Users->addChild('admin@UserdeleteUser');
			
			$Authors = $authMgr->createTask('Author', 'Manage(Add/update/delete) Authors');
			$Authors->addChild('admin@AuthorIndex');
			$Authors->addChild('admin@AuthorCreateAuthor');
			$Authors->addChild('admin@AuthorUpdateAuthor');
			$Authors->addChild('admin@AuthorDeleteAuthor');

			$Books = $authMgr->createTask('Book', 'Manage(Add/update/delete/search) Books in the Library');
			$Books->addChild('admin@BookIndex');
			$Books->addChild('admin@BookCreateBook');
			$Books->addChild('admin@BookUpdateBook');
			$Books->addChild('admin@BookdeleteBook');
			$Books->addChild('admin@BookSearch');
			
			$Cats = $authMgr->createTask('Category', 'Manage(Add/update/delete) Categories');
			$Cats->addChild('admin@CategoryIndex');
			$Cats->addChild('admin@CategoryCreateCategory');
			$Cats->addChild('admin@CategoryUpdateCategory');
			$Cats->addChild('admin@CategorydeleteCategory');

			$Pubs = $authMgr->createTask('Publisher', 'Manage(Add/update/delete) Publishers');
			$Pubs->addChild('admin@PublisherIndex');
			$Pubs->addChild('admin@PublisherCreatePublisher');
			$Pubs->addChild('admin@PublisherUpdatePublisher');
			$Pubs->addChild('admin@PublisherdeletePublisher');

			$Issues	= $authMgr->createTask('Issue', 'Issues Management');
			$Issues->addChild('admin@IssueIndex');
			$Issues->addChild('admin@IssuereturnBook');

			$Mems = $authMgr->createTask('Member', 'Manage(update/delete) Library members');			
			$Mems->addChild('admin@MemberIndex');
			$Mems->addChild('admin@MemberupdateMember');
			$Mems->addChild('admin@MemberdeleteMember');
			
			$Reqs = $authMgr->createTask('Request', 'Requests Management');			
			$Reqs->addChild('admin@RequestIndex');
			$Reqs->addChild('admin@RequestissueBook');

			//Task to allow access to the RBAC module
			$rbac = $authMgr->createTask('Rbac', 'Role-based Access Control Module');			
			$rbac->addChild('srbac@DefaultIndex');

			//Assistant Librarian role is less powerful than admin
			$asstRole->addChild('Author');
			$asstRole->addChild('Book');
			$asstRole->addChild('Category');
			$asstRole->addChild('Publisher');
			
			//admin role is omnipotent
			//Add all the tasks to it
			//No need to add Book, Author, Category and Publisher tasks since they will be inherited from Assistant Librarian(a child of admin)
			$adminRole->addChild('AdminUser');
			$adminRole->addChild('Issue');
			$adminRole->addChild('Member');
			$adminRole->addChild('Request');
			$adminRole->addChild('Rbac');			

			$adminDefRole->addChild('admin@DefaultIndex');
			$adminDefRole->addChild('admin@DefaultError');			
		}
	}
?>
