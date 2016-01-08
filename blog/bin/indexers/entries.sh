#!/usr/bin/env bash

entry_ids_opened.sh | sed -E 's/^.+$/\/\0\//'
