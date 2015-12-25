#!/usr/bin/env ruby

require 'builder'
require 'yaml'

site = YAML.load_file 'web/site.yml'

xml = Builder::XmlMarkup.new indent:2
xml.instruct! :xml, version:1.0, encoding:'UTF-8'
sitemap = xml.urlset xmlns:'http://www.sitemaps.org/schemas/sitemap/0.9' do
  `entry_ids.sh`.split("\n").each do |id|
    xml.url do
      xml.loc("#{site['scheme']}://#{site['host']}/#{id}/")
      xml.lastmod(`entry_updated.sh #{id}`)
    end
  end
end

puts sitemap