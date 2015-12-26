#!/usr/bin/env ruby

require 'yaml'

puts <<"EOF"
class Routes
  def self.routes
    #{YAML.load_file('web/routes.yml').inspect}
  end
end
EOF
