module Jekyll
  class PHPFlasherTag < Liquid::Tag
    def render(context)
      '<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>'
    end
  end
end

Liquid::Template.register_tag('PHPFlasher', Jekyll::PHPFlasherTag)
