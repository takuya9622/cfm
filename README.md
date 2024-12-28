# coachtechフリマ[模擬案件]

<div id="top"></div>

## 使用技術一覧

<p style="display: inline">

  <img src="https://img.shields.io/badge/-Laravel-171923.svg?logo=laravel&style=for-the-badge">
  <img src="https://img.shields.io/badge/-Php-777BB4.svg?logo=php&logoColor=FFF&style=for-the-badge">
  <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=for-the-badge">
  <img src="https://img.shields.io/badge/-MySQL-4479A1.svg?logo=mysql&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-phpmyadmin-6C78AF.svg?logo=phpmyadmin&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=for-the-badge">
  <img src="https://img.shields.io/badge/-github-010409.svg?logo=github&style=for-the-badge">
  <img src="https://img.shields.io/badge/-Stripe-635bff.svg?logo=stripe&logoColor=FFF&style=for-the-badge">
  <img src="https://img.shields.io/badge/-MailHog-952225.svg?style=for-the-badge">

</p>

## 目次

1. [環境](#環境)
2. [開発環境構築](#開発環境構築)
3. [URL](#URL)
4. [主なコマンド一覧](#主なコマンド一覧)
3. [ER図](#ER図)

<br />




## 環境


| 仕様技術               | バージョン  |
| --------------------- | ---------- |
| php                   | 8.2.27     |
| Laravel               | 10.48.24   |
| MySQL                 | 8.0.26     |
| phpMyAdmin            | 5.2.1      |
| nginx                 | 1.21.1     |
| MailHog               |            |
| Stripe API            |            |


<p align="right">(<a href="#top">トップへ</a>)</p>

## 開発環境構築

必要に応じてdocker-compose.yml,Dockerfileは編集してください


### リポジトリの設定

以下のコマンドでリポジトリをクローン

```
git clone https://github.com/takuya9622/cfm.git
```

必要であれば以下のコマンドでリモートリポジトリに紐づけ

```
cd cfm
git remote set-url origin <作成したリポジトリのurl>
git add .
git commit -m "リモートリポジトリの変更"
git push origin main
```

エラーが出るようであれば以下のコマンドを実行後に再度コマンドを実行

```
sudo chmod -R 777 src/*
```

### Dockerコンテナの作成

以下のコマンドでdockerコンテナを作成

```
docker-compose up -d --build
```

### 環境変数の設定

以下を参考に.envファイルを作成

```
cd src
cp .env.example .env
```

必要に応じてAPP_NAMEを変更
```
APP_NAME=COACHTECH-FLEAMARKET

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```
必要に応じてstripe APIキーを取得
```
STRIPE_KEY=pk_test_example
STRIPE_SECRET=sk_test_example
```

### パッケージのインストール

phpコンテナに移動し以下のコマンドを実行

```
composer install
php artisan key:generate
```

### マイグレーションの実行

以下の7つのテーブルに対応するファイルがsrc/database/migrationsにある事を確認

1.users<br />
2.items<br />
3.categories<br />
4.category_item<br />
5.orders<br />
6.likes<br />
7.comments<br />

確認出来たら以下のコマンドでマイグレーションを実行

```
php artisan migrate
```

もしエラーが出た場合は以下のコマンドでリトライ

```
php artisan migrate:fresh
```

必要に応じて以下のコマンドでシーディングを実行

```
php artisan db:seed
```

うまく行かない場合は以下のコマンドを実行後に再度マイグレーション

```
composer dump-autoload
```

<p align="right">(<a href="#top">トップへ</a>)</p>

## URL

・開発環境 : http://localhost<br />
・phpMyAdmin : http://localhost:8080<br />
・MailHog : http://localhost:8025<br />

<p align="right">(<a href="#top">トップへ</a>)</p>

## 主なコマンド一覧

| コマンド                                                                               | 実行する処理                           |
| -------------------------------------------------------------------------------------- | -------------------------------------- |
| composer create-project --prefer-dist laravel/laravel                                  | Laravelをインストール                 |
| composer require laravel/fortify                                                       | Laravel Fortifyをインストール         |
| php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"　　　　　| Laravel Fortifyのカスタムの準備 |
|composer require stripe/stripe-php 　　　　　　　　　　　　　　　　　　　　　　　　　　　　　| Stripeのパッケージをインストール|
| docker-compose up -d --build                                                           | コンテナの起動                         |
| docker-compose down                                                                    | コンテナの停止                         |
| docker-compose exec php bash                                                           | php コンテナに入る                     |
| php artisan key:generate                                                               | 暗号化キーを生成                     |
| php artisan make:migration create_items_table                                       | マイグレーションファイルを作成         |
| php artisan make:seeder ItemSeeder                                                 | シーダーファイルを作成                 |
| php artisan make:factory ItemFactory                                                | ファクトリーファイルを作成             |
| php artisan migrate                                                                    | マイグレーションを行う                 |
| php artisan db:seed                                                                    | シーディングを行う                     |
| php artisan make:model Item                                                         | モデルファイルを作成                   |
| php artisan make:controller ItemController                                          | コントローラーファイルを作成           |
| php artisan make:request PurchaseRequest                                                | リクエストファイルを作成               |
|php artisan storage:link　　　　　　　　　　　　　　　　　                                 |ストレージディレクトリのシンボリックリンクを作成|

<p align="right">(<a href="#top">トップへ</a>)</p>

## ER図
![alt](er.png)

<p align="right">(<a href="#top">トップへ</a>)</p>