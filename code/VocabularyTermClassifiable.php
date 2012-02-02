<?php

/* DataObjectDecorator that can be added to SiteTree nodes to allow them to be
 * classified by VocabularyTerms from the Taxonomy plugin.
 *
 * @author Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @copyright (c) 2012 Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @package silverstripe-taxonomy
 * @subpackage code
 */
class VocabularyTermClassifiable extends DataObjectDecorator {

   function extraStatics() {
      return array(
         'many_many' => array(
            'VocabularyTerms' => 'VocabularyTerm',
         ),
      );
   }

   public function updateCMSFields(FieldSet &$fields) {
      //$fields->addFieldToTab('Root.Content.Main', new ReadonlyField('FirstPublishedDate', 'First Published (online)'), 'Title');
      $termsSort = '"Vocabulary"."Name", "VocabularyTerm"."Term"';
      $termsJoin = 'JOIN "Vocabulary" ON "Vocabulary"."ID" = "VocabularyTerm"."VocabularyID"';
      $terms = DataObject::get('VocabularyTerm', '', $termsSort, $termsJoin)->map('ID', 'FullTermTitle');
      $fields->addFieldToTab('Root.Taxonomy', new CheckboxSetField('VocabularyTerms', 'Vocabulary Terms', $terms));
   }

}
