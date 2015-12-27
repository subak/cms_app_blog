FROM ubuntu:wily
MAINTAINER Subak Systems <info@subak.jp>

WORKDIR /root

RUN apt-get update \
 && apt-get install -y software-properties-common

# pandoc
RUN apt-get install -y pandoc

# h2o
RUN add-apt-repository -y ppa:h2o-maintainers/stable \
 && apt-get update && apt-get install -y h2o-server

# ruby
RUN apt-get install -y pry

# node
RUN apt-get install -y npm \
 && npm install -g yaml2json

# php, git
ENV PATH /root/.composer/vendor/bin:$PATH
RUN apt-get install -y php-pear php5-dev libyaml-dev composer \
 && echo '' | pecl install YAML \
 && echo 'extension=yaml.so' >> /etc/php5/cli/php.ini \
 && composer g require psy/psysh:@stable \
 && echo 'short_open_tag = On' >> /etc/php5/cli/php.ini

# go
ENV GOPATH /root/.go
ENV PATH /root/.go/bin:$PATH
RUN apt-get install -y golang \
 && go get github.com/ericchiang/pup

# other
RUN apt-get install -y jq

COPY . .
COPY web/bin/cms-entrypoint.sh /usr/local/bin/

EXPOSE 80
