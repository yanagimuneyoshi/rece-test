

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
AWS: http://54.172.42.101/
メール送信機能の設定
Mailtrapを使用して、開発環境でのメール送信をテストします。.envファイルに以下の設定を追加します：
管理画面からのメール送信: 管理者は管理画面から利用者にお知らせメールを送信できます。

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"


AWSの設定
プロジェクトのデプロイにはAWSを使用します。以下の環境変数を.envファイルに追加します：


AWS_ACCESS_KEY_ID=your_aws_access_key_id
AWS_SECRET_ACCESS_KEY=your_aws_secret_access_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_s3_bucket_name
AWS_USE_PATH_STYLE_ENDPOINT=false


機能一覧
ユーザー登録: 新しいユーザーは登録してアカウントを作成できます。
ユーザーログイン: 登録済みユーザーはログインしてサービスを利用できます。
店舗の閲覧: ユーザーは店舗のリストを閲覧し、詳細情報を確認できます。
予約機能: ユーザーは店舗の予約を行うことができます。
評価機能: ユーザーは予約した店舗を評価することができます。
予約情報変更機能: ユーザーは予約情報を変更することができます。
QR決済機能: ユーザーはQRコードを使用して予約の支払いを行うことができます。
管理者機能: 管理者は店舗代表者のアカウントを作成・管理し、通知メールを送信できます。
通知機能: 管理者は利用者にお知らせメールを送信することができます。
認証: メールを使用した認証が行えます。
ストレージ: シンボリックリンクを使用した画像保存機能を提供します。
リマインダー: タスクスケジューラを使用したリマインド機能があります。
決済機能: Stripeの決済機能を利用して支払いができます。
AWS: AWS(EC2, S3, RDS)の環境構築をサポートしています。
管理画面機能
ユーザ、店舗代表者、管理者の3権限: 管理者はユーザ、店舗代表者、管理者の3権限を管理できます。
店舗代表者の機能: 店舗代表者は店舗情報の管理や予約情報の確認ができます。
管理者側の機能: 管理者は全てのユーザと店舗代表者の管理、システム全体の監視ができます。

特記事項
MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。









