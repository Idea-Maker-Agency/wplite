dev:
	docker compose run --rm sass sh -c "npm run watch:sass"

compile:
	docker compose run --rm sass sh -c "npm run compile:sass"
	docker compose run --rm composer install --no-dev --optimize-autoloader
	docker compose run --rm sass sh -c "cd theme && npx wp-scripts plugin-zip && mv wplite.zip .."
	docker compose run --rm composer install