#!/usr/bin/env ruby

require 'json'
require 'yaml'

$:.push(Dir.pwd)
require ENV['APP']+'/ruby/router.rb'

puts Router.new(YAML.load_file File.join(ENV['APP'],'config/routes.yml'))
         .detect(ARGV.last).to_json
