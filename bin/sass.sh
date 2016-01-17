#!/usr/bin/env bash

set -ue

context="${@}"

uri=$(echo ${context} | jq -r '.uri')

input="html/stylesheets${uri%.css}.*"
out_dir=${BUILD:-/tmp/cms}
output="${out_dir}${uri}"

if [ -n "${BUILD:-}" ]; then

  sassc -t compressed ${input}

elif [ ! -e "${output}" ] || [ -n "$(find html/stylesheets/* -newer ${output})" ]; then
  [ -e "${output%/*}" ] || mkdir -pv "${output%/*}" 1>/dev/stderr

  sassc -m -t compressed ${input} ${output}

  # fix path
  sed -i 's/'$(echo "../..$(pwd)/html/stylesheets/" | sed -E 's/([./])/\\\1/g')'//' "${output}.map"

  cat "${output}"

else

  cat "${output}"

fi

