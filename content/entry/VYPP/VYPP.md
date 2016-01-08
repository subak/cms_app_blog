# HTML5のvideo要素について軽く調べてみる

## video要素
開始タグと終了タグは必須。

### 固有の属性
- `src`
- `poster`
- `autobuffer`
- `autoplay`
- `loop`
- `controls`
- `width`
- `height`

### 例
    <video src="sample.mp4" controls="controls">
        <p>ご利用のブラウザーでは再生できません。...</p>
    </video>

video要素のなかに対応していないブラウザーに対して表示させたいコンテンツをマークアップする

### オート・バッファ
`autobuffer="autobuffer"`という属性を指定するとビデオを先読みしてダウンロードしてくれる

### ポスター・フレーム
youtubeのサムネイルみたいなやつ。ただしビデオ再生の準備が整う直前までしか表示されない。

`poster="poster.png"`というように画像ファイルのURLを指定する

## source要素
ブラウザによって対応するビデオのフォーマットがことなるのでソースを複数指定する必要があります。
video要素のsrc属性を使う代わりにsource要素を使います。

    <video controls="controls">
        <source src="theora_vorbis.ogg" type="video/ogg">
        <soruce src="h264_aac.mp4" type="video/mp4">
        <p>ご利用のブラウザーでは再生できません。...</p>
    </video>

`type`属性にファイルのMIMEタイプを指定します。

### おもなMIME

- `vide/ogg`
- `video/mp4`

## イベント

- `loadstart` メディアファイル採用を選定し始めた、どのファイルを採用するのかは決まっていない
- `loadeddata` 再生の準備が整った
- `play` 再生が開始された
- `playing` 再生が開始された、次のフレームも再生可能である
- `pause` 停止された
- `ended` 最後まで再生された
- `waiting` ファイルのダウンロードが再生速度に追いつかない場合など
- `error` ダウンロードエラーなど
- `volumechange` 音量が変更された、ミュートが変更された
- `timeupdate` 再生位置が変わっている最中に連続的に発生。フレームごとに発生するわけではない。ブラウザによって発生のタイミングはことなる。

## video要素のIDL属性
Javascriptから参照できるプロパティ

             attribute DOMString width;
             attribute DOMString height;
    readonly attribute unsigned long videoWidth;
    readonly attribute unsigned long videoHeight;
             attribute DOMString poster;
             attribute DOMSettableTokenList audio;

    // error state
    readonly attribute MediaError error;

    // network state
             attribute DOMString src;
    readonly attribute DOMString currentSrc;
    const unsigned short NETWORK_EMPTY = 0;
    const unsigned short NETWORK_IDLE = 1;
    const unsigned short NETWORK_LOADING = 2;
    const unsigned short NETWORK_NO_SOURCE = 3;
    readonly attribute unsigned short networkState;
             attribute DOMString preload;
    readonly attribute TimeRanges buffered;
    void load();
    DOMString canPlayType(in DOMString type);

    // ready state
    const unsigned short HAVE_NOTHING = 0;
    const unsigned short HAVE_METADATA = 1;
    const unsigned short HAVE_CURRENT_DATA = 2;
    const unsigned short HAVE_FUTURE_DATA = 3;
    const unsigned short HAVE_ENOUGH_DATA = 4;
    readonly attribute unsigned short readyState;
    readonly attribute boolean seeking;

    // playback state
             attribute float currentTime;
    readonly attribute float startTime;
    readonly attribute float duration;
    readonly attribute boolean paused;
             attribute float defaultPlaybackRate;
             attribute float playbackRate;
    readonly attribute TimeRanges played;
    readonly attribute TimeRanges seekable;
    readonly attribute boolean ended;
             attribute boolean autoplay;
             attribute boolean loop;
    void play();
    void pause();

    // controls
             attribute boolean controls;
             attribute float volume;
             attribute boolean muted;


## 参考
- <http://www.amazon.co.jp/%E5%BE%B9%E5%BA%95%E8%A7%A3%E8%AA%ACHTML5%E3%83%9E%E3%83%BC%E3%82%AF%E3%82%A2%E3%83%83%E3%83%97%E3%82%AC%E3%82%A4%E3%83%89%E3%83%96%E3%83%83%E3%82%AF-%E7%BE%BD%E7%94%B0%E9%87%8E%E5%A4%AA%E5%B7%B3/dp/4798025291>
- <http://coliss.com/articles/build-websites/operation/javascript/js.html>
- <http://5509.me/log/notification-of-using-video-element>
- <http://www.w3.org/wiki/HTML/Elements/video#IDL_Attributes_and_Methods>

