GBC API
=========

### Installation Instructions ###

* Use GIT to clone the repository
* Create a MySQL database.
* Copy app/config/parameters.yml.dist to app/parameters.yml and add MySQL database connection details in there.
* Use composer to install dependencies
* Update migrations
* Update fixtures
* Set 0777 permissions to app/cache/*, app/logs/* and app/sessions/* directories.

**Use the API**