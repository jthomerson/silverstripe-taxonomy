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
      $fields->addFieldToTab('Root.Taxonomy', new ManyManyPickerField(
         $this->owner,
        'VocabularyTerms',
        _t('Vocabulary.Terms.Label', 'Vocabulary Terms'),
        array(
           'ShowPickedInSearch' => false,
        )
      ));
   }

}
