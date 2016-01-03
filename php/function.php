<?php
/**
 * Created by IntelliJ IDEA.
 * User: subak
 * Date: 2015/12/22
 * Time: 20:32
 */

function entry_title($id) {
  return `entry_title.sh ${id}`;
}

function entry_created($id) {
  return new DateTime(`entry_created.sh ${id}`);
}

function entry_updated($id) {
  return new DateTime(`entry_updated.sh ${id}`);
}

function entry_ids() {
  return array_values(array_filter(explode("\n", `entry_ids.sh`)));
}

