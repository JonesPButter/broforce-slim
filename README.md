# broforce-slim
An Example Webservice based on the slim/slim-skeleton

Installationguide:

Repolink https://github.com/JonesPButter/broforce-slim.git

1. Clone Repo
2. Install Composer
3. run command: php composer install
4. Start a Webserver. For example the php built-in webserver:
    php -S localhost:8080 -t public public/index.php
	
	
install composer into current dir:

php -r "copy('https://getcomposer.org/installer','composer-setup.php');" 

php -r "if (hash_file('SHA384', 'composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') 
{ echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" 

php composer-setup.php --filename=composer
 
php -r "unlink('composer-setup.php');"
