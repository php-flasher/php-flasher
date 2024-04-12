module Jekyll
  class LaravelTag < Liquid::Tag
    def render(context)
      '<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> <strong>Laravel</strong>'
    end
  end
end

Liquid::Template.register_tag('Laravel', Jekyll::LaravelTag)
