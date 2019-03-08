# URLShortener

Built using vanilla php and mysql.

# Run instructions

    git clone https://github.com/Fraser0319/URLShortener.git

    docker-compose up --build

HTTP Endpoints

Return all short urls

    http://localhost:8100/shorten
    Returns an array of short URL's

Get a short URL

    http://localhost:8100/shorten?url=https://github.com
    Returns a short url

Get original URL

    http://localhost:8100/{shortCode}
    Redirects to original url


# To run the tests 

while docker-compose up is running

    docker ps

get the container id for the apache server container.

and pass the conainter id into this commannd.

    docker exec -i -t <ContainerId>  ./phpunit --bootstrap URLShortener.php tests/URLShortenerTest
