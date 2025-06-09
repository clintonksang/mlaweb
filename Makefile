COMPOSE = docker compose
       # or docker-compose if you installed the old tool

build:
	$(COMPOSE) build --pull        # no hard-coded path needed

run:
	$(COMPOSE) up -d --build       # -d now legal because 'compose' exists
	@echo "🚀 App on http://localhost:8000"
logs:                             ## Follow logs (all) or `make logs SERVICE=php`
	$(COMPOSE) logs -f --tail=50 $(SERVICE)

stop:
	$(COMPOSE) down

ARTISAN = $(COMPOSE) exec -T php php /var/www/html/core/artisan

migrate:
	$(ARTISAN) migrate

seed:
	$(ARTISAN) db:seed

refresh:
	$(ARTISAN) migrate:fresh --seed

.PHONY: logs migrate seed refresh