.PHONY: help install test test-coverage test-ci clean
default: help
.DEFAULT_GOAL := help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install dependencies
	composer install --no-interaction --optimize-autoloader --prefer-dist --ansi --no-suggest

tests: ## Run the tests
	vendor/bin/phpspec run

tests-coverage: ## Run the tests with code coverage
	phpdbg -qrr vendor/bin/phpspec run -c phpspec-coverage.yml

clean: ## Clean temporary files and installed dependencies
	rm -rf vendor/

ci-tests: install ## [CI] Run the tests
	vendor/bin/phpspec run --no-interaction -f dot
