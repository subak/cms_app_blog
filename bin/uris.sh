#!/usr/bin/env bash

for indexer in $(find app/bin/indexers/*); do
  echo "$(${indexer})"
done

for indexer in $(find web/bin/indexers/*); do
  echo "$(${indexer})"
done
