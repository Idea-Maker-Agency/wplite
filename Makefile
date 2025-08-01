THEME_NAME ?= wplite

theme-build:
	docker compose run --rm sass sh -c "npm run compile:sass && cp -r theme $(THEME_NAME) && npx bestzip $(THEME_NAME).zip $(THEME_NAME)/* && rm -r $(THEME_NAME)"

watch\:templates-sass:
	docker compose run --rm sass sh -c "npm run watch:templates-sass"

watch\:page-templates-sass:
	docker compose run --rm sass sh -c "npm run watch:page-templates-sass"