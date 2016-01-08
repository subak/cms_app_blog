# さくらVPSにgitをインストール

    $ sudo rpm -Uhv http://apt.sw.be/redhat/el5/en/x86_64/rpmforge/RPMS//rpmforge-release-0.3.6-1.el5.rf.x86_64.rpm
    $ sudo yum install git.x86_64 --enablerepo=rpmforge

    # 動作確認
    $ git --version
    git version 1.7.8.2

yumにrpmforgeというリポジトリを追加します。CentOSのデフォルトのyumリポジトリが提供しているソフトウェアはあまり多くありません。

以上。


## 参考
- http://dag.wieers.com/rpm/FAQ.php#B
- http://d.hatena.ne.jp/mrgoofy33/20110206/1296952248


