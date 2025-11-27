# ontact

# 環境構築

## Dockerビルド

 ・ git clone <git@github.com>:haruki-saitou/first-contact.git <br>
 ・ docker-compose up -d --build

## Laravel環境構築

 ・ docker-compose exec php bash <br>
 ・ composer install <br>
 ・ cp .env.exemple. .env , 環境変数を適宣変更 <br>
 ・ php artisan key:generate <br>
 ・ php artisan migrate <br>
 ・ php artisan db:seed <br>

## 開発環境

 ・ ユーザー登録 : <http://localhost/register> <br>
 ・ ログイン : <http://localhost/login> <br>
 ・ お問合せ画面 : <http://localhost/> <br>
 ・ お問合せ内容確認 : <http://localhost/confirm> <br>
 ・ 送信完了画面 : <http://localhost/thanks> <br>
 ・ 管理画面 : <http://localhost/admin> <br>
 ・ phpMyAdmin : <http://localhost:8080/> <br>

## 使用技術(実行環境)

・ PHP 8.1.33 <br>
・ MySQL 8.0 <br>
・ nginx 1.21.1 <br>
・ laravel : 8.83.8 <br>

## 機能一覧
管理者機能: お問い合わせ一覧の閲覧、検索、詳細表示、削除、CSVエクスポート <br>
ユーザー認証機能（ログイン、ログアウト）<br>

## ER図

![ER Diagram](assets/er_diagram.png) <br>

users Table (ユーザー認証情報)  
Column Name,Data Type,Key/Constraints,Description
id,BIGINT UNSIGNED,PRIMARY KEY,ユーザーID
name,VARCHAR(255),,ユーザー名
email,VARCHAR(255),UNIQUE,メールアドレス (ログインID)
password,VARCHAR(255),,パスワード (ハッシュ化)
remember_token,VARCHAR(100),NULLABLE,ログイン状態維持トークン
created_at,TIMESTAMP,,レコード作成日時
updated_at,TIMESTAMP,,レコード更新日時

categories Table (お問い合わせカテゴリ)  
Column Name,Data Type,Key/Constraints,Description
id,BIGINT UNSIGNED,PRIMARY KEY,カテゴリID
content,VARCHAR(255),,カテゴリ内容
created_at,TIMESTAMP,,レコード作成日時
updated_at,TIMESTAMP,,レコード更新日時

contacts Table (お問い合わせ内容)  
Column Name,Data Type,Key/Constraints,Description
id,BIGINT UNSIGNED,PRIMARY KEY,お問い合わせID
category_id,BIGINT UNSIGNED,FOREIGN KEY (参照: categories.id),お問い合わせカテゴリID
last_name,VARCHAR(255),,姓
first_name,VARCHAR(255),,名
gender,TINYINT,,"性別 (1:男性, 2:女性, 3:その他)"
email,VARCHAR(255),,メールアドレス
tel,VARCHAR(255),,電話番号
address,VARCHAR(255),,住所
building,VARCHAR(255),NULLABLE,建物名 (任意)
detail,TEXT,,お問い合わせ詳細
created_at,TIMESTAMP,,レコード作成日時
updated_at,TIMESTAMP,,レコード更新日時
