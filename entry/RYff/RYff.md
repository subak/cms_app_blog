# さくらVPSでRVMのPassengerをnginxと使う

![](http://evernote.tk84.net/shard/s8/res/226518d4-d25a-4ed2-a544-da741ca8e83c/)

さくらのVPSサーバ（CentOS-5.6）でRack/Railsアプリケーションを動かすためにPassengerを使います。nginxにPassengerモジュールを組み込んでビルドしたりする必要があります。



##さくらVPSでRVMを使う##
甘く見てるとはまります。コチラをどうぞ。

> [RVMをさくらVPS（CentOS-5.6）にインストール](http://www.tk84.net/blog/RVM%E3%82%92%E3%81%95%E3%81%8F%E3%82%89VPS%EF%BC%88CentOS-5.6%EF%BC%89%E3%81%AB%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB/
)


##Passengerのインストール##

    $ rvm use ruby-head
    $ gem install passenger
    $ gem install rake


RVMで`passenger`をgemからインストールします。

`rake`もついでにインストール。Passenger用モジュールをビルドするのに必要になります。


##nginxのインストール##
`passenger-install-nginx-module`を使ってインストールする方法もありますが、今回はnginxに`--add-module`オプションを指定してソースからビルドしてインストールします。




    $ cd /usr/local/var/
    $ wget http://nginx.org/download/nginx-1.1.15.tar.gz
    $ tar zxfv nginx-1.1.15.tar.gz
    $ cd nginx-1.1.15
    $ ./configure \
    --add-module=/home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11/ext/nginx  \
    --with-http_stub_status_module \
    --with-http_ssl_module
    $ make
    $ sudo paco -D make install


**rvmを使用中のユーザー**が`./configure`するところがポイントです。

`--add-module`オプションでPassengerモジュールを組み込みます。

今回もpacoを使ってパッケージ管理します。

> [「Paco」で「make uninstall」できないソフトを削除する](http://www.tk84.net/blog/%E3%80%8CPaco%E3%80%8D%E3%81%A7%E3%80%8Cmake%20uninstall%E3%80%8D%E3%81%A7%E3%81%8D%E3%81%AA%E3%81%84%E3%82%BD%E3%83%95%E3%83%88%E3%82%92%E5%89%8A%E9%99%A4%E3%81%99%E3%82%8B/)

###エラーになったら###


    configuring additional modules
    adding module in /home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11/ext/nginx
    *** The Phusion Passenger support files are not yet compiled. Compiling them for you... ***
    *** Running 'rake nginx RELEASE=yes' in /home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11/ext/nginx... ***
    /home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11/ext/nginx/config: line 9: rake: command not found


このようなエラーが出たらそれはgemのパスが通っていないことが原因です。
rvmのgemでrakeをインストールしたユーザで`./configure`します。


###nginx.confの設定###

nginxをwwwという名前のユーザーで動かします。wwwユーザのホームディレクトリにnginxのコンフィグ、公開ディレクトリ、ログなどを置くことにします。

    $ cd ~
    $ mkdir nginx
    $ cp /usr/local/nginx/conf nginx/conf
    $ mkdir nginx/html
    $ mkdir nginx/logs

    # sudoコマンドで環境変数を引き継ぎ、aliasも使えるようにする
    $ echo "alias sudo='sudo -E '" >> .bash_profile
    # nginxのalias
    $ echo "alias nginx='/usr/local/nginx/sbin/nginx '"

    # プリフィックスを指定して実行
    sudo nginx -p /home/www/nginx



本当は起動用のシェルスクリプトを用意するとよいですが、とりあえずコマンド手打ちで起動します。



###よく使うコマンド###

    # 停止
    sudo nginx -s stop

    # コンフィグの再読み込み
    sudo nginx -s reload



## 参考
- <http://hiroki.jp/2011/05/29/1852/>


