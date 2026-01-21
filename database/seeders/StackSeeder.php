<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StackSeeder extends Seeder
{
  public function run()
  {
    Schema::disableForeignKeyConstraints();
    Stack::truncate();
    DB::table('stack_variables')->truncate();
    Schema::enableForeignKeyConstraints();

    DB::transaction(function () {
      // --- DATABASES ---
      $this->createPostgresAlpine();
      $this->createMysql();
      $this->createMariaDB();
      $this->createMongoDB();
      $this->createRedis();

      // --- APPLICATIONS ---
      $this->createLaravel();
    });
  }

  // 1. POSTGRESQL
  private function createPostgresAlpine()
  {
    $compose = <<<'YAML'
services:
  db:
    container_name: ${SERVICE_NAME}
    image: postgres:${PG_VERSION}-alpine
    restart: unless-stopped
    command: postgres -p ${DB_INTERNAL_PORT}
    ports:
      - "${DB_PORT}:${DB_INTERNAL_PORT}"
    environment:
      POSTGRES_DB: ${DB_NAME}
      POSTGRES_USER: ${DB_USER}
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - ${SERVICE_NAME}_data:/var/lib/postgresql/data
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}

volumes:
  ${SERVICE_NAME}_data:
YAML;

    $stack = Stack::create([
      'name' => 'PostgreSQL (Alpine)',
      'slug' => 'postgresql-alpine',
      'type' => 'database',
      'description' => 'Advanced Open Source Relational Database.',
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'Version', 'env_key' => 'PG_VERSION', 'type' => 'select', 'default_value' => '14,15,16,17,18', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'DB_INTERNAL_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => true],
      ['label' => 'DB Name', 'env_key' => 'DB_NAME', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => true],
      ['label' => 'DB User', 'env_key' => 'DB_USER', 'type' => 'text', 'default_value' => 'postgres', 'is_required' => true],
      ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
    ]);
  }

  // 2. MYSQL
  private function createMysql()
  {
    $compose = <<<'YAML'
services:
  db:
    container_name: ${SERVICE_NAME}
    image: mysql:${MYSQL_VERSION}
    restart: unless-stopped
    command: --port=${DB_INTERNAL_PORT}
    ports:
      - "${DB_PORT}:${DB_INTERNAL_PORT}"
    environment:
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
    volumes:
      - ${SERVICE_NAME}_data:/var/lib/mysql
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}

volumes:
  ${SERVICE_NAME}_data:
YAML;

    $stack = Stack::create([
      'name' => 'MySQL',
      'slug' => 'mysql',
      'type' => 'database',
      'description' => 'The most popular Open Source SQL Database.',
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'Version', 'env_key' => 'MYSQL_VERSION', 'type' => 'select', 'default_value' => '8.4,8.0,5.7', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '3306', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'DB_INTERNAL_PORT', 'type' => 'number', 'default_value' => '3306', 'is_required' => true],
      ['label' => 'DB Name', 'env_key' => 'DB_NAME', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => true],
      ['label' => 'DB User', 'env_key' => 'DB_USER', 'type' => 'text', 'default_value' => 'app_user', 'is_required' => true],
      ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
      ['label' => 'Root Password', 'env_key' => 'DB_ROOT_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
    ]);
  }

  // 3. MARIADB
  private function createMariaDB()
  {
    $compose = <<<'YAML'
services:
  db:
    container_name: ${SERVICE_NAME}
    image: mariadb:${MARIADB_VERSION}
    restart: unless-stopped
    command: --port=${DB_INTERNAL_PORT}
    ports:
      - "${DB_PORT}:${DB_INTERNAL_PORT}"
    environment:
      MARIADB_DATABASE: ${DB_NAME}
      MARIADB_USER: ${DB_USER}
      MARIADB_PASSWORD: ${DB_PASSWORD}
      MARIADB_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
    volumes:
      - ${SERVICE_NAME}_data:/var/lib/mysql
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}

