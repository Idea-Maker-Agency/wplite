dev:
	docker compose run --rm sass sh -c "npm run watch:sass"

dev\:templates:
	docker compose run --rm sass sh -c "npm run watch:templates-sass"

dev\:page-templates:
	docker compose run --rm sass sh -c "npm run watch:page-templates-sass"

name ?= wplite

compile:
	docker compose run --rm sass sh -c "npm run compile:sass && cp -r theme $(name) && npx bestzip $(name).zip $(name)/* && rm -r $(name)"