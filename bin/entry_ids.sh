#!/usr/bin/env bash

[ -n "${PUBLISH_MODE}" ] && entry_ids_opened.sh || entry_ids_all.sh
