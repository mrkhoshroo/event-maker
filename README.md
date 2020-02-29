#  event-maker

This is a simple event making system able to set appointments with certain invitees.

all docker-compose files are contained within the laradock folder.

## Install & Run the app

    cd laradock
    docker-compose up -d workspace nginx mysql

    mv .env.example .env
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
            --header 'Accept: application/json' \
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
        --header 'Accept: application/json' \
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


## Create a new appointment

### Request

`POST /api/appointments/`

   curl --location --request POST 'http://event_maker.exp/api/appointments' \
        --header 'Content-Type: application/x-www-form-urlencoded' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...' \
        --form 'due_date=2020-02-29' \
        --form 'title=sample_appoinment_title' \
        --form 'info=sample_info' \
        --form 'invitees[0]=1' \
        --form 'invitees[1]=43'

### Response

    HTTP/1.1 201 Created   
    Status: 200 OK
    Content-Type: application/json

    {"id": 13,"user_id": 43,"due_date": "2020-02-29T00:00:00.000000Z","title": "sample_appoinment_title","info": "sample_info","invitees": [1,43]}

## Get list of appointments

### Request

`GET /api/appointments/`

    curl --location --request GET 'http://event_maker.exp/api/appointments' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK   
    Status: 200 OK

    [{"id": 1,"title": "sample_appoinment_title","due_date": "2020-02-29 00:00:00"},]{"id": 2,"title": "sample_appoinment_title2","due_date": "2020-02-30 00:00:00"}

    

## Get a specific appoinment

### Request

`GET /api/appointments/id`

    curl --location --request GET 'http://event_maker.exp/api/appointments/11' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'
### Response

    HTTP/1.1 200 OK   
    Status: 200 OK   
    Content-Type: application/json  

    {"id": 11,"user_id": 43,"due_date": "2020-02-29T00:00:00.000000Z","title": "sample_appoinment_title","info": "sample_info","invitees": [1,2]}

## Get list of invitations

### Request

`GET /api/invitations/`

    curl --location --request GET 'http://event_maker.exp/api/invitations' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'

### Response

    HTTP/1.1 200 OK   
    Status: 200 OK
    Content-Type: application/json

    [{
        "id": 12,
        "title": "sample_appoinment_title",
        "due_date": "2020-02-29 00:00:00",
        "pivot": {
            "user_id": 43,
            "appointment_id": 12,
            "created_at": "2020-02-29 18:06:58",
            "updated_at": "2020-02-29 18:20:27",
            "visited_at": "2020-02-29",
            "status": 1
        }
     },
     {
        "id": 13,
        "title": "sample_appoinment_title",
        "due_date": "2020-02-29 00:00:00",
        "pivot": {
            "user_id": 43,
            "appointment_id": 13,
            "created_at": "2020-02-29 18:27:39",
            "updated_at": "2020-02-29 18:27:39",
            "visited_at": null,
            "status": null
        }
    }]
    

## Get a specific invitation

### Request

`GET /api/invitations/id`

    curl --location --request GET 'http://event_maker.exp/api/invitations/12' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...'
### Response

    HTTP/1.1 200 OK   
    Status: 200 OK   
    Content-Type: application/json  

    {
    "id": 12,
    "user_id": 43,
    "due_date": "2020-02-29T00:00:00.000000Z",
    "title": "sample_appoinment_title",
    "info": "sample_info",
    "invitees": [
        1,
        43
    ]
}
    

## Change an invitations's state

### 0 : rejected - 1 : accepted

### Request

`PATCH /thing/:id/status/changed`

    curl --location --request PATCH 'http://event_maker.exp/api/invitations/12' \
        --header 'Content-Type: application/x-www-form-urlencoded' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer vbsfg...' \
        --data-urlencode 'status=1'

### Response

    HTTP/1.1 200 OK   
    Status: 200 OK   
    Content-Type: application/json

    {"id": 12,"user_id": 43,"due_date": "2020-02-29T00:00:00.000000Z","title": "sample_appoinment_title","info": "sample_info","invitees": [1,43]}
