theme-build:
	docker compose run --rm sass sh -c "npm run compile:sass && npm run compile:purify-css && cp -r theme wplite"
