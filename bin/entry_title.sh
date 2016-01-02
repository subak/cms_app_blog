#!/usr/bin/env bash

set -ue

: $1

id=$1

head -1 content/entry/${id}/${id}.md | sed -e 's/^[# ]*//'