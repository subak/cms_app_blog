#!/usr/bin/env ruby

require 'builder'
require 'yaml'

site = YAML.load_file 'web/site.meta.yml'

xml = Builder::XmlMarkup.new indent:2
xml.instruct! :xml, version:1.0, encoding:'UTF-8'
sitemap = xml.urlset xmlns:'http://www.sitemaps.org/schemas/sitemap/0.9' do
  `web/bin/ids.sh`.split("\n").each do |id|
    xml.url do
      xml.loc("#{site['scheme']}://#{site['host']}/#{id}/")
      entry = YAML.load_file("content/entry/#{id}/#{id}.meta.yml")
      xml.lastmod(entry['updated'])
    end
  end
end

puts sitemap