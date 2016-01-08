# rvmでmacruby-headをインストール

rvmのmacrubyには`macruby[-0.10]`、`macruby-nightly`、`macruby-head`の３つが用意されています。

このうち前者の二つは`.pkg`形式で提供されているパッケージでインストールされます。この中で最新版である`macruby-head`はソースからビルドしてインストールされます。

MacRubyはLLVMを使用しているためllvmのインストールが必要になりますがバージョンによってはコンパイルできませんので注意が必要です。




## llvm2.9をインストール
llvmのバージョンがシビアです。3.0ではコンパイルできませんでした。

    $ svn co https://llvm.org/svn/llvm-project/llvm/branches/release_29@127367 llvm-2.9

    $ cd llvm-2.9
    $ env CC=/usr/bin/gcc CXX=/usr/bin/g++ ./configure --enable-bindings=none --enable-optimized --with-llvmgccdir=/tmp
    $ env CC=/usr/bin/gcc CXX=/usr/bin/g++ make  -j2
    $ sudo env CC=/usr/bin/gcc CXX=/usr/bin/g++ make install


ビルドに３０分位かかりました。`make  -j2`というオプションは使用しているcpuによって調節してください。

core 2 duoなどcoreが二つのcpuは`-j2`、core 2 quadなどcoreが4つのcpuであれば`-j4`とすれば並列処理でコンパイルが行われます。

※llvmはmake uninstallできる。ビルド時に使ったディレクトリは削除せずそのままにしておくとよい。




## macruby-headをインストール

    $ rvm install macruby-head

下のようにあらかじめインストールスクリプトを弄っておくとコンパイル時のcpuを最適化できます。

        $ diff -u /Volumes/Data/Users/hiro/.rvm/scripts/functions/manage/macruby.org /Volumes/Data/Users/hiro/.rvm/scripts/functions/manage/macruby
        --- /Volumes/Data/Users/hiro/.rvm/scripts/functions/manage/macruby.org     2012-03-25 07:42:18.000000000 +0900
        +++ /Volumes/Data/Users/hiro/.rvm/scripts/functions/manage/macruby     2012-03-25 07:40:26.000000000 +0900
        @@ -14,7 +14,7 @@
               macruby_path="/usr/local/bin"
               # TODO: configure & make variables should be set here.
               rvm_ruby_configure=" true "
        -      rvm_ruby_make="rake"
        +      rvm_ruby_make="rake jobs=2"
               rvm_ruby_make_install="$rvm_bin_path/rvmsudo rake install"
        
               __rvm_db "${rvm_ruby_interpreter}_repo_url" "rvm_ruby_url"





## 参考
- <https://github.com/MacRuby/MacRuby#readme>
- <https://rvm.beginrescueend.com/interpreters/macruby/>
- <http://blog.katsuma.tv/2011/01/macruby_llvm_introduction.html>
- <http://lists.macosforge.org/pipermail/macruby-devel/2011-June/007872.html>
- <http://llvm.org/docs/GettingStarted.html>
