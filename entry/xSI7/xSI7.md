# Ruby GemでJasmineをインストール[Ruby][JS]















![](http://evernote.tk84.net/shard/s8/res/79d84320-5815-4d6d-a95d-3f74da2dcbaf/Jasmine_%20BDD%20for%20your%20JavaScript.jpg)

JavascriptのテスティングフレームワークJasmineをRuby Gemでインストールして使ってみた時のメモです。

## Jasmineの種類
スタンドアローン版、Ruby Gem版、その他と三種類あるようです。

Ruby Gemを使えばファイルのダウンロードからセットアップするところまで全部コマンドラインで行えます。
RubyにはRakeという協力なビルドツールがありますのでテスト用プロジェクトの雛形を作ったりといったことも全部コマンド一発です。

## インストール

bundleを使ってインストールします。bundleはスクリプトで必要なgemファイルをまとめてダウンロード、インストールしてくれるプログラムです。
bundleがインストールされていない場合は

    $ gem intall bundle

でインストールして`bundle`コマンドを使用できるようにしておく必要があります。

### プロジェクト
プロジェクトは次のようなディレクトリ構成を想定しています。

    ./src
    ./src/Hoge.js
    ./test

Hoge.jsが実際にテストを行いたいJSのファイル。
testがJasmineのspecなどを置くディレクトリです。

### プロジェクトのtestディレクトリに移動してGemfileを作る
    $ cd $PROJECT/test
    $ nano Gemfile

### Gemfile
    source 'https://rubygems.org'


    gem 'jasmine'
    gem 'rake'


### bundle install

    # $PROJECT/test/vender/bundle以下にgemファイルがインストールされます
    $ bundle install --path vender/bundle

### テストのひな形を作成

    # bundle exec で bundleでインストールされたgemを利用してコマンドを実行
    $ bundle exec jasmin init

## テストのディレクトリ構成
`jasmine init`を実行するとテストのひな形が作成されます。
次のようなディレクトリ構成になっています。

    ./test/public
    ./test/public/javascripts
    ./test/spec
    ./test/spec/javascripts

`public`ディレクトリの中にテストの対象のクラスを配置します。


## テストの実行
rakeのタスクを使ってテストを実行します。

    $ bundle exec rake jasmin:ci

上記のコマンドを実行するとrakeのタスクが実行されます。
次のようなプログラムが自動的に実行されます。

1. ローカルでWebサーバを起動
2. Firefoxが起動
3. FirefoxがWebサーバにアクセスしてテストを実行

テストが終了するとブラウザは終了します。
テスト結果はコンソールに出力されます。

失敗するとこんな感じで表示されます。


     % bundle exec rake jasmine:ci
     /Volumes/Data/Users/hiro/.rvm/rubies/ruby-1.9.2-p318/bin/ruby -S rspec /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/jasmine-1.2.0/lib/jasmine/runner.rb --colour --format progress
     Waiting for jasmine server on 51446...
     [2012-05-16 03:35:17] INFO  WEBrick 1.3.1
     [2012-05-16 03:35:17] INFO  ruby 1.9.2 (2012-02-14) [x86_64-darwin11.3.0]
     [2012-05-16 03:35:17] INFO  WEBrick::HTTPServer#start: pid=24799 port=51446
     Waiting for jasmine server on 51446...
     jasmine server started.
     Waiting for suite to finish in browser ...
     Expected true to equal false.
     ([object Object])@http://localhost:51446/__JASMINE_ROOT__/jasmine.js:102
     (false)@http://localhost:51446/__JASMINE_ROOT__/jasmine.js:1199
     ()@http://localhost:51446/__spec__/PlayerSpec.js:13
     ((function () {if (jasmine.Queue.LOOP_DONT_RECURSE && calledSynchronously) {completedSynchronously = true;return;}if (self.blocks[self.index].abort) {self.abort = true;}self.offset = 0;self.index++;var now = (new Date).getTime();if (self.env.updateInterval && now - self.env.lastUpdate > self.env.updateInterval) {self.env.lastUpdate = now;self.env.setTimeout(function () {self.next_();}, 0);} else {if (jasmine.Queue.LOOP_DONT_RECURSE && completedSynchronously) {goAgain = true;} else {self.next_();}}}))@http://localhost:51446/__JASMINE_ROOT__/jasmine.js:1024
     ()@http://localhost:51446/__JASMINE_ROOT__/jasmine.js:2025
     (4)@http://localhost:51446/__JASMINE_ROOT__/jasmine.js:2015

     F....

     Failures:

       1) Player should be able to play a Song
          Failure/Error: fail out unless spec_results['result'] == 'passed'
          RuntimeError:
            Expected true to equal false.
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/jasmine-1.2.0/lib/jasmine/spec_builder.rb:148:in `report_spec'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/jasmine-1.2.0/lib/jasmine/spec_builder.rb:114:in `block in declare_spec'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example.rb:87:in `instance_eval'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example.rb:87:in `block in run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example.rb:195:in `with_around_each_hooks'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example.rb:84:in `run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example_group.rb:353:in `block in run_examples'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example_group.rb:349:in `map'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example_group.rb:349:in `run_examples'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/example_group.rb:335:in `run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/command_line.rb:28:in `block (2 levels) in run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/command_line.rb:28:in `map'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/command_line.rb:28:in `block in run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/reporter.rb:34:in `report'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/command_line.rb:25:in `run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/runner.rb:69:in `run'
          # /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/rspec-core-2.10.0/lib/rspec/core/runner.rb:10:in `block in autorun'

     Finished in 0.94901 seconds
     5 examples, 1 failure

     Failed examples:

     rspec ./vender/bundle/ruby/1.9.1/gems/jasmine-1.2.0/lib/jasmine/spec_builder.rb:113 # Player should be able to play a Song
     rake aborted!
     /Volumes/Data/Users/hiro/.rvm/rubies/ruby-1.9.2-p318/bin/ruby -S rspec /Volumes/Data/Users/hiro/Dev/lib/subak_template/test/vender/bundle/ruby/1.9.1/gems/jasmine-1.2.0/lib/jasmine/runner.rb --colour --format progress failed

     Tasks: TOP => jasmine_continuous_integration_runner
     (See full trace by running task with --trace)


## 参考
- <http://d.hatena.ne.jp/griefworker/20120313/jasmine>
















