<?php

namespace Drupal\deims_siterelationships_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'DeimsSiterelationshipsFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "deims_siterelationships_formatter",
 *   label = @Translation("DEIMS Site Relationships Formatter"),
 *   field_types = {
 *     "entity_reference_revisions"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
 
class DeimsSiterelationshipsFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
 
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Formats the site relationships field of DEIMS.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

	foreach ($items as $delta => $item) {

	  if ($item->entity) {
		$relationship_type = $item->entity->field_relationship_type;
		$related_sites = $item->entity->field_related_sites;
		
		$relationship_element = serialize($related_sites);
		
		//$RefEntity_item['title'] = $RefEntity->get('title')->value;
		//$RefEntity_item['id']['prefix'] = 'https://deims.org/';
		//$RefEntity_item['id']['suffix'] = $RefEntity->field_deims_id->value;
		
	  }
	  else {
		break;
	  }  
	  
	  $element[$delta] = [
		'#markup' => $relationship_element,
	  ];
	  
	} 

	return $element;
  }
	
}


