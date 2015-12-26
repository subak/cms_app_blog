#!/usr/bin/env bash

set -eu

: $1
param=$1

uri=$(echo $1 | php -R 'parse_str(parse_url($argn)["query"],$query);print json_encode($query);' | jq -r .uri)


to_file=web/public${uri}
to_dir=$(echo ${to_file} | sed -e 's/\/[^/]*$//')
echo ${to_file} | egrep '/$' && to_file=${to_dir}/index.html

mkdir -p ${to_dir}

page.php ${param} > ${to_file}
echo ${to_file}

#to_dir=web/public${uri}
#
#mkdir -p web/public${uri}
#
#page.php ${param} > web/public${uri}index.html
#echo web/public${uri}index.html