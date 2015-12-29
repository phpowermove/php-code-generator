Best Practices
==============

The code generator was written with some thoughts in mind. See for yourself, if they are useful for you, too.

Template system for Code Bodies
-------------------------------

It is useful to use some kind of template system to load the contents for your bodies. The template system can also be used to replace variables in the templates.

Hack in Traits
--------------

Let's assume you generate a php class. This class will be used in your desired framework as it serves a specific purpose in there. It possible needs to fulfill an interface or some abstract methods and your generated code will also take care of this - wonderful. Now imagine the programmer wants to change the code your code generation tools created. Once you run the tools again his changes probably got overwritten, which would be bad.
Here is the trick: First we declare the generated class as "host" class. Your code generation tools should first check if the host class exists and if not create it, or if it exists, load the existing class. For the possible required methods your host class must contain create a trait and implement the required logic at the trait. Check in the host class, if the trait is available and add it if not present. Now you only need to write the host class if there is an update (or if your code generation tools have some kind of force parameter). It also keeps programmer modified code intact and your tools can safely overwrite the trait. If you want to give the programmer more freedom offer him hook methods in the host class, that - if he wants to - can overwrite with his own logic.

Format in Post-Processing
-------------------------

After generating code is finished, it can happen that (especially) bodies are formatted ugly. Thus just run the suggested code formatter after generating the code. Can be found on github `gossi/php-code-formatter`_.

.. _gossi/php-code-formatter: https://github.com/gossi/php-code-formatter
