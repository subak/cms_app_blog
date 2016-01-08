# ablogcmsで特定のカスタムフィールドをキーワード検索から外す

a-blog cmsではカスタムフィールの内容もキーワード検索の対象になります。しかしタグやカテゴリーのようにメタ情報として使用している場合にカスタムフィールドが意図しないキーワードで検索されて困ることがあります。

## やり方

    <!-- カスタムフィールド -->
    <input name="hoge" value="{hoge}" type="text">
    <input name="field[]" value="hoge" type="hidden">

    <!-- :serach属性を0にする -->
    <input name="hoge:search" vlaue="0" type="hidden">

- カスタムフィールドに`:search`を付けて属性を指定します。
- `:validator`や`:connector`と一緒です。
- `hoge@serach`ではありません。
- イメージのカスタムフィールドで使われる`photo@alt`のように`@`を使って指定するのはプロパティです。
- `hoge:serach`という属性に`0`を指定するとキーワード検索の対象から外れます。
- プロパティを明示的に指定しない場合にはデフォルトで`1`が設定されキーワード検索の対象になります。
- キーワード検索の対象からは外れますが、カスタムフィールドの検索はできます。

## 参考
- <http://www.a-blogcms.jp/support/tutorial/custom-field/fieldSearch.html>
