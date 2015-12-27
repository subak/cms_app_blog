require 'web/ruby/router.rb'
eval(`routes.rb`)

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
              `#{context['handler']} '#{JSON.generate(context)}'`
          ]
      ]
    else
      [399, {}, []]
    end
  end
end

Handler.new