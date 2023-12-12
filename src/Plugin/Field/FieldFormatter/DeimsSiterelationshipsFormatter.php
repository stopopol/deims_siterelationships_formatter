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

		$relationship_label = null;
		$relationship_type = $item->entity->field_relationship_type;
		$related_sites = $item->entity->field_related_sites;
		
		foreach ($relationship_type as $term) {
			$relationship_label = $term->entity->label();
		}
		
		if (!empty($relationship_label)) {
			$relationship_type_string = "This site " . $relationship_label . ":<br>";
		}
		else {
			break;
		}
		
		$ul_string = "";
		foreach ($related_sites as $delta => $site) {
			if ($site->entity) {
				$ul_string = $ul_string . '<li><a href="' . "/" . $site->entity->field_deims_id->value . '">' . $site->entity->get('title')->value . '</a></li>';
			}
		}

		if ($ul_string == "") {
			break;
		}
		
		$relationship_element = $relationship_type_string . "<ul>". $ul_string . "</ul>";
		
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
