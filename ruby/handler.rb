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
      query = Hash[Hash[*env['QUERY_STRING'].scan(/([^=&]+)=([^=&]+)/).flatten].map{|k,v| [URI.decode_www_component(k),URI.decode_www_component(v)]}]
      context['query'] = env['QUERY_STRING'] unless env['QUERY_STRING'].empty?
      context.merge!(JSON.parse query['context']) if query['context']
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