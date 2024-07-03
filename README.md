

# Rese

ユーザー登録、ログイン、店舗の閲覧、予約機能などを提供します。

## 環境構築

### Dockerビルド

1. リポジトリをクローンします：
   git clone リンク


2.  Dockerコンテナをビルドして起動します：
docker-compose up -d --build
MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

### Laravel環境構築

1.  PHPコンテナ内に入ります：

docker-compose exec php bash

2.  Composerの依存関係をインストールします：

composer install
3.  環境変数ファイルを設定します：

cp .env.example .env
4.  アプリケーションキーを生成します：

php artisan key:generate
5.  データベースをマイグレーションします：

php artisan migrate
6.  データベースをシーディングします：

php artisan db:seed

### 使用技術
PHP 7.4.9
Laravel 8.83.27
MySQL 15.1
URL
開発環境： http://localhost/
phpMyAdmin： http://localhost:8080/