#!/usr/bin/env bash

set -eu

arg=${@:2:($#-1)}

echo -e $("$1" "$arg")"\t""$arg"
