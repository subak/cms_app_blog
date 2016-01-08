# Threadを使ったタイムアウト処理

Rubyにはtimeoutというライブラリがありますが、これを使わずにThreadだけでtimeout処理を実装してみます。



## コード

    # timeout_using_thread.rb

    wait  = ARGV[0].to_f
    limit = ARGV[1].to_f

    puts "wait:#{wait}"
    puts "limit:#{limit}"

    t = Thread.new do
      Thread.pass
      t = Thread.new do
        sleep wait
      end

      begin
        t.join limit
      rescue Exception => e
        # 例外処理

        false
      else
        res = t.alive?
        t.kill
        res
      end
    end

    puts "timeout:#{t.value}"




## 実行結果

    $ ruby timeout_using_thread.rb 0.5 1
    wait:0.5
    limit:1
    timeout:false

    $ ruby timeout_using_thread.rb 0.5 0.1
    wait:0.5
    limit:0.1
    timeout:true




## 参考
- <http://doc.okkez.net/static/192/class/Thread.html>
