#!/usr/bin/env ruby

require 'yaml'

routes = YAML.load_file('web/routes.yml')

puts Marshal.dump(routes.to_a)
