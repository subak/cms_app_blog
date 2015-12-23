# Hello, world! from Sinatra

![](http://evernote.tk84.net/shard/s8/res/179a526b-22b0-4341-b123-2ef7ed5e27cb/)

Rubyの軽量WebフレームワークSinatraを使ってHello, world!を表示する簡単なアプリケーションを作ってみます。



##動作環境##
さくらVPS+nginx+rvm+passengerです。

動作に必要なソフトウェアのインストールは下記を参考にしてください。


> - [RVMをさくらVPS（CentOS-5.6）にインストール](http://www.tk84.net/blog/RVM%E3%82%92%E3%81%95%E3%81%8F%E3%82%89VPS%EF%BC%88CentOS-5.6%EF%BC%89%E3%81%AB%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB/)
- [さくらVPSでRVMのPassengerをnginxと使う](http://www.tk84.net/blog/%E3%81%95%E3%81%8F%E3%82%89VPS%E3%81%A7RVM%E3%81%AEPassenger%E3%82%92nginx%E3%81%A8%E4%BD%BF%E3%81%86/)



##Sinatraのインストール##

    $ gem install sinatra


## プロジェクトディレクトリの構成
SinatraはRackの上で動いています。プロジェクトディレクトリの構成はRackアプリケーションと同じです。

>[RackでHello world!](http://www.tk84.net/blog/Rack%E3%81%A7Hello%20world!/)

次のようにプロジェクトを用意しました。

    $ cd ~
    $ cd nginx/html
    $ pwd
    /home/www/nginx/html

    $ mkdir sinatra
    $ mkdir sinatra/public
    $ mkdir sinatra/tmp


ユーザーは`www`、ホームディレクトリは`/home/www`、nginxのWeb公開ディレクトリは`/home/www/nginx/html`です。



##nginx.confの設定##

    …
    http {
    …
        passenger_root /home/www/.rvm/gems/ruby-head/gems/passenger-3.0.11;
        passenger_ruby /home/www/.rvm/wrappers/ruby-head/ruby;
    …
      server {
        location /sinatra {
          passenger_enabled on;
          root   html/sinatra/public;
        }
      }
    ...
    }
    ...



##app.rb

    $ cd ~
    $ nano nginx/html/sinatra/app.rb

### app.rb
    require 'sinatra'

    before do
      request.path_info.sub!(/^\/sinatra/,'')
    end

    get '/' do
        "Hello, world!"
    end


`http://www.example.com/sinatra`で動かします。

path_infoには`/sinatra`という物理ディレクトリのパスが含まれてしまいます。`request.path_info.sub!(/^\/sinatra/,'')`としてマッチングパターンから余計な文字を取り除いています。






##config.ru##
    $ cd ~
    $ nano nginx/html/sinatra/config.ru

### config.ru
    require './app'
    run Sinatra::Application

`require './app'`で`app.rb`ファイルを読み込みます。 パスには明示的に**カレントディレクトリ**(`./`)を指定してください。




##Sinatra(Rack)アプリケーションの再起動##
`app.rb`などのプログラムファイルを変更したときはSinatra(Rack)を再起動して変更を反映する必要があります。

    $ cd ~
    $ touch nginx/html/sinatra/tmp/restart.txt

`tmp`ディレクトリに`restart.txt`というファイルを置きます。ブラウザからアクセスした時にSinatra(Rack)は`restart.txt`の更新を検出するとプロセスを再起動します。




##関連リンク##
- <http://d.hatena.ne.jp/tagomoris/20100927/1285559238>
- <http://www.red-mount.com/blogs/show/how_to_sinatra_on_passenger>


