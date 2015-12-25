#!/usr/bin/env bash

# yamlで出力するオプションを備える

set -ue

target=${1:-title}

entry_ids.sh | xargs -n 1 -P4 exec_and_print_args.sh entry_${target}.sh | awk '{print $2,$1}'
