require 'web/ruby/router.rb'

class Handler
  @@router = nil

  def call(env)
    @@router ||= Router.new(JSON.parse `yaml2json.rb app/config/routes.yml`)
    context = @@router.detect(env['PATH_INFO'])
    condition = if context.nil?
                  false
                elsif context['condition']
                  eval(context['condition'])
                else
                  true
                end

    if (condition)
      status = context['status'] || 200
      content_type = context['content_type'] || 'text/html; charset=utf-8'
      body = if context['body']
               eval("<<EOF\n#{context['body']}\nEOF\n")
             else `#{context['handler']} '#{JSON.generate(context)}'` end
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