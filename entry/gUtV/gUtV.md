# [ablogcms]GETクエリでエントリーの表示件数を切り替える

a-blog cmsのエントリー系のモジュールはURLコンテキストから表示件数を制御することができません。

これはセキュリティ上の問題で、大量のエントリーがある場合に大きな表示件数を指定するとデータベースに負荷がかかるためです。

表示件数を調整する場合には管理ページから設定する必要があります。

今回はその制限を回避して、検索フォームから検索結果の表示件数を指定する方法を考えたのでカスタマイズを紹介します。

## やりたいこと

![](http://evernote.tk84.net/shard/s8/res/780520ce-0098-4091-83b5-780841d709ee/)

こういうの。

## やり方

- 表示件数だけ別の値を設定したモジュールIDを複数用意してそれを切り替えることにします。
- モジュールIDの切り替えにはグローバル変数を使います。
- グローバル変数はGETクエリを使って出力します。

### 1. 検索フォーム

検索フォームは次のようにします。

    <form action="" method="POST">
      <input name="keyword" value="%{KEYWORD}" type="text">
      <select name="quantity">
        <option value="few">20</option>
        <option value="plenty">50</option>
        <option value="many">100</option>
      </select>
      <input name="tpl" value="result.html" type="hidden">
      <input name="query[]" value="quantity" type="hidden">
      <input name="AMCS_POST_2GET" value="検索" type="submit">
    </form>

`quantity`というname属性のセレクトボックスが表示件数を設定する変数になります。valueは`few`、`plenty`、`many`というようにしました。

### 2. モジュールID

検索結果の件数を、20件、50件、100件と切り替えたい場合には3つのモジュールIDが必要になります。それぞれ表示件数だけ異なる値を設定します。

基本となるモジュールIDを用意してモジュールIDの複製を使うとよいでしょう。

この時モジュールIDのidがポイントになります。GETクエリーで送信される変数をモジュールIDのidに組み込みます。

- fewresult
- plentyresult
- manyresult

という３つのモジュールIDを用意しました。表示件数はそれぞれ20,50,100が指定してあります。

![](http://evernote.tk84.net/shard/s8/res/62cff04a-e3cb-4106-ad26-41706c9681af/%E7%AE%A1%E7%90%86%E3%83%98%E3%82%9A%E3%83%BC%E3%82%B7%E3%82%99.jpg)

### 3. テンプレート

検索結果はEntry_Bodyを使って表示します。モジュールのidを指定している部分にグローバル変数を出力するのがポイントです。

    <!-- BEGIN_MODULE Entry_Body id="%{quantity}result" -->
    ...
    <!-- END_MODULE Entry_Body -->

## 解説

フォームを送信するとポストモジュールのACMS_POST_2GETは次のようなurlにリダイレクトします。

`http://www.example.com/result.html/keyword/hoge/?quantity=plenty`

上記のurlにはGETクエリーが含まれています。GETクエリーはグローバル変数として取り出すことができます。

`%{quantity}`というグローバル変数が使えるようになります。

グローバル変数はモジュールidに指定できます。
通常のモジュールの変数は使える場所に制限がありますが、グローバル変数は広い範囲で使えます。

`<!-- BEGIN_MODULE Entry_Body id="plentyresult" -->`と解釈されます。

## 補足

quantityのvalueを20,50,100のような数字ではなく、few,plenty,manyというような文字にしたのは理由があります。

quantityはモジュールIDのidに組み込まれます。ですので具体的な数値ではなく意味のある文字を使っています。
こうしておくと表示件数を後で調整したくなった時にも管理ページで指定するだけで済みます。

仮に数字で指定した場合にはモジュールIDのidは`20result`、`50result`というようにする必要があります。
これでもできますが表示件数を変更したくなった場合にはモジュールIDのidを変更しなくてはなりません。
（変更しなくてもいいですが気持ち悪いです）

## おわりに

モジュールに設定できることには限りがあります。通常の範囲を超えてカスタマイズする場合には工夫する必要があります。

グローバル変数とモジュールIDを使えば通常の制限を超えてモジュールを制御することができます。
が、あまりやり過ぎるとバッドノウハウの塊になってしまうので注意が必要です。。

a-blog cmsが積んでから始まると言われるのはこういった側面があるからではないでしょうか。


