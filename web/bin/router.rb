#!/usr/bin/env ruby

require 'json'

$:.push(Dir.pwd)
require 'web/ruby/router.rb'
eval(`routes.rb`)

puts Router.new(Routes.routes).select(ARGV.last).to_json
