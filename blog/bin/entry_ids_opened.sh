#!/usr/bin/env bash

diff <(entry_ids.sh) <(entry_ids_draft.sh) | grep '<' | sed 's/< //'
