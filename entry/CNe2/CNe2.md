# Tutorial: 3 - Filtering Repeatersをやってみる[AnglarJS]

![](http://evernote.tk84.net/shard/s8/res/20e430bc-4af2-4505-9045-2efcf0554656/AngularJS_%203%20-%20Filtering%20Repeaters.jpg)

AnglarJS三番目のチュートリアルは濃いです。幾つものエッセンスが詰まっています。

これをみてAnglarJSがどういうフレームワークを目指しているのかというのがちょっとわかった気がしました。

<http://docs.angularjs.org/tutorial/step_03>

## step-3をチェックアウト

    $ cd angular-phonecat
    $ git checkout -f step-3
    Note: checking out 'step-3'.

    You are in 'detached HEAD' state. You can look around, make experimental
    changes and commit them, and you can discard any commits you make in this
    state without impacting any branches by performing another checkout.

    If you want to create a new branch to retain commits you create, you may
    do so (now or later) by using -b with the checkout command again. Example:

      git checkout -b new_branch_name

    HEAD is now at 4dbf79e... step-3 interactive search

## とりあえず動かしてみる

`scripts/web-server.js`を実行してwebサーバを起動します。node.jsを使って動かすようです。

    $ ./scripts/web-server.js
    The "sys" module is now called "util". It should have a similar interface.
    Http Server running at http://localhost:8000/


<http://localhost:8000/>にアクセスっす

[Angular-step-3.m4v](http://evernote.tk84.net/shard/s8/res/089e19c2-dc13-476d-b00b-2dd4aae4e411/Angular-step-3.m4v)

モデル内のデータをインクリメンタルサーチするアプリケーションのようです。

## ディレクトリ構成

![](http://evernote.tk84.net/shard/s8/res/ef299a4c-b9fa-44c9-a435-04b18e232461/angular-phonecat-1.jpg)


### `app/index.html`

`input`要素に`ng-model="query"`という属性が付加されています。

この`input`要素に入力されたデータから`query`というモデルが作られます。
そのモデルを使って、Controllerで定義されているもう一つのモデル`phones`をフィルタリングしています。

フィルタリングされたデータからリアルタイムにDOMが更新されます。ModelとViewが協力にBindingされているのがわかります。

    <!doctype html>
    <html lang="en" ng-app>
    <head>
      <meta charset="utf-8">
      <title>Google Phone Gallery</title>
      <link rel="stylesheet" href="css/app.css">
      <link rel="stylesheet" href="css/bootstrap.css">
      <script src="lib/angular/angular.js"></script>
      <script src="js/controllers.js"></script>
    </head>
    <body ng-controller="PhoneListCtrl">

      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span2">
            <!--Sidebar content-->

            Search: <input ng-model="query">

          </div>
          <div class="span10">
            <!--Body content-->

            <ul class="phones">
              <li ng-repeat="phone in phones | filter:query">
                {{phone.name}}
                <p>{{phone.snippet}}</p>
              </li>
            </ul>

          </div>
        </div>
      </div>

    </body>
    </html>


`ng-repeat="phone in phones | filter:query"`属性が指定された`li`要素があります。

`in`を使って`phones`配列型からデータを取り出す際にパイプ演算子(`|`)でデータをフィルタリングしています。

`query`モデルのデータに一致するデータのみイテレータで取り出すというような動作をしています。

### `app/js/controller.js`

    'use strict';

    /* Controllers */

    function PhoneListCtrl($scope) {
      $scope.phones = [
        {"name": "Nexus S",
         "snippet": "Fast just got faster with Nexus S."},
        {"name": "Motorola XOOM™ with Wi-Fi",
         "snippet": "The Next, Next Generation tablet."},
        {"name": "MOTOROLA XOOM™",
         "snippet": "The Next, Next Generation tablet."}
      ];
    }


### `test/e2e/scenarios.js`

    'use strict';

    /* http://docs.angularjs.org/guide/dev_guide.e2e-testing */

    describe('PhoneCat App', function() {

      describe('Phone list view', function() {

        beforeEach(function() {
          browser().navigateTo('../../app/index.html');
        });


        it('should filter the phone list as user types into the search box', function() {
          expect(repeater('.phones li').count()).toBe(3);

          input('query').enter('nexus');
          expect(repeater('.phones li').count()).toBe(1);

          input('query').enter('motorola');
          expect(repeater('.phones li').count()).toBe(2);
        });
      });
    });


1. `beforeEach()`で`it()`が実行される前処理を定義しています。
2. `browser().navigateTo('../../app/index.html');`で`app/index.html`に移動(**!**)します。
3. `input('query').enter('nexus');`で`ng-model="query"`属性が指定された`input`要素に"nexus"という文字列を入力しています。
4.  `expect(repeater('.phones li').count()).toBe(1);`でフィルタリング後のli要素の数が期待通りの値になっているかをチェックしています。

`browser().navigateTo()`や`input().enter()`というメソッドが非常に協力です。これでJavaScriptのオブジェクトだけではなく、ブラウザの操作までまで振る舞いとしてSpecに記述できるようです。

## テスト

node.jsを使っている人は<http://localhost:8000/test/e2e/runner.html>にアクセスしてみてください。

![](http://evernote.tk84.net/shard/s8/res/6a9bd490-94c2-40ee-a2b0-b63bc6713415/End2end%20Test%20Runner.jpg)

こんな感じでテストが実行されます。

## 感想

このチュートリアルを見るとModelがテンプレートで定義されているのがわかります。しかもそのモデルは動的に生成され、インプット要素にバインディングされていました。

モデルを使ってモデルをフィルタリングできるということも学びました。それらもほとんどテンプレート上に定義されていました。

ここまでの機能がほぼコードを書かずに実現できてしまっているあたりはなんかすごいですね。

テスト環境が非常に協力です。この環境をを使えばかなり開発効率がアップするのではないでしょうか。

## 参考
- <http://docs.angularjs.org/guide/dev_guide.e2e-testing>


