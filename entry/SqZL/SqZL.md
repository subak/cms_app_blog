# AjaxページでTwitterのwidget.jsを使う








![](http://evernote.tk84.net/shard/s8/res/7ced13e4-935b-4dbd-9c7b-3607ff328b56/Twitter%20Developers.jpg)

ブログのエントリーページからツイッターにつぶやくためのボタンを設置するメモです。

![](http://evernote.tk84.net/shard/s8/res/4c4acde1-f6fa-4a82-8162-9394c9534ab9/Twitter%20for%20Websites%20%7C%20Twitter%20Developers.jpg)

通常は次のようなコードをHTMLのソースに貼り付けます。

    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id))    {js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}    (document,"script","twitter-wjs");</script>


こちらのコードも外部スクリプトを読み込んで自動でHTMLを書き換えるような処理を行なっているようです。
`<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>`がiframeに置き換わります。

一度だけボタンを表示したい場合は問題ありませんがAjaxなどで画面を遷移する場合には、ページが切り替わった時にも同じボタンが表示されてしまします。HTML5のhistoryAPIなどと併用する場合などはURLが変わりますので特に困ったことになります。

通常はURLが変わればページが再読込されてスクリプトも再実行されますので問題ありません。しかしAjaxを使ってページを遷移する場合にはURLが変わってもページは再読み込みされずスクリプトも実行されません。

ですので手動でDOMの再構築を行う必要があります。

さて、twitterのwidgetのAPIなのですが、困ったことにAjaxと併用するときのドキュメントが見つかりませんでした。ですが、スクリプトを読み込んで何らかの処理を行なってHTMLの再構築を行なっているようですから、それがわかれば簡単に手動で実行できるかもしれません。

ということで調べてみました。

## widget.js の中身

`platform.twitter.com/widgets.js`を読み込むと`twttr`というオブジェクトが作られるようです。早速なかみを覗いてみます。

![](http://evernote.tk84.net/shard/s8/res/b1cf124a-01c7-4621-8c5c-07eaac82322e/CMS%E5%B0%82%E9%96%80%20Web%E9%96%8B%E7%99%BA%E8%80%85%E3%83%95%E3%82%99%E3%83%AD%E3%82%AF%E3%82%99.jpg)

こんな感じになっているようです。

あとは怪しそうなメソッドを適当に実行してみます。

どうやら`twttr.widgets.load()`というのが初期化するメソッドのようです。これを実行したところHTMLが書き換わりました。

以下、実際に使用したコードを載せておきます。CoffeeScriptです。

    # twitter
    if twttr?
      twttr.widgets.load()
    else
      jQuery.getScript "http://platform.twitter.com/widgets.js"

`twttr`というオブジェクトがすでにあれば、HTMLを書き換えて初期化する`twttr.widgets.load()`メソッドを実行します。なければjQueryのajaxを使ってスクリプトを読み込んで実行します。最初に読み込んだ時には自動で`twttr.widgets.load()`が実行される用になっていると思います。

## 参考
- <https://dev.twitter.com/>
- <https://dev.twitter.com/docs/twitter-for-websites>


