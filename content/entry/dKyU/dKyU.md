# gitことはじめ

![](http://evernote.tk84.net/shard/s8/res/3ae803ef-c921-4c68-a625-d6dec6f49788/)

gitを初めて使う際に行った設定です。gitを使ってホームディレクトリにある.bash_profileを管理するところです。



## .gitignore を作成

    $ cd ~
    $ nano .gitignore

### .gitignore
    # ルート直下のすべてのファイル、フォルダを無視
    /*

    # .gitignore自身を監視対象に
    !/.gitignore

    # .bash_profile
    !.bash_profile


ホームディレクトリは様々なファイル、フォルダが混在するので.gitignoreを使ってバージョン管理したいファイルだけ並べてゆきます。

すべてのファイル、フォルダを無視したあとに、許可したいファイルを「!」を使って除外します。

履歴が残っていると便利なので.gitignoreファイル自身もバージョン管理して監視対象に追加します。



## 監視対象ファイルをステージング

    $ git add .bash_profile
    $ git add .gitignore
    $ git status
    # On branch master
    #
    # Initial commit
    #
    # Changes to be committed:
    #   (use "git rm --cached <file>..." to unstage)
    #
    #     new file:   .bash_profile
    #     new file:   .gitignore
    #

add コマンドで監視対象にしたいファイルをステージングします。statusコマンドで状況を確認します。

監視対象にしたいファイルのみがステージングされていることを確認します。
監視対象以外のファイルは.gitignoreによって無視されていますのでstatusにも表示されません。



## コミット
    [www@localhost ~]$ git commit -m 'add .bash_profile .gitignore'

    *** Please tell me who you are.

    Run

      git config --global user.email "you@example.com"
      git config --global user.name "Your Name"

    to set your account's default identity.
    Omit --global to set the identity only in this repository.

    fatal: empty ident  <www@localhost.localdomain> not allowed


`-m`オプションでコメントを付けてコミットします。コミットするのが初めての場合は上記のようなエラーが出ます。エラーメッセージに従ってメールアドレスと名前を設定します。

    $ git config --global user.email "git@tk84.net"
    $ git config --global user.name "tk84"
    $ git commit -m 'add .bash_profile .gitignore'
    [master (root-commit) e9e5fcf] add .bash_profile .gitignore
     2 files changed, 32 insertions(+), 0 deletions(-)
     create mode 100644 .bash_profile
     create mode 100644 .gitignore

