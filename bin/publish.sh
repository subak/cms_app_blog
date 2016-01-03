#!/usr/bin/env bash

set -eu

out_dir=${1}
local=${2:-local}
MAX_PROCS=${MAX_PROCS:-4}

filter=$([ "${local}" == local ] && echo "sed -e 's/}$/"',"local":true}'"/'" || echo 'cat')

cp -rv ${APP}/public $([ -e "${out_dir}" ] && dirname "${out_dir}" || echo "${out_dir}")

for publisher in $(find ${APP}/bin/publish/*); do
  . "${publisher}"
done
