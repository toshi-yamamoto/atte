# 勤怠管理システム (Attendance Management System)

Atte社勤怠管理システム

# 概要 (Overview)

この勤怠管理システムは、従業員の勤務時間や休憩時間を記録・管理するためのWebアプリケーションです。ユーザーは、勤務開始、勤務終了、休憩開始、休憩終了の打刻を行い、日々の勤務状況を確認することができます。

# 機能 (Features)

- **ユーザー認証**: ログイン・ログアウト機能を提供。
- **勤務時間の記録**: 勤務開始と勤務終了を記録。
- **休憩時間の記録**: 休憩開始と休憩終了を記録。
- **勤務履歴の確認**: 各ユーザーが自身の勤務記録を確認可能。
- **ボタンの無効化**: 勤務や休憩の状態に応じて、無効化されたボタンを使用して操作ミスを防ぐ。
- **日付ごとの勤怠確認**: 特定の日付の勤怠を確認可能。

# 開発環境 (Development Environment)

- **フレームワーク**: Laravel 8.x
- **データベース**: MySQL
- **フロントエンド**: Bootstrap 5
- **使用言語**: PHP, HTML, CSS
- **バージョン管理**: Git

# 必要な環境 (Requirements)

- PHP >= 8.0
- Composer
- MySQL >= 5.7
- Node.js と npm (Laravel Mix使用時)

## セットアップ (Setup)

### 1. リポジトリのクローン

git clone https://github.com/toshi-yamamoto/atte.git
cd attendance-system

### 2. 環境ファイルの設定

- DB_CONNECTION: mysql
- DB_DATABASE: larave_db
- DB_USERNAME: laravel_user
- DB_PASSWORD: laravel_pass

### 3. 使用方法

- 勤務開始: 「勤務開始」ボタンを押して勤務を開始します。
- 勤務終了: 勤務終了時に「勤務終了」ボタンを押して勤務を終了します。
- 休憩の開始: 「休憩開始」ボタンを押して休憩を開始します。
- 休憩の終了: 休憩終了後に「休憩終了」ボタンを押して終了します。

### 4. ディレクトリ構成

.
├── app/              # コントローラーやモデルなどアプリケーションロジック
├── database/         # マイグレーションやシーディングファイル
├── public/           # 公開ディレクトリ（フロントエンドファイルなど）
├── resources/        # BladeテンプレートやCSSファイル
├── routes/           # ルーティング設定 (web.php)
├── .env              # 環境設定ファイル
└── ...

### 5. 主なファイル構成

- routes/web.php: ルート設定。ページ遷移やAPI呼び出しを定義。
- app/Http/Controllers/AttendanceController.php: 勤怠の管理ロジック。
- app/Models/Attendance.php: 勤怠記録のモデル。
- resources/views/index.blade.php: ホームページのビュー（フロントエンド）。

### 6. 使用技術

- Laravel: フレームワーク
- Bootstrap: フロントエンドスタイル
- Carbon: 日付操作ライブラリ（勤務時間・休憩時間の計算に使用）

### 7. 開発者向けメモ

- 勤務開始、終了のボタンは状態に応じて無効化されます。コントローラ内でこれらの判定を行っています。
- Bladeテンプレートを利用して、フロントエンドとバックエンドの連携が効率化されています。
- 休憩時間の計算は Attendance モデル内で処理し、getTotalBreakTimeAttribute というアクセサを通じて合計休憩時間を表示
