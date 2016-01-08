# AngularJSのチュートリアルをやってみる

![](http://evernote.tk84.net/shard/s8/res/fcf96608-b24d-4ed2-ab5b-05843dc90838/AngularJS%20%E2%80%94%20Superheroic%20JavaScript%20MVC%20Framework.jpg)

## AnglarJSについて
<http://angularjs.org/>

**AnglarJS**はJavascriptのMVCフレームワークです。
Backborn.js、Knockoutと並び、今後の展開が期待されている注目のフレームワークです。

四人の開発者のうち、二人はグーグルに勤めているそうです。さすがです。

## チュートリアル
**AnglarJS**にはチュートリアルが用意されているようなのでやってみます。

<http://docs.angularjs.org/tutorial>

## チュートリアル用のgitリポジトリをclone

    $ git clone git://github.com/angular/angular-phonecat.git

    Cloning into 'angular-phonecat'...
    remote: Counting objects: 1260, done.
    remote: Compressing objects: 100% (657/657), done.
    remote: Total 1260 (delta 618), reused 1167 (delta 527)
    Receiving objects: 100% (1260/1260), 7.82 MiB | 1.48 MiB/s, done.
    Resolving deltas: 100% (618/618), done.


## 新しいブランチを作ってチェックアウト

    $ cd angular-phonecat
    $ git checkout -f step-0
    Note: checking out 'step-0'.

    You are in 'detached HEAD' state. You can look around, make experimental
    changes and commit them, and you can discard any commits you make in this
    state without impacting any branches by performing another checkout.

    If you want to create a new branch to retain commits you create, you may
    do so (now or later) by using -b with the checkout command again. Example:

    git checkout -b new_branch_name

    HEAD is now at 06c0b28... step-0 bootstrap angular app

## ローカルWebサーバを起動
Macを使っている人は以下のコマンドでWebサーバが起動します。

    $ ./scripts/web-server.js

    The "sys" module is now called "util". It should have a similar interface.
    Http Server running at http://localhost:8000/


ブラウザで<http://localhost:8000/app/index.html>にアクセスします。

![](http://evernote.tk84.net/shard/s8/res/4662c67c-1d12-4e7d-8f1e-12478d43814c/My%20HTML%20File.jpg)

このように表示されていれば成功です。

## テンプレート

初期状態のテンプレートの中身はこんな感じです。

`app/index.html`

    <!doctype html>

    <html lang="en" ng-app>
    <head>
      <meta charset="utf-8">
      <title>My HTML File</title>
      <link rel="stylesheet" href="css/app.css">
      <link rel="stylesheet" href="css/bootstrap.css">
      <script src="lib/angular/angular.js"></script>
    </head>
    <body>

      <p>Nothing here {{'yet' + '!'}}</p>

    </body>
    </html>


`html`要素の`ng-app`属性でModelにアサインされることを示しているようです。

{{}}で囲まれている部分は変数になっていて、この中にはJavascriptが書けます。
実行結果が文字列として出力されるようになっているようです。

## 感想

上のアプリケーションでは`lib/angular/angular.js`というライブラリを読み込んでいます。
これはクラスファイルであり、手続きを記述したものではありません。
にもかかわらず基本的なアプリケーションは動作しています。

テンプレートの機構がフレームワークに含まれているのでHTMLドリブンのような趣もあります。

## 参考

- <http://docs.angularjs.org/tutorial>
- <http://blog.livedoor.jp/kotesaki/archives/1738808.html>



