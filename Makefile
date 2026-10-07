USER_ID ?= $(id -u)

override DOCKER_COMPOSE = @USER_ID=${USER_ID} docker compose

.PHONY: build up down

build:
	${DOCKER_COMPOSE} build

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down
