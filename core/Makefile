ARTISAN ?= $(COMPOSE) exec -T php php /var/www/html/core/artisan

migrate:
	$(ARTISAN) migrate

seed:
	$(ARTISAN) db:seed

refresh:
	$(ARTISAN) migrate:fresh --seed