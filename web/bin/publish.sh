#!/usr/bin/env bash

set -eu
. env.sh

out_dir=${1}
local=${2:-local}

filter=$([ "${local}" == local ] && echo "sed -e 's/}$/"',"local":true}'"/'" || echo 'cat')

cp -rv web/public ${out_dir}

entry_ids.sh | xargs -P0 -I@ router.rb /@/ \
  | tr '\n' '\0' | xargs -0 -P0 -I@ build_entry.sh @ ${out_dir}

build_page.sh $(router.rb /sitemap.xml | eval "${filter}") ${out_dir}
build_page.sh $(router.rb / | eval "${filter}") ${out_dir}

num_of_entries=$(entry_ids.sh | wc -l)
num_of_pages=$((${num_of_entries} / 5))
[ $((${num_of_entries} % 5)) != 0 ] && num_of_pages=$((${num_of_pages}+1))
for ((i=2; i<=$num_of_pages; i++)); do
  echo ${i}
done \
  | xargs -P0 -I@ router.rb /page/@/ | eval "${filter}" \
  | tr '\n' '\0' | xargs -0 -P${CORE} -I@ build_page.sh @ ${out_dir}