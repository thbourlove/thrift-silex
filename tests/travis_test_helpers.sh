wget https://github.com/php-test-helpers/php-test-helpers/tarball/master
tar -zxf master
sh -c "cd php-test-helpers-php-test-helpers-*&&phpize; ./configure; make; sudo make install"
phpenv config-add test_helpers.ini
