# sshfsを使ってMacのFinderからサーバのファイルを操作する
##概要##

サーバとファイルをやり取りするにはFTPを使うのが一般的です。 

わざわざFTPのクライアントソフトを使わずにファイルを操作できたら便利なのにと思ったことはありませんか。    
 
sshfsを使うと**外付けディスクを使用するのと同じような感覚**でサーバのファイルを操作することができるようになります。   
 
ファイルのリネームや削除はもちろんコピー＆ペーストやドラッグ＆ドロップを使ったファイルの移動まで、サーバのファイルをローカルにあるファイルと同じように**Finderから操作**できます。

 

##sshfsとは##

sshfsとはsshを使って接続したサーバとの通信をファイルシステムとして取り扱えるようにしたものです。 
 
通常sshを使ってファイルのリネームや削除といった操作を行うにはコマンド操作が必要になります。 
 
sshfsはFinderから行うファイルのリネームや削除といった操作をコマンドに変換してサーバとの通信を行います。 

一度サーバをファイルシステムとしてマウントしてしまえばサーバとの通信を意識する必要はありません。

 

##MacFuseをインストールする##

sshfsはssh接続したサーバをファイルシステムとして扱うものです。 

ssh以外にもftpやntfs、面白いものではGmailをファイルシステムのように扱えるものまであります。 
 
こういったソフトはそれぞれのリソースをファイルシステムと繋ぐドライバのようなものです。 

MacFUSEはこれらのソフトとにMacのファイルシステムとを繋ぐ役割をします。

 

###OSX Lion用のファイルをダウンロードする###

今回はOSX Lionで使用することを考えます。

下記のページからパッケージをダウンロードしてください。

[Official Wuala Blog.: Wuala for OS X Lion](http://wualablog.blogspot.com/2011/07/wuala-for-os-x-lion.html)

 

![](http://evernote.tk84.net/shard/s8/res/c83259b5-d1ca-4dd4-a1a1-bd4cbd3a54e0/)

 

 

![](http://evernote.tk84.net/shard/s8/res/dd0450a0-4acd-4a18-8c01-69779dbc47c4/)

 

###MacFUSEがインストール済みの場合###


すでにMacFUSEがインストールされている場合にはアンインストールする必要があります。   

もしインストールに失敗するようならアンインストールしてみてください。

 

「システム環境設定」＞「MacFUSE」＞「Remove MacFUSE」 

と進んでください。

 

![](http://evernote.tk84.net/shard/s8/res/8654b6c9-d0ce-48be-ab9e-0fb5bf5eb52b/)

 

![](http://evernote.tk84.net/shard/s8/res/8355f8cf-6ba2-4699-8206-332001f74193/)

 

##sshfsのインストール##

下記のページからパッケージをダウンロードしてください。  

[sshfs-gui - A GUI for different SSHFS realizations — MacFUSE and http://pqrs.org/macosx/sshfs/ - Google Project Hosting](http://code.google.com/p/sshfs-gui/)

 

![](http://evernote.tk84.net/shard/s8/res/f10baad2-62f5-44c9-bebd-d79ebc88676a/)

![](http://evernote.tk84.net/shard/s8/res/ecd22516-6f54-4544-b23d-9b695d52fc13/)

![](http://evernote.tk84.net/shard/s8/res/240026c9-33ad-4182-8f2f-b14b59174d08/)

アプリケーションフォルダにコピー

 

##SSHFS GUIの設定##

sshfsを使う前に、サーバとssh接続できることを確認してください。

 

![](http://evernote.tk84.net/shard/s8/res/2de72733-26aa-479b-acfd-9974287876d7/)

 

サーバ名、ユーザー名とパスワードを入力します。  

ssh接続と同じものを使います。

公開鍵暗号を使った認証でパスフレーズを設定していない場合にはパスワードは必要ありません。

>[SSHでパスワードなしログイン　公開鍵暗号を使った認証](http://www.tk84.net/blog/SSH%E3%81%A7%E3%83%91%E3%82%B9%E3%83%AF%E3%83%BC%E3%83%89%E3%81%AA%E3%81%97%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E3%80%80%E5%85%AC%E9%96%8B%E9%8D%B5%E6%9A%97%E5%8F%B7%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%9F%E8%AA%8D%E8%A8%BC/)

 

うまくいけばFinderに表示されます。

 

![](http://evernote.tk84.net/shard/s8/res/1b7ddb48-3984-4521-a970-fc1109d342f8/)

 

###接続できない###

接続できない場合はサーバ側の設定を確認してください。

**/etc/ssh/sshd_config**を以下のようにするとよいです。

 

    # override default of no subsystems

    #Subsystem     sftp               /usr/libexec/openssh/sftp-server

     # ↑がコメントアウトされている場合には外     す↓

     Subsystem     sftp     /usr/libexec/openssh/sftp-server

 

