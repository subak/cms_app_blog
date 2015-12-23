# Ruby CoffeeScriptをつかう

Ruby CoffeeScriptを使うと、RubyからCooffeeScriptをコンパイルできるようになります。

<https://github.com/josh/ruby-coffee-script>

## インストール

gem install で簡単にインストール出来ます。
bundleを使ってプロジェクトのgemにインストールしときます。

     % bundle install --path vender/bundle
     Fetching gem metadata from https://rubygems.org/.....
     Using rake (0.9.2.2)
     Using addressable (2.2.8)
     Using ffi (1.0.11)
     Using childprocess (0.3.2)
     Installing coffee-script-source (1.3.3)
     Using multi_json (1.3.5)
     Installing execjs (1.3.2)
     Installing coffee-script (2.2.0)
     Using diff-lcs (1.1.3)
     Using jasmine-core (1.2.0)
     Using rack (1.4.1)
     Using rspec-core (2.10.0)
     Using rspec-expectations (2.10.0)
     Using rspec-mocks (2.10.1)
     Using rspec (2.10.0)
     Using libwebsocket (0.1.3)
     Using rubyzip (0.9.8)
     Using selenium-webdriver (2.21.2)
     Using jasmine (1.2.0)
     Using bundler (1.1.3)
     Your bundle is complete! It was installed into ./vender/bundle


### Gemfile
    source 'https://rubygems.org'

    gem 'jasmine'
    gem 'rake'
    gem 'coffee-script'


## Rakefileを用意してコンパイルをタスクに登録する

Ruby CoffeeScriptはコマンドではなく、Gemのライブラリです。

nodeのcoffeeコマンドみたいに使いたい時にはcoffeeのパスを引数で受け取ってコンパイル結果を特定の場所に出力するようなプログラムを自分で用意する必要があります。

今回はプロジェクト中のファイルを指定した場所に出力するということがやりたいので、rakeでコンパイルするようなものを用意してみます。

### Rakefile

    require 'coffee-script'

    COFFEE_FILES = {"../src/template.coffee" => "./public/javascripts/template.js"}
    desc "compile CoffeeScript to JavaScript"
    task :coffee do
      COFFEE_FILES.each do |from, to|
        puts "compile from #{from}"
        coffee = CoffeeScript.compile File.read(from)
        File.open to, "w" do |f|
          f.puts coffee
        end
        puts "compile to #{to}"
      end
    end


COFFEE_FILES定数にハッシュで、コンパイル元のファイルとコンパイル先のファイルのパスを指定しています。

`CoffeeScript.compile`というメソッドは引数として与えられた文字列をCompileされたJavaScriptを文字列で返します。

### 実行
    # rake -T でRakefileに登録されているタスクの一覧を表示できます。
    % rake -T
    rake coffee  # compile CoffeeScript to JavaScript

    % rake coffee
    compile from ../src/template.coffee
    compile to ./public/javascripts/template.js


