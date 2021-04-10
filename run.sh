docker info > /dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."

    exit 1
fi

docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    bash -c "composer install --ignore-platform-reqs && cp .env.example .env && php artisan key:generate && php ./artisan sail:install --with=mysql,meilisearch"

./vendor/bin/sail up -d && \
./vendor/bin/sail php artisan migrate && \
./vendor/bin/sail php artisan festivities:load