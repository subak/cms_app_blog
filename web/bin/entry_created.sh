#!/usr/bin/env bash

set -u
. env.sh

id=$1
path=content/entry/${id}/${id}

created=$(cat ${path}.yml 2>/dev/null | grep created | cut -f 2 -d' ' | sed -e "s/'//g")

echo $([ -n "${created}" ] && echo ${created} \
  || git log --date=iso --pretty=format:"%cd" ${path}.md | tail -1 \
  | sed -e 's/ /T/' | sed -e 's/ //' | egrep . \
  || date --iso-8601=minutes)
