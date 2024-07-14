### Introduction

This repository is a technical exercise whose objective is to experiment in the implementation of DDD architecture without using any framework..

The following are some considerations and comments about it:

- I have implemented the DDD architecture, with which I am taking my first steps, resorting to repositories with examples and tutorials following the guidelines in which I have observed a general consensus. 

- I decided to do this experiment without using any framework, since I would like to implement DDD following the basic principles I got from my research. 

- Some things that could be improved:

    - Implementation of a service container.
    - More testing coverage.
    - Better error handling.
    - Docker implementation.

### Installation

- Install dependencies: ```$ composer install```
- Create a local environment file ```$ cp .env.example .env```

### Run the server
```$ php -S localhost:8000 -t public```
### Endpoints

#### Create Job

```
$ curl --location 'http://localhost:8000/job' \
--header 'Content-Type: application/json' \
--data '{
    "title": "Java Developer",
    "country": "Bolivia",
    "salary": 90000,
    "keywords": ["java", "mysql"]
}'
```

#### Search Jobs

```
$ curl --location --request GET 'http://localhost:8000/jobs' \
--header 'Content-Type: application/json' \
--data '{"keyword" : "java"}'
```

### PHP_CodeSniffer

[PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer/) is used to detect violations of a defined coding standard. 

```
$ ./vendor/squizlabs/php_codesniffer/bin/phpcs --config-set error_severity 6
$ ./vendor/squizlabs/php_codesniffer/bin/phpcs src
```

### Running tests

```
 $ ./vendor/phpunit/phpunit/phpunit tests
```

### Resources

- https://github.com/slimphp/Slim
- https://github.com/CodelyTV/php-ddd-example/
