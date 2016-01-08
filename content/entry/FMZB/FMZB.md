# EventMachineを使って並列処理

    #! /usr/bin/env ruby
    # -*- coding: utf-8; -*-
    # em_test.rb
    'event machine'


    EventMachine.run do
      10.times do |time|
        EM.defer do
          wait = rand(5) / 10.0
          sleep wait
          puts time  
        end
      end
    end



rubyで並列処理を行う簡単なコードです。イベント駆動型のフレームワークであるEventMachineを使っています。



## 実行結果
    $ ruby em_test.rb
    5
    3
    8
    0
    1
    4
    2
    6
    7
    9

実行された順序と関係なく処理が終わったブロックからすぐに結果を返しているのがわかります。

deferrを使えば最大20個まで並列処理できるようです。nodeのようにシングルスレッドではありませんがプロセスは１つのためプロセスを複数起動するよりリソースの消費は少ないと思います。



## 参考
- <http://20bits.com/article/an-eventmachine-tutorial>
- <http://keijinsonyaban.blogspot.jp/2010/12/eventmachine.html>
