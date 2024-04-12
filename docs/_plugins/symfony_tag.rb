module Jekyll
  class SymfonyTag < Liquid::Tag
    def render(context)
      '<i class="fa-brands fa-symfony text-black fa-xl"></i> <strong>Symfony</strong>'
    end
  end
end

Liquid::Template.register_tag('Symfony', Jekyll::SymfonyTag)
