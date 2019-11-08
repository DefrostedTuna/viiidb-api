# VIIIDB API

<p align="center">
  <img src="https://img.shields.io/circleci/build/github/DefrostedTuna/viiidb-api/master?logo=circleci&style=for-the-badge" alt="Build Status">
</p>

VIIIDB is a project that aims to bring all of the information related to Final Fantasy VIII to a simple, elegant API. VIIIDB is currently under construction and is subject to major additions and/or project changes. The final product will consist of a back end API that is publicly accessible, as well as a front end UI for general consumption.

An API documentation page will be placed here once it is completed.

## Getting Started

### Prerequisites

  To get up and running with VIIIDB locally, a couple of things need to be set up beforehand.

  ##### Docker
  VIIIDB API is built on PHP, Laravel and [Docker](https://docker.com). The development environment utilizes `docker-compose` to quickly spin up the application. As such, Docker is going to be the first and foremost requirement. If running on a Mac, simply get Docker Desktop and go from there.

  ##### Reverse Proxy
  Once Docker is up and running, a reverse proxy should be set up to route traffic around the Docker network. The easiest way to handle this is by setting up a global set of resources using `docker-compose`.

  Create a `docker-compose.yaml` file in a directory of your choosing (something like `~/Utilities`) and paste the following contents:

  ```yaml
  version: '3'

  networks:
    viiidb:
      external:
        name: viiidb

  services:
    nginx-proxy:
      image: jwilder/nginx-proxy
      container_name: reverse-proxy
      ports:
        - "80:80"
        - "443:443"
      volumes:
        - /var/run/docker.sock:/tmp/docker.sock:ro
      networks:
        - viiidb
  ```

  This will enable the use of a reverse proxy, and will allow traffic to be routed throughout the `viiidb` network.

  Before Docker can route the traffic around the `viiidb` network, the network must exist on the machine. The network can be created via the command line.

  ```bash
  docker create network viiidb
  ```

  Once the network and configuration have been created, the proxy container can be started using `docker-compose`.

  ```bash
  docker-compose up
  # Or in the background...
  docker-compose up -d
  ```

  The proxy container will listen for requests sent to `localhost` and route them to the container that has a matching `VIRTUAL_HOST` environment variable.

  ### Local Development

  Setting up VIIIDB for local development is quick and easy.

  Clone the repository to your local machine.

  ```
  git clone git@github.com:DefrostedTuna/viiidb-api.git && cd viiidb-api
  ```

  Copy the example environment configuration and modify it according to your needs.

  ```bash
  cp .env.example .env
  ```

  Generate an application key.

  ```bash
  php artisan key:generate
  ```

  Spin up the container.

  ```bash
  docker-compose up
  # Or in the background...
  docker-compose up -d
  ```

  Visit your fresh new API using the address specified under `VIRTUAL_HOST`!

  ##### Virtual Host Setup

  When setting up the environment variables, make sure that the value used for `VIRTUAL_HOST` is also present in the systems `hosts` file. For Mac OSX this is `/etc/hosts`.

  Example:

  ```bash
  # .env
  VIRTUAL_HOST=viiidb-api.local.example.com
  ```

  ```bash
  # /etc/hosts
  127.0.0.1    viiidb-api.local.example.com
  ```

  This will ensure that traffic gets routes the container when visiting `http://viiidb-api.local.example.com`.

  ##### Database

  VIIIDB does not ship with an internal database container. In order to connect to a database, an external connection will need to be provided. If an external database is not already set up, simply add a database container to a configuration.

  Using the `~/Utilities/docker-compose.yaml` configuration referenced under the prerequisites section, the following lines can be added to quickly spin up a connection.

  ```yaml
  services:
    # Proxy container lives up here...
    
    global_database:
      image: mysql:5.7
      container_name: global_database
      environment:
        MYSQL_USER: homestead
        MYSQL_PASSWORD: secret
        MYSQL_ROOT_PASSWORD: secret
      volumes:
        - ~/Utilities/mysql:/var/lib/mysql
      ports:
        - "3306:3306"
      networks:
        - viiidb
  ```

  When referencing the connection in the VIIIDB environment file, the container name `global_database` can be used in place of the `DB_HOST`.

  Migrations and Seeds (Ha! SeeDs... Some of you will understand...) will also need to be run if working with a fresh database. This can be done using the `artisan` command.

  ```bash
  php artisan migrate
  # Seeding the initial values...
  php artisan db:seed
  ```

## Deployment

  VIIIDB will be deployed on a Kubernetes cluster using Digital Ocean. Deployments are taken care of using Flux, and are controlled via a separate Git repository.

  ### New Deployments

  When deploying a new release to a cluster, please follow the instructions outlined in the repository for the cluster itself. The readme will provide clear steps to set up a new project and get it quickly deployed to a cluster.

  ### Updating a Release

  To deploy a new version release, simply create a version tag using the SemVer schema. Deployments are automatically tracked and updated based on the schema outlined in the target cluster's repository. For example, if the cluster is configured to watch for `~1.*`, tagging a release as `1.4.2` will automatically trigger an update if the currently deployed version is below `1.4.2`.

## Testing

  VIIIDB API uses PHPUnit for testing. The unit tests can be run by simply calling PHPUnit.

  ```bash
  vendor/bin/phpunit
  ```

  If a code coverage report is desired, unit tests can be run from inside the Docker container as the VIIIDB API development environment ships with XDebug enabled out of the box.

  ```bash
  docker-compose exec viiidb-api vendor/bin/phpunit --coverage-text
  ```