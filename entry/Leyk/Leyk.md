# rvmでruby-1.9.2をインストール[Mac OS X]

## 環境
- Mac OS X Lion
- Xcode 4.3.2

Xcode4.2.1からgccがllvm-gccになりました。しかしruby-1.9.2はllvmではないgccでないとコンパイルできません。

そのためllvmではないgccをインストールする必要があります。



## gccをインストール

    $ brew tap homebrew/versions
    $ brew tap homebrew/dupes
    $ brew install apple-gcc42
    ==> Downloading http://r.research.att.com/tools/gcc-42-5666.3-darwin11.pkg
    ######################################################################## 100.0%
    ==> Caveats
    NOTE:
    This formula provides components that were removed from XCode in the 4.2
    release. There is no reason to install this formula if you are using a
    version of XCode prior to 4.2.

    This formula contains compilers built from Apple's GCC sources, build
    5666.3, available from:

      http://opensource.apple.com/tarballs/gcc

    All compilers have a `-4.2` suffix. A GFortran compiler is also included
    and is the exact same version as the compiler provided by the `gfortran`
    formula in the main repository.
    ==> Summary
    /usr/local/Cellar/apple-gcc42/4.2.1-5666.3: 106 files, 75M, built in 19 seconds


`apple-gcc42`というのがXcode4.2.1より前に使われていたgccになります。



## 参考
- <http://toggtc.hatenablog.com/entry/2012/01/28/224006>
- <http://kin2ku.org/protein/wiki/tadanomemo/memos/2011/10/18/mac_lion_gcc>
