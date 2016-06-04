#!/usr/bin/env ruby

require 'json'
require 'yaml'

$:.push(Dir.pwd)
require 'web/ruby/router.rb'

puts Router.new(YAML.load_file File.join('app/config/routes.yml'))
         .detect(ARGV.last).to_json
