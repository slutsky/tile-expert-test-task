USER_ID ?= $(id -u)

override DOCKER_COMPOSE = @USER_ID=${USER_ID} docker compose

.PHONY: build up down phpstan cscheck csfix

build:
	${DOCKER_COMPOSE} build

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down

phpstan:
	${DOCKER_COMPOSE} exec php bin/phpstan

cscheck:
	${DOCKER_COMPOSE} exec php bin/php-cs-fixer check

csfix:
	${DOCKER_COMPOSE} exec php bin/php-cs-fixer fix
