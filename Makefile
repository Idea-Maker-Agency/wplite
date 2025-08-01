sass_dir ?= templates

watch\:sass:
	docker compose run --rm sass sh -c "npm run watch:$(sass_dir)-sass"

name ?= wplite

compile:
	docker compose run --rm sass sh -c "npm run compile:sass && cp -r theme $(name) && npx bestzip $(name).zip $(name)/* && rm -r $(name)"