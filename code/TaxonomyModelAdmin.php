<?php

/* Data model admin for taxonomy vocabularies and terms.
 *
 * @author Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @copyright (c) 2012 Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @package silverstripe-taxonomy
 * @subpackage code
 */
class TaxonomyModelAdmin extends ModelAdmin {

   static $managed_models = array(
      'Vocabulary',
      'VocabularyTerm',
   );

   static $url_segment = 'taxonomy';

   static $menu_title = 'Taxonomy';

}
