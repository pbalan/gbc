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

### API Documentation
Navigate to [http://api.gbcorps.cn/api/doc](http://api.gbcorps.cn/app_dev.php/api/doc) on your browser. Documentation is shown using the **NelmioApiDocBundle.**


### Dependencies

- [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md) **for login with JWT.**
- [JWTRefreshTokenBundle](https://github.com/gesdinet/JWTRefreshTokenBundle/blob/master/README.md#generating-tokens) **allows tokens to be refreshed without prompting user for their credentials.**
- [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/README.md) **for user management that aims to handle common tasks such as user registration and password retrieval.**
- [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle/blob/master/README.md) **adds support for authenticating users via OAuth1.0a or OAuth2 in Symfony. It allows users to login with social media websites.**
- [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md) **allows application to perform Cross Origin Requests.**
- [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle/blob/master/README.md) **allows to document the APIs for the Application.**
- [VoryRESTGeneratorBundle](https://github.com/voryx/restgeneratorbundle/blob/master/README.md) **Simplifies setting up a RESTful Controller.**
- [JMSSerializerBundle](http://jmsyst.com/libs/serializer) **Easily serialize, and deserialize data of any complexity (supports XML, JSON, YAML).**
