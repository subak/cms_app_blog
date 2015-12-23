# MeCabをインストール

![](http://evernote.tk84.net/shard/s8/res/0635b999-22e3-45cd-992d-768f20ad7033/)

MeCab(v0.993)をソースからビルドしてインストールします。



## mecabをインストール

    $ cd /usr/local/var
    $ wget http://mecab.googlecode.com/files/mecab-0.993.tar.gz
    $ tar zxfv mecab-0.993.tar.gz
    $ cd mecab-0.993
    $ ./configure --with-charset=utf-8 \
    --enable-utf8-only
    $ make
    $ sudo paco -D make install


`--with-charset=utf8`オプションを指定するのをお忘れなく



## 辞書をインストール

    $ cd /usr/local/var
    $ wget http://mecab.googlecode.com/files/mecab-ipadic-2.7.0-20070801.tar.gz
    $ cd mecab-ipadic-2.7.0-20070801
    $ ./configure --with-charset=utf-8
    $ make
    $ sudo paco -D make install

`--with-charset=utf-8`オプションを指定するのをお忘れなく。こちらは`utf-8`というようにハイフン有り



## 動作確認

    $ mecab
    すもももももももものうち
    すもも     名詞,一般,*,*,*,*,すもも,スモモ,スモモ
    も     助詞,係助詞,*,*,*,*,も,モ,モ
    もも     名詞,一般,*,*,*,*,もも,モモ,モモ
    も     助詞,係助詞,*,*,*,*,も,モ,モ
    もも     名詞,一般,*,*,*,*,もも,モモ,モモ
    の     助詞,連体化,*,*,*,*,の,ノ,ノ
    うち     名詞,非自立,副詞可能,*,*,*,うち,ウチ,ウチ
    EOS

以下のように辞書を指定できます

    $ mecab -d /usr/local/lib/mecab/dic/ipadic

