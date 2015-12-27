#!/usr/bin/env bash

source web/bin/path.sh
publish.sh global

h2o -c "$@"