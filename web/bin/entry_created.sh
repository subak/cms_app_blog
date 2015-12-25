#!/usr/bin/env bash

set -u

: $1

id=$1
path=content/entry/${id}/${id}

created=$(cat ${path}.yml | grep created | cut -f 2 -d' ' | sed -e "s/'//g")
echo $([ -n "${created}" ] && echo ${created} \
  || git log --date=iso --pretty=format:"%cd" ${path}.md | tail -1 \
  | sed -e 's/ /T/' | sed -e 's/ //')
