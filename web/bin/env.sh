#!/usr/bin/env bash

shopt -s expand_aliases
type gxargs | grep -v 'not found' >/dev/null && alias xargs='gxargs'
type gdate | grep -v 'not found' >/dev/null && alias date='gdate'

PATH=$(dirname $BASH_SOURCE):$PATH
CORE=4