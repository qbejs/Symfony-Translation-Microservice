# 🐳 Docker + PHP 8.1 + MySQL + Nginx + Symfony 6.1 Boilerplate

## Description

This is a complete stack for running Symfony 6.1 into Docker containers using docker-compose tool with [docker-sync library](https://docker-sync.readthedocs.io/en/latest/).

It is composed by 4 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 8.0 version of PHP.
- `db` which is the MySQL database container with a **MySQL 8.0** image.
- `symfony_docker_app_sync` to sync files using library `docker-sync `.

## Installation

1. 😀 Clone this rep.

2. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as template. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.

3. Go inside folder `./docker` and run `docker-sync-stack start` to start containers.

4. You should work inside the `php` container. This project is configured to work with [Remote Container](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension for Visual Studio Code, so you could run `Reopen in container` command after open the project.

5. Inside the `php` container, run `composer install` to install dependencies from `/var/www/symfony` folder.

6. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://app_user:helloworld@db:3306/app_db?serverVersion=8.0.23
```

You could change the name, user and password of the database in the `env` file at the root of the project.

## To learn more

I have recorded a Youtube session explaining the different parts of this project. You could see it here:

[Boilerplate para Symfony basado en Docker, NGINX y PHP8](https://youtu.be/A82-hry3Zvw)


# Symfony-Translation-Microservice 🌍

Welcome to `Symfony-Translation-Microservice`! This is a simple translation microservice built with Symfony implementing DDD architecture.

## 🖥️ Technologies Used

- **PHP 8.1**: One of the latest version of PHP, ensuring the best performance and security.
- **Symfony**: Built on top of Symfony, one of the most efficient PHP frameworks, ensuring robust performance and modular codebase.
- **MySQL**: A reliable relational database system, ensuring data integrity and efficient retrieval.
- **Doctrine**: An ORM for PHP that provides database abstraction, ensuring seamless data manipulation and persistence.
- **RabbitMQ**: A message broker that implements the Advanced Message Queuing Protocol (AMQP), ensuring reliable message delivery.
- **Redis**: An in-memory data structure store used as a caching layer to speed up data access.
- **PHPUnit**: A popular PHP testing framework that ensures our code runs as expected and is free from regressions.
- **Docker**: An OS-level virtualization tool that packages our app and its dependencies into containers for consistent and easy deployment.
- **Composer**: A dependency manager for PHP, ensuring the project has all the necessary libraries and manages them with ease.
- **Nginx**: A high-performance web server that serves static and dynamic content on the web.

## 🐳 Docker Deployment

Docker makes it easy to wrap your applications and services in containers so you can run them anywhere. Our project is already Docker-ready for you!

1. **Navigate to the Docker Directory**

    ```bash
    cd .docker
    ```

2. **Build and Start the Containers**

   Note: Ensure Docker is running on your system.

    ```bash
    docker-compose up -d
    ```

   This command will build the containers based on the services defined in `docker-compose.yml` and the respective `Dockerfile`s located in the service directories.

3. **Check the Running Containers**

    ```bash
    docker ps
    ```

   You should see your services running. If you face any issues, logs can be checked using:

    ```bash
    docker-compose logs -f [service-name]
    ```

4. **Stopping the Containers**

   Once you're done, you can stop the containers by running:

    ```bash
    docker-compose down
    ```

With Docker, you can ensure the application runs in the same environment regardless of where Docker is running. It simplifies deployment, scaling, and testing.



## 🛠 Setup & Installation

1. **Clone the Repository**
    ```bash
    git clone https://github.com/your-username/Symfony-Translation-Microservice.git
    ```

2. **Navigate into the Directory**
    ```bash
    cd Symfony-Translation-Microservice
    ```

3. **Install Dependencies**
    ```bash
    composer install
    ```

4. **Run the Service**
    ```bash
    symfony server:start
    ```

That's it! Your translation microservice should now be running on `http://127.0.0.1:8000`.

## 📝 Usage

Send a POST request to `/translate` endpoint with source and target language codes and the text you want to translate.

Example:
```bash
curl -X POST -H "Content-Type: application/json" \
     -d '{"source": "en", "target": "fr", "text": "Hello World!"}' \
     http://127.0.0.1:8000/translate
