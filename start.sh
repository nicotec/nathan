docker network create ai_network

docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build --pull always
