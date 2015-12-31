#!/usr/bin/env bash

set -eu

param=$1
out_dir=$2

uri=$(echo $1 | jq -r .uri)

to_file=${out_dir}${uri}
to_dir=$(echo ${to_file} | sed -e 's/\/[^/]*$//')
echo ${to_file} | egrep '/$' && to_file=${to_dir}/index.html

mkdir -pv ${to_dir}

page.php ${param} > ${to_file}
echo ${to_file}
