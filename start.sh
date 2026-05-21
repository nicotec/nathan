docker network create ai_network

# docker image prune -f

docker compose pull
# docker compose build --no-cache
docker compose -f docker-compose.yml -f docker-compose.dev.yml build --pull
docker compose -f docker-compose.yml -f docker-compose.dev.yml up
