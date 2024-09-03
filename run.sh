rm -rf dbData/
rm -rf app/logs/
if [[ $(docker ps -aqf name=web) ]]; then
    docker-compose down
    docker image rm securebs-web
    docker image rm mariadb
fi
docker compose up --build