#!/usr/bin/env bash

entry_ids.sh | sed -E 's/^.+$/\/\0\//'
