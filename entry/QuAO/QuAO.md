# Sass+CompassでiPhoneのRetina用CSSスプライトを用意する

Sass+CompassはCSSスプライトを自動で作ってくれるので便利ですが、Retina用の画像は２倍の大きさの画像を半分のサイズに指定するので位置がずれてしまいます。  
画像のサイズを半分の大きさに指定して、ポジションも半分の位置にするミックスインを書いてみました。

    $map:                sprite-map("sprite/*.png")
    $retina-sprite-path: sprite-path($map)
    $retina-sprite-url:  image-url($retina-sprite-path)
    $retina-sprite-size: (image-width($retina-sprite-path) / 2) (image-height($retina-sprite-path) / 2)
    @mixin retina-sprite($name)
      $position: sprite-position($map, $name)
      $image:    sprite-file($map, $name)
      display:   block
      width:     image-width($image) / 2
      height:    image-height($image) / 2
      background:
        repeat:   no-repeat
        image:    $retina-sprite-url
        size:     $retina-sprite-size
        position: 0 (nth($position, 2) / 2)

1. `sprite-path()`で自動生成されたスプライト画像のパスを取得
2. `image-width()`, `image-height()`で画像の大きさを取得して半分にする
3. `sprite-position()`で任意のスプライトのbackground positionを取得
  - `0 -200px`のような値になります
4. nth()でpositionのheight値を取得して半分にする

というような処理を行なっています。


## 使用方法

    /* sass
    #hoge
      +retina-sprite(icon)
というsassが

    /* css */
    #hoge {
      display: block;
      width:   50px;
      height:  50px;
      background-repeat:   no-repeat;
      background-image:    url("sprite-98723498734.png");
      background-size:     50px 50px;
      background-position: 0 -50px;
    }
というようなcssに展開されます。

画像の大きさを自動で取得してくれるの便利ですね。





## 参考リンク
- <http://compass-style.org/help/tutorials/spriting/>
