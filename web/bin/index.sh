#!/usr/bin/env bash

# yamlで出力するオプションを備える

paste \
  <(find content/entry/* -type d | xargs basename) \
  <(find content/entry/* -name "*.md" | xargs -n 1 -P 2 head -1 | sed -e 's/^[# ]*//') \
  | sed -e 's/:/: /'