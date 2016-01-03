#!/usr/bin/env bash

per_page=$(yaml2json ${APP}/config/app.yml | jq .num_of_entries_per_page)
num_of_entries=$(entry_ids.sh | wc -l)
num_of_pages=$((${num_of_entries} / 5))
[ $((${num_of_entries} % 5)) != 0 ] && num_of_pages=$((${num_of_pages}+1))
for ((i=2; i<=$num_of_pages; i++)); do
  echo ${i}
done \
  | xargs -P0 -I@ router.rb /page/@/ | eval "${filter}" \
  | tr '\n' '\0' | xargs -0 -P${MAX_PROCS} -I@ build_page.sh @ ${out_dir}