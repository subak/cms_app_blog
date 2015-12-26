FROM ubuntu:wily

WORKDIR /root

RUN apt-get update && apt-get install -y software-properties-common

# pandoc
RUN apt-get install pandoc

# ruby
RUN apt-get install -y pry

# node
RUN apt-get install -y npm \
 && npm install -g yaml2json

# php
RUN apt-get install -y php-pear php5-dev libyaml-dev composer \
 && echo '' | pecl install YAML \
 && echo 'extension=yaml.so' >> /etc/php5/cli/php.ini \
 && composer g require psy/psysh:@stable \
 && echo 'export PATH=$HOME/.composer/vendor/bin:$PATH' >> .profile

