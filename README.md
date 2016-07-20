# slice-php-oauth

This has been tested with apache2 and PHP 5.5.14 on OS X El Capitan

To test, do the following.

## apache setup

Pick a domain for testing (say www.testdomain.com)

Add an entry to your hosts file

```
127.0.0.1 www.testdomain.com
```

Add a file (testdomain.php) with following content to /etc/apache2/other

```
NameVirtualHost www.otherdomain.com:80
<VirtualHost www.otherdomain.com:80>
	servername www.otherdomain.com
	DocumentRoot <PATH_TO_WHERE_THIS_REPO_IS_CHECKED_OUT>
	<Directory "<PATH_TO_WHERE_THIS_REPO_IS_CHECKED_OUT>">
		Options Indexes FollowSymLinks
		Require all granted
	</Directory>
</VirtualHost>
```

Ensure that you can access http://www.testdomain.com/index.php

There is a http://www.testdomain.com/php_info.php page to check version of PHP on your machine

## Create an OAuth application on the Slice developer portal

1. Signup for a developer account at https://developer.slice.com
2. Create an OAuth application and set redirect_uri to http://www.testdomain.com/callback.php
3. Note the client_id and client_secret
4. It may take a few minutes (10-15) for your application to take effect

## Create an ini file for application

Let's call this application your "test" application. So create a test.ini file with following information.

```
client_id=YOUR_APPLICATION_CLIENT_ID
client_secret=YOUR_APPLICATION_CLIENT_SECRET
redirect_uri=http://www.testdomain.com/callback.php
authorize_url=https://api.slice.com/oauth/authorize
token_url=https://api.slice.com/oauth/token
revoke_token_url=https://api.slice.com/oauth/revoke
base_api_url=https://api.slice.com
use_proxy=false
```

## Testing

Load the index page in a browser (or refresh if already loaded) http://www.testdomain.com/index.php

This should give you an option to choose application to test.

Application name is taken from the ini file. So, if you created test.ini, you would have an option called "test"

Clicking "choose" will take you through an OAuth authorization process and if everything works fine, should provide you with an access and a refresh token.

You can click "Show config" button to view the configuration that will take effect.

## To test with a debugging proxy (test with Charles which uses port 8888)

1. Set `use_proxy=true` in the ini file
2. Reload http://www.testdomain.com
3. Start Charles
4. You will see the http calls in Charles proxy as they are made.
