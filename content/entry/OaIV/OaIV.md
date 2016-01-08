# [nginx+Thin]バックエンドをhttpsでリバースプロキシ

nginxでbackendのwebサーバを動かすときはリバースプロキシを使います。  
httpsサイトではbackendにリバースプロキシするとhttpになってしまいます。  
backend側に、

1. リバースプロキシされていること
2. https通信であること

を伝える必要があります。

## `X_FORWARDED_PROTO` を使う
    ...
    upstream thin {
      server unix:/tmp/thin.sock;
    }
    ...
    location / {
        proxy_pass http://thin;
        proxy_set_header HTTPS on;
        proxy_set_header X_FORWARDED_PROTO https;
    }
    ...

上記のように`X_FORWARDED_PROTO`ヘッダに`https`を指定すると、thinがリバースプロキシされたことに気づいて、http通信をhttpsで受け取ったように振る舞ってくれます。

## 参考
- <http://webos-goodies.jp/archives/51261261.html>
