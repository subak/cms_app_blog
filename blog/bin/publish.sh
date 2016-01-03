#!/usr/bin/env bash

set -eu

out_dir=${1}
local=${2:-local}
MAX_PROCS=${MAX_PROCS:-4}

local_context=$([ "${local}" == local ] && echo '+ {"local": true}' || echo '')

filter="jq -c '. ${local_context}'"

cp -rv ${APP}/public $([ -e "${out_dir}" ] && dirname "${out_dir}" || echo "${out_dir}")

for publisher in $(find ${APP}/bin/publish/*); do
  . "${publisher}"
done
