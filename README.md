## PHP DDD Boilerplate

### Introduction

This repository is a technical exercise aimed at experimenting with the implementation of a DDD (Domain-Driven Design) architecture **without relying on any external framework**.

Below are some considerations and notes about this work:

- I chose to build this experiment without a framework in order to focus on applying DDD using only the core principles I gathered during my research.  

#### Areas for improvement

    - Implementation a service container.
    - Increasing test coverage.
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
