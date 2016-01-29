# Framelab [![Build Status](https://travis-ci.org/jdlabails/framelab.svg?branch=master)](https://travis-ci.org/jdlabails/framelab)

## Installation 

```sh
php composer.phar install --prefer-source
php app/console doctrine:schema:update --force
php app/console assets:install
php app/console assetic:dump
php app/console ppa:init
```

## Fake data loading

```sh
php app/console hautelook:doctrine:fixtures:load
```

## Connexion

If  fixtures are loaded

admin/admin123