# RVMをさくらVPS（CentOS-5.6）にインストール

![](http://evernote.tk84.net/shard/s8/res/20f6544a-be2c-45b4-969a-d465a00c5efd/)

CentOS-5.6だとライブラリが古かったりしてすんなりとはインストールできません。そんなお話です。

##ビルドに必要なソフトのインストール##

    # gccのインストール
    $ sudo yum install gcc.x86_64
    $ sudo yum install gcc-c++.x86_64

    # yumにrpmforgeリポジトリを追加
    $ sudo rpm -Uhv http://apt.sw.be/redhat/el5/en/x86_64/rpmforge/RPMS//rpmforge-release-0.3.6-1.el5.rf.x86_64.rpm

    # makeのインストール
    $ sudo yum install make.x86_64 --enablerepo=rpmforge

    # gitのインストール
    $ sudo yum install git.x86_64 --enablerepo=rpmforge


ソースのビルドが必要になります。gccとmakeがないようであればインストールしておいてください。makeのインストールはyumに**rpmforge**リポジトリを登録する必要があります。gitもあとで必要になるのでインストールしておきます。

>[さくらVPSにgitをインストール](http://www.tk84.net/blog/%E3%81%95%E3%81%8F%E3%82%89VPS%E3%81%ABgit%E3%82%92%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB/)


##autoconfのインストール##

    $ cd /usr/local/var
    $ wget http://ftp.gnu.org/gnu/autoconf/autoconf-2.68.tar.gz
    $ tar zxfv autoconf-2.68.tar.gz
    $ cd autoconf-2.68
    $ ./configure
    $ make
    $ sudo paco -D make install


autoconfはrvmがrubyをmakeするときに必要です。yumでインストールできるautoconfはバージョンが古いためエラーになります。めんどうですが最新版をソースからインストールします。

pacoをつかってパッケージ管理します。

> [「Paco」で「make uninstall」できないソフトを削除する](http://www.tk84.net/blog/%E3%80%8CPaco%E3%80%8D%E3%81%A7%E3%80%8Cmake%20uninstall%E3%80%8D%E3%81%A7%E3%81%8D%E3%81%AA%E3%81%84%E3%82%BD%E3%83%95%E3%83%88%E3%82%92%E5%89%8A%E9%99%A4%E3%81%99%E3%82%8B/)



##automakeのインストール##

    $ cd /usr/local/var
    $ wget http://ftp.gnu.org/gnu/automake/automake-1.11.3.tar.gz
    $ tar zxfv automake-1.11.3.tar.gz
    $ cd automake-1.11.3
    $ ./configure
    $ make
    $ sudo paco -D make install


yumを使ってautomakeをインストールするとautoconfも一緒にインストールされてします。重複するとよくないことが起こるかもしれないので、やはりこちらもソースからビルドしてインストール。


##rvmのインストール##

    # baserubyのインストール
    $ sudo yum install ruby.x86_64

    # curlのインストール
    $ sudo yum install curl.x86_64

    # ssl証明書の更新
    $ cd /etc/pki/tls/certs/
    $ sudo cp ca-bundle.crt ca-bundle.crt.org
    $ sudo curl http://curl.haxx.se/ca/cacert.pem -o ca-bundle.crt

    # curl-develのインストール opensslとopenssl-develも依存でインストールされる
    $ sudo yum install curl-devel.x86_64

    # bisonのインストール
    $ sudo yum install bison.x86_64

    # rvmのインストール
    $ cd ~
    $ bash -s stable < <(curl -s https://raw.github.com/wayneeseguin/rvm/master/binscripts/rvm-installer)
    $ source ~/.bash_profile
    $ rvm install ruby-head -C --with-openssl-dir=/usr


rvmを利用するにはRubyがインストールされている必要があります。とりあえずyumで簡単にインストール。

curlはrvmのインストールスクリプトで使用します。SSL証明書を更新しているのはCentOS-5.6のSSL証明書が古いため、そのままインストールするとエラーになりからです。

Passengerを利用したかったので`rvm install ruby-head -C --with-openssl-dir=/usr`としてOpenSSLサポートを組み込みました。



##関連リンク##
- <http://beginrescueend.com/>
- <http://d.hatena.ne.jp/okdt/20111004/1317686950>
- <http://d.hatena.ne.jp/xyk/20111214/1323859416>

