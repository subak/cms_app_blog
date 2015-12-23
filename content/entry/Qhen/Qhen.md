# HomebrewでGNUScreen開発版をインストール
![](http://evernote.tk84.net/shard/s8/res/c75c286b-d7ce-44df-a2dc-1f1d516de7c5/)
 
せっかくMacを使っているのでHomebrewのFormulaを作ってみました。GNU Screenの開発版をインストールできます。画面の縦分割やレイアウトが使えます。
 
 
   
 $ brew install https://raw.github.com/gist/2157166/2c2dd118f127236220c7c0fa782761206e2baa85/screen-devel.rb

    ######################################################################## 100.0%
    ==> Installing screen-devel dependency: autoconf
    ==> Downloading http://ftpmirror.gnu.org/autoconf/autoconf-2.68.tar.gz
    Already downloaded: /Library/Caches/Homebrew/autoconf-2.68.tar.gz
    ==> Patching
    patching file bin/autoreconf.in
    ==> ./configure --prefix=/usr/local/Cellar/autoconf/2.68
    ==> make install
    /usr/local/Cellar/autoconf/2.68: 66 files, 2.6M, built in 6 seconds
    ==> Installing screen-devel
    ==> Downloading http://git.savannah.gnu.org/cgit/screen.git/snapshot/screen-mast
    Already downloaded: /Library/Caches/Homebrew/screen-devel-master.tar.gz
    ==> autoconf
    ==> autoheader
    ==> ./configure --enable-colors256 --prefix=/usr/local/Cellar/screen-devel/maste
    ==> make
    ==> make install
    /usr/local/Cellar/screen-devel/master: 23 files, 916K, built in 13 seconds
 
 
依存ライブラリとして`autoconf`がインストールされます。
 
- <http://git.savannah.gnu.org/cgit/screen.git/commit/>
- <http://mitukiii.jp/2010/12/31/gnu-screen-install-to-mac/>
- <https://gist.github.com/2157166>
