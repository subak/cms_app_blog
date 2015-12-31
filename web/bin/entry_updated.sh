#!/usr/bin/env bash

set -u
. env.sh

id=$1
path=content/entry/${id}/${id}

updated=$(cat ${path}.yml 2>/dev/null | grep updated | cut -f 2 -d' ' | sed -e "s/'//g")

echo $([ -n "${updated}" ] && echo ${updated} \
  || git log --date=iso --pretty=format:"%cd" -n 1 ${path}.md \
  | sed -e 's/ /T/' | sed -e 's/ //' | egrep . \
  || date --iso-8601=minutes)
