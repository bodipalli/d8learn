<?php

namespace Drupal\rmp_client\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Client entity.
 *
 * @ingroup rmp_client
 *
 * @ContentEntityType(
 *   id = "client",
 *   label = @Translation("Client"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rmp_client\ClientListBuilder",
 *     "views_data" = "Drupal\rmp_client\Entity\ClientViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\rmp_client\Form\ClientForm",
 *       "add" = "Drupal\rmp_client\Form\ClientForm",
 *       "edit" = "Drupal\rmp_client\Form\ClientForm",
 *       "delete" = "Drupal\rmp_client\Form\ClientDeleteForm",
 *     },
 *     "access" = "Drupal\rmp_client\ClientAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\rmp_client\ClientHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "client",
 *   admin_permission = "administer client entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/client/{client}",
 *     "add-form" = "/admin/structure/client/add",
 *     "edit-form" = "/admin/structure/client/{client}/edit",
 *     "delete-form" = "/admin/structure/client/{client}/delete",
 *     "collection" = "/admin/structure/client",
 *   },
 *   field_ui_base_route = "client.settings"
 * )
 */
class Client extends ContentEntityBase implements ClientInterface {

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

    $fields['industry'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Industry'))
      ->setDescription(t('The name of the client industry.'))
      ->setRevisionable(TRUE)
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
      
    $fields['client_email'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email'))
      ->setDescription(t('The client email.'))
      ->setRevisionable(TRUE)
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
      
    $fields['client_phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone'))
      ->setDescription(t('The client phone.'))
      ->setRevisionable(TRUE)
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
      
      
    $fields['spoc_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Spoc name'))
      ->setDescription(t('The spoc name.'))
      ->setRevisionable(TRUE)
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
      
    
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Client entity.'))
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
      ->setLabel(t('Client name'))
      ->setDescription(t('The name of the Client entity.'))
      ->setRevisionable(TRUE)
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
      
    $fields['client_location'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Client Location'))
      ->setDescription(t('Client Location Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'country']])
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

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Client is published.'))
      ->setRevisionable(TRUE)
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
