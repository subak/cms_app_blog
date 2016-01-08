# nvmでnode.jsをインストール


![](http://evernote.tk84.net/shard/s8/res/777ced32-a549-4ef5-aa49-dc40ea6077f8/)
nvmでnode.js(v0.6.13)をインストールします。




## nvmをインストール

    $ git clone git://github.com/creationix/nvm.git ~/.nvm
    $ . ~/.nvm/nvm.sh

gitリポジトリをクローンします。`nvm.sh`スクリプトを実行しnvmを利用可能な状態にします。


## node.js v0.6.13をインストール

    $ nvm install v0.6.13

    $ nano ~/.bash_profile
    $ git diff
    diff --git a/.bash_profile b/.bash_profile
    index 687f7cc..68a0572 100644
    --- a/.bash_profile
    +++ b/.bash_profile
    @@ -21,3 +21,6 @@ rvm use ruby-head@default
     # alias
     alias sudo='sudo -E '
     alias nginx='/usr/local/nginx/sbin/nginx'
    +
    +. ~/.nvm/nvm.sh
    +nvm use v0.6.13

.bash_profileにスクリプトを追加してログイン時にnvmを使えるようにしておきます。
