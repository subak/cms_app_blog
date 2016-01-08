# 気になったRubyのメソッド

## instance_eval

ブロックの中のselfが呼び出し元オブジェクトになるってことかしら

    # lib/daemons/etc_extension.rb
    require 'etc'

    Etc.instance_eval do
      def groupname(gid)
        Etc.group {|e| return e.name if gid == e.gid }
        nil
      end
      def username(uid)
        Etc.passwd {|e| return e.name if uid == e.uid }
        nil
      end
    end


## values_at
<http://ref.xaio.jp/ruby/classes/hash/values_at>

values_atメソッドは、ハッシュから引数で指定したキーに対応する値を取り出し、配列にして返します。引数は複数指定できます。存在しないキーを指定すると、その値はnilになります。

      def initialize(app, options={})
        @secrets = options.values_at(:secret, :old_secret).compact
        @coder  = options[:coder] ||= Base64::Marshal.new
        super(app, options.merge!(:cookie_only => true))
      end

## compat
<http://doc.ruby-lang.org/ja/search/class:Array/query:compact/version:1.9.3/>

配列からnilを取り除く

## class_eval
<https://github.com/rack/rack/blob/master/test/spec_session_cookie.rb>


  before do
    @warnings = warnings = []
    Rack::Session::Cookie.class_eval do
      define_method(:warn) { |m| warnings << m }
    end
  end

  after do
    Rack::Session::Cookie.class_eval { remove_method :warn } 
  end

## 参考
- <http://ref.xaio.jp/ruby/classes/object/instance_eval>
- <http://ref.xaio.jp/ruby/classes/hash/values_at>
