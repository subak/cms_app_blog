# ubuntu:wily に php7.0 をインストール

![](443792.jpg)

`apt-add-repository`で`ppa:ondrej/php`を追加。  
`apt-add-repository`が無い場合には`apt-get install -y software-properties-common`しておく必要があります。

```
$ LANG=C.UTF-8 apt-add-repository -y ppa:ondrej/php
gpg: keyring `/tmp/tmpos25t6ks/secring.gpg' created
gpg: keyring `/tmp/tmpos25t6ks/pubring.gpg' created
gpg: requesting key E5267A6C from hkp server keyserver.ubuntu.com
gpg: /tmp/tmpos25t6ks/trustdb.gpg: trustdb created
gpg: key E5267A6C: public key "Launchpad PPA for Ondřej Surý" imported
gpg: Total number processed: 1
gpg:               imported: 1  (RSA: 1)
OK
```

この時localeをutf-8に指定すること。  
utf-8以外のlocaleで追加しようとすると下記のエラーが出て失敗します。

```
Exception in thread Thread-1:
Traceback (most recent call last):
  File "/usr/lib/python3.4/threading.py", line 920, in _bootstrap_inner
    self.run()
  File "/usr/lib/python3.4/threading.py", line 868, in run
    self._target(*self._args, **self._kwargs)
  File "/usr/lib/python3/dist-packages/softwareproperties/SoftwareProperties.py", line 688, in addkey_func
    func(**kwargs)
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 385, in add_key
    return apsk.add_ppa_signing_key()
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 262, in add_ppa_signing_key
    tmp_export_keyring, signing_key_fingerprint, tmp_keyring_dir):
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 211, in _verify_fingerprint
    got_fingerprints = self._get_fingerprints(keyring, keyring_dir)
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 203, in _get_fingerprints
    output = subprocess.check_output(cmd, universal_newlines=True)
  File "/usr/lib/python3.4/subprocess.py", line 609, in check_output
    output, unused_err = process.communicate(inputdata, timeout=timeout)
  File "/usr/lib/python3.4/subprocess.py", line 949, in communicate
    stdout = _eintr_retry_call(self.stdout.read)
  File "/usr/lib/python3.4/subprocess.py", line 491, in _eintr_retry_call
    return func(*args)
  File "/usr/lib/python3.4/encodings/ascii.py", line 26, in decode
    return codecs.ascii_decode(input, self.errors)[0]
UnicodeDecodeError: 'ascii' codec can't decode byte 0xc5 in position 92: ordinal not in range(128)
```

`apt-cache search php7.0`でインストール可能なパッケージ一覧が表示されます。

```
$ apt-cache search php7.0
php7.0-common - Common files for packages built from the PHP source
libapache2-mod-php7.0 - server-side, HTML-embedded scripting language (Apache 2 module)
php7.0-cgi - server-side, HTML-embedded scripting language (CGI binary)
php7.0-cli - command-line interpreter for the PHP scripting language
php7.0-phpdbg - server-side, HTML-embedded scripting language (PHPDBG binary)
php7.0-fpm - server-side, HTML-embedded scripting language (FPM-CGI binary)
libphp7.0-embed - HTML-embedded scripting language (Embedded SAPI library)
php7.0-dev - Files for PHP7.0 module development
php7.0-dbg - Debug symbols for PHP7.0
php7.0-curl - CURL module for PHP
php7.0-gd - GD module for PHP
php7.0-imap - IMAP module for PHP
php7.0-interbase - Interbase module for PHP
php7.0-intl - Internationalisation module for PHP
php7.0-ldap - LDAP module for PHP
php7.0-mcrypt - libmcrypt module for PHP
php7.0-readline - readline module for PHP
php7.0-odbc - ODBC module for PHP
php7.0-pgsql - PostgreSQL module for PHP
php7.0-pspell - pspell module for PHP
php7.0-recode - recode module for PHP
php7.0-snmp - SNMP module for PHP
php7.0-tidy - tidy module for PHP
php7.0-xmlrpc - XMLRPC-EPI module for PHP
php7.0 - server-side, HTML-embedded scripting language (metapackage)
php7.0-json - JSON module for PHP
php7.0-sybase - Sybase module for PHP
php7.0-modules-source - PHP 7.0 modules source package
php7.0-sqlite3 - SQLite3 module for PHP
php7.0-mysql - MySQL module for PHP
php7.0-opcache - Zend OpCache module for PHP
php7.0-bz2 - bzip2 module for PHP
```

`apt-get install -y php7.0`でインストール。