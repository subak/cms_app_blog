#!/usr/bin/env bash

# yamlで出力するオプションを備える

paste \
  <(web/bin/ids.sh) \
  <(web/bin/ids.sh | xargs -n 1 -P 2 web/bin/entry_title.sh ) \
  | sed -e 's/:/: /'