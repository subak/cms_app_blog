#!/usr/bin/env bash

except=$(yaml2json ${APP}/config/app.yml | jq -r .content_include_dir)/
views=$(find ${APP}/php/views/* -type f | sed -E 's/^.*views//' | egrep -v ${except})

for view in $(echo "${views}"); do
  context=$(router.rb ${view})
  [ $(echo ${context} | jq -r .status) -ne 200 ] && continue
  build_page.sh $(echo ${context} | eval "${filter}") ${out_dir}
done
