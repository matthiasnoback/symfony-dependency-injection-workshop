# Dependency injection sandbox for workshops

By [Matthias Noback](http://php-and-symfony.matthiasnoback.nl/)

## Getting started

Clone this project:

    git clone git@github.com:matthiasnoback/symfony-dependency-injection-workshop.git
    cd symfony-dependency-injection-workshop

Install [Composer](https://getcomposer.org/download/) if you don't have it already.

Run:

    composer install

Try:

    php run.php

You should see something like:

    URL for cat gif with id "vd": http://24.media.tumblr.com/tumblr_m1pgmg9Fe61qjahcpo1_1280.jpg
    A random URL of a cat gif: http://24.media.tumblr.com/tumblr_m2kkonCfCa1qejbiro1_500.jpg

You may also try to run the tests:

    vendor/bin/phpunit

This takes a couple of seconds and then you may either see a red or a green bar telling you that all tests succeeded,
or one of them failed.
