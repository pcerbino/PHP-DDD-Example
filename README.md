### Introduction

This repository contains the technical exercise requested for the Avature interview.

The following are some considerations and comments about it:

- I decided to implement the DDD architecture, with which I am taking my first steps. I have worked in projects that implement DDD, but this was my first time implementing it from scratch. 
I have resorted to example repositories and tutorials following the guidelines in which I observed a general consensus. 

- In addition, I decided to do this project without using any framework, as I considered that this would expose my knowledge and facilitate the evaluation. 

- The disadvantage of all the above is that it took me more time than I expected and there are several things that could be improved, for example:

    - Implementation of a service container.
    - More testing coverage.
    - Better error handling.
    - Docker implementation.

- Anyway and despite these limitations I hope this work serves for evaluation purposes and I am available to introduce any improvement that may be required.


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
