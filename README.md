#  event-maker

This is a simple event making system able to set appointments with certain invitees.

all docker-compose files are contained within the laradock folder.

## Install & Run the app

    cd laradock
    docker-compose up -d workspace nginx mysql

    composer install

    php artisan migrate
    php artisan passport:install

## Run the tests

    phpunit

# REST API

The REST API to the event_maker app is described below.

## signup

### Request

`POST /api/auth/signup/`

    curl --location --request POST 'http://event_maker.exp/api/auth/signup' \
            --header 'Content-Type: application/x-www-form-urlencoded' \
            --form 'name=default4' \
            --form 'email=default4@sample.com' \
            --form 'phone_number=09143456789' \
            --form 'password=secretsecret' \
            --form 'password_confirmation=secretsecret' \
            --form 'picture=@/home/pictures/s1QK2.jpg'

### Response

    HTTP/1.1 200 OK    
    Status: 200 OK    

    {
    "token": "vbsfg...",
    "message": "Registration successfull.."
    }

## login

### login

`POST /api/auth/login/`

   curl --location --request POST 'http://event_maker.exp/api/auth/login' \
        --header 'Content-Type: application/x-www-form-urlencoded' \
        --form 'user_name=09153456789' \
        --form 'password=secretsecret'

### Response

    HTTP/1.1 200 OK    
    Status: 200 OK    

    {
    "token": "vbsfg...",    
    }

## get current user

### getuser

`GET /api/auth/getuser/`

   curl --location --request GET 'http://event_maker.exp/api/auth/getuser' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK    
    Status: 200 OK    

    {
        "id": 2,
        "name": "default4",
        "phone_number": "09153456789",
        "email": "default5@sample.com",
        "picture": "/9j/4AAQ..."
    }

## logout

### logout

`GET /api/auth/logout/`

   curl --location --request GET 'http://event_maker.exp/api/auth/logout' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK    
    Status: 200 OK    

    {
       "message": "Successfully logged out."
    }

## Get list of users

### Request

`GET /api/users/`

    curl --location --request GET 'http://event_maker.exp/api/users' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK   
    Status: 200 OK

    [{"id": 1,"name": "default1"},{"id": 2,"name": "default3"},{"id": 3,"name": default4"}]


## Get a specific user

### Request

`GET /api/users/id`

    curl --location --request GET 'http://event_maker.exp/api/users/1' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK   
    Status: 200 OK

    {"id": 1,"name": "default1","phone_number": "09143456789","email": "default4@sample.com","picture": "/9j/4..."}


## Create a new Thing

### Request

`POST /thing/`

    curl -i -H 'Accept: application/json' -d 'name=Foo&status=new' http://localhost:7000/thing

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}

## Get a specific Thing

### Request

`GET /thing/id`

    curl -i -H 'Accept: application/json' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}

## Get a non-existent Thing

### Request

`GET /thing/id`

    curl -i -H 'Accept: application/json' http://localhost:7000/thing/9999

### Response

    HTTP/1.1 404 Not Found
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 404 Not Found
    Connection: close
    Content-Type: application/json
    Content-Length: 35

    {"status":404,"reason":"Not found"}

## Create another new Thing

### Request

`POST /thing/`

    curl -i -H 'Accept: application/json' -d 'name=Bar&junk=rubbish' http://localhost:7000/thing

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/2
    Content-Length: 35

    {"id":2,"name":"Bar","status":null}

## Get list of Things again

### Request

`GET /thing/`

    curl -i -H 'Accept: application/json' http://localhost:7000/thing/

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 74

    [{"id":1,"name":"Foo","status":"new"},{"id":2,"name":"Bar","status":null}]

## Change a Thing's state

### Request

`PUT /thing/:id/status/changed`

    curl -i -H 'Accept: application/json' -X PUT http://localhost:7000/thing/1/status/changed

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 40

    {"id":1,"name":"Foo","status":"changed"}

## Get changed Thing

### Request

`GET /thing/id`

    curl -i -H 'Accept: application/json' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 40

    {"id":1,"name":"Foo","status":"changed"}

## Change a Thing

### Request

`PUT /thing/:id`

    curl -i -H 'Accept: application/json' -X PUT -d 'name=Foo&status=changed2' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 41

    {"id":1,"name":"Foo","status":"changed2"}

## Attempt to change a Thing using partial params

### Request

`PUT /thing/:id`

    curl -i -H 'Accept: application/json' -X PUT -d 'status=changed3' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 41

    {"id":1,"name":"Foo","status":"changed3"}

## Attempt to change a Thing using invalid params

### Request

`PUT /thing/:id`

    curl -i -H 'Accept: application/json' -X PUT -d 'id=99&status=changed4' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 41

    {"id":1,"name":"Foo","status":"changed4"}

## Change a Thing using the _method hack

### Request

`POST /thing/:id?_method=POST`

    curl -i -H 'Accept: application/json' -X POST -d 'name=Baz&_method=PUT' http://localhost:7000/thing/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 41

    {"id":1,"name":"Baz","status":"changed4"}

## Change a Thing using the _method hack in the url

### Request

`POST /thing/:id?_method=POST`

    curl -i -H 'Accept: application/json' -X POST -d 'name=Qux' http://localhost:7000/thing/1?_method=PUT

### Response

    HTTP/1.1 404 Not Found
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 404 Not Found
    Connection: close
    Content-Type: text/html;charset=utf-8
    Content-Length: 35

    {"status":404,"reason":"Not found"}

## Delete a Thing

### Request

`DELETE /thing/id`

    curl -i -H 'Accept: application/json' -X DELETE http://localhost:7000/thing/1/

### Response

    HTTP/1.1 204 No Content
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 204 No Content
    Connection: close


## Try to delete same Thing again

### Request

`DELETE /thing/id`

    curl -i -H 'Accept: application/json' -X DELETE http://localhost:7000/thing/1/

### Response

    HTTP/1.1 404 Not Found
    Date: Thu, 24 Feb 2011 12:36:32 GMT
    Status: 404 Not Found
    Connection: close
    Content-Type: application/json
    Content-Length: 35

    {"status":404,"reason":"Not found"}

## Get deleted Thing

### Request

`GET /thing/1`

    curl -i -H 'Accept: application/json' http://localhost:7000/thing/1

### Response

    HTTP/1.1 404 Not Found
    Date: Thu, 24 Feb 2011 12:36:33 GMT
    Status: 404 Not Found
    Connection: close
    Content-Type: application/json
    Content-Length: 35

    {"status":404,"reason":"Not found"}

## Delete a Thing using the _method hack

### Request

`DELETE /thing/id`

    curl -i -H 'Accept: application/json' -X POST -d'_method=DELETE' http://localhost:7000/thing/2/

### Response

    HTTP/1.1 204 No Content
    Date: Thu, 24 Feb 2011 12:36:33 GMT
    Status: 204 No Content
    Connection: close


