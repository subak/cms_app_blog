#!/usr/bin/env bash

set -ue

id=$1

file=$(find content/entry -name ${id}.adoc -o -name ${id}.md -o -name ${id}.rst)

head -1 ${file} | sed -r 's/^[#= ]*([^#= ]*)[#= ]*$/\1/'