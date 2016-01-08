#!/usr/bin/env bash

ids=$(entry_ids.sh)
ids_draft=`entry_filter.rb 'contains({"status":"draft"})'`

diff <(echo "${ids}") <(echo "${ids_draft}") | grep '<' | sed 's/< //'
