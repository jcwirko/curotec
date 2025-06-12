# ============================
# GENERAL VARIABLES
# ============================

ENV = development

# Nadal env variables
include .env.${ENV}
export

# Docker Compose
DOCKER_COMPOSE_YML := -f docker-compose.yml

# ============================
# MAIN COMMANDS
# ============================

up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear docker-build docker-up
ps: docker-ps
clean: docker-clean

# ============================
# BUILD TASKS
# ============================

build-fd: copy-laravel-env add-testing-database build-minio build-laravel

copy-laravel-env: ## Copy .env${ENV} to .env if it doesn't already exist
	$(call print_banner, Checking if .env already exists...)
	docker compose $(DOCKER_COMPOSE_YML) run --rm -it --workdir=$(BACKEND_CONTAINER_PATH) findra-laravel-builder sh -c \
		"if [ ! -f .env ]; then if [ -f .env.${ENV} ]; then cp .env.${ENV} .env; fi; fi"

build-minio: ## Set up MinIO and required buckets
	$(call print_banner, Setting up MinIO and required buckets...)
	docker compose up findra-minio -d
	docker exec -it findra-minio mc alias set finaldraw $(APP_URL):$(MINIO_API_PORT) $(MINIO_ROOT_USER) $(MINIO_ROOT_PASSWORD)
	docker exec -it findra-minio mc mb finaldraw/$(MINIO_BUCKET)
	docker exec -it findra-minio mc anonymous set public finaldraw/$(MINIO_BUCKET)
	docker exec -it findra-minio mc mb finaldraw/$(MINIO_BUCKET_TEST)
	docker exec -it findra-minio mc anonymous set public finaldraw/$(MINIO_BUCKET_TEST)
	docker exec -it findra-minio mc admin user svcacct add --access-key "minio_access_key_fd" --secret-key "minio_private_key_fd" finaldraw minio

add-testing-database: ## Add a testing database for Laravel
	$(call print_banner, Adding a testing database for Laravel...)
	docker exec -it findra-mysql mysql -u root -proot -e \
		"CREATE USER IF NOT EXISTS '$(DB_USERNAME)'@'%' IDENTIFIED BY '$(DB_PASSWORD)'; GRANT ALL PRIVILEGES ON *.* TO '$(DB_USERNAME)'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES;"
	env $(cat ./.env.testing | xargs) docker exec -it findra-mysql mysql -u $(DB_USERNAME) -p$(DB_PASSWORD) -e \
		"DROP DATABASE IF EXISTS $(DB_DATABASE_TESTING); CREATE DATABASE $(DB_DATABASE_TESTING);"

build-laravel: ## Run Laravel setup script and generate RSA keys
	$(call print_banner, Running Laravel setup and generating RSA keys...)
	docker compose $(DOCKER_COMPOSE_YML) run --rm -it findra-laravel-builder /usr/local/bin/laravel-setup.sh
	docker compose $(DOCKER_COMPOSE_YML) run --rm -it findra-laravel-builder php artisan nadal:generate-rsa-crypto-keys

# ============================
# DOCKER TASKS
# ============================

docker-up: ## Start Docker containers
	$(call print_banner, Starting Docker containers...)

	docker compose $(DOCKER_COMPOSE_YML) up -d

docker-down: ## Stop Docker containers
	$(call print_banner, Stopping Docker containers...)
	docker compose down

docker-down-clear: ## Stop and remove all Docker containers, images, and volumes
	$(call print_banner, Clearing all Docker containers, images, and volumes...)
	docker compose down --rmi all --volumes

docker-clean: ## Clean Docker environment
	$(call print_banner, Cleaning Docker environment...)
	docker compose down --rmi all --volumes

docker-ps: ## Show Docker containers' status
	$(call print_banner, Showing Docker containers' status...)
	docker compose ps

# Define la función para imprimir mensajes decorativos
define print_banner
	@echo "\n#########################################"
	@echo "####  $(1)"
	@echo "#########################################\n"
endef
