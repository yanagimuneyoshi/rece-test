# ベースイメージとしてPHP 7.4.9 FPMを使用
FROM php:7.4.9-fpm

# カスタムphp.iniをコピー
COPY php.ini /usr/local/etc/php/

# 必要なパッケージと拡張機能をインストール
RUN apt-get update && apt-get install -y \
  default-mysql-client \
  zlib1g-dev \
  libzip-dev \
  unzip \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libmagickwand-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) pdo_mysql zip gd \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composerをインストール
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# 作業ディレクトリを設定
WORKDIR /var/www

# プロジェクトファイルをコピー
COPY ./ php

# Imagickのインストール
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && pecl install imagick && docker-php-ext-enable imagick


# ポート80を公開
EXPOSE 80

# 起動スクリプトを定義
CMD ["php-fpm"]
