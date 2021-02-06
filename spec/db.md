/* admins - 管理者アカウント */
drop table if exists admins;
CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    name VARCHAR(50) NOT NULL,                  /* 名前 */
    email VARCHAR(100) NOT NULL,                /* メールアドレス */
    password VARCHAR(100) NOT NULL,             /* パスワード */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);

/* users - ユーザーアカウント */
drop table if exists users;
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    name VARCHAR(50) NOT NULL,                  /* 名前 */
    email VARCHAR(100) NOT NULL,                /* メールアドレス */
    password VARCHAR(100) NOT NULL,             /* パスワード */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);

/* addresses - 住所(配送先) */
drop table if exists addresses;
CREATE TABLE addresses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    user_id INT NOT NULL                        /* ユーザーID */,
    prefecture_id INT NOT NULL,                 /* 都道府県ID */
    zip VARCHAR(7) NOT NULL,                    /* 郵便番号 */
    address VARCHAR(100) NOT NULL,              /* 住所(都道府県市区町村) */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);

/* items - 商品 */
drop table if exists items;
CREATE TABLE items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    admin_id INT NOT NULL,                      /* 管理者ID */
    name VARCHAR(50) NOT NULL,                  /* 商品名 */
    img VARCHAR(50) NOT NULL,                   /* 画像 */
    description VARCHAR(255) NOT NULL,          /* 説明文 */
    price INT NOT NULL,                         /* 価格 */
    tag_for_search TEXT NOT NULL,               /* 検索用タグ */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);

/* orders - 注文 */
drop table if exists orders;
CREATE TABLE orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    user_id INT NOT NULL,                       /* ユーザーID */
    address_id INT NOT NULL,                    /* 配送先ID */
    order_code VARCHAR(255) NOT NULL,           /* 注文番号 */
    status INT NOT NULL,                        /* ステータス */
    fix_date DATETIME DEFAULT NULL,             /* 注文確定日時 */
    mail_send_date DATETIME DEFAULT NULL,       /* メール送信日時 */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);

/* order_items - 注文商品 */
drop table if exists order_items;
CREATE TABLE order_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, /* ID */
    order_id INT NOT NULL,                      /* 注文ID */
    item_id INT NOT NULL,                       /* 商品ID */
    price INT NOT NULL,                         /* 価格 */
    created_at DATETIME NOT NULL,               /* 作成日時 */
    updated_at DATETIME NOT NULL,               /* 更新日時 */
    deleted_at DATETIME DEFAULT NULL            /* 削除日時 */
);
