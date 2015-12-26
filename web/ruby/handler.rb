require 'web/ruby/router.rb'
#require 'web/routes.rb'
eval(`routes.rb`)
#eval('class Hoge; end')


class Handler
  @@router = nil

  def call(env)
    @@router ||= Router.new(Routes.routes)
    context = @@router.select(env['PATH_INFO'])

    if (context)
      [
          200,
          {
              "content-type" => "text/html; charset=utf-8",
          },
          [
              `page.php '#{JSON.generate(context)}'`
          ]
      ]
    else
      [
          404,
          {
              "content-type" => "text/plain; charset=utf-8",
          },
          [
              'not found'
          ]
      ]
    end
  end
end

Handler.new