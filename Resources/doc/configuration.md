Configuration
=============

## Basic Configuration ##

If you have just one database connection, your configuration will look like as following:

``` yaml
# app/config/config*.yml
propel:
    dbal:
        driver:               mysql
        user:                 root
        password:             null
        dsn:                  mysql:host=localhost;dbname=test;charset=UTF8
        options:              {}
        attributes:           {}
```

The recommended way to fill in these information is to use parameters:

``` yaml
# app/config/config*.yml
propel:
    dbal:
        driver:               %database_driver%
        user:                 %database_user%
        password:             %database_password%
        dsn:                  %database_driver%:host=%database_host%;dbname=%database_name%;charset=UTF8
        options:              {}
        attributes:           {}
```

