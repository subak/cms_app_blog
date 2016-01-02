

canonicalはindex.htmlを取り除く


alias date="gdate"
osxの場合はbrew install coreutils

# build pro docker
$ build --build-arg ID_RSA="$(cat ~/.ssh/id_rsa)" --build-arg REPO="${REPO}" -t subak/cms:pro -f web/docker/pro/Dockerfile .