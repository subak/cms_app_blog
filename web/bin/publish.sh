#!/usr/bin/env bash

cp -v -a web/html/assets web/public

entry_ids.sh | sed -e 's/^/\//' | sed -e 's/$/\//' \
  | xargs -P 4 -n 1 router.rb | tr '\n' '\0' | xargs -0 -P 4 -n 1 build_entry.rb

build_page.sh $(router.rb /sitemap.xml)
build_page.sh $(router.rb /)

num_of_entries=$(entry_ids.sh | wc -l)
num_of_pages=$((${num_of_entries} / 5))
[ $((${num_of_entries} % 5)) != 0 ] && num_of_pages=$((${num_of_pages}+1))
for ((i=2; i<=$num_of_pages; i++)); do
echo ${i}
done \
  | sed -e 's/^/\/page\//' | sed -e 's/$/\//' \
  | xargs -n 1 router.rb | tr '\n' '\0' | xargs -0 -n 1 -P4 build_page.sh