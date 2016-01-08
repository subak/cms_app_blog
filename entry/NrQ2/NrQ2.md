# 「Paco」で「make uninstall」できないソフトを削除する

![](http://evernote.tk84.net/shard/s8/res/1b3ad279-616a-4f5e-bca9-bfdc13a59221/)

yumなどのパッケージ管理ソフトをつかえばソフトのアンインストールが簡単に出来ます。  
しかしパッケージ管理ソフトで用意されていないソフトを使いたい時はソースからビルドしてインストールする必要があります。

そういったソフトをアンインストールしたくなった時、make uninstall が用意されていない場合にはファイルを一つづつ削除する必要があります。

Pacoをつかえばソースからビルドしてmake installしたソフトを簡単にアンインストールできます。

##公式サイト##
[paco - a source code pacKAGE oRGANIZER for Unix/Linux](http://paco.sourceforge.net/)  
現在(<time>2012-02-25</time>)の最新バージョンは**2.0.9**です。

##手順##

    $ cd /usr/local/var
    $ wget http://downloads.sourceforge.net/paco/paco-2.0.9.tar.gz
    $ tar zxfv paco-2.0.9.tar.gz
    $ cd paco-2.0.9
    $ ./configure --disable-gpaco
    $ make
    $ sudo make install

途中`$ ./configure --disable-gpaco`としたのはエラーを防ぐためです。
gtkmmというライブラリがインストールされていない場合にはエラーになります。

「Gpaco」というgui用のツールを使いたい場合にはライブラリをインストールした後、オプションを外して`./configure`してください。

また、次の手順を行うとPaco自身もPacoでアンインストールできるようになります。
    $ sudo make logme

##使い方##
###インストールされているソフト一覧###
    $ paco -a
    nginx-1.1.15  paco-2.0.9  php-5.3.10

###ソフトのアンインストール###
    $ sudo paco -r nginx-1.1.15
    Remove package nginx-1.1.15 (y/N) ? 

###インストールでコピーされたファイル一覧###
    $paco -f nginx-1.1.15

##注意##
###Mac OSX では使えません###
PacoのREADMEを読むと次のように書かれています。

    Note: Paco does not work on systems in which binaries are linked statically,
          like FreeBSD or OpenBSD.

BSD UNIXベースで作られているMac OSXでは使えません。
Mac OSXではHomebrewを使うとよいでしょう。

yumと違って新しいソフトウェアも比較的早く登録されます。
Formulaと呼ばれる簡単な定義ファイルさえ作ればソフトを管理対象にできます。

>[Homebrew — MacPorts driving you to drink? Try Homebrew!](http://mxcl.github.com/homebrew/)  
[Formula Cookbook - GitHub](https://github.com/mxcl/homebrew/wiki/Formula-Cookbook)

##まとめと考察##
最新のソフトはyumなどで提供されていない事が多いです。 
そういうソフトを使いたい場合に簡単にアンインストールできれば次のようなことが簡単に出来ます。

- `./.configure`で細かいオプションを指定する
- ソフトを違うオプションでビルドし直す


##参考リンク##
- ["make install"したソフトウェアを管理できる超便利ツール「Paco」 - RX-7乗りの適当な日々](http://d.hatena.ne.jp/rx7/20081011/p2)
- [pacoはMac OS Xでは正常に動作しないようです - 祈れ、そして働け ～ Ora et labora](http://d.hatena.ne.jp/tetsuyai/20111111/1320985021)

