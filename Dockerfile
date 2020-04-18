FROM php:7.4-zts-alpine

COPY . /usr/src/lifeinphp74

WORKDIR /usr/src/lifeinphp74

CMD ["php", "app/run.php"]
