# VIIIDB API

<p align="center">
  <img src="https://img.shields.io/github/workflow/status/DefrostedTuna/viiidb-api/Build%20Branch/master?label=Build&logo=github&style=flat-square">

  <a href="https://github.com/DefrostedTuna/viiidb-api/releases">
    <img src="https://img.shields.io/github/v/release/DefrostedTuna/viiidb-api?label=Stable&sort=semver&logo=github&style=flat-square">
  </a>
</p>

<p align=center>
  <a href="https://viiidb.com">
    <img src="https://img.shields.io/badge/Interface-viiidb.com-red?logo=digitalocean&logoColor=white&style=flat-square">
  </a>
  <a href="https://api.viiidb.com">
    <img src="https://img.shields.io/badge/API-api.viiidb.com-blue?logo=digitalocean&logoColor=white&style=flat-square">
  </a>
</p>

- [Description](#description)
- [Local Development](#local-development)
  * [Prerequisites](#prerequisites)
  * [Global Resources](#global-resources)
    + [Network](#network)
    + [Reverse Proxy](#reverse-proxy)
      - [SSL Certificates](#ssl-certificates)
    + [Database](#database)
      - [Creating Databases](#creating-databases)
      - [Creating Users](#creating-users)
      - [Granting Permissions](#granting-permissions)
    + [Wrapping up](#wrapping-up)
  * [Setup](#setup)
    + [Container Initialization](#container-initialization)
    + [Installing Dependencies](#installing-dependencies)
    + [Application Key Generation](#application-key-generation)
    + [Database & Migrations](#database--migrations)
  * [Testing](#testing)

# Description 

VIIIDB is a project that aims to bring all of the information related to Final Fantasy VIII to a user's fingertips. This comes in the form of an ecosystem consisting of both an elegant REST API, as well as an easy to use web interface. The API will be publicly available and free for use amongst developers who wish to integrate the data into their own project, while the web interface (coming soon&trade;) will be freely available for general consumption by the community.

The API is built on Laravel and is currently under construction. With that said, the project is subject to major additions and/or changes leading up to its official public release. A collection of available resources will be outlined at the root of the API to outline development progress and will be updated in the event that new resources are added. To view the resources that have currently been implemented, please visit [https://api.viiidb.com](https://api.viiidb.com). VIIIDB API usage documentation will also be coming soon&trade;.

# Local Development

## Prerequisites

Three requirements must be met in order to spin up a local development environment.

The first and foremost requirement is going to be [Docker](https://docker.com). VIIIDB API ships with a Docker container to streamline the development process. As such, Docker is needed to bootstrap the application on the local machine.

Aside from this, an external database will be required as VIIIDB API does _not_ ship with a database container out of the box. While an existing local database may be used, it is very easy to spin up a database container using Docker and a global `docker-compose.yaml` manifest. The latter is the preferred method and will be outlined within the [Global Resources](#global-resources) section of this document.

Lastly, the application also expects that it will be available via a dedicated hostname rather than the traditional `http://localhost` endpoint. As with the database layer, this can be done using a reverse proxy that is defined within a global `docker-compose.yaml` manifest. This will also be outlined within the [Global Resources](#global-resources) section of this document.

## Global Resources

When working with microservices locally, a set of global resources can be defined to ease the reliance on external dependencies. Common dependencies include things such as persistent databases (MySQL), caching layers (Redis), and generally anything that is readily available via cloud service providers. This will allow an application's development architecture to closely resemble what will be expected in a production environment and allow developers to plan accordingly.

The default VIIIDB API configuration expects a global Docker-based MySQL database to be available within the same Docker network as the application container. It also expects the application to be reachable via a dedicated hostname rather than the traditional `http://localhost` endpoint, which can be solved with the use of a reverse proxy. Both of these requirements can be taken care of using a single `docker-compose.yaml` manifest.

To quickly get spun up with both a globally available database, as well as a reverse proxy to handle hostname routing, create a `docker-compose.yaml` file in a directory of your choosing (something like `~/Utilities`) and paste the following contents.

```yaml
version: '3.5'
 
networks:
  viiidb:
    name: viiidb
 
services:
  reverse-proxy:
    image: jwilder/nginx-proxy:alpine
    container_name: reverse-proxy
    ports:
      - 80:80
      - 443:443
    volumes:
      - ./certs:/etc/nginx/certs
      - /var/run/docker.sock:/tmp/docker.sock:ro
    networks:
      - viiidb

  database:
    container_name: database
    image: mysql:5.7
    ports:
      - 3306:3306
    environment:
      MYSQL_USER: homestead
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: secret
      VIRTUAL_HOST: database.local # This can be any hostname desired
      VIRTUAL_PORT: 3306
    volumes:
      - ./mysql:/var/lib/mysql
    networks:
      - viiidb

  meilisearch:
    image: getmeili/meilisearch:v0.26.1
    container_name: uptilt-meilisearch
    ports:
      - 7700:7700
    volumes:
      - ./meilisearch:/data.ms
    environment:
      VIRTUAL_HOST: meilisearch.local
      MEILI_MASTER_KEY: secret
      MEILI_NO_ANALYTICS: 'true'
    networks:
      - uptilt
      - viiidb
```

This manifest will create three different resources; a **Network**, **Reverse Proxy**, and a **Database**. Each of which will be globally available throughout the local system via Docker.

### Network

First up is a network resource. The network resource is what Docker containers will be bound to. A Docker container bound to a specific network will be able to connect with any other Docker containers on said network. This is necessary for VIIIDB as each of the containers within the VIIIDB ecosystem will need to be able to reach each other. This can be thought of as more or less a LAN connection between containers.

### Reverse Proxy

The second resource here is the `reverse-proxy` service. The proxy service enables Docker containers to be accessed locally via a specified hostname. Whenever a container is spun up on the same network as the proxy container, the reverse proxy will look for a `VIRTUAL_HOST` environment variable on the new container. When a request is made to the local machine, the reverse proxy will look for a container with a matching `VIRTUAL_HOST` value. If a matching value is found it will route all traffic to the container that was matched.

For example, the default `VIRTUAL_HOST` value for VIIIDB API is configured as `api.local.viiidb.com`. Binding this value to the container will expose the application via [https://api.local.viiidb.com](https://api.local.viiidb.com) rather than requiring the use of something like http://localhost:8080. This approach helps to streamline the development process when working with microservice ecosystems locally.

Aside from the `VIRTUAL_HOST` variable being set on the container, a matching `host` record must exist on the local system to direct traffic for the hostname back to `localhost`. Using the default configuration for VIIIDB API mentioned above, the system's `hosts` file will need to be modified to include the following line.

```bash
127.0.0.1       api.local.viiidb.com
```

This will allow any outbound traffic sent to `api.local.viiidb.com` to be redirected back to the local machine where it can be picked up by the reverse proxy container. 

#### SSL Certificates

One of the benefits of using a reverse proxy to serve an application is that it will enable the use of SSL certificates. When the reverse proxy receives an `https` request for a specific hostname, it will attempt to find an SSL certificate with a filename that matches the requested hostname. If a matching certificate is found, it is simply served to the client along with the response.

To create an SSL certificate for a specific hostname, simply run the following command(s) from the directory where the global resources are stored.

```bash
# Create the "certs" directory if it does not yet exist
if [ ! -d "certs" ]; then mkdir certs; fi

# This can be any hostname desired
export SSL_DOMAIN_NAME=api.local.viiidb.com

# Requires OpenSSL v1.1.1+
openssl req -x509 \
  -nodes \
  -subj "/CN=$SSL_DOMAIN_NAME" \
  -newkey rsa:4096 \
  -keyout certs/$SSL_DOMAIN_NAME.key \
  -out certs/$SSL_DOMAIN_NAME.crt \
  -addext "subjectAltName=DNS:$SSL_DOMAIN_NAME" \
  -days 365
```

**Note**: This requires the use of OpenSSL `v1.1.1` or higher. Mac unfortunately ships with LibreSSL out of the box. [OpenSSL](https://formulae.brew.sh/formula/openssl@1.1) must be installed via [Homebrew](https://brew.sh/) in order to use the `-addext` option.

Make sure to trust the newly generated SSL certificate at an OS level after it is generated!

### Database

The last resource defined within this manifest is the `database` service. Simply put, this is used to persist data for Docker containers across the same network. Abstracting this resource to a global system level will allow multiple containers to utilize the same resource. This saves the system from having duplicate resources, allowing databases to be managed in a single, convenient place.


#### Creating Databases

By default, the database container will not contain any, well, databases. To create a database, the following command can be run from the directory where the global resources are stored;

```bash
docker-compose exec database mysql -u root -psecret -e "CREATE DATABASE DATABASE_NAME_HERE;"
```

**Note**: This command can only be used if the resources are currently _running_.

#### Creating Users

In the event it is desirable to create a new user, the following command can be run from the directory where the global resources are stored;

```bash
docker-compose exec database mysql -u root -psecret -e "CREATE USER 'USERNAME_HERE'@'%' IDENTIFIED BY 'PASSWORD_HERE';"
```

**Note**: This command can only be used if the resources are currently _running_.


#### Granting Permissions

In the event a new user or database has been added, permissions will need to be granted for access to the desired resources. To grant privileges to a user for a specific database, the following command can be run from the directory where the global resources are stored;

```bash
docker-compose exec database mysql -u root -psecret -e "GRANT ALL PRIVILEGES ON DATABASE_NAME_HERE . * TO 'USERNAME_HERE'@'%'; FLUSH PRIVILEGES;"
```

**Note**: This command can only be used if the resources are currently _running_.

### Wrapping up

The last step to get up and running with a Docker environment is to simply start the resources defined in the `docker-compose.yaml` manifest. The following command can be run from the directory where the global resources are stored;

```bash
# In the foreground...
docker-compose up
 
# Or in the background...
docker-compose up -d
```

## Setup

### Container Initialization

Once a Docker environment is available, start by cloning the repository to the local machine.

```bash
git clone git@github.com:DefrostedTuna/viiidb-api.git && cd viiidb-api
```

Copy the example environment configuration and modify it according to your needs.

```bash
cp .env.example .env
```

Bind the `VIRTUAL_HOST` value specified in `.env` to your systems `hosts` file.

```bash
# /etc/hosts -- Unix Systems
# C:\Windows\System32\drivers\etc\hosts -- Windows Systems
 
127.0.0.1    api.local.viiidb.com
```

With this taken care of, the Docker container can be initialized.

```bash
docker-compose up
```

If at any time the contents of `.env` are modified and the changes do not take effect, the Docker container can be restarted to apply the changes.

```bash
docker-compose restart
```

### Installing Dependencies

If this is the first time setting up VIIIDB API locally, the dependencies will need to be installed via Composer. While this can be done locally, it is highly recommended to install them from within the container instance. This will reduce version conflicts and ensure a more stable environment. Install the dependencies by running the following command;

```bash
docker-compose exec viiidb-api composer install --no-interaction
```

### Application Key Generation

If this is the first time setting up VIIIDB API locally, an application key will need to be generated. This can be done either from the local machine, or from within the container.

```bash
docker-compose exec viiidb-api php artisan key:generate
```

### Database & Migrations

VIIIDB API does not ship with a database container. With this being the case, a standalone database instance must be accessible. The [Global Resources](#global-resources) section covers how to spin up a database container. To create the default database using this method, navigate to the directory where the global Docker resources are stored and run the following command.

```bash
docker-compose exec database mysql -u root -psecret -e "CREATE DATABASE viiidb";
```

With an existing database in place, migrations can be run to create the tables. Migrations should always be performed from _within_ the Docker container. This ensures the correct database and environment are targeted during the migration.

```bash
docker-compose exec viiidb-api php artisan migrate
```

## Testing

VIIIDB API uses PHPUnit for testing. Unit tests should be run from _inside_ the container in order to ensure proper database functionality across all testing suites.

```bash
docker-compose exec viiidb-api vendor/bin/phpunit
```

XDebug is enabled out of the box for local development which allows code coverage reports to be easily generated.

```bash
docker-compose exec viiidb-api vendor/bin/phpunit --coverage-text
```

These commands can be aliased to make frequent testing easier

```bash
alias t="docker-compose exec viiidb-api vendor/bin/phpunit"
 
# Tests can now be run with...
 
t
t --coverage-text
```