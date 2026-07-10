build:
	docker compose run --rm nodejs sh -c "cd theme && npx wp-scripts plugin-zip && mv wplite.zip .."