# nginxとphp-fmでa-blogcmsを動かす

![](http://evernote.tk84.net/shard/s8/res/b7102304-d3de-4c1b-b2f6-181c9e6d123f/4f4b517c6606a.jpeg)

nginxとphp-fpm環境でa-blog cmsを動作させるために行った設定のメモです。

##下準備##
- nginxとphpがインストールされていること
- nginxでrewriteモジュールが使えること ( `--with-pcre` オプションで `./configure` )
- phpでfpmが使えること ( `--with-fpm` オプションで `--./configure` )
- その他、a-blog cmsの動作に必要なモジュールがphpに組み込まれていること

>
[さくらVPSサーバにnginx-1.1.15をソースからビルドしてインストールしたときのメモ](http://www.tk84.net/blog/%E3%81%95%E3%81%8F%E3%82%89VPS%E3%82%B5%E3%83%BC%E3%83%90%E3%81%ABnginx-1.1.15%E3%82%92%E3%82%BD%E3%83%BC%E3%82%B9%E3%81%8B%E3%82%89%E3%83%93%E3%83%AB%E3%83%89%E3%81%97%E3%81%A6%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB%E3%81%97%E3%81%9F%E3%81%A8%E3%81%8D%E3%81%AE%E3%83%A1%E3%83%A2/)
[php-5.3.10をインストール php-fpmで動かす ioncubeもね](http://www.tk84.net/blog/php-5.3.10%E3%82%92%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB%20php-fpm%E3%81%A7%E5%8B%95%E3%81%8B%E3%81%99%20ioncube%E3%82%82%E3%81%AD/)

phpとnginxはwwwというユーザーで動かすことにします。
web公開ディレクトリもwwwユーザーのホームディレクトリに置きます。

##php-fpmの設定##

php-fpm.confを次のように編集しました。
ほぼデフォルトの状態で使用しています。

    --- /usr/local/etc/php-fpm.conf.default     2012-02-24 03:15:08.000000000 +0900
    +++ /home/www/php/php-fpm.conf     2012-02-25 15:03:45.000000000 +0900
    @@ -22,14 +22,14 @@
     ; Pid file
     ; Note: the default prefix is /usr/local/var
     ; Default Value: none
    -;pid = run/php-fpm.pid
    +pid = run/php-fpm.pid
    
     ; Error log file
     ; If it's set to "syslog", log is sent to syslogd instead of being written
     ; in a local file.
     ; Note: the default prefix is /usr/local/var
     ; Default Value: log/php-fpm.log
    -;error_log = log/php-fpm.log
    +error_log = /home/www/php/php-fpm.log
    
     ; syslog_facility is used to specify what type of program is logging the
     ; message. This lets syslogd specify that messages from different facilities
    @@ -129,8 +129,9 @@
     ; Unix user/group of processes
     ; Note: The user is mandatory. If the group is not set, the default user's group
     ;       will be used.
    -user = nobody
    -group = nobody
    +;user = nobody
    +user = www
    +;group = nobody
    
     ; The address on which to accept FastCGI requests.
     ; Valid syntaxes are:
    @@ -140,7 +141,7 @@
     ;                            specific port;
     ;   '/path/to/unix/socket' - to listen on a unix socket.
     ; Note: This value is mandatory.
    -listen = 127.0.0.1:9000
    +listen = 127.0.0.1:9001
    
     ; Set listen(2) backlog. A value of '-1' means unlimited.
     ; Default Value: 128 (-1 on FreeBSD and OpenBSD)
    @@ -161,7 +162,7 @@
     ; must be separated by a comma. If this value is left blank, connections will be
     ; accepted from any ip address.
     ; Default Value: any
    -;listen.allowed_clients = 127.0.0.1
    +listen.allowed_clients = 127.0.0.1
    
     ; Choose how the process manager will control the number of child processes.
     ; Possible Values:
    @@ -224,7 +225,7 @@
     ; This can be useful to work around memory leaks in 3rd party libraries. For
     ; endless request processing specify '0'. Equivalent to PHP_FCGI_MAX_REQUESTS.
     ; Default Value: 0
    -;pm.max_requests = 500
    +pm.max_requests = 500
    
     ; The URI to view the FPM status page. If this value is not set, no URI will be
     ; recognized as a status page. It shows the following informations:

- ユーザーを指定します。 
  これをやっておかないとphp-fpmからWeb公開ディレクトリ内のファイルに**アクセスできません**。
- `listen.allowed_clients = 127.0.0.1`で自ホストからのみ接続できるようにします。 
  nginxからのみアクセスされることを想定しています。
- `pm.max_requests = 500` 
  定期的にプロセスを再起動させます。 
  500アクセスで一旦終了してメモリを開放します。




##nginx.confの設定##
nginx.conf は次のように設定しました。

    user                www;
    worker_processes    2;
    error_log           /var/log/nginx/error.log debug;
    pid                 /var/run/nginx.pid;

    events {
        worker_connections  1024;
    }

    http {
        include       mime.types;
        default_type  application/octet-stream;

        log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                          '$status $body_bytes_sent "$http_referer" '
                          '"$http_user_agent" "$http_x_forwarded_for"';

        sendfile        on;
        #tcp_nopush     on;

        #keepalive_timeout  0;
        keepalive_timeout  65;

        gzip    off;

        # httpヘッダにバージョンを表示しない
        server_tokens   off;


        #
        # www.tk84.net 以下
        #
        server {
            listen      80;
            server_name www.tk84.net;
            access_log  /home/www/httpdocs/www.tk84.net.access.log  main;
            error_log   /home/www/httpdocs/www.tk84.net.error.log debug;
            client_max_body_size 4M;

            #
            # .で始まる名前のファイル、ディレクトリにアクセスさせない
            #
            location ~ (^|/)\. {
                return 403;
            }


            #
            # blogディレクトリでは別プログラムが動作
            #
            location /blog {
              root /home/www/httpdocs/blog@www.tk84.net;
              access_log  /home/www/httpdocs/blog@www.tk84.net.access.log main;
              error_log  /home/www/httpdocs/blog@www.tk84.net.error.log debug;
              index index.html index.htm index.php;
              if (-e $request_filename) { break; }
              rewrite (.*(^|/)[^\./]+)$ $1/ permanent;
              rewrite ((\.(html|htm|php|xml|txt|js|json|css|yaml|csv))|/)$ /blog/index.php last;
            }

            location ~ ^/blog(/.*\.php)$ {
                root /home/www/httpdocs/blog@www.tk84.net;
                access_log  /home/www/httpdocs/blog@www.tk84.net.access.php.log main;
                error_log  /home/www/httpdocs/blog@www.tk84.net.error.php.log debug;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_pass 127.0.0.1:9001;
                include fastcgi_params;
            }
        }


a-blog cms は /blog というurlで動かします。

`index index.html index.htm index.php;`

/blog/ というurlでアクセスされた時、index.html、index.htm、index.phpというファイルがあればそれを表示します。

`if (-e $request_filename) { break; }`

/blog でアクセスされた時に静的ファイルのリクエストであればそのまま返します。 

`rewrite (.*(^|/)[^\./]+)$ $1/ permanent;`

URLの最後に/がついていない場合には/をつけてリダイレクトします。 
URLの最後は/をつけるという形で統一します。 
「index.html」など、ファイルの拡張子が指定されているときには/をつけません。

`rewrite ((\.(html|htm|php|xml|txt|js|json|css|yaml|csv))|/)$ /blog/index.php last;`
:
次の拡張子のファイルがリクエストされ、実ファイルが存在しなかった場合にはa-blog cmsで生成します。   
`(html|htm|php|xml|txt|js|json|css|yaml|csv) `  
これら以外の拡張子のファイルはa-blog cmsでは生成しません。404 not foundになります。

拡張子がphpのファイルはa-blog cmsのディレクトリ内でもそのまま実行することができます。
静的ファイル、phpファイル以外のリクエストはa-blog cmsのindex.phpで処理されます。




##参考リンク##
[nginx+PHP-FPMでどこまでチューニングできるか at 改訂版 新卒ネットワークエンジニア](http://blog.kubox.info/?p=175)

