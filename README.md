# Fitoda (File to database)

PHP 8 Data Processor

## Overview

Welcome to the Fitoda project! This tool is designed to efficiently process (xml) data using PHP 8, Composer and Docker. Using Docker is not required to run the script, but it is recommended. 

The project includes a docker-compose file for easy deployment, allowing you to start the application with a simple command:

```bash
docker-compose up -d
```

Connect to the running container using:

```bash
docker exec -it -w /app fitoda-php-1 bash
```

Install the dependencies using:

```bash
composer install
```

## Execution

You can execute the core functionality of the project by navigating to the root directory and running:

```bash
php main.php
```

Default configurations are stored in `config.ini` and can be manually configured. However, the script also supports parameters for dynamic configuration:

- `--help`: Display this help message.
- `-f <filename>` or `--file=<filename>`: Overwrite the source file.
- `-u <user>` or `--user=<user>`: Overwrite the target database user.
- `-p <password>` or `--password=<password>`: Overwrite the target database password.
- `-h <host>` or `--host=<host>`: Overwrite the target database host.
- `-D <database>` or `--Database=<database>`: Overwrite the target database name.

## Features

- Object-oriented programming principles are at the core of this project.
- Easily replaceable components, such as the parser or the database driver, ensure flexibility.
- A progress bar provides visual feedback during script execution.
- Upon completion, a statistical overview is presented, detailing the total items processed, failed, and succeeded.

## Error Handling

In case of errors, logs are available under `logs/error.log`.

## Testing

Tests have been created with PHPUnit 11 and can be executed manually with:

```bash
vendor/bin/phpunit tests
```

## Environment and Tools

This project was created using IntelliJ IDEA Ultimate and Docker for Desktop on Windows 10.
