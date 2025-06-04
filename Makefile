build:
	docker build --platform linux/amd64 -t optimuswest/mkulima-loan-app:v1.0.7 -f docker/dockerfile .

run:
	docker stop mkulima-app || true && docker rm mkulima-app || true && docker run -d -p 8000:80 --name mkulima-app optimuswest/mkulima-loan-app:v1.0.7

push:
	docker push optimuswest/mkulima-loan-app:v1.0.7
	

