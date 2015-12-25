#!/usr/bin/env bash

set -u

: $1

id=$1
path=content/entry/${id}/${id}

echo $(cat ${path}.meta.yml | shyaml get-value updated 2>/dev/null \
  || git log --date=iso --pretty=format:"%cd" ${path}.md | tail -1 \
  | sed -e 's/ /T/' | sed -e 's/ //')
