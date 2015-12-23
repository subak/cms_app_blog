# GoogleAnalyticsで特定のユーザーを除外する

![](http://evernote.tk84.net/shard/s8/res/ac190fab-7104-4900-9c41-f35b04065a30/)

サイト制作をしていると編集したページを確認するため頻繁にアクセスします。  
GoogleAnalyticsにこういったアクセスが記録されるのは好ましくありません。  
指定したユーザーからのアクセスを除外する方法を紹介します。  
（2012年2月現在）

##Cookieを利用して特定のユーザーを除外する##
多くの家庭用ネットワークはDHCPを使用して動的にIPを取得しています。 
アクセスするたびにIPアドレスが変わってしまいます。 
IPアドレスが変更されるたびにフィルタリングで除外することもできなくは無いですが、現実的ではないでしょう。 
GoogleAnalytics（グーグルアナリティクス）ではCookieを利用して特定のブラウザ（ユーザー）からのアクセスを除外できます。

##手順１．GoogleAnalyticsでカスタムフィルタを作成##
フィルタを作成するところまではIPアドレスでフィルタリングする手順と同じです。

>[GoogleAnalyticsで特定のネットワーク除外する](http://www.tk84.net/blog/GoogleAnalytics%E3%81%A7%E7%89%B9%E5%AE%9A%E3%81%AE%E3%83%8D%E3%83%83%E3%83%88%E3%83%AF%E3%83%BC%E3%82%AF%E3%82%92%E9%99%A4%E5%A4%96%E3%81%99%E3%82%8B/)

フィルタを作るときに「**カスタムフィルタ**」を選びます。


![](http://evernote.tk84.net/shard/s8/res/967c1314-d6e6-4e9d-98e9-a2613ad23ada/)

1. 「**フィルタフィールド**」は「**ユーザー定義**」を選択します。
2. 「**フィルタパターン**」には「`test_value`」と入力してください。
3. 設定を保存します。

GoogleAnalyticsでの作業は以上で終わりです。


##手順２．アクセスを除外したいブラウザにCookieを書き込む##
次のようなhtmlファイルを作成し、アクセス解析を行なっているサイトにアップロードします。 
一般の人にアクセスされないようにファイル名は推測されにくいものにしてください。

    <!DOCTYPE html>
    <html lang="ja"]]]]
>

      <head>
        <meta charset="UTF-8"]]]]
>


        <title>このページに一度でもアクセスした人はアクセス解析の対象から除外されます</title>

        <script type="text/javascript"]]]]
>

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-xxxxxxxx-x']);
          _gaq.push(['_trackPageview']);
         
          (function() {
          　　var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          　　ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
           　　var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
      </head>
      <body onLoad="javascript:pageTracker._setVar('test_value');"]]]]
>

        <p>このページに一度でもアクセスした人はアクセス解析の対象から除外されます</p>
      </body>
    </html>


**上記のコードをそのままコピペしても動きません。** 
GoogleAnalyticsのIDの部分(`UA-xxxxxxxx-x`)を書き換えてください。

##動作の確認##
上の手順でアップロードしたhtmlにアクセスしてちゃんとCookieが書きこまれているか確認します。 
Google Chrome であればデベロッパーツールからそのサイトで使われているCookieを見ることができます。

![](http://evernote.tk84.net/shard/s8/res/8ae11390-debd-4795-9916-07dbfcac8ec9/)

上記のようにCookieが書きこまれていれば成功です。

Cookieを削除すればアクセス解析の対象から除外されることはなくなります。 
除外する必要がなくなった場合にはCookieを削除してください。  


##番外編 Google Chromeのユーザーを切り替えて使う##
Google Chromeでは複数のユーザーを切り替えて使うことができます。 
ユーザーはブラウザのウィンドウごとに設定できます。 
複数のウィンドウを立ち上げておけば複数のユーザーを同時に使えます。

ユーザーそれぞれが違うCookieを設定できます。 
開発用ユーザーを作ってウィンドウを一つ立ち上げて置くと、そのウィンドウからのアクセスのみ除外するといったことができ、非常に便利です。

>[Google Chrome 16リリース、マルチユーザログイン＆同期に対応 -- Engadget Japanese](http://japanese.engadget.com/2011/12/13/google-chrome-16/)



##参考リンク##
- [社内からのアクセスを除外するにはどうすればよいですか？ - アナリティクス ヘルプ](http://support.google.com/googleanalytics/bin/answer.py?hl=ja&answer=55481)
- [アカウント、ウェブ プロパティ、プロファイル、ユーザー - アナリティクス ヘルプ](http://support.google.com/analytics/bin/answer.py?hl=ja&answer=1009618)
