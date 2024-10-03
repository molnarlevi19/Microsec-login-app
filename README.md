# User Registration and Authentication System

This project is a user registration and authentication system built with Laravel and React. It allows users to register, log in, and update their profile information securely.

## Features

- Users can register with their email, nickname, birthdate, and password.
- User data is stored in both a relational database and a CSV file.
- Registration data retrieval is random, simulating resource failure.
- Users can log in with their email and password.
- After logging in, users can update their password, nickname, and birthdate.
- Users can log out.

## Technologies
**A full stack web application with the following technologies:**
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/frameworks/react.svg" alt="drawing" width="30" align="center"/> *React*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/programming%20languages/javascript.svg" alt="drawing" width="30" align="center"/> *JavaScript*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/frameworks/laravel.svg" alt="drawing" width="30" align="center"/> *Laravel*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/programming languages/php.png" alt="drawing" width="30" align="center"/> *PHP*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/databases/mysql.svg" alt="drawing" width="30" align="center"/> *MySQL*

## Prerequisites
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/frameworks/laravel.svg" alt="drawing" width="30" align="center"/> *Laravel 10.10*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4f03108213fbb57ec4/programming languages/php.png" alt="drawing" width="30" align="center"/> *PHP 8.1*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4/others/npm.svg" alt="drawing" width="30" align="center"/> *NPM 8.19.2*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4/databases/mysql.svg" alt="drawing" width="30" align="center"/> *MySQL 8.1.0*
- <img src="https://raw.githubusercontent.com/yurijserrano/Github-Profile-Readme-Logos/042e36c55d4d757621dedc4/others/git.svg" alt="drawing" width="30" align="center"/> *Git 2.38.1*

## Usage
**Clone the repository using the following command:**

```bash
# Clone this repository
git clone git@github.com:molnarlevi19/Microsec-login-app.git
```

```bash
# Navigate to the frontend directory
cd {local_folder_of_cloned_project/frontend}

# Install dependencies
npm install

# Run the application
npm run dev

# Visit localhost:5173
```

```bash
# Navigate to the backend directory
cd {local_folder_of_cloned_project/backend}

# Install dependencies
composer install

# Create a '.env' file in the root directory of the project and set your MySQL environment variables based on '.env.example':
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306  # Replace with your MySQL port number
DB_DATABASE= # Replace with your MySQL database name
DB_USERNAME= # Replace with your MySQL username
DB_PASSWORD= # Replace with your MySQL password

# Migrate the database
php artisan migrate --seed

# Run the application
php artisan serve
```

## Author:

* Molnár Levente (molnarlevi19@gmail.com)

## License:

* MIT License (See LICENSE file)