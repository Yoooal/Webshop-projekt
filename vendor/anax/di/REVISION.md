Revision history
=================================

v1.0.5 (2017-09-14)
---------------------------------

* Make setDI return self.


v1.0.4 (2017-09-11)
---------------------------------

* Made DI instance variables protected instead of public.
* Remove commented section with magic methods from DI.
* Adding DIFactoryConfigMagic that uses DIMagicTrait.
* Adding testcases for DIFactoryConfigMagic.


v1.0.3 (2017-08-17)
---------------------------------

* Require specific DIInterface.
* Allow to activate service directly by configuration file setting.


v1.0.2 (2017-08-10)
---------------------------------

* Major rework doing integration test.


v1.0.1 (2017-08-09)
---------------------------------

* Rewrote DIFactoryDefault.
* Added DIFactoryConfig which reads services from configuration file.
* Adding sample klass App/AppDI which is InjectionAware.


v1.0.0 (2017-06-29)
---------------------------------

* Made it close to supporting PHP-FIG 11 Container, using DI instead of Container.
* First inofficial release, moved from Anax MVC.
