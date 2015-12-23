# thin+sinatraで同時続接

thinを使ってsinatraを動かすと複数のリクエストを同時に処理できるようになります。

    $ thin start --threaded

とすることでsinatraのルーティングをマルチスレッド化出来るようです。

## テスト1
### app.rb

    get "/" do
      sleep 1
      body "ok"
    end

### シングルスレッドで動作
    $ http_load -parallel 2 -fetches 2 tmp/url.txt
    2 fetches, 2 max parallel, 8 bytes, in 2.00526 seconds
    4 mean bytes/connection
    0.997378 fetches/sec, 3.98951 bytes/sec
    msecs/connect: 0.1435 mean, 0.188 max, 0.099 min
    msecs/first-response: 2005.07 mean, 2005.07 max, 2005.07 min
    HTTP response codes:
      code 200 -- 2

### --threadedオプションを指定してマルチスレッドで動作
    $ http_load -parallel 2 -fetches 2 tmp/url.txt
    2 fetches, 2 max parallel, 8 bytes, in 1.09866 seconds
    4 mean bytes/connection
    1.8204 fetches/sec, 7.28158 bytes/sec
    msecs/connect: 0.144 mean, 0.187 max, 0.101 min
    msecs/first-response: 1098.47 mean, 1098.47 max, 1098.47 min
    HTTP response codes:
      code 200 -- 2

## 検証１
http_loadを使って同時接続しています。2アクセスを2同時接続で実行しました。

sinatraでは`sleep 1`として1秒後に結果を出力するようにしています。

シングルスレッドの場合には全てのリクエストを完了するのに`2.00526`秒かかっています。http_loadによってリクエストは同時に２個投げられていますが１つずつ処理が実行されているのがわかります。

マルチスレッドにした場合には`1.09866`秒でリクエストが完了しています。二つのリクエストがほぼ同時に処理されたということがわかります。

## テスト2
同時接続数を増やしたい場合には`Eventmachine`の`threadpool_size`を調整する必要があります。

### 同時接続数20
    $ http_load -parallel 20 -fetches 20 tmp/url.txt
    20 fetches, 20 max parallel, 80 bytes, in 1.02251 seconds
    4 mean bytes/connection
    19.5597 fetches/sec, 78.2388 bytes/sec
    msecs/connect: 0.33225 mean, 0.575 max, 0.18 min
    msecs/first-response: 1017.84 mean, 1021.8 max, 1013.25 min
    HTTP response codes:
      code 200 -- 20

### 同時接続数21
    $ http_load -parallel 21 -fetches 21 tmp/url.txt
    21 fetches, 21 max parallel, 84 bytes, in 2.02767 seconds
    4 mean bytes/connection
    10.3567 fetches/sec, 41.4269 bytes/sec
    msecs/connect: 0.317714 mean, 0.512 max, 0.183 min
    msecs/first-response: 1068.38 mean, 2026.61 max, 1015.29 min
    HTTP response codes:
      code 200 -- 21

## 検証２
同時接続数が20までならほぼ1秒で処理が終わっています。しかし同時接続を21にした途端に処理が倍の２秒かかっています。

thinはEventMachineを使ってマルチスレッドの処理を行なっています。EventMachineで扱えるスレッドの数はデフォルトでは20となっています。20スレッドを超えてスレッドを生成しようとすると処理待ちの状態になるようです。

この制限を変更したい場合にはプログラム中に次のように設定します。

    EM.threadpool_size = 100

これで100リクエストまで同時に処理を行う事ができます。

## 注意
--threadedオプションを指定した場合にはsinatraをマルチスレッド対応でコーディングする必要があります。マルチスレッドではI/Oに同時アクセスされるという状況が頻発しますのでMutexやflockなどをつかって排他制御する必要があります。

## 参考
- <http://eventmachine.rubyforge.org/EventMachine.html>
