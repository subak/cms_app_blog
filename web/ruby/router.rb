class Router
  def initialize(routes)
    # @routes = routes
    @routes = routes.map do |route|
      match = /\?\<([^>]+)\>/.match(route['route'])
      if match
        route[:_names] = match.to_a.drop(1)
      end
      route
    end
  end

  def select(uri)
    match = nil
    route = @routes.find do |route|
      pattern = Regexp.new(route['route'])
      match = pattern.match(uri)
    end

    return nil unless match

    res = {}
    if route[:_names]
      route[:_names].each do |name|
        name = name.to_sym

        begin
          match[name]
        rescue
        else
          res[name] = match[name]
        end
      end
    end

    route = route.dup
    route.delete(:_names)

    res['uri'] = uri

    res.merge(route)
  end
end