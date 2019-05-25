# Php Language Permalink
Generate a URL friendly "slug" from a given string.

## Examples
```php
Permalink::generate("Lorem Ipsum is simply dummy text of the printing and typesetting industry.");
Permalink::generate("Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "_");
Permalink::generate('Lorem Ipsum ist ein einfacher Demo-Text für die Print- und Schriftindustrie.', '-', 'de');
```
```html
Output: lorem-ipsum-is-simply-dummy-text-of-the-printing-and-typesetting-industry
Output: lorem_ipsum_is_simply_dummy_text_of_the_printing_and_typesetting_industry
Output: lorem-ipsum-ist-ein-einfacher-demo-text-fuer-die-print-und-schriftindustrie
```
