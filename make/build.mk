.PHONY: assets build

## Download local assets from cdn
assets:
	bin/assets

# Build a new PHPFlasher version
build: lint assets
