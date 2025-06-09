# build:
# 	docker build --platform linux/amd64 -t optimuswest/mkulima-loan-app:v1.0.9 -f docker/php.dockerfile .

# run:
# 	docker stop mkulima-app || true && docker rm mkulima-app || true && docker run -d -p 8000:80 --name mkulima-app optimuswest/mkulima-loan-app:v1.0.9

# push:
# 	docker push optimuswest/mkulima-loan-app:v1.0.9
	

# ───────────────────────────────
# Makefile – Laravel docker stack
# ───────────────────────────────

COMPOSE = docker compose      # or "docker-compose" if you use the legacy plugin
PROJECT = mkulima             # shown in docker ps as mkulima-php / mkulima-nginx

# ---------------------------------
# Images / services
# ---------------------------------
build:
	$(COMPOSE) build --pull

run:                          ## Build (if needed) and start containers in detached mode
	$(COMPOSE) up -d --build
	@echo "🚀 $(PROJECT) is running → http://localhost:8000"

stop:                         ## Stop containers but keep them
	$(COMPOSE) stop

restart:                      ## Restart without rebuilding
	$(COMPOSE) restart

logs:                         ## Follow logs from all services
	$(COMPOSE) logs -f --tail=50

ps:                           ## Show service status table
	$(COMPOSE) ps

clean:                        ## Stop & remove everything (containers, network, volumes)
	$(COMPOSE) down --volume
