# お問い合わせフォーム[確認テスト]

<div id="top"></div>

## 使用技術一覧

<p style="display: inline">

  <!-- バックエンドのフレームワーク一覧 -->
  <img src="https://img.shields.io/badge/-Laravel-171923.svg?logo=laravel&style=for-the-badge">
  <!-- バックエンドの言語一覧 -->
  <img src="https://img.shields.io/badge/-Php-777BB4.svg?logo=php&logoColor=FFFFFF&style=for-the-badge">
  <!-- WEBサーバー -->
  <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=for-the-badge">
  <!-- データベース関連 -->
  <img src="https://img.shields.io/badge/-MySQL-4479A1.svg?logo=mysql&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-phpmyadmin-6C78AF.svg?logo=phpmyadmin&style=for-the-badge&logoColor=white">
  <!-- インフラ一覧 -->
  <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=for-the-badge">
  <img src="https://img.shields.io/badge/-github-010409.svg?logo=github&style=for-the-badge">
</p>

## 目次

1. [環境](#環境)
2. [開発環境構築](#開発環境構築)
リポジトリの設定
Docker の設定
Laravel のパッケージのインストール
.env ファイルの作成

<br />




## 環境


| 言語・フレームワーク | バージョン  |
| --------------------- | ---------- |
| php                   | 7.4.9      |
| Laravel               | 8.83.27    |
| MySQL                 | 8.0.26     |
| phpMyAdmin            | 5.2.1      |
| nginx                 | 1.21.1     |
| MailHog               | ?.?.?      |


<p align="right">(<a href="#top">トップへ</a>)</p>

## 開発環境構築

必要に応じてdocker-compose.yml,Dockerfileは編集してください


### コンテナの作成と起動

①以下のコマンドでリポジトリをクローン

```git clone https://github.com/takuya9622/cfm.git```

必要であれば以下のコマンドでリモートリポジトリに紐づけて下さい。

```cd cfm```

<br />

```git remote set-url origin <作成したリポジトリのurl>```


```git add .```
```git commit -m "リモートリポジトリの変更"```
```git push origin main```

エラーが出るようであれば以下のコマンドを実行後に再度コマンドを実行しなおしてください

```sudo chmod -R 777 *```

③.env ファイルを作成後、以下のコマンドで開発環境を構築

docker-compose up -d --build

②.env ファイルを以下の環境変数例を元に作成

.env <br />
DB_CONNECTION=mysql <br />
DB_HOST=mysql <br />
DB_PORT=3306 <br />
DB_DATABASE=laravel_db <br />
DB_USERNAME=laravel_user <br />
DB_PASSWORD=laravel_pass <br />



### 動作確認

http://localhost にアクセスできるか確認
アクセスできたらnginxはOK
<br />
http://localhost にアクセスできるか確認
アクセス出来たらphpMyAdminはOK

### コンテナの停止

以下のコマンドでコンテナを停止

docker-compose down

## ER図
![fix](https://github.com/user-attachments/assets/e74b1871-545c-428e-a1a7-344c1f2caad4)

### 主なコマンド一覧

| コマンド                                                                               | 実行する処理                           |
| -------------------------------------------------------------------------------------- | -------------------------------------- |
| composer create-project --prefer-dist laravel/laravel                                  | Laravel をインストール                 |
| composer require laravel/fortify                                                       | Laravel Fortify をインストール         |
| docker-compose up -d --build                                                           | コンテナの起動                         |
| docker-compose down                                                                    | コンテナの停止                         |
| docker-compose exec php bash                                                           | php コンテナに入る                     |
| php artisan key;generate                                                               | 暗号化キーを生成                     |
| php artisan make:migration create_contacts_table                                       | マイグレーションファイルを作成         |
| php artisan make:seeder ContactsSeeder                                                 | シーダーファイルを作成                 |
| php artisan make:factory ContactFactory                                                | ファクトリーファイルを作成             |
| php artisan migrate                                                                    | マイグレーションを行う                 |
| php artisan db:seed                                                                    | シーディングを行う                     |
| php artisan make:model Contact                                                         | モデルファイルを作成                   |
| php artisan make:controller ContactController                                          | コントローラーファイルを作成           |
| php artisan make:request ContactRequest                                                | リクエストファイルを作成               |



<p align="right">(<a href="#top">トップへ</a>)</p>
