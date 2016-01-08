# RackでHello world!

![](http://evernote.tk84.net/shard/s8/res/13921416-46b5-4812-aeee-2faa5d493590/)
さくらVPS+nginx+rvm+passengerという環境でRackを使ってHello worldを表示するアプリケーションを作ってみます。

nginx、rvm、passengerのインストールはコチラを参考にしてください。


>[さくらVPSでRVMのPassengerをnginxと使う](http://www.tk84.net/blog/%E3%81%95%E3%81%8F%E3%82%89VPS%E3%81%A7RVM%E3%81%AEPassenger%E3%82%92nginx%E3%81%A8%E4%BD%BF%E3%81%86/)


##rackのインストール##

    $ gem install rack

##プロジェクトディレクトリの構成##
PassengerからRackアプリケーションを動かすときはプロジェクトディレクトリを作ります。プロジェクトディレクトリ内に決められた名前でファイル、ディレクトリを作る必要があります。

プロジェクトディレクトリは公開ディレクトリに置きます。`/home/www/nginx/html`が公開ディレクトリとします。

次のようにファイル、ディレクトリを作成します。

    $ cd ~
    $ cd nginx/html
    $ pwd
    /home/www/nginx/html

    $ mkdir rack
    $ touch rack/config.ru
    $ mkdir rack/public
    $ mkdir rack/tmp

publicディレクトリは画像やcss等の静的なファイルを入れます。tmpディレクトリはRackの再起動に必要なrestart.txt等を置きます。

![](http://evernote.tk84.net/shard/s8/res/d2c9e485-81da-4307-8459-1b54c3622de2/)

##nginx.confの設定##

    …
    http {
    …
        passenger_root /home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11;
        passenger_ruby /home/www/.rvm/wrappers/ruby-head/ruby;
    …
      server {
        location /rack {
          passenger_enabled on;
          root   html/rack/public;
        }
      }
    ...
    }
    ...

`http://example.com/rack`というurlで動かします。プロジェクトディレクトリの中の**public**をrootに指定して下さい。



##hello worldコードを用意##
`http://example.com/rack`にアクセスされると`config.ru`が実行されます。本来は設定などを行うファイルですが、今回はHello worldを表示するだけの簡単なプログラムなのでここにコードを書いてしまいます。

    $ cd ~/nginx/html
    $ nano config.ru
    $ cat config.ru

    run proc {|env|
    require 'sinatra'
      [200, {'Content-Type'=>'text/plain'}, ['Hello world!']]
    }




##動作確認##
`http://example.com/rack`にアクセスして`Hello world!`と表示されたら成功です。



##関連リンク##
- <http://randd.kwappa.net/2010/06/18/175>
