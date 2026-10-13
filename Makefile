.DEFAULT_GOAL := install

USER_ID ?= $(shell id -u)

NGINX_PORT ?= $(shell \
	grep -oP -e '(?<=^NGINX_PORT=)\d+$$' .env.local || \
	grep -oP -e '(?<=^NGINX_PORT=)\d+$$' .env || \
	echo '80' \
)

MANTICORE_SQL_PORT ?= $(shell \
	grep -oP -e '(?<=^MANTICORE_SQL_PORT=)\d+$$' .env.local || \
	grep -oP -e '(?<=^MANTICORE_SQL_PORT=)\d+$$' .env || \
	echo '9306' \
)

MARIADB_PORT ?= $(shell \
	grep -oP -e '(?<=^MARIADB_PORT=)\d+$$' .env.local || \
	grep -oP -e '(?<=^MARIADB_PORT=)\d+$$' .env || \
	echo '3306' \
)

override DYSPLAYED_HOST = http://localhost$(shell \
	[ ${NGINX_PORT} != 80 ] && echo ":${NGINX_PORT}" \
)

override DOCKER_COMPOSE = \
	USER_ID=${USER_ID} \
	NGINX_PORT=${NGINX_PORT} \
	MANTICORE_SQL_PORT=${MANTICORE_SQL_PORT} \
	MARIADB_PORT=${MARIADB_PORT} \
	docker compose

.PHONY: .install .up .upinfo install build up down phpstan cscheck csfix test \
	test-trigger cover cover-html

.install:
	@${DOCKER_COMPOSE} exec php sh -c " \
		composer install; \
		bin/console doctrine:migrations:sync-metadata-storage; \
		bin/console doctrine:migration:migrate --no-interaction; \
		bin/console foundry:load-fixtures --no-interaction order; \
		bin/console doctrine:migrations:sync-metadata-storage --env=test; \
		bin/console doctrine:migration:migrate --no-interaction --env=test; \
		bin/console app:manticore:populate; \
	"

.up:
	@${DOCKER_COMPOSE} up -d

.upinfo:
	@echo
	@echo -e "Application started at    \033[4;36m${DYSPLAYED_HOST}\033[0m"
	@echo -e "REST API documentation at \033[4;36m${DYSPLAYED_HOST}/api/doc\033[0m"
	@echo -e "SOAP API documentation at \033[4;36m${DYSPLAYED_HOST}/soap/doc/\033[0m"
	@echo -e "Test coverage at          \033[4;36m${DYSPLAYED_HOST}/coverage/index.html\033[0m"
	@echo

install: build .up .install cover-html .upinfo

build:
	@${DOCKER_COMPOSE} build

up: .up .upinfo

down:
	@${DOCKER_COMPOSE} down

phpstan:
	@${DOCKER_COMPOSE} exec php bin/phpstan --memory-limit=256M

cscheck:
	@${DOCKER_COMPOSE} exec php bin/php-cs-fixer check --verbose

csfix:
	@${DOCKER_COMPOSE} exec php bin/php-cs-fixer fix

test:
	@${DOCKER_COMPOSE} exec php bin/phpunit --display-all-issues $(c)

test-trigger:
	@${DOCKER_COMPOSE} exec --env XDEBUG_TRIGGER=1 php bin/phpunit $(c)

cover:
	@${DOCKER_COMPOSE} exec --env XDEBUG_MODE=coverage php \
		bin/phpunit --coverage-text

cover-html:
	@${DOCKER_COMPOSE} exec --env XDEBUG_MODE=coverage php \
		bin/phpunit --coverage-html ./public/coverage
