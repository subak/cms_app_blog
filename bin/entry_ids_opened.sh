#!/usr/bin/env bash

diff <(entry_ids_all.sh) <(entry_ids_draft.sh) | grep '<' | sed 's/< //'
