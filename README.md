# Bus Booking System

## Introduction

This is a fleet management system for a bus-booking service, built using Laravel web framework and a relational database. The system is designed to manage trips between cities in Egypt and allow users to book seats on those trips. Each trip has a predefined route that includes multiple stations, and each bus on the trip has 12 available seats that can be booked by users. The system provides two APIs for consumers, which allow them to book seats on a trip if available, and get a list of available seats for their trip by specifying the start and end stations.


## Technology Used

- Laravel.
- Repository Pattern
    - Abstracts the data access layer from the rest of the application and provides a clean separation of concerns.
    - A repository is created for each model (Trip,Seat,Reservation,User) which are responsible for fetching and updating the data.
    - Allows for easy switching of data sources or updating the data access logic without affecting the rest of the application.

## Installation and Usage

### Running the Project

1. Clone the repository to your local machine using `git clone`.
2. Start the local development server using `docker compose up`.
3. install the required dependencies by running `docker-compose exec php composer install`.
4. Create a copy of the `.env.example` file and name it `.env` run`docker-compose exec php cp .env.example .env`.
5. Generate Laravel application key run `docker-compose exec php php artisan key:generate`.
6. Run the migrations and seed the database using `docker-compose exec php php artisan migrate:fresh --seed`.

### Running the Test Cases

1. Run the test cases using `docker-compose exec php php artisan test`.

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