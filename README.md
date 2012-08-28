New Features in this branch:
- MANY_MANY relationships between a book and its authors and categories
	- A book can have upto 3 authors and 3 categories (CAdvancedArBehavior extension is used to implement this feature)

- Caching 
	- Is implemented in this branch
	- Duration is specified in the main.php config file

####Instructions to switch to this branch:
	- Follow the installation instructions mentioned in the README doc of master branch to install the app
	- cd DL
	- Run: Git checkout 'Caching-and-Many-Many-relations'
	- There are two ways to set up the database for this branch:
		- Clean install of the database:
			- Run the DL_MySQL.sql script to set up the database
		- Already have the database for the master version of the app and you want to migrate it up to this version:
			- CD protected
			- Run: yiic migrate up 1
				- If migration is successful, the database will be in sync with this version of the app
			- 
	- **Go!**