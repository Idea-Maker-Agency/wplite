theme_name ?= wplite

theme-build:
	docker compose run --rm sass sh -c "npm run compile:sass && cp -r theme $(theme_name) && npx bestzip $(theme_name).zip $(theme_name)/* && rm -r $(theme_name)"

watch\:templates-sass:
	docker compose run --rm sass sh -c "npm run watch:templates-sass"

watch\:page-templates-sass:
	docker compose run --rm sass sh -c "npm run watch:page-templates-sass"