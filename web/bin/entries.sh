#!/usr/bin/env bash

find content/entry/* -maxdepth 0 \( -name *.md -o -type d \) -exec basename {} .md \; | sed -e 's/^/\//'