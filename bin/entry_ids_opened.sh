#!/usr/bin/env bash

diff <(entry_ids_all.sh) <(entry_ids_filter.sh '.status=="draft"') | grep '<' | sed 's/< //'
