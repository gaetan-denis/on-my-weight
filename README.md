# On My Weight

A small PHP exercise to understand the backend flow without any frameworks.  
This project lets you track user weights and manage authentication using plain PHP.

---

## Features

- User registration, login, and logout.
- Add and view your own weights.
- Simple MVC-like structure:
  - **Controller**: handles HTTP requests and reads `$_POST`/`$_GET`.
  - **Service**: contains business logic and validates data.
  - **Repository**: communicates with the database.
  - **Entities**: represent data objects (User, Weight).

---

## Requirements

- PHP 8+
- MySQL / MariaDB
- Composer
- A local server like WAMP, XAMPP, or MAMP

---

## Setup

1. Copy `.env.example` to `.env` and fill in your database credentials:

```dotenv
DB_HOST=127.0.0.1
DB_NAME=weight
DB_USER=root
DB_PASS=
```

2. Start your local PHP & MySQL server.
3. Run the initialization script to automatically create the database and tables:

```bash
php scripts/init_db.php
```

This script will create the weight database if it doesn't exist, and the users and weights tables with the proper structure.

4. Access the project in your browser:

```
http://localhost/on-my-weight/index.php
```

## Usage

### Routing

The project uses a simple routing system via the action GET parameter. Example:

```text
http://localhost/on-my-weight/index.php?action=add-weight
```

### Available actions:

- `register` → Register a new user

- `login` → Log in

- `logout` → Log out

- `add-weight` → Add a weight for the logged-in user

- `get-weights` → Retrieve all weights of the logged-in user

### Example POST Requests

- Register:

  - POST action=register

  - Body: username, email, password

- Login:

  - POST action=login

  - Body: email, password

- Add Weight (logged-in only):

  - POST action=add-weight

  - Body: weight (the user's weight in kg)

- Get Weights (logged-in only):

  - GET action=get-weights

---

## How It Works

1. Controller reads the HTTP request ($\_POST / $\_GET) and decides which Service to call.

2. Service validates input and contains business logic (e.g., check if weight > 0, authenticate user).

3. Repository communicates with the database and returns entities.

4. Entities represent your objects (User, Weight) with methods to access data.

5. Controller sends the final response back to the client.

## Notes

- Sessions are used to track logged-in users.

- Only authenticated users can add or view their weights.

- No frameworks, pure PHP to understand the flow from request to response.
