COMPOSE = docker compose        # or docker-compose if you installed the old tool

build:
	$(COMPOSE) build --pull        # no hard-coded path needed

run:
	$(COMPOSE) up -d --build       # -d now legal because 'compose' exists
	@echo "🚀 App on http://localhost:8000"
