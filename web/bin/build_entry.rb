#!/usr/bin/env ruby

require 'uri'
require 'json'
require 'fileutils'

context = ARGV.last
id = JSON.parse(context)['id']

# id = Hash[URI::decode_www_form(URI(uri).query)]['id']

to_dir = "web/public/#{id}"
from_dir = "content/entry/#{id}"
to_file = "#{to_dir}/index.html"

FileUtils.mkdir_p(to_dir)

exts = %w(jpg png)
filter = "-name \"*.#{exts.join('" -o -name "*.')}\""
print `find #{from_dir}/* \\( #{filter} \\) -exec cp -v {} #{to_dir} \\;`

File.write(to_file, `page.php '#{context}'`)
puts to_file
