<?php

namespace Drupal\rmp_tagging\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Tagging entity.
 *
 * @ingroup rmp_tagging
 *
 * @ContentEntityType(
 *   id = "tagging",
 *   label = @Translation("Tagging"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rmp_tagging\TaggingListBuilder",
 *     "views_data" = "Drupal\rmp_tagging\Entity\TaggingViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\rmp_tagging\Form\TaggingForm",
 *       "add" = "Drupal\rmp_tagging\Form\TaggingForm",
 *       "edit" = "Drupal\rmp_tagging\Form\TaggingForm",
 *       "delete" = "Drupal\rmp_tagging\Form\TaggingDeleteForm",
 *     },
 *     "access" = "Drupal\rmp_tagging\TaggingAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\rmp_tagging\TaggingHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "tagging",
 *   admin_permission = "administer tagging entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/tagging/{tagging}",
 *     "add-form" = "/admin/structure/tagging/add",
 *     "edit-form" = "/admin/structure/tagging/{tagging}/edit",
 *     "delete-form" = "/admin/structure/tagging/{tagging}/delete",
 *     "collection" = "/admin/structure/tagging",
 *   },
 *   field_ui_base_route = "tagging.settings"
 * )
 */
class Tagging extends ContentEntityBase implements TaggingInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Tagging entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Project Tag Name'))
      ->setDescription(t('Project Tag Name.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  
/////////////////////////////

	$fields['project_tag_code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Project Tag Code'))
      ->setDescription(t('Project Tag Code.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


  $fields['project_tag_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Project Tag Name'))
      ->setDescription(t('Project Tag Name.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	
	
	$fields['project_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Project Name'))
      ->setDescription(t('Mapping with project entity'))
      ->setSetting('target_type', 'project')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
	  ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  
	  
	$fields['pursuit_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Pursuit Name'))
      ->setDescription(t('Mapping with pursuit entity'))
      ->setSetting('target_type', 'pursuit')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
	  ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


	$fields['so_code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('SO Code'))
      ->setDescription(t('SO Code.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  


	$fields['start_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start date'))
      ->setDescription(t('Tagging Start date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
	  
	  
	$fields['end_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End date'))
      ->setDescription(t('Tagging End date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	


	$fields['resource_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Resource Name'))
      ->setDescription(t('Mapping with resource/user entity'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
	  ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	


	$fields['reporting_manager_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Reporting Manager'))
      ->setDescription(t('Mapping with resource/user entity'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
	  ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	



    $fields['tagging_status'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Status'))
      ->setDescription(t('Tagging status'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'tagging_status']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['skill'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Skill'))
      ->setDescription(t('Resource skill'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'primary_skills']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['location'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Location'))
      ->setDescription(t('Location'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'office_locations']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	


    $fields['grade'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Grade'))
      ->setDescription(t('Grade'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'grades']])
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'entity_reference_label',
          'weight' => -4,
          'settings' => array(
            'link' => FALSE,
          ),
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);		  
	  

	$fields['active'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Active'))
      ->setDescription(t('Active status of resource.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('0')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'boolean',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'boolean',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);	  
//////////////////////////////	  

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Tagging is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
