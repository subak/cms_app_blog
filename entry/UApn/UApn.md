# http_loadをMacのhome brewでインストール

![](http://evernote.tk84.net/shard/s8/res/b48af415-6619-40f2-acd0-e268672695fa/http_load.jpg)

どうにもMac OS X Lion でab(ApacheBench)が変なので**http_load**を使うことにしました。

    $ brew install https://raw.github.com/gist/2773495/6a797cfb69b52f7935b1929241061a49427ba9b5/http_load.rb
    ######################################################################## 100.0%
    ==> Downloading http://www.acme.com/software/http_load/http_load-12mar2006.tar.gz
    ######################################################################## 100.0%
    ==> make
    ==> make install
    rm -f /usr/local/bin/http_load
    cp http_load /usr/local/bin
    rm -f /usr/local/man/man1/http_load.1
    cp http_load.1 /usr/local/man/man1
    cp: /usr/local/man/man1: No such file or directory
    make: *** [install] Error 1
    ==> Build Environment
    CPU: dual-core 64-bit penryn
    MacOS: 10.7.4-x86_64
    Xcode: 4.3.2
    CC: /usr/bin/clang
    CXX: /usr/bin/clang++ => /usr/bin/clang
    LD: /usr/bin/clang
    CFLAGS: -Os -w -pipe -march=native -Qunused-arguments
    CXXFLAGS: -Os -w -pipe -march=native -Qunused-arguments
    MAKEFLAGS: -j2
    Error: Failed executing: make install (.rb:)
    If `brew doctor' does not help diagnose the issue, please report the bug:
        https://github.com/mxcl/homebrew/wiki/reporting-bugs


エラーになりますが、インストールはできているみたい

    $ which http_load
    /usr/local/bin/http_load

## 参考
- <http://www.acme.com/software/http_load/>
- <https://gist.github.com/2773495>
