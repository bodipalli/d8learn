<?php

namespace Drupal\rmp_pursuit\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Pursuit entity.
 *
 * @ingroup rmp_pursuit
 *
 * @ContentEntityType(
 *   id = "pursuit",
 *   label = @Translation("Pursuit"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rmp_pursuit\PursuitListBuilder",
 *     "views_data" = "Drupal\rmp_pursuit\Entity\PursuitViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\rmp_pursuit\Form\PursuitForm",
 *       "add" = "Drupal\rmp_pursuit\Form\PursuitForm",
 *       "edit" = "Drupal\rmp_pursuit\Form\PursuitForm",
 *       "delete" = "Drupal\rmp_pursuit\Form\PursuitDeleteForm",
 *     },
 *     "access" = "Drupal\rmp_pursuit\PursuitAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\rmp_pursuit\PursuitHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "pursuit",
 *   admin_permission = "administer pursuit entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/pursuit/{pursuit}",
 *     "add-form" = "/admin/structure/pursuit/add",
 *     "edit-form" = "/admin/structure/pursuit/{pursuit}/edit",
 *     "delete-form" = "/admin/structure/pursuit/{pursuit}/delete",
 *     "collection" = "/admin/structure/pursuit",
 *   },
 *   field_ui_base_route = "pursuit.settings"
 * )
 */
class Pursuit extends ContentEntityBase implements PursuitInterface {

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

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Pursuit Name'))
      ->setDescription(t('The RFP Name of the Pursuit.'))
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
      ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['deal_value'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Deal Value'))
      ->setDescription(t('Deal Value'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['fte'] = BaseFieldDefinition::create('string')
      ->setLabel(t('FTE'))
      ->setDescription(t('FTE info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['onshore_resources'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Onshore Resources'))
      ->setDescription(t('Onshore Resources info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['offshore_resources'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Offshore Resources'))
      ->setDescription(t('Offshore Resources info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['effort_wincenter'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Effort Wincenter'))
      ->setDescription(t('Effort Wincenter info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['effort_sme'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Effort SME'))
      ->setDescription(t('Effort SME info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['effort_delivery'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Effort Delivery'))
      ->setDescription(t('Effort Delivery'))
      ->setSettings(array(
        'max_length' => 45,
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
      ->setDescription(t('Pursuit Start date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
          'settings' => ['format_type' => 'short'],
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
      ->setDescription(t('Pursuit End date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
          'settings' => ['format_type' => 'short'],
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['path_info'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Path'))
      ->setDescription(t('Path info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['remarks'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Remarks'))
      ->setDescription(t('Remarks info'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string_textarea',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textarea',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['final_document'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Final Document'))
      ->setDescription(t('Final Document info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['item_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Item Type'))
      ->setDescription(t('Item Type info'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['client_name'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Client Name'))
      ->setDescription(t('Client Name info'))
      ->setSetting('target_type', 'client')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['technology'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Technology'))
      ->setDescription(t('Technology Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'technology']])
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

    $fields['sbu'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('SBU'))
      ->setDescription(t('SBU Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'sbu']])
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

    $fields['sector'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Sector'))
      ->setDescription(t('Sector Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'sector']])
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

    $fields['type_of_proposal'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Proposal Type'))
      ->setDescription(t('Type of Proposal Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'type_of_proposal']])
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

    $fields['probability_percentage'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Probability Percentage'))
      ->setDescription(t('Probability Percentage Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'probability_percentage']])
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

    $fields['country'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Country'))
      ->setDescription(t('Country Info'))
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

    $fields['archive'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Archived'))
      ->setDescription(t('Is this Pursuit Archived???'))
      ->setSettings(array(
        'allowed_values' => array(
          '0' => 'No',
          '1' => 'Yes',
        ),
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['pursuit_status'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Pursuit Status'))
      ->setDescription(t('Pursuit Status'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'pursuit_status']])
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

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Pursuit entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Pursuit is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['modified_by'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Modified By'))
      ->setDescription(t('Who Modified the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('view', TRUE);

    $fields['opp_owner'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Opp Owner'))
      ->setDescription(t('Opp Owner Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'opp_owner']])
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

    $fields['sub_practice'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Sub Practice'))
      ->setDescription(t('Sub Practice Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'sub_practice']])
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

    $fields['practice'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Practice'))
      ->setDescription(t('Practice Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'practice']])
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

    $fields['sub_region'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Sub Region'))
      ->setDescription(t('Sub Region Info'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'sub_region']])
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

    $fields['proposal_lead'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Proposal Lead'))
      ->setDescription(t('Proposal Lead the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['solution_architect'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Solution Architect'))
      ->setDescription(t('Solution Architect the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['delivery_leader'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Delivery Leader'))
      ->setDescription(t('Delivery Leader the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['practice_leader'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Practice Leader'))
      ->setDescription(t('Practice Leader the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['wincenter_lead'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Wincenter Lead'))
      ->setDescription(t('Wincenter Lead of the this Pursuit'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'user',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => -4,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['new_client'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('New Client'))
      ->setDescription(t('Is this New Client?'))
      ->setSettings(array(
        'allowed_values' => array(
          '0' => 'No',
          '1' => 'Yes',
        ),
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'string_textarea',
          'weight' => -4,

      ))
      ->setDisplayOptions('form', array(
          'type' => 'string_textarea',
          'weight' => -4,
          'settings' => array(
              'placeholder' => 'Description for Pursuit',
          ),
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['date_received'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Date received'))
      ->setDescription(t('Pursuit Date received.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
          'settings' => ['format_type' => 'short'],
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['submission_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Submission Date'))
      ->setDescription(t('Pursuit Submission Date.'))
      ->setSettings(array(
          'datetime_type' => 'date',
          'date_format' => 'd-m-Y',
        ))
      ->setDisplayOptions('view', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
          'settings' => ['format_type' => 'short'],
        ))
      ->setDisplayOptions('form', array(
          'label' => 'above',
          'type' => 'datetime_default',
          'weight' => -4,
        ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['win_lost_month'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Win / Lost Month'))
      ->setDescription(t('Win / Lost Month'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['india_deal_value'] = BaseFieldDefinition::create('string')
      ->setLabel(t('India Deal Value (K Euro)'))
      ->setDescription(t('India Deal Value (K Euro)'))
      ->setSettings(array(
        'max_length' => 45,
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

    $fields['thor_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('THOR ID'))
      ->setDescription(t('THOR ID'))
      ->setSettings(array(
        'max_length' => 45,
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

    return $fields;
  }

}