volumes:
  ${SERVICE_NAME}_data:
YAML;

    $stack = Stack::create([
      'name' => 'MariaDB',
      'slug' => 'mariadb',
      'type' => 'database',
      'description' => 'Open source drop-in replacement for MySQL.',
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'Version', 'env_key' => 'MARIADB_VERSION', 'type' => 'select', 'default_value' => '10.11,11.2,11.4,latest', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '3306', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'DB_INTERNAL_PORT', 'type' => 'number', 'default_value' => '3306', 'is_required' => true],
      ['label' => 'DB Name', 'env_key' => 'DB_NAME', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => true],
      ['label' => 'DB User', 'env_key' => 'DB_USER', 'type' => 'text', 'default_value' => 'app_user', 'is_required' => true],
      ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
      ['label' => 'Root Password', 'env_key' => 'DB_ROOT_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
    ]);
  }

  // 4. REDIS
  private function createRedis()
  {
    $compose = <<<'YAML'
services:
  cache:
    container_name: ${SERVICE_NAME}
    image: redis:${REDIS_VERSION}-alpine
    restart: unless-stopped
    command: redis-server --port ${REDIS_INTERNAL_PORT} --requirepass ${REDIS_PASSWORD}
    ports:
      - "${REDIS_PORT}:${REDIS_INTERNAL_PORT}"
    volumes:
      - ${SERVICE_NAME}_data:/data
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}

volumes:
  ${SERVICE_NAME}_data:
YAML;

    $stack = Stack::create([
      'name' => 'Redis',
      'slug' => 'redis',
      'type' => 'cache',
      'description' => 'In-memory data structure store, used as a database, cache, and message broker.',
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'Version', 'env_key' => 'REDIS_VERSION', 'type' => 'select', 'default_value' => '7.4,7.2,7.0,6.2', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'REDIS_PORT', 'type' => 'number', 'default_value' => '6379', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'REDIS_INTERNAL_PORT', 'type' => 'number', 'default_value' => '6379', 'is_required' => true],
      ['label' => 'Password', 'env_key' => 'REDIS_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
    ]);
  }

  // 5. MONGODB
  private function createMongoDB()
  {
    $compose = <<<'YAML'
services:
  db:
    container_name: ${SERVICE_NAME}
    image: mongo:${MONGO_VERSION}
    restart: unless-stopped
    command: --port ${DB_INTERNAL_PORT}
    ports:
      - "${DB_PORT}:${DB_INTERNAL_PORT}"
    environment:
      MONGO_INITDB_ROOT_USERNAME: ${DB_USER}
      MONGO_INITDB_ROOT_PASSWORD: ${DB_PASSWORD}
    volumes:
      - ${SERVICE_NAME}_data:/data/db
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}

volumes:
  ${SERVICE_NAME}_data:
YAML;

    $stack = Stack::create([
      'name' => 'MongoDB',
      'slug' => 'mongodb',
      'type' => 'database',
      'description' => 'The most popular database for modern apps (NoSQL).',
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'Version', 'env_key' => 'MONGO_VERSION', 'type' => 'select', 'default_value' => '8.0,7.0,6.0,5.0', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '27017', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'DB_INTERNAL_PORT', 'type' => 'number', 'default_value' => '27017', 'is_required' => true],
      ['label' => 'Root User', 'env_key' => 'DB_USER', 'type' => 'text', 'default_value' => 'admin', 'is_required' => true],
      ['label' => 'Root Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
    ]);
  }

  // 6. LARAVEL
  private function createLaravel()
  {
    $dockerfile = <<<'EOT'
ARG NODE_VERSION=20
ARG PHP_VERSION=8.2

FROM node:${NODE_VERSION}-alpine as node_source

FROM php:${PHP_VERSION}-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev default-libmysqlclient-dev \
    # Install PHP Core Extensions
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd \
    # Install Redis Extension
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=node_source /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_source /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
WORKDIR /var/www/html
EOT;

    $compose = <<<'YAML'
services:
  app:
    container_name: ${SERVICE_NAME}
    restart: unless-stopped
    build:
      context: .
      args:
        PHP_VERSION: ${PHP_VERSION}
        NODE_VERSION: ${NODE_VERSION}
    
    command: sh -c "composer install --no-dev --ignore-platform-reqs && php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${APP_INTERNAL_PORT}"
    
    ports:
      - "${APP_PORT}:${APP_INTERNAL_PORT}"
    environment:
      APP_KEY: ${APP_KEY}
      APP_ENV: ${APP_ENV}
      APP_DEBUG: ${APP_DEBUG}
      
      DB_CONNECTION: ${DB_CONNECTION} 
      DB_HOST: ${DB_HOST}
      DB_PORT: ${DB_PORT}
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}

      REDIS_HOST: ${REDIS_HOST}
      REDIS_PASSWORD: ${REDIS_PASSWORD}
      REDIS_PORT: ${REDIS_PORT}

    volumes:
      - ./code:/var/www/html
    networks:
      - ${NETWORK_NAME}

