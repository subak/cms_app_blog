#!/usr/bin/env bash

set -eu

: $1
param=$1

uri=$(echo $1 | jq -r .uri)

to_file=web/public${uri}
to_dir=$(echo ${to_file} | sed -e 's/\/[^/]*$//')
echo ${to_file} | egrep '/$' && to_file=${to_dir}/index.html

mkdir -pv ${to_dir}

page.php ${param} > ${to_file}
echo ${to_file}
