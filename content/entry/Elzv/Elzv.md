# [AngularJS]Tutorial: 4 - Two-way Data Bindingをやってみる

チュートリアルを適当に読みながらやってみます。

<http://docs.angularjs.org/tutorial/step_04>

今回は「データバインディングする二つの方法」についてです。

## gitリポジトリからタグstep-4をチェックアウト
    $ git checkout -f step-4
    Previous HEAD position was 4dbf79e... step-3 interactive search
    HEAD is now at 7551dd7... step-4 phone ordering

## とりあえず動かす
    $ ./scripts/web-server.js
    The "sys" module is now called "util". It should have a similar interface.
    Http Server running at http://localhost:8000/


<http://localhost:8000/app/index.html>にアクセス

[AngularJS-step-4.m4v](http://evernote.tk84.net/shard/s8/res/dc7dae43-34f5-4f2a-a8e3-44bb6c4a3902/AngularJS-step-4.m4v)

インクリメンタルサーチは前回と同じですが、今回はさらにモデルのソートが行われているようです。

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

      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span2">
            <!--Sidebar content-->

            Search: <input ng-model="query">
            Sort by:
            <select ng-model="orderProp">
              <option value="name">Alphabetical</option>
              <option value="age">Newest</option>
            </select>

          </div>
          <div class="span10">
            <!--Body content-->

            <ul class="phones">
              <li ng-repeat="phone in phones | filter:query | orderBy:orderProp">
                {{phone.name}}
                <p>{{phone.snippet}}</p>
              </li>
            </ul>

          </div>
        </div>
      </div>

    </body>
    </html>

ソート方法を指定しているセレクトボックスに注目します。  
`ng-model="query"`でこの入力要素から`query`というモデルが作られています。  
それを使って`phone`モデルをフィルタリングしているのだろうということが前回のチュートリアルを済ませていれば、勘付くはずです。

`ng-repeat="phone in phones | filter:query | orderBy:orderProp"`  
でイテレータを使って`phones`モデルをバインディングしています。  
この時に`orderBy:orderProp`という処理をパイプでつないでいるようです。`orderProp`はセレクトボックスから生成されるモデルです。モデルを使って並べ替えを行うときには`orderBy`という命令を使うようです。

セレクトボックスのDOMから`orderProp`モデルは

  orderProp = "name | age"

であることがわかります。セレクトボックスを切り替えることで`orderProp`モデルの中身が動的に変更されていると考えられます。

`orderBy:( name | age )`と解釈されると考えると、`phone.name`もしくは`phone.age`を基準にしてソートしているということが予想できます。

## app/js/controllers.js

    'use strict';
    /* Controllers */

    function PhoneListCtrl($scope) {
      $scope.phones = [
        {"name": "Nexus S",
         "snippet": "Fast just got faster with Nexus S.",
         "age": 0},
        {"name": "Motorola XOOM™ with Wi-Fi",
         "snippet": "The Next, Next Generation tablet.",
         "age": 1},
        {"name": "MOTOROLA XOOM™",
         "snippet": "The Next, Next Generation tablet.",
         "age": 2}
      ];

      $scope.orderProp = 'age';
    }


これがスクリプトで定義されたモデルになります。今回もコントローラの中でモデルを定義しているようです。やはり`age`というプロパティが用意されていました。

ここでは`phones`と`orderProp`という二つのモデルが定義されています。`orderProp`はテンプレートでも定義されていましたね。

これがデータバインディングの二つの方法ということでしょうか。

> We added a line to the controller that sets the default value of orderProp to age. If we had not set the default value here, the model would stay uninitialized until our user would pick an option from the drop down menu.

コントローラで同名のモデルを定義しておくとデフォルト値として使えるようです。ユーザーがセレクトボックスに対してアクションを起こす前から初期状態を制御できるわけですね。

ちなみに
    //$scope.orderProp = 'age';
というように初期値を設定せずにページを再読み込みするとセレクトボックスは何も選択されていない状態となりました。
![](http://evernote.tk84.net/shard/s8/res/66ccff13-cb6c-4f1b-9163-fbe8b1fdb8a2/Google%20Phone%20Gallery-1.jpg)

インスペクタで見てみると`? undefined:undefined ?`となっていました。内部的な処理が推測できるようで非常に興味深いですね。

ちなみにこの状態でセレクトボックスを選びなおすは選択肢は「Alpabetical」と「Newest」の二つのみになりました。一つ目のoptionは消えてしましました。

この機能を使うときにはスクリプトで初期値を決めておくのがよさそうです。

## test/unit/controllerSpec.js

    'use strict';

    /* jasmine specs for controllers go here */
    describe('PhoneCat controllers', function() {

      describe('PhoneListCtrl', function(){
        var scope, ctrl;

        beforeEach(function() {
          scope = {},
          ctrl = new PhoneListCtrl(scope);
        });


        it('should create "phones" model with 3 phones', function() {
          expect(scope.phones.length).toBe(3);
        });


        it('should set the default value of orderProp model', function() {
          expect(scope.orderProp).toBe('age');
        });
      });
    });


`PhonListCtrl`クラスで生成されたモデルが期待される値であるかをテストしているようです。

`scope`オブジェクトにはそのコントローラがどのスコープで呼び出されたかの情報が入っているようです。  
テンプレートで属性`ng-app`が指定される要素が一つのアプリケーションの単位となり、その中で定義されてるコントローラはこのアプリケーションのスコープを持っているようです。

### テストを実行してみる
    $ ./scripts/test-server.sh

    Starting JsTestDriver Server (http://code.google.com/p/js-test-driver/)

    Please open the following url and capture one or more browsers:


    http://localhost:9876
    setting runnermode QUIET


1. ブラウザで<http://localhost:9876/>へアクセス
2. Capture This Browser in strict modeを選択
![](http://evernote.tk84.net/shard/s8/res/198ca431-957e-4f40-ab1d-31e711c22c4c/JsTestDriver.jpg)

ブラウザがキャプチャ待ちになったら別の端末から次のコマンドを実行します。

    $ ./scripts/test.sh
    setting runnermode QUIET
    Chrome: Reset
    Chrome: Reset
    ..
    Total 2 tests (Passed: 2; Fails: 0; Errors: 0) (4.00 ms)
      Chrome 19.0.1084.52 Mac OS: Run 2 tests (Passed: 2; Fails: 0; Errors 0) (4.00 ms)


## test/e2e/scenarios.js

end-to-endテストと呼ばれるものを実行してみます。UIをシミュレーションできます。

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


        it('should be possible to control phone order via the drop down select box', function() {
          input('query').enter('tablet'); //let's narrow the dataset to make the test assertions shorter

          expect(repeater('.phones li', 'Phone List').column('phone.name')).
              toEqual(["Motorola XOOM\u2122 with Wi-Fi",
                       "MOTOROLA XOOM\u2122"]);

          select('orderProp').option('Alphabetical');

          expect(repeater('.phones li', 'Phone List').column('phone.name')).
              toEqual(["MOTOROLA XOOM\u2122",
                       "Motorola XOOM\u2122 with Wi-Fi"]);
        });
      });
    });


`select('orderProp').option('Alphabetical');`  
セレクトボックスで「Alphabetical」を選択したというUIをシミレーションしているようです。`.option()`メソッドではoptionのバリューではなくラベルを渡すようですね。

    $ ./scripts/web-server.js
    The "sys" module is now called "util". It should have a similar interface.
    Http Server running at http://localhost:8000/


webサーバをたちあげて<http://localhost:8000/test/e2e/runner.html>にアクセス

![](http://evernote.tk84.net/shard/s8/res/9db41454-e86b-43fa-a993-795283b9182b/End2end%20Test%20Runner.jpg)


## 参考
- <http://docs.angularjs.org/tutorial/step_04>
- <http://docs.angularjs.org/guide/dev_guide.e2e-testing>
