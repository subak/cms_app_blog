#!/usr/bin/env bash

set -eu

out_dir=${1}
local=${2:-local}
MAX_PROCS=${MAX_PROCS:-4}

local_context=$([ "${local}" == local ] && echo '+ {"local": true}' || echo '')

filter="jq -c '. ${local_context}'"

find ${APP}/public/* -maxdepth 1 -print0 | xargs -0 -I@ cp -rv @ "${out_dir}"

uris.sh | xargs -P0 -I@ router.rb @ | eval "${filter}" \
 | tr '\n' '\0' | xargs -0 -P${MAX_PROCS} -I@ build.sh @ ${out_dir}
