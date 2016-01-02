require ENV['APP']+'/ruby/router.rb'
eval(`routes.rb`)

class Handler
  @@router = nil

  def call(env)
    @@router ||= Router.new(Routes.routes)
    context = @@router.detect(env['PATH_INFO'])

    if (context)
      status = context['status'] || 200
      content_type = context['content_type'] || 'text/html; charset=utf-8'
      body = context['body'] && eval("<<EOF\n#{context['body']}\nEOF\n") || `#{context['handler']} '#{JSON.generate(context)}'`
      [
          status,
          {
              'content-type' => content_type,
          },
          [
              body
          ]
      ]
    else
      [399, {}, []]
    end
  end
end

Handler.new