#!/usr/bin/env bash

set -eu

exts=(jpg png)

param="${1}"
out_dir="${2}"

build_page.sh "${param}" "${out_dir}"

id=$(echo $1 | jq -r .id)

filter=$(for ext in "${exts[@]}"; do
  echo -n " -o -name *.${ext}"
done | sed -e 's/^ -o //')

find content/entry/${id}/* \( ${filter} \) \
  -exec cp -v {} ${out_dir}/${id} \;
