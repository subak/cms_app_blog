#!/usr/bin/env node

var moment = require('moment');

console.log(moment(process.argv[2]).format());
