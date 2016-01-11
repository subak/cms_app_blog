#!/usr/bin/env bash

find content/entry/* -maxdepth 0 -exec basename {} \; | sort