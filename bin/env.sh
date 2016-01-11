#!/usr/bin/env bash

base_dir=$(cd $(dirname $BASH_SOURCE)/../../ && pwd)
PATH=${base_dir}/app/bin:${base_dir}/web/bin:${PATH}
