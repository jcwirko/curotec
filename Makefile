include .env.local
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

build-app: copy-laravel-env build-laravel

copy-laravel-env: ## Copy .env${ENV} to .env if it doesn't already exist
	$(call print_banner, Checking if .env already exists...)
	docker compose $(DOCKER_COMPOSE_YML) run --rm -it --workdir=$(BACKEND_CONTAINER_PATH) curotec-laravel-builder sh -c \
		"if [ ! -f .env ]; then if [ -f .env.local ]; then cp .env.local .env; fi; fi"

build-laravel: ## Run Laravel setup script and generate RSA keys
	$(call print_banner, Running Laravel setup...)
	docker compose $(DOCKER_COMPOSE_YML) run --rm -it curotec-laravel-builder /usr/local/bin/laravel-setup.sh

# ============================
# DOCKER TASKS
# ============================

docker-up: ## Start Docker containers
	$(call print_banner, Starting Docker containers...)

	docker compose $(DOCKER_COMPOSE_YML) up -d

# Define la función para imprimir mensajes decorativos
define print_banner
	@echo "\n#########################################"
	@echo "####  $(1)"
	@echo "#########################################\n"
endef
