New Features in this branch:
- MANY_MANY relationships between a book and its authors and categories
	- A book can have upto 3 authors and 3 categories (CAdvancedArBehavior extension is used to implement this feature)

- Caching 
	- Is implemented in this branch
	- Duration is specified in the main.php config file

####Instructions to switch to this branch:
	- Install the app from the master branch 
	- cd DL
	- Git checkout 'Caching-and-Many-Many-relations'
	- Run the DL_MySQL.sql script to set up the database
	- **Go!**