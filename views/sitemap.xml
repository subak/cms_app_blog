<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?= $this->each(\Helpers\Entry::entry_ids(), function($i, $id) { ?>
  <url>
    <?= $this->tag('loc', $this->url_for("/${id}/")) ?>
    <?= $this->tag('lastmod', \Helpers\Entry::entry_updated($id)->format('c')) ?>
  </url>
  <? }) ?>
</urlset>