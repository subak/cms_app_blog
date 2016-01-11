#!/usr/bin/env bash

set -u

id=$1

meta=$(find content/entry -name ${id}.yml)
file=$(find content/entry -name ${id}.adoc -o -name ${id}.md -o -name ${id}.rst)
content_dir=$(dirname ${file})

created=$([ -n "${meta}" ] && cat ${meta} 2>/dev/null | grep created | cut -f 2 -d' ' | sed -e "s/'//g")

echo $([ -n "${created}" ] && echo ${created} \
  || echo $(cd ${content_dir} && git log --date=iso --pretty=format:"%cd" ${file##${content_dir}/} | tail -1) \
  | sed -e 's/ /T/' | sed -e 's/ //' | egrep . \
  || date --iso-8601=minutes)
