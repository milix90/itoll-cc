#### Code Challenge

By importing Postman Json file, Rest APIs are available. Thus start with `Submit` Endpoint and other flows are clear to be handled. 

- note: review postman comments to the correct tokens in headers.


##### follow the below steps to run the service

- to run docker:

```
docker-compose up -d
```

- prepare `.env`:

```
cp .env.example .env
```

- migrate database:

```
php artisan migrate
```

- seed database:

```
php artisan db:seed
```

- run jobs:

```
php artisan schedule:work
```

- generate Mocked Auth Token and use in the Postman:

```
php artisan token:mock
```
