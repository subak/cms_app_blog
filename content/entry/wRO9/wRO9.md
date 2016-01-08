# 「Tutorial: 2 - Angular Templates」をやってみる








前回に引き続き今回もAnglarのチュートリアルに挑戦してみます。

<http://docs.angularjs.org/tutorial/step_02>


## Gitリポジトリからstep-2タグをチェックアウト

    $ git tag
    step-0
    step-1
    step-10
    step-11
    step-2
    step-3
    step-4
    step-5
    step-6
    step-7
    step-8
    step-9

    $ git checkout -b step-2
    Switched to a new branch 'step-2'

## app/index.html
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

      <ul>
        <li ng-repeat="phone in phones">
          {{phone.name}}
          <p>{{phone.snippet}}</p>
        </li>
      </ul>

    </body>
    </html>


`app/index.html`がテンプレートです。`html`要素に`ng-app`属性を付けてルートのアプリケーションであることを宣言しています。

`body`要素には`ng-controller="PhoneListCtrl"`が付けられています。`body`要素内がコントローラ`PhoneListCtrl`と関連付けられます。

`ng-repeat="phone in phones"`属性が指定された`li`要素がリピートされることを定義しています。`phones`はモデルのデータになります。配列phonesからphone変数をイテレータで取り出します。

`{{phone.name}}`、`{{phone.snippet}}`にモデルのデータがアサインされます。


## app/js/controllers.js
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


コントローラの中でモデルを定義しているようです。json形式のファイルをサーバに用意しておいてajaxで読み込んだりする場合も同じようにコントローラの中でモデルにデータを突っ込むみたいです。

## test/unit/controllersSpec.js
    'use strict';

    /* jasmine specs for controllers go here */
    describe('PhoneCat controllers', function() {

      describe('PhoneListCtrl', function(){

        it('should create "phones" model with 3 phones', function() {
          var scope = {},
              ctrl = new PhoneListCtrl(scope);

          expect(scope.phones.length).toBe(3);
        });
      });
    });


AnglarはテスティングフレームワークにJasmineを使用しています。
**PhoneCat controllers**の**PhoneListCtrl**は**should create "phones" model with 3 phones**であることが期待されるというテストです。

`PhoneListCtrl`の`phones`モデルの配列の長さが`3`であることをテストしています。

## テストを行う

    $ ./scripts/test-server.sh
    Starting JsTestDriver Server (http://code.google.com/p/js-test-driver/)
    Please open the following url and capture one or more browsers:
    http://localhost:9876
    setting runnermode QUIET


`./scripts/test-server.sh`を実行してテスト用サーバを起動します。

![](http://evernote.tk84.net/shard/s8/res/3b8caee4-c1ab-4a17-b5ca-ec611796e793/JsTestDriver.jpg)

<http://localhost:9876>にアクセス。`Capture This Browser in strict mode`をクリックします。

![](http://evernote.tk84.net/shard/s8/res/1a3fb022-d538-4046-bdc0-393e9f88e088/Remote%20Console%20Runner.jpg)

こんな感じになります。

    $ ./scripts/test.sh
    setting runnermode QUIET
    Chrome: Reset
    Chrome: Reset
    .
    Total 1 tests (Passed: 1; Fails: 0; Errors: 0) (3.00 ms)
      Chrome 18.0.1025.168 Mac OS: Run 1 tests (Passed: 1; Fails: 0; Errors 0) (3.00 ms)

コマンドラインからテストを実行するようです。サーバを起動したターミナルはロックされてしまうので別のターミナルから実行しました。

## 感想
コントローラの中でモデルを定義しているのがちょっと不思議な感じがしました。モデルはクラスを定義せずにJson形式のまま扱うのが流儀なのでしょうか？

テストをコマンドラインから実行できるのが**cool**ですね。

## 参考
- <http://docs.angularjs.org/tutorial/step_02>


