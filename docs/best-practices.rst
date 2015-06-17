Best Practices
==============

The code generator was written with some thoughts in mind. See for yourself, if they are useful for you, too.

Template system for Bodies
--------------------------

It is useful to use some kind of template system to load the contents for you bodies, which can also be used to replace variables.

Hack in Traits
--------------

When generating code there is a high chance the code generator is run again. A good practice is to generate traits and only add the trait to your "host" class. The latter can be done loading the model through reflection for the traits programmatically generation the models is most appreciated.

Format in Post-Processing
-------------------------

After generating code is finished, it can happen that (especially) bodies are format ugly. Thus just run the suggested code formatter after generating the code. Can be found on github `gossi/php-code-formatter`_.

.. _gossi/php-code-formatter: https://github.com/gossi/php-code-formatter
