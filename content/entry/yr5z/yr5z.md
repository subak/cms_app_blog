# プリインストールのMacRubyでgemのnative extensionをビルド

![](http://evernote.tk84.net/shard/s8/res/fc2bc012-17b4-4de5-b70c-df5e6e8f3d5a/)

ライブラリによってはgemでインストールするときにnative extensionをビルドするものがあります。プリインストールのMacRubyにはgemの実行ファイルは含まれていますがライブラリのコンパイルに必要なヘッダがありません。ヘッダファイルをframework内にコピーする必要があります。



## 手順

プリインストールされているMacRubyのおおよそのバージョンを調べます。

'/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/bin/macruby'にある実行ファイルの作成日を見ると「2011年8月1日 5:59」となっています。

![](http://evernote.tk84.net/shard/s8/res/ff4a3f1a-abd2-419c-979d-211a60faf914/)

<http://www.macruby.org/files/nightlies/>
から同じバージョンと思しきパッケージをダウンロードしてきます。

![](http://evernote.tk84.net/shard/s8/res/7fe1df37-ef48-4726-8e9b-b36926d76cad/)

`macruby_nightly-2011-08-01.pkg`というパッケージがあったのでこれをダウンロード。

[unpkg](http://www.timdoug.com/unpkg/)を使ってパッケージの中身を取り出します。

![](http://evernote.tk84.net/shard/s8/res/7b0d2799-ed29-4f52-a84b-ba4f5e7a8508/)

取り出したファイルの中にある `macruby_nightly-2011-08-01/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/include` というフォルダを `/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr`にコピーします。

`include/ruby-1.9.2/universal-darwin11.0/ruby/config.h`を次のように編集します。

    @@ -236,12 +236,12 @@
     #define HAVE_BRIDGESUPPORT_FRAMEWORK 0
     #define HAVE_AUTO_ZONE_H 0
     #define ENABLE_DEBUG_LOGGING 1
    -#define RUBY_PLATFORM "universal-darwin10.0"
    -#define RUBY_LIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/1.9.2"
    -#define RUBY_ARCHLIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/1.9.2/universal-darwin10.0"
    -#define RUBY_SITE_LIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/site_ruby"
    -#define RUBY_SITE_LIB2 "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/site_ruby/1.9.2"
    -#define RUBY_SITE_ARCHLIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/site_ruby/1.9.2/universal-darwin10.0"
    -#define RUBY_VENDOR_LIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/vendor_ruby"
    -#define RUBY_VENDOR_LIB2 "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/vendor_ruby/1.9.2"
    -#define RUBY_VENDOR_ARCHLIB "/Library/Frameworks/MacRuby.framework/Versions/0.11/usr/lib/ruby/vendor_ruby/1.9.2/universal-darwin10.0"
    +#define RUBY_PLATFORM "universal-darwin11.0"
    +#define RUBY_LIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/1.9.2"
    +#define RUBY_ARCHLIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/1.9.2/universal-darwin11.0"
    +#define RUBY_SITE_LIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/site_ruby"
    +#define RUBY_SITE_LIB2 "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/site_ruby/1.9.2"
    +#define RUBY_SITE_ARCHLIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/site_ruby/1.9.2/universal-darwin11.0"
    +#define RUBY_VENDOR_LIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/vendor_ruby"
    +#define RUBY_VENDOR_LIB2 "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/vendor_ruby/1.9.2"
    +#define RUBY_VENDOR_ARCHLIB "/System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/lib/ruby/vendor_ruby/1.9.2/universal-darwin11.0"




## gemでライブラリをインストール

次のようにしてgemからライブラリをインストールします。

    $ env GEM_HOME=/tmp /System/Library/PrivateFrameworks/MacRuby.framework/Versions/A/usr/bin/macgem install thrift

thriftというライブラリをインストールしています。thriftをインストールすると`thrift_native.bundle`というバイナリファイルがビルドされます。このバイナリ形式のライブラリはMacRuby.frameworkにリンクされています。

上では`/tmp`ディレクトリにインストールしています。`lib`の中身だけとりだしておき、Xcodeでビルドするアプリでライブラリを使いたいときに同梱します。



![](http://evernote.tk84.net/shard/s8/res/dd159f3d-d3dd-4473-b652-f5e362edb86c/)


![](http://evernote.tk84.net/shard/s8/res/3dff6a44-006b-4cea-958b-04c1a481e169/)



## 参考
- <http://www.macruby.org>
- <http://www.timdoug.com/unpkg/>
