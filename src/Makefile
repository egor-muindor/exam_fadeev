ROOT_DIR=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

PHPSTAN=$(ROOT_DIR)/vendor/bin/phpstan
PHPSTAN_OPTIONS=--memory-limit=2G

PHPCS=$(ROOT_DIR)/vendor/bin/php-cs-fixer

analyse:
	@$(PHPSTAN) analyse $(PHPSTAN_OPTIONS)
	@echo 'PHPSTAN: OK\n'

phpcs:
	@$(PHPCS) fix --config=$(ROOT_DIR)/.php-cs-fixer.dist.php -v --dry-run --using-cache=no
	@echo 'PHPCS: OK\n'

phpcsfix:
	@$(PHPCS) fix --config=$(ROOT_DIR)/.php-cs-fixer.dist.php --using-cache=no

lint: phpcs analyse
