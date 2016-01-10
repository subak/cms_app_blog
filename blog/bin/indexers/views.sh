#!/usr/bin/env bash

except=$(yaml2json.rb ${APP}/config/app.yml | jq -r .content_include_dir)/
find ${APP}/php/views/* -type f | sed -E 's/^.*views//' | egrep -v ${except}
