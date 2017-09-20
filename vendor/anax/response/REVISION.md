Revision history
=================================

v1.0.7 (2017-09-11)
---------------------------------

* Add status codes 400, 405, 501, 418.
* Ignore phpmd exit expression in Response::redirect().


v1.0.6 (2017-08-17)
---------------------------------

* Do exit after redirect().
* Add utility methods through ResponseUtility.


v1.0.5 (2017-04-12)
---------------------------------

* Do not send headers if they are already sent, silently fail on send() and sendJson().
* Remove warning from composer.json, duplicate PHP version.


v1.0.4 (2017-03-13)
---------------------------------

* Added `JSON_UNESCAPED_SLASHES` to SendJson().


v1.0.3 (2017-03-10)
---------------------------------

* Remove `JSON_PRESERVE_ZERO_FRACTION` from SendJson().


v1.0.2 (2017-03-09)
---------------------------------

* Enable to use callable to set the body.


v1.0.1 (2017-03-07)
---------------------------------

* Corrections after test with anax-lite.


v1.0.0 (2017-03-07)
---------------------------------

* Extracted from anax to be its own module.
