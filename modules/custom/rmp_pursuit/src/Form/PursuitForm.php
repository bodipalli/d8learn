<?php

namespace Drupal\rmp_pursuit\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Pursuit edit forms.
 *
 * @ingroup rmp_pursuit
 */
class PursuitForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\rmp_pursuit\Entity\Pursuit */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Pursuit.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Pursuit.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.pursuit.canonical', ['pursuit' => $entity->id()]);
  }
}
