docker network create ai_network

docker image prune -f

docker compose pull
docker compose build --no-cache
docker compose build --pull
docker compose up
