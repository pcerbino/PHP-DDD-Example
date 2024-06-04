## Installation

- Install dependencies: ```composer install```
- Create a local environment file ```cp .env.example .env```

## Endpoints

### Create Job

```
curl -X POST -H "Content-Type: application/json" -d '{"title":"FullStack Developer", "description":"Job Descrioption example", "company":"Microsoft"}' http://localhost:8000/job
```

### Search Jobs

```
curl --location --request GET 'http://localhost:8000/jobs' \
--header 'Content-Type: application/json' \
--data '{"keyword" : "php"}'
```

## Resources

- https://github.com/slimphp/Slim
- https://github.com/CodelyTV/php-ddd-example/
