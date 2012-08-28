New Features in this branch:
- Extends the 'Cacing-and-Many-Many-relations' version of the app with the following:
	- Use of YII's db-based RBAC for authorization(srbac extension is used to implement this feature)
	- Search the books catalog by author or title
	
####Instructions to switch to this branch:
	- Follow the installation instructions mentioned in the README doc of master branch to install the app
	- cd DL
	- Run: Git checkout 'Use-Yii-RBAC'
	- There are two ways to set up the database for this branch:
	    - Clean install of the database:
	        - Run the DL_MySQL.sql script to set up the database
	    - Already have the database for the 'Caching-and-Many-Many-relations' version of the app and you want to migrate it up to this version:
	        - CD protected
	        - Run: yiic migrate
	            - If migration is successful, the database will be in sync with this version of the app
	        - CD .. (if you are in protected folder)
	- Run: php index-console.php Create 
		- To populate the database with default roles, tasks, operations, etc.
	- **Go!**