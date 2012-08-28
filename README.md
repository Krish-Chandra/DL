Digital Library is a full-fledged web application built using Yii/PHP. The main purpose of coming up with this demo app is to show newbie Yii developers how to use the various Yii features to build a meaningful web application that is different from the obligatory Blog demo that usually accompanies the frameworks.


#About Digital Library:
	An online book store app that has two modules: Admin (back end) and Library(front end).

#Versions of the app:
	There are 3 versions of the DL app corresponding to the 3 branches:
	- Version 1(master branch):
		- Uses PHP script file for authorization data and access control filters for RBAC
		- Allows a book to have only one author and category each.
		- Doesn't support caching
		- Supports database migration
	- Version 2('Caching-and-Many-Many-relations' branch):
		- Uses PHP script file for authorization data and access control filters for RBAC
		- Allows a book to have a maximum of 3 authors and categories each
		- Supports caching
		- Supports database migration
	- Version 3('Use-Yii-RBAC' branch):
		- Uses the database for RBAC
			- There is an admin component for it
		- Allows a book to have a maximum of 3 authors and categories each
		- Supports caching
		- Allows the books catalog to be searched based on title or author
		- Supports database migration
	
##Admin Module:
	Is where the book store is administered

###Admin Module Features:

- Add/update/delete Books, Authors, Publishers, Categories, Admin Users, Admin Roles
- Activate/Deactivate/Delete Members
- View requests for books
- Issue/return of books
			
####Books:

- Add/update/delete books
	- Currently, a book can have only one author, category, and publisher
	- Before adding a book, atleast one author, category, and publisher need to be added to the system
			
####Authors, Publishers and Categories:

- Add/update/delete

####Issues:

- View a list of books issued to the members 
- Delete an issue by flagging it returned

####Requests:

- View a list of requests for books from members
- Issue a book to the respective user thereby removing it from the request list

####Admin Users:

- Are those that administer the system 
- Belong to roles that can be defined by the master admin user (the omnipotent user of the system)
- Can carry out activities as per the access rights assigned to the roles they belong to 
- The DB script that comes with the system automatically creates the master admin user: "administrator" with the password: "admin"
	- This user has full access rights to the system
- Can add/delete admin users
	- Assign the user to a role while adding

####Members:

- Are the public users of the system
- Activate/deactivate/delete members

####Roles:

- Roles determine the activities that can be performed by a user in the system
- The included DB script automatically creates two roles:
	- 'admin'
		- Omnipotent
		- The 'administrator' user belongs to this role
			- Add/delete other admin users and assign roles to them						
	- 'supervisor'						
		- Less powerful than admin
		- Has restricted access to the backend

- View a list of users belonging to a role
	- Change the role for a user


##Library Module:

	Is the frontend of the application that will be used by members

- Members can:
	- View the books catalog
	- Add books to the request cart
	- Checkout the books thereby sending a request to the backend
		- Only registered users can send request for books
	- Contact the administrator (needs to be tested!)
	

###Things that can be learned from studying these versions of the app:

- Yii Module creation
	- Admin and Library
- Authentication and authorization
	- Role based access control (both file- and db-based)
- Enabling and disabling of menu items based on the logged in user's role
- Use of Yii's ORM (Active Record and Relational Active Record) for database access
- Form input and AJAX validation
- Button columns with images in CGridView
- Error handling
- Implementing search
- Database migrations to migrate up/down from one version of the app to the next/previous
- 

###TODO list to make it more feature rich:

####App specific:

- Allowing multiple authors and categories for a book
- Role-based access control is a manual process
	- Need an interface to automate this process
- Concurrency support

####Yii specific:

- Caching 
- Security
- i18n
- Search

####Software Requirements:

- Yii 1.1.9+, PHP 5.3+ and MySQL 5.0+

####Installation:

- Clone or copy the app in a web-accessible folder
- Checkout the submodules if cloned via git or copy/symlink the yii-framework to `./protected/yiiCore/`

	- **Detailed steps for installing the project on local machine:**
		- Using Git:
			- using Git version 1.6.5 or greater
				- git clone --recursive https://github.com/Krish-Chandra/DL.git
			- Using earlier versions of Git
				- git clone https://github.com/Krish-Chandra/DL.git
				- cd DL (DL is the folder in which the project is installed/cloned)
				- git submodule init
				- git submodule update

			- Another way to setup the project 
				- git clone https://github.com/Krish-Chandra/DL.git
				- cd DL\protected
				- git clone https://github.com/yiisoft/yii.git yiiCore

		- Using the Zip files:
			- Download the project zip file, unzip the contents to a web-accessible folder
			- Download the Yii framework zip file from Yii website or GitHub, unzip the conents to './protected/yiiCore/'

- Create the database
- **Go!**