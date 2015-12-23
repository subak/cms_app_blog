# Ruby1.9.3+SQLite3+Sinatraでエラーを拾えない問題

Ruby1.9.3でSinatraを使った時にエラーハンドラーで例外の詳細を拾えない問題に遭遇しました。

## 状況

Sinatraでは`error()`メソッドでルーティング内で起こった例外を補足できます。

    # 全ての例外を補足してスタックトレースする
    error do |e|
        logger.error e
    end

しかし、ルーティング内でSQLite3の例外が起こるとこのエラーハンドラを使ってエラーを取得することができませんでした。

    require "sqlite3"
    get "/" do
      raise SQLite3::Exception::SQLException
    end

上記のようにしてアクセスすると本来はログにスタックトレースが書き出されるはずですが、実際には次のようなメッセージが表示されるのみです。

    !! Unexpected error while processing request: ...

どうやらSinatraが内部で正常にエラーハンドラに処理を渡せていないようです。

    require "sqlite3"
    get "/" do
      begin
        raise SQLite3::Exception::SQLException
      rescue Exception => e
        logger.error e
      end
    end

と、すれば例外をスタックトレースできるのですが、いちいちbegin,rescue,endを使って、、はやってられません。

## 調査

**!! Unexpected error ~**というエラーメッセージを発行している箇所を見てみます。

    # Logs catched exception and closes the connection.
    def handle_error
      log "!! Unexpected error while processing request: #{$!.message}"
      log_error
      close_connection rescue nil
    end

`thin/connection.rb`の122行目付近です。さらに処理を追っていくと、、

    # Error handling during requests.
    def handle_exception!(boom)
      @env['sinatra.error'] = boom
      status boom.respond_to?(:code) ? Integer(boom.code) : 500

`sinatra/base.rb`の893行目付近です。どうやら`boom.code`を整数値型に変換する部分で失敗しているようです。例外オブジェクトがcodeメソッドを持つかを調べているようです。

そこでSQLite3の例外クラスを調べてみると、、

    module SQLite3
      class Exception < ::StandardError
        @code = 0

        # The numeric error code that this exception represents.
        def self.code
          @code
        end

        # A convenience for accessing the error code for this exception.
        def code
          self.class.code
        end
      end


`sqlite3/errors.rb`に上記のコードが見つかりました。`code()`メソッドは`self.class.code`を返すようですが、これが`nil`になってしまっていることが原因のようです。

そこで次のようにしてメソッドを上書きしてみました。

    module SQLite3
      class Exception
        def code
          self.class.code || 500
        end
      end
    end

とりあえずこれでSinatraのエラーハンドラで例外を補足できるようになりました。

