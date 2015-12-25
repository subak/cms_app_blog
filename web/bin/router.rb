#!/usr/bin/env ruby

require 'yaml'
require 'uri'

uri = ARGV.last

routes = YAML.load_file('web/routes.yml')

match = nil
route = routes.find do |route|
  pattern = Regexp.new(route['route'])
  match = pattern.match(uri)
end

res = match.names.inject({}) do |res, name|
  res[name] = match[name]
  res
end

res['uri'] = uri

uri = URI(route['path'])
uri.query = URI.encode_www_form(res.merge(route))

puts uri.to_s
