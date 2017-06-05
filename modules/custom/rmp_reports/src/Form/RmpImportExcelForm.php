<?php

namespace Drupal\rmp_reports\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\rmp_reports\Services\RmpImportExcelService;

/**
 * Class RmpImportExcelForm.
 *
 * @package Drupal\rmp_reports\Form
 */
class RmpImportExcelForm extends FormBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\rmp_reports\Services\RmpImportExcelService definition.
   *
   * @var \Drupal\rmp_reports\Services\RmpImportExcelService
   */
  protected $rmpReportsImportExcel;
  public function __construct(
    Connection $database,
    RmpImportExcelService $rmp_reports_import_excel
  ) {
    $this->database = $database;
    $this->rmpReportsImportExcel = $rmp_reports_import_excel;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('rmp_reports.import_excel')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rmp_import_excel_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    ];
    $data = $this->rmpReportsImportExcel->spreadsheetExcelReader('example.xls');
    $sheet_count = count($data->sheets);
    $html = "<span><b>Excel File: example.xls</b></span>";
    for($i=0;$i< $sheet_count;$i++) // Loop to get all sheets in a file.
    { 
      $sheet_no = $i + 1;
      $html .= "<h3>Sheet-" . $sheet_no . "</h3>";
      $html .= "<table border='1'>";
      if(count($data->sheets[$i]['cells'])>0) // checking sheet not empty
      {
        for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
        { 
          $html.="<tr>";
          for($k=1;$k<=count($data->sheets[$i]['cells'][$j]);$k++) // This loop is created to get data in a table format.
          {
          $html.="<td>";
          $html.=$data->sheets[$i]['cells'][$j][$k];
          $html.="</td>";
          }
          $html.="</tr>";
        }
      }
      $html.="</table>";
    }
    $form['#markup'] =  $html;
    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Service call.
    $data = $this->rmpReportsImportExcel->spreadsheetExcelReader('example.xls');
    $batch = array(
      'title' => t('Creating users...'),
      'operations' => array(
        array(
          '\Drupal\rmp_reports\RmpCreateUserFromExcel::userCreate',array($data)
        ),
      ),
      'finished' => '\Drupal\rmp_reports\RmpCreateUserFromExcel::userCreateFinishedCallback',
      'init_message' => 'Creating users Batch is starting.',
    );
    batch_set($batch);
  }

}
