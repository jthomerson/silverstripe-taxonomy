<?php

/* A term that can be applied to content nodes to identify and classify them
 * into a secondary categorization (where the primary categorization comes from
 * the natural ordering of the nodes within the site tree).
 *
 * @author Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @copyright (c) 2012 Jeremy Thomerson <jeremy@thomersonfamily.com>
 * @package silverstripe-taxonomy
 * @subpackage code
 */
class VocabularyTerm extends DataObject {

   static $db = array(
      'Term'        => 'VARCHAR(64)',
      'MachineName' => 'VARCHAR(16)',
   );

   static $has_one = array(
      'Vocabulary' => 'Vocabulary',
   );

   static $many_many = array(
      'Children' => 'VocabularyTerm',
   );

   static $belongs_many_many = array(
      'Parents' => 'VocabularyTerm',
   );

   static $default_sort = 'Term';

   // config for data model admin:
   static $summary_fields = array(
      'Vocabulary.Name',
      'Term',
      'MachineName',
      'ParentsTerms',
      'ChildrenTerms',
   );

   static $searchable_fields = array(
      'Term',
      'MachineName',
   );

   public function getChildrenTerms() {
      return implode(', ', $this->Children()->map('ID', 'Term'));
   }

   public function getCMSValidator() {
      return new RequiredFields('Term', 'MachineName', 'VocabularyID');
   }

   function getCMSFields() {
      $fields = new FieldSet(array(
         new TextField('Term', 'Term'),
         new TextField('MachineName', 'Machine Name'),
         new LiteralField('', '<h3>Manage Children</h3>'),
         new ManyManyComplexTableField(
            $controller = $this,
            $name = 'Children',
            $sourceClass = 'VocabularyTerm',
            $fieldList = array('Term' => 'Term'),
            $detailFormFields = null,
            $sourceFilter = sprintf('"VocabularyTerm"."VocabularyID" = %d AND "VocabularyTerm"."ID" <> %d', $this->VocabularyID, $this->ID)
         ),
      ));
      return $fields;
   }

   public function getFullTermTitle() {
      return sprintf('%s : %s', $this->Vocabulary()->Name, $this->Term);
   }

   public function getParentsTerms() {
      return implode(', ', $this->Parents()->map('ID', 'Term'));
   }

   public function Summary() {
      $summary = $this->getFullTermTitle();
      $parents = $this->getParentsTerms();
      if (!empty($parents)) {
         $summary .= sprintf('<em>' . _t('VocabularyTerm.Summary.Parents', ' (Parent terms: %s)') . '</em>', $parents);
      }
      return $summary;
   }

}
