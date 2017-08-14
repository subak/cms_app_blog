#!/usr/bin/env bash

set -ue

filter=${1}

for id in $(entry_ids_all.sh); do
  path=content/entry/${id}/${id}.yml
  [ ! -e ${path} ] && continue
  if [ "true" == $(yaml2json ${path} | jq -r ${filter}) ]; then
    echo ${id}
  fi
done
