wget https://github.com/php-test-helpers/php-test-helpers/tarball/master
tar -zxf master
sh -c "cd php-test-helpers-php-test-helpers-*&&phpize; ./configure; make; sudo make install"
echo "extension=test_helpers.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
