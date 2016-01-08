# h2o をビルド

`mruby.handler`が使いたかったので最新版をビルドしてみました。  
プラットフォームは`ubuntu:wily`です

## 手順

ビルドに必要な依存パッケージは[ppa:h2o-maintainers/stable](https://launchpadlibrarian.net/222257361/h2o-server_1.5.2-0~ubuntu15.04.1.dsc)を参考にしました。[^1]  


```
$ H2O_VER="1.6.1"
$ H2O_URL="https://github.com/h2o/h2o/archive/v${H2O_VER}.tar.gz"
$ H2O_DIR="h2o-${H2O_VER}"

$ cd /usr/src

$ apt-get update && apt-get install -y \
    cmake \
    curl \
    libscope-guard-perl \
    libssl-dev \
    libtest-tcp-perl \
    libyaml-dev \
    liburi-perl \
    libio-socket-ssl-perl \
    ruby \
    bison

$ curl -SL ${H2O_URL} | tar xzv
$ cd ${H2O_DIR}

$ cmake -DWITH_BUNDLED_SSL=on . \
    && cmake -DWITH_MRUBY=on .

$ make install

```

ポイントは`ruby`と`bison`をインストールパッケージに追加したことです。  
`mruby`を`on`にした時に必要になるパッケージで、これがないと以下のエラーで`make`に失敗します。

```
$ make
/bin/sh: 1: ruby: not found
CMakeFiles/mruby.dir/build.make:49: recipe for target 'CMakeFiles/mruby' failed
make[2]: *** [CMakeFiles/mruby] Error 127
CMakeFiles/Makefile2:413: recipe for target 'CMakeFiles/mruby.dir/all' failed
make[1]: *** [CMakeFiles/mruby.dir/all] Error 2
Makefile:116: recipe for target 'all' failed
make: *** [all] Error 2
```

```
$ make
(in /usr/src/h2o-1.6.1/deps/mruby)
YACC  mrbgems/mruby-compiler/core/parse.y -> ../../mruby/host/mrbgems/mruby-compiler/core/y.tab.c
sh: 1: bison: not found
sh: 1: bison: not found
rake aborted!
Command Failed: [bison -o "/usr/src/h2o-1.6.1/mruby/host/mrbgems/mruby-compiler/core/y.tab.c" "/usr/src/h2o-1.6.1/deps/mruby/mrbgems/mruby-compiler/core/parse.y"]

CMakeFiles/mruby.dir/build.make:49: recipe for target 'CMakeFiles/mruby' failed
make[2]: *** [CMakeFiles/mruby] Error 1
CMakeFiles/Makefile2:413: recipe for target 'CMakeFiles/mruby.dir/all' failed
make[1]: *** [CMakeFiles/mruby.dir/all] Error 2
Makefile:116: recipe for target 'all' failed
make: *** [all] Error 2
```

## 参考
- https://hub.docker.com/r/vimagick/h2o/~/dockerfile/
- https://hub.docker.com/r/masakielastic/h2o/~/dockerfile/

[^1]: この`PPA`に`mruby`が含まれていればビルドしなくて良かったのに。。