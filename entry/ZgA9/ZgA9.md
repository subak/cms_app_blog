# [JavaScript] Jsonで取得した文字列に「C2A0」が含まれている問題

JsonからMarkdownテキストを取得してHTMLに変換する処理を書いていたのですがうまくいきませんでした。
試しにスクリプト中に書かれたテキストを変換したところ問題なく動作していました。

空白文字に変なもんが混ざっている、という勘が働いたので次のようなスクリプトを書いて調べてみました。

    // markdownにmarkdwonテキストが入っています。
    if mathces = markdown.match /[^\S\r\n\t]/g
      for match in matches
        console.log encodeURI match

上記のCoffeeスクリプトを実行してみました。
正規表現`[^\S\r\n\t]`はタブと改行をのぞいた空白文字という意味です。

Consoleには次のような出力が

    %20
    %20
    %C2%A0

ん？`%C2%A0`

`%20`はURLなどでよく見かける空白文字`\x20`です。`%C2%A0`はなんぞや？と思って調べてみたところUTF-8の空白文字とのことでした。
次のようなスクリプトを書いてUTF-8の空白文字を通常の空白文字に書き換えてみたところうまくいきました。

    re = new RegExp decodeURI("%C2%A0"), "g"
    markdown = markdown.replace re, " "

はじめ正規表現を使って`markdown.replace /(\xc2\xa0)/g, " "`と書いてみたのですが、うまくいきませんでした。UTF-8文字はテキストエディタでは入力できない（出来るのかもしれないけどやり方がわからない）ので文字のエンコード表現をデコードして文字に変換しています。

## 参考
- <http://www.softel.co.jp/blogs/tech/archives/769>
- <http://blog.fkoji.com/2009/08051332.html>
