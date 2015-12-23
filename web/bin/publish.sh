#!/usr/bin/env bash

web/bin/entries.sh | xargs -P 4 -n 1 web/bin/router.rb | xargs -P 4 -n 1 web/bin/build.rb
web/bin/sitemap.rb > web/public/sitemap.xml
