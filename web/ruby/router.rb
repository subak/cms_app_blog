class Router
  def initialize(routes)
    @routes = routes.map do |route|
      route[:_names] = route['route'].scan(/\?\<([^>]+)\>/).flatten
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

    route[:_names].each do |name|
      name = name.to_sym

      begin
        match[name]
      rescue
      else
        res[name.to_s] = match[name]
      end
    end

    route = route.dup
    route.delete(:_names)

    res['uri'] = uri unless res['uri']

    res.merge(route)
  end
end