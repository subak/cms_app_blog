# Jasmineの使い方を調べてみる１

![](http://evernote.tk84.net/shard/s8/res/41627863-d876-43da-b809-efdddffe3132/Home%20%C2%B7%20pivotal_jasmine%20Wiki%20%C2%B7%20GitHub.jpg)

<https://github.com/pivotal/jasmine/wiki>

テストしないと夜も不安で眠れなくなりそうだったので、Javascriptテスティングフレームワーク**Jasmine**についてゆるく調べてみました。

ところどころ変な日本語があるかもですが気にしないでください。

## Specs（仕様）

`it()`というfunctionでスペックを表現(express)するみたいです。

    it('should increment a variable', function () {
      var foo = 0;
      foo++;
    });

上記のコードは**それは変数をインクリメントすべきである**という仕様を表している、と考えれば良いでしょうか。

## Expectations（期待）

仕様(Spec)は、それが期待(Expectations)される振る舞い(behavior)を表す必要があります。
振る舞いの結果を期待と比較することで仕様を満たしているかどうかをチェックします。

    it('should increment a variable', function () {
      var foo = 0;            // set up the world
      foo++;                  // call your application code
      expect(foo).toEqual(1); // passes because foo == 1
    });

**JavaScriptは変数をインクリメントすべきである**と解釈すればよいでしょうか。

コードの振る舞いの結果と、期待される値との比較が真であれば、`it()`でJasmineに伝えた(tell)仕様を満たしていると考えてよい、みたいなことでしょうか。

## Suites（ひとそろい）

仕様は`describe()`関数でグルーピングできます。

    describe('Calculator', function () {
      it('can add a number', function () {
      ...
      });

      it('can multiply some numbers', function () {
      ...
      });
    });


- 計算機は、数字を加えることが出来る
- 計算機は、数字のうちのいくつかは乗算することができる

的なことだと思います。

ひとそろいの仕様は記述の中で順番通りに実行されます。

`describe()`のなかで定義された変数は関数スコープを持つので、`it()`のなかでは同じ変数が参照されます。

    describe('Calculator', function () {
      var counter = 0

      it('can add a number', function () {
        counter = counter + 2;   // counter was 0 before
        expect(counter).toEqual(2);
      });

      it('can multiply a number', function () {
        counter = counter * 5;   // counter was 2 before
        expect(counter).toEqual(10);
      });
    });


### Nested Describes（説明の入れ子）

    describe('some suite', function () {

      var suiteWideFoo;

      beforeEach(function () {
        suiteWideFoo = 0;
      });

      describe('some nested suite', function() {
        var nestedSuiteBar;
        beforeEach(function() {
          nestedSuiteBar=1;
        });

        it('nested expectation', function () {
          expect(suiteWideFoo).toEqual(0);
          expect(nestedSuiteBar).toEqual(1);
        });

      });

      it('top-level describe', function () {
        expect(suiteWideFoo).toEqual(0);
        expect(nestedSuiteBar).toEqual(undefined); // Spec will fail with ReferenceError: nestedSuiteBar is not undefined
      });
    });


`describe()`内で定義された関数スコープの変数をうまいこと利用したいときに役に立つんでしょう、多分。

### Disabling Tests & Suites

`it()`を`xit()`にすることで無効化できます。あと`describe()`を`xdescribe()`にして無効にすることも出来るみたいです。

コメントアウトするより簡単ね、ということでしょうか。

## 参考
- <https://github.com/pivotal/jasmine/wiki>
- <https://github.com/pivotal/jasmine/wiki/Matchers>
