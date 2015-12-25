#!/usr/bin/env bash

set -eu

arg=${@:2:($#-1)}

echo $("$1" "$arg") "$arg"
