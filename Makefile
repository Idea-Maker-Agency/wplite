build:
	docker compose run --rm composer install --no-dev --optimize-autoloader
	docker compose run --rm nodejs sh -c "cd theme && npx wp-scripts plugin-zip && mv wplite.zip .."
	docker compose run --rm composer install