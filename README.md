## Installation

- Install dependencies: ```$ composer install```
- Create a local environment file ```$ cp .env.example .env```

### Endpoints

#### Create Job

```
$ curl -X POST -H "Content-Type: application/json" -d '{"title":"FullStack Developer", "description":"Job Descrioption example", "country":"Microsoft"}' http://localhost:8000/job
```

#### Search Jobs

```
$ curl --location --request GET 'http://localhost:8000/jobs' \
--header 'Content-Type: application/json' \
--data '{"keyword" : "php"}'
```

### PHP_CodeSniffer

[PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer/) is used to detect violations of a defined coding standard. 

```
$ ./vendor/squizlabs/php_codesniffer/bin/phpcs --config-set error_severity 6
$ ./vendor/squizlabs/php_codesniffer/bin/phpcs src
```

### Resources

- https://github.com/slimphp/Slim
- https://github.com/CodelyTV/php-ddd-example/
