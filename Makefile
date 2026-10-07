USER_ID ?= $(id -u)

override DOCKER_COMPOSE = USER_ID=${USER_ID} docker compose

.PHONY: build up down phpstan cscheck csfix test cover cover-html

build:
	@${DOCKER_COMPOSE} build

up:
	@${DOCKER_COMPOSE} up -d

down:
	@${DOCKER_COMPOSE} down

phpstan:
	@${DOCKER_COMPOSE} exec php bin/phpstan

cscheck:
	@${DOCKER_COMPOSE} exec php bin/php-cs-fixer check

csfix:
	@${DOCKER_COMPOSE} exec php bin/php-cs-fixer fix

test:
	@${DOCKER_COMPOSE} exec php bin/phpunit

cover:
	@${DOCKER_COMPOSE} exec --env XDEBUG_MODE=coverage php \
		bin/phpunit --coverage-text

cover-html:
	@${DOCKER_COMPOSE} exec --env XDEBUG_MODE=coverage php \
		bin/phpunit --coverage-html ./public/coverage
