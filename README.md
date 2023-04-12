# Bus Booking System

## Introduction



## Technology Used

- Laravel.
- Repository Pattern
    - Abstracts the data access layer from the rest of the application and provides a clean separation of concerns.
    - A repository is created for each model (Trip,Seat,Reservation,User) which are responsible for fetching and updating the data.
    - Allows for easy switching of data sources or updating the data access logic without affecting the rest of the application.

## Installation and Usage

### Running the Project

1. Clone the repository to your local machine using `git clone`.
2. In the php container 
    - install the required dependencies by running `composer install`.
    - Create a copy of the `.env.example` file and name it `.env`.
    - Update the `DB_DATABASE` value in the `.env` file to point to your database.
    - Run the migrations and seed the database using `php artisan migrate --seed`.
3. Start the local development server using `docker compose up`.

### Running the Test Cases

1. Create a new database called 'task_test'.
2. Run the test cases using `php artisan test`.

# API Documentation

## Register Endpoint

### POST ```/api/auth/register```

Creates a new user in the system.

**Request Body:**

```json
{
    "name": "dina",
    "mobile_number":"012345687",
    "email":"user@example.com",
    "password": "password",
}
```

## Login Endpoint

### POST ```/api/auth/login```

Login a user to the system.

**Request Body:**

```json
{
    "email":"user@example.com",
    "password": "password",
}
```

## Trips Endpoint

### GET ```/api/trips```

Get all trips of the system.

## Book seat Endpoint

### POST ```/api/book-seat```

book a seat is a specific trip if there is an available seat.

**Request Body:**

```json
{
    "trip_id":1,
    "from_station_id": 1,
    "to_station_id": 5,
}
```

## Available seat Endpoint

### GET ```/api/book-seat```

List the available seats to be booked for your trip by sending start and end
stations.
.

**Request Parameters:**

```json
{
    "from_station_id": 1,
    "to_station_id": 5,
}
```