# Installation 

```sh
php composer.phar install --prefer-source
php app/console doctrine:schema:update --force
php app/console assets:install
php app/console assetic:dump
```

### Fake data loading

```sh
php app/console doctrine:fixtures:load
```
