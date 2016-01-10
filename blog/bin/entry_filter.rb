#!/usr/bin/env ruby

require 'jq/extend'
require 'yaml'

filter = ARGV.last

`entry_ids_all.sh`.split("\n").each do |id|
  catch(:not_found) do
    path = "content/entry/#{id}/#{id}.yml"
    next unless File.exists?(path)
    meta = YAML.load_file(path)
    meta.jq(filter) do |value|
      throw(:not_found) unless value
    end
    puts id
  end
end
