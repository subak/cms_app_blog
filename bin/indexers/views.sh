#!/usr/bin/env bash

except=$(yaml2json.rb app/config/meta.yml | jq -r .content_include_dir)/
find app/php/views/* -type f | sed -E 's/^.*views//' | egrep -v ${except}
