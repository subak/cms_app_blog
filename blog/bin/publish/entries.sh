#!/usr/bin/env bash

entry_ids.sh | xargs -P0 -I@ router.rb /@/ | eval "${filter}" \
  | tr '\n' '\0' | xargs -0 -P0 -I@ build_page.sh @ ${out_dir}
