# ACMS_POST_2GETを使ってGETクエリのurlを組み立てる[ablogcms]

## `ACMS_POST_2GET` って？

`ACMS_POST_2GET`モジュールはシンプルなPOSTモジュールです。
フォームからPOSTメソッドを使って送信されたパラメータからURLを組み立ててリダイレクトします。

キーワード検索やカスタムフィールドを使ったエントリーの検索をする時に使います。

## 基本

    <form action="" method="POST">
        <input name="keyword" value="hoge" type="text" />
        <input name="tpl" value="result.html" type="hidden" />
        <input name="ACMS_POST_2GET" value="検索" type="submit" />
    </form>

上記のフォームを送信すると

`http://example.com/result.html/keyword/hoge`

というようなurlを組み立ててリダイレクトします。

## GET クエリーを使いたい

`http://example.com/?hoge=huga`

上記のurlにリダイレクトさせたい場合には次のようにします。

    <form action="" method="POST">
      <input name="hoge" value="huga" type="text" />
      <input name="query[]" value="hoge" type="hidden" />
      <input name="ACMS_POST_2GET" value="リダイレクト" type="submit" />
    </form>

`query[]`というname属性を持ったinput要素がポイントです。ここに指定されたパラメータがGETクエリになります。

