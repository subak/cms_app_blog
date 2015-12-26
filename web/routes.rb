class Routes
  def self.routes
    [
        {
            route: '^/(?<id>[\w\W\d]{4})/(?:index.html)?$',
            path: 'web/html/main.html',
            class: 'Entry'
        },
        {
            route: '^(/index\.html|/)$',
            path: 'web/html/main.html',
            class: 'Index',
            page: 1
        },
        {
            route: '^/page/(?<page>[\d]+)/(?:index.html)?$',
            path: 'web/html/main.html',
            class: 'Index'
        },
        {
            route: '^/sitemap.xml$',
            path: 'web/html/sitemap.xml',
            class: 'Page'
        }
    ]
  end
end