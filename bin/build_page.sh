#!/usr/bin/env bash

set -eu

param=$1
out_dir=$2

out_dir_context='+ {"out_dir": "'"${out_dir}"'"}'
param=$(echo ${param} | jq -c ". ${out_dir_context}")

uri=$(echo $1 | jq -r .uri)
handler=$(echo $1 | jq -r .handler)

to_file=${out_dir}${uri}
to_dir=$(echo ${to_file} | sed -e 's/\/[^/]*$//')
echo ${to_file} | egrep '/$' && to_file=${to_dir}/index.html

mkdir -pv ${to_dir}

eval "${handler}" "'"${param}"'" > ${to_file}
echo ${to_file}
