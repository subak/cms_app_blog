# a-blog cms でスマートに js ( JavaScript ) ファイルを管理する

![](http://evernote.tk84.net/shard/s8/res/172d1b63-2369-460f-bde1-ac1e9579c3f8/jpeg.jpeg)

ページにjsのライブラリや、自分で書いたjsを読み込む際に私が実践している方法を紹介します。

##手順##
使用するテーマフォルダに「**js**」フォルダを作成します。 
「**js**」フォルダに「**index.js**」を作成します。  


![](http://evernote.tk84.net/shard/s8/res/afb4d84c-2a42-4e31-aec0-f5f2641d4cd1/)

    /**
     * index.js
     */

    var jsDir = $('#user-js').attr('src').replace(/index\.js$/, '');


使用するテンプレートにindex.jsを読み込みます。


    <!-- BEGIN_MODULE Js -->
    <script type="text/javascript" src="/index.js{arguments}" charset="UTF-8" id="acms-js"></script><!-- END_MODULE Js -->
    <!--BEGIN_MODULE Touch_Unlogin --><!-- BEGIN_MODULE Blog_Field -->{googleAnalytics}[raw]<!-- END_MODULE Blog_Field --><!-- END_MODULE Touch_Unlogin -->
    <!-- ここに追加 --><script type="text/javascript" src="/js/index.js" id="user-js"></script>
    </head>


a-blog cms のルートディレクトリにある index.js と名前が同じでわかりづらいので注意してください。 
**ルートディレクトリにあるindex.jsの後に読み込ませる**必要がありますのでhead の閉じタグのすぐ上に置きます。

> ここで読み込む二つの/index.jsと/js/index.jsというファイルのパスはともに実在していない。 
a-blog cms ではscriptタグのsrc属性やlinkタグのhref属性に実在しないファイルパスが指定された場合に適当なディレクトリを検索してこれを補完する。 
生成されたページのソースを見ると、/index.js は /blog/index.js、/js/index.js は /blog/themes/a@blog/js/index.js などのように書き換えられているのがわかる。 
このためディレクトリ構成がどのようでも同一の書き方で対応できる。 


##外部jsファイルを読み込むサンプル##


    /**
     * index.js
     */

    var jsDir = $('#user-js').attr('src').replace(/index\.js$/, '');
    // jsDir変数には /blog/themes/a@blog/js/ というように js ディレクトリまでのパスが入っています

    ACMS.Load(jsDir+ 'hoge.js')();
    // js ディレクトリにある「hoge.js」というファイルを読み込んでいます。

    ACMS.Load.css(jsDir + 'hoge.css');
    // js ディレクトリにある「hoge.css」というcssのファイルを読み込んでいます。

 

##まとめ##
###メリット###
- 新たにjsファイルを追加する場合にもテンプレートを修正する必要がない。
- jsディレクトリの場所やファイル名、タグの書き方まで決められるのでルーティン化でき、新しくサイトを立ち上げる場合にもいちいち考えなくて良い
###デメリット###
- JavaScriptの知識が必要
- a-blog cms の非公開apiを使用しているため仕様の変更などがあった場合に動かなくなる可能性がある
- テーマを継承させる場合には使いづらい

##おわりに##
以上が手順となりますが、これだけでは何がいいのかわかりづらいと思います。 
実際に活用している例なども紹介してゆきますのでそちらの方も参考にしてください。
