#!/usr/bin/env bash

set -eu

: $1
param=$1

uri=$(echo $1 | php -R 'parse_str(parse_url($argn)["query"],$query);print json_encode($query);' | jq -r .uri)

mkdir -p web/public${uri}

page.php ${param} > web/public${uri}index.html
echo web/public${uri}index.html