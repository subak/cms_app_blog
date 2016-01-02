#!/usr/bin/env bash

set -eu

title=${1:-'no title'}

while :; do
  id=$(openssl rand -base64 3 | egrep ^[0-9a-zA-Z]{4}$)
  [ $? -ne 0 ] && continue
  [ -e "content/entry/${id}" ] && continue
  break
done

mkdir -pv "content/entry/${id}"

echo "# ${title}" > "content/entry/${id}/${id}.md"

