name ?= wplite

theme-build:
	docker compose run --rm sass sh -c "npm run compile:sass && cp -r theme $(name) && npx bestzip $(name).zip $(name)/* && rm -r $(name)"
