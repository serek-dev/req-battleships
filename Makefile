.PHONY: help

docker-compose=docker-compose

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

start: _install tests_unit ### Start local env and tests

_install:
	$(docker-compose) build
	$(docker-compose) run --rm lib install

tests: tests_unit tests_acceptance ### Runs all tests to prove it works :)

tests_unit: ### Runs unit tests
	$(docker-compose) run --rm lib tests:unit

tests_acceptance: ### Runs acceptance test
	$(docker-compose) run --rm lib tests:acceptance

bash: ### Runs container in bash mode
	$(docker-compose) run --rm lib bash

stop: ### Cleans up the environment
	docker-compose down -v --remove-orphans
	docker network prune -f

play:
	$(docker-compose) run --rm lib play
