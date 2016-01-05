#!/usr/bin/env bash

for indexer in $(find ${APP}/bin/indexers/*); do
  echo "$(${indexer})"
done