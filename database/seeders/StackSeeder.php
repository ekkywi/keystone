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
        // 1. Reset Database dengan Aman
        Schema::disableForeignKeyConstraints();
        Stack::truncate();
        DB::table('stack_variables')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Jalankan Seeder
        DB::transaction(function () {
            $this->createRobustPostgres();
            $this->createRobustLaravel();
        });
    }

    private function createRobustPostgres()
    {
        $compose = <<<'YAML'
services:
  db:
    container_name: ${SERVICE_NAME}
    image: postgres:${PG_VERSION}-alpine
    restart: unless-stopped
    # COMMAND: Memaksa Postgres listen di Internal Port pilihan user
    command: postgres -p ${DB_INTERNAL_PORT}
    ports:
      # Format: "HostPort : ContainerPort"
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
            'name' => 'PostgreSQL (Robust)',
            'slug' => 'postgres-robust',
            'type' => 'service',
            'description' => 'PostgreSQL dengan Full Port Control (Public & Internal).',
            'raw_compose_template' => $compose,
            'is_active' => true,
        ]);

        $stack->variables()->createMany([
            ['label' => 'Version', 'env_key' => 'PG_VERSION', 'type' => 'select', 'default_value' => '14,15,16,17', 'is_required' => true],
            
            // --- PORT CONFIGURATION ---
            ['label' => 'Public Port (Host)', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => true],
            ['label' => 'Internal Port (Container)', 'env_key' => 'DB_INTERNAL_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => true],
            
            ['label' => 'DB Name', 'env_key' => 'DB_NAME', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => true],
            ['label' => 'DB User', 'env_key' => 'DB_USER', 'type' => 'text', 'default_value' => 'postgres', 'is_required' => true],
            ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
        ]);
    }

    private function createRobustLaravel()
    {
        // PERBAIKAN 1: ARG ditaruh paling atas (Global Scope) agar terbaca oleh FROM
        // PERBAIKAN 2: Install libpq-dev dan pdo_pgsql untuk PostgreSQL
        $dockerfile = <<<'EOT'
ARG NODE_VERSION=18
ARG PHP_VERSION=8.2

FROM node:${NODE_VERSION}-alpine as node_source

FROM php:${PHP_VERSION}-fpm

# Install Dependencies (Termasuk Driver Postgres)
RUN apt-get update && apt-get install -y git curl zip unzip libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=node_source /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_source /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
WORKDIR /var/www/html
EOT;

        // PERBAIKAN 3: Command menggunakan 'sh -c' untuk menjalankan composer install sebelum serve
        // PERBAIKAN 4: Inject DB_CONNECTION: pgsql
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
    
    # COMMAND VITAL: Install Vendor -> Migrate -> Serve
    command: sh -c "composer install --no-dev --ignore-platform-reqs && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${APP_INTERNAL_PORT}"
    
    ports:
      # Format: "HostPort : ContainerPort"
      - "${APP_PORT}:${APP_INTERNAL_PORT}"
    environment:
      APP_KEY: ${APP_KEY}
      APP_ENV: ${APP_ENV}
      APP_DEBUG: ${APP_DEBUG}
      
      # Database Connection
      DB_CONNECTION: pgsql
      DB_HOST: ${DB_HOST}
      DB_PORT: ${DB_PORT}
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}
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
            'name' => 'Laravel App (Robust)',
            'slug' => 'laravel-robust',
            'type' => 'application',
            'description' => 'Laravel App + Postgres Support (Auto Composer & Migrate).',
            'build_dockerfile' => $dockerfile, 
            'build_script' => "composer install --no-dev --optimize-autoloader\nphp artisan migrate --force", 
            'raw_compose_template' => $compose,
            'is_active' => true,
        ]);

        $stack->variables()->createMany([
            ['label' => 'PHP Version', 'env_key' => 'PHP_VERSION', 'type' => 'select', 'default_value' => '8.1,8.2,8.3', 'is_required' => true],
            // Perbaikan: Membersihkan typo copy-paste terminal
            ['label' => 'NodeJS Version', 'env_key' => 'NODE_VERSION', 'type' => 'select', 'default_value' => '16,18,20', 'is_required' => true],
            
            // --- PORT CONFIGURATION ---
            ['label' => 'Public App Port (Host)', 'env_key' => 'APP_PORT', 'type' => 'number', 'default_value' => '8000', 'is_required' => true],
            ['label' => 'Internal App Port (Container)', 'env_key' => 'APP_INTERNAL_PORT', 'type' => 'number', 'default_value' => '8000', 'is_required' => true],
            // --------------------------

            ['label' => 'App Key', 'env_key' => 'APP_KEY', 'type' => 'text', 'default_value' => '', 'is_required' => true],
            ['label' => 'App Env', 'env_key' => 'APP_ENV', 'type' => 'select', 'default_value' => 'production,local', 'is_required' => true],
            ['label' => 'Debug', 'env_key' => 'APP_DEBUG', 'type' => 'boolean', 'default_value' => 'false', 'is_required' => true],
            
            // Database Vars
            ['label' => 'DB Host', 'env_key' => 'DB_HOST', 'type' => 'text', 'default_value' => 'db', 'is_required' => true],
            ['label' => 'DB Port', 'env_key' => 'DB_PORT', 'type' => 'number', 'default_value' => '5432', 'is_required' => true],
            ['label' => 'DB Name', 'env_key' => 'DB_DATABASE', 'type' => 'text', 'default_value' => 'keystone', 'is_required' => true],
            ['label' => 'DB User', 'env_key' => 'DB_USERNAME', 'type' => 'text', 'default_value' => 'postgres', 'is_required' => true],
            ['label' => 'DB Password', 'env_key' => 'DB_PASSWORD', 'type' => 'secret', 'default_value' => '', 'is_required' => true],
        ]);
    }
}