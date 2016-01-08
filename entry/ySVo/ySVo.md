# RubyとNode(Coffee)でUnixDomainSocketを使って通信

サーバをRuby、クライアントをNodeでテストしてみました。



## Ruby スクリプト

    # unixsocket_server.rb

    require 'socket'

    UNIXServer.open("/tmp/s") {|serv|
      s = serv.accept
      p s.recv(20)
    }





## Coffee スクリプト


    # unixsocket_client.coffee

    net = require 'net'
    socket = new net.Socket
    socket.connect '/tmp/s'

    socket.write 'hoge', 'utf8', ->
      console.log 'send'






## 実行

### ruby
    ruby$ ruby unixsocket_server.rb

### coffee
    coffee$ coffee unixsocket_client.coffee

### ruby
    ruby$
    "hoge"

### coffee
    coffee$
    send

## 感想
非常に簡単ですね。メインはNodeで一部分だけRubyで処理したいといった状況で使えます。UnixDomainSocketはTCPより速いらしいです。

NodeからRubyプロセスを複数動かすリソースを大量に消費してしまいます。Rubyでサーバを立てておいてスレッドで処理すれば少ないリソースで高速に処理できそうです。



## 参考
- <http://doc.okkez.net/static/192/class/UNIXServer.html>
- <http://nodejs.org/api/net.html>
