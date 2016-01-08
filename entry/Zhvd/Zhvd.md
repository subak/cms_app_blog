# 私的Git標準１

gitは色々なやり方で設定できるけど、一番手間がかからなくて簡単だと思う方法をメモ

## どこかのリポジトリから取ってくる
すべてのリビジョンがコピーされます

    $ git clone git@github.com:hoge/huga.git hoge_huga

## リモート／ローカル、全てのブランチを確認する

    $ git branch -a 
    * master
      remotes/origin/HEAD -> origin/master
      remotes/origin/gh-pages
      remotes/origin/master

## リモートのブランチに切り替える
実際にはローカルにブランチを作り、リモートのブランチをトラッキングします

    $ git checkout -b gh-pages origin/gh-pages
    Branch gh-pages set up to track remote branch gh-pages from origin.
    Switched to a new branch 'gh-pages'

    $ git branch -a
    * gh-pages
      master
      remotes/origin/HEAD -> origin/master
      remotes/origin/gh-pages
      remotes/origin/master

## ブランチの削除
    $ git branch -d gh-pages

## リモートブランチの削除
    $ git push origin :gh-pages

## ローカルブランチをマスターブランチに関連付けて初期化する
githubなどで新しいリポジトリを作った時によく使う

    $ git add remote origin git@github.com:hoge/huga.git
    $ git push -u origin master


## 私的な理解（まちがってるかもよ）
- git cloneするとリモートのすべてのリビジョンがコピーされる。
- tagはsha1ハッシュのエイリアス
- branchは特定のリビジョンから新しいコミットポイントを作る
- branchはリビジョン間を繋ぐ線
- branchは他のbranchから派生するので結果的に木構造のような形になる
- branchやtagから参照されないリビジョンも存在する
- revertするとリビジョンはリビジョンの参照を持つようになる？

## 参考
- <http://d.hatena.ne.jp/zariganitosh/20080908/1220881938>
- <http://sourceforge.jp/magazine/09/03/16/0831212>
