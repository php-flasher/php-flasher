.PHONY: install update

## 🧙‍ Installs the project dependencies and assets
install: composer.lock
	$(COMPOSER) install $(COMPOSER_ARGS)

## Upgrades your dependencies to the latest version according to composer.json, and updates the composer.lock file.
update:
	$(COMPOSER) update --lock $(COMPOSER_ARGS)
