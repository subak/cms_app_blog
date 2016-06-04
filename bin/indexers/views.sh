#!/usr/bin/env bash

find html/views/* \( -type f -o -type l \) \
  | grep -v '/_' \
  | sed -e 's/^html\/views//'
