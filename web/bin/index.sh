#!/usr/bin/env bash

set -ue
. env.sh

target=${1:-title}

entry_ids.sh \
  | xargs -P0 -I@ exec_and_print_args.sh entry_${target}.sh @ \
  | awk -F'\t' '{print $2,$1}'
