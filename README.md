# Rese

**Rese**は、ユーザーが店舗を閲覧し、口コミを投稿・編集・削除、店舗の予約ができる機能を提供するWebアプリケーションです。また、管理者はCSVファイルをインポートして店舗情報を追加することができます。

## 概要

本アプリケーションでは、以下の3つの主要な機能が追加されました：

1. **口コミ機能**：店舗ごとの口コミを追加、編集、削除する機能
2. **店舗一覧ソート機能**：ユーザーが店舗をランダムや評価順で並び替え
3. **CSVインポート機能**：管理者がCSVを使って店舗情報を一括追加

**期限**：1週間

---

## 環境構築

### 必要環境

- PHP 7.4.9
- Laravel 8.0.26
- Docker, Docker Compose

### Dockerビルド

1. リポジトリをクローンします：
   ```bash
   git clone <リポジトリURL>

2. Dockerコンテナをビルドして起動します
   ```bash
   docker-compose up -d --build


### Laravel環境構築

1. PHPコンテナに入ります：

   ```bash
   docker-compose exec php bash


2. **Composerの依存関係をインストールします：**：

   ```bash
   composer install


3. 環境変数ファイルを設定します：

   ```bash
   cp .env.example .env


4. アプリケーションキーを生成します：

   ```bash
   php artisan key:generate


5. データベースをマイグレーションします：

   ```bash
   php artisan migrate


6. データベースをシーディングします：

   ```bash
   php artisan db:seed



### URL

- **開発環境**： [http://localhost/](http://localhost/)
- **phpMyAdmin**： [http://localhost:8080/](http://localhost:8080/)


## 機能一覧

### 口コミ機能

#### 機能要件

- **新規口コミ追加**
  - 一般ユーザーは店舗に対し1件の口コミを追加できます（テキスト・星評価（1～5）・画像）。
  - テキスト：400文字以内、自由記述
  - 星評価：1～5の選択式
  - 画像：jpeg、pngのみアップロード可能。非対応の拡張子はエラーメッセージを表示します。

- **口コミ編集**
  - ユーザーは自身が追加した口コミの内容を編集できます。前回の入力値を保持します。

- **口コミ削除**
  - 一般ユーザーは自分が追加した口コミのみ削除可能です。管理者はすべての口コミを削除できます。

#### 権限別の操作

| 機能           | 一般ユーザー     | 店舗ユーザー | 管理者ユーザー   |
| -------------- | ---------------- | ------------ | ---------------- |
| 新規口コミ追加 | ○                | ×            | ×                |
| 口コミ編集     | ○                | ×            | ×                |
| 口コミ削除     | ○ (自身のみ削除) | ×            | ○ (全て削除可能) |

#### レスポンシブ対応

- デバイスサイズ（ノートPC、スマートフォン）に合わせたレスポンシブデザインを実装。


### 店舗一覧ソート機能

#### 機能要件

- 一般ユーザーが店舗一覧を以下の順で並び替え可能：
  - **ランダム**：選択するたびに並び順が変わります。
  - **評価が高い順・低い順**：評価が1件もない場合は、どちらの順序でも最後尾に表示されます。

- ページアクセス時に毎回評価数を取得し、最新情報が反映されます。


### CSVインポート機能

#### 機能要件

- **店舗情報のインポート**：管理ユーザーはCSVファイルを使って新規店舗情報を一括で追加できます。
- **項目要件**：
  - 店舗名：50文字以内
  - 地域：「東京都」「大阪府」「福岡県」のいずれか
  - ジャンル：「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれか
  - 店舗概要：400文字以内
  - 画像URL：jpeg、pngのみアップロード可能。非対応の拡張子にはエラーメッセージを表示します。

#### CSVファイルの記述方法

#### CSVファイルのサンプル（ヘッダー付き）：

   ```bash
   name,area,genre,about,photo
   リストランテ,大阪府,イタリアン,シェフ自慢のイタリアン料理を堪能できるおしゃれなレストラン。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg
   炭,大阪府,焼肉,最高級の和牛を提供する焼肉の名店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg
   はかた,福岡県,居酒屋,地元の旬の素材を活かした一品料理が楽しめる居酒屋。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg
   大将,大阪府,ラーメン,秘伝のスープと手作り麺の本格ラーメン店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg
   パスタ工房,大阪府,イタリアン,手作りの新鮮なパスタが自慢のイタリアン店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg
   焼肉本舗,東京都,焼肉,厳選された上質な和牛を提供する焼肉店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg
   酒場まる,福岡県,居酒屋,アットホームな雰囲気でくつろげる居酒屋。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg
   ラーメン一筋,東京都,ラーメン,こだわりのスープともちもちの麺が特徴のラーメン屋。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg
   オステリア,東京都,イタリアン,本場の味を再現したイタリアンレストラン。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg
   焼肉タウン,福岡県,焼肉,地元で人気のリーズナブルな焼肉店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg
   夜の酒場,大阪府,居酒屋,美味しい料理とお酒を楽しめる落ち着いた居酒屋。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg
   麺道場,福岡県,ラーメン,特製スープと手打ち麺が自慢のラーメン専門店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg
   イタリアンカフェ,大阪府,イタリアン,カジュアルに楽しめる本格イタリアンカフェ。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg
   和牛苑,東京都,焼肉,とろけるような和牛が楽しめる高級焼肉店。,https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg


## 使用技術

- **PHP**: 7.4.9
- **Laravel**: 8.0.26
- **Docker**
