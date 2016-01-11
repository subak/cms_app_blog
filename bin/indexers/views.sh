#!/usr/bin/env bash

except=$(yaml2json.rb app/config/app.yml | jq -r .content_include_dir)/
find app/php/views/* -type f | sed -E 's/^.*views//' | egrep -v ${except}