networks:
  ${NETWORK_NAME}:
    external: true
    name: ${NETWORK_NAME}
YAML;

    $stack = Stack::create([
      'name' => 'Laravel',
      'slug' => 'laravel',
      'type' => 'application',
      'description' => 'Laravel App with MySQL, PostgreSQL, MariaDB, MongoDB, & Redis Support.',
      'build_dockerfile' => $dockerfile,
      'build_script' => "composer install --no-dev --optimize-autoloader\nphp artisan migrate --force",
      'raw_compose_template' => $compose,
      'is_active' => true,
    ]);

    $stack->variables()->createMany([
      ['label' => 'PHP Version', 'env_key' => 'PHP_VERSION', 'type' => 'select', 'default_value' => '8.1,8.2,8.3,8.4', 'is_required' => true],
      ['label' => 'NodeJS Version', 'env_key' => 'NODE_VERSION', 'type' => 'select', 'default_value' => '18,20,22', 'is_required' => true],
      ['label' => 'Public Port', 'env_key' => 'APP_PORT', 'type' => 'number', 'default_value' => '8000', 'is_required' => true],
      ['label' => 'Internal Port', 'env_key' => 'APP_INTERNAL_PORT', 'type' => 'number', 'default_value' => '8000', 'is_required' => true],

      ['label' => 'App Key', 'env_key' => 'APP_KEY', 'type' => 'text', 'default_value' => '', 'is_required' => true],
      ['label' => 'App Environment', 'env_key' => 'APP_ENV', 'type' => 'select', 'default_value' => 'production,staging,testing,local', 'is_required' => true],
      ['label' => 'App Debug', 'env_key' => 'APP_DEBUG', 'type' => 'select', 'default_value' => 'false,true', 'is_required' => true],

      // --- DB ---
      ['label' => 'DB Driver', 'env_key' => 'DB_CONNECTION', 'type' => 'select', 'default_value' => 'pgsql,mysql,mariadb,sqlite', 'is_required' => true],
      ['label' => 'DB Host', 'env_key' => 'DB_HOST', 'type' => 'text', 'default_value' => 'db', 'is_required' => false],
      ['label' => 'DB Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => false],
      ['label' => 'DB Name', 'env_key' => 'DB_DATABASE', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => false],
      ['label' => 'DB User', 'env_key' => 'DB_USERNAME', 'type' => 'text', 'default_value' => 'postgres', 'is_required' => false],
      ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => false],

      // --- REDIS (Optional Defaults) ---
      ['label' => 'Redis Host', 'env_key' => 'REDIS_HOST', 'type' => 'text', 'default_value' => 'redis', 'is_required' => false],
      ['label' => 'Redis Port', 'env_key' => 'REDIS_PORT', 'type' => 'number', 'default_value' => '6379', 'is_required' => false],
      ['label' => 'Redis Password', 'env_key' => 'REDIS_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => false],
    ]);
  }
}
