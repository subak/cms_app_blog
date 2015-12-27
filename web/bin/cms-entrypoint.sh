#!/usr/bin/env bash

source web/bin/path.sh
publish.sh

h2o -c "$@"