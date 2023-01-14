.PHONY: lint fix

## Run code style, linters
lint:
	test `find ./src -iname "*.php" | xargs -n1 -P6 php -l | grep -Fv "No syntax errors" | wc -l` -eq 0
	$(PHP_CS_FIXER) fix --diff --dry-run -v
	$(COMPOSER)	normalize
	find src -name "composer.json" -exec $(COMPOSER) normalize {} \;
	$(COMPOSER)	validate --strict
	find src -name "composer.json" -exec $(COMPOSER) validate --strict {} \;
	find packs -name "composer.json" -exec $(COMPOSER) normalize {} \;

## Fix files with php-cs-fixer
fix:
	$(PHP_CS_FIXER) fix --allow-risky=yes
