#!/usr/bin/env ruby

require 'fileutils'
require 'json'
require 'yaml'

head = '| head -10' && nil

from_dir = '~/Repos/emark-rails/public/_/bl/blog.tk84.net/'
ids = `find #{from_dir}* -name "*.json" -exec basename {} .json \\; | egrep -v index #{head}`.split("\n")

to_dir = 'content/entry'

ids.each do |id|
  FileUtils.mkdir_p(File.join(to_dir, id), :verbose => true)

  json = JSON.parse `cat #{File.join(from_dir, id+'.json')} | sed -e 's/\\u00a0/ /g'`

  meta = {
      :id => json['eid'],
      :title => json['title'],
      :created => `web/bin/date_to_jst.js #{json['created']}`.strip,
      :updated => `web/bin/date_to_jst.js #{json['updated']}`.strip
  }

  File.write(File.join(to_dir, id, "#{id}.meta.yml"),
             meta.to_yaml.sub("---\n", '').gsub(/^:/, ''))
  File.write(File.join(to_dir, id, "#{id}.md"),
             "# #{meta[:title]}\n#{json['markdown']}")

end
