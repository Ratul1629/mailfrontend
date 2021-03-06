<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * CampaignTrackOpenWebhookQueue
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link https://www.mailwizz.com/
 * @copyright MailWizz EMA (https://www.mailwizz.com)
 * @license https://www.mailwizz.com/license/
 * @since 1.6.8
 */

/**
 * This is the model class for table "{{campaign_track_open_webhook_queue}}".
 *
 * The followings are the available columns in table '{{campaign_track_open_webhook_queue}}':
 * @property string $id
 * @property integer $webhook_id
 * @property string $track_open_id
 * @property integer $retry_count
 * @property string $next_retry
 *
 * The followings are the available model relations:
 * @property CampaignTrackOpenWebhook $webhook
 * @property CampaignTrackOpen $trackOpen
 */
class CampaignTrackOpenWebhookQueue extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{campaign_track_open_webhook_queue}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function relations()
	{
		$relations = array(
			'webhook'   => array(self::BELONGS_TO, 'CampaignTrackOpenWebhook', 'webhook_id'),
			'trackOpen' => array(self::BELONGS_TO, 'CampaignTrackOpen', 'track_open_id'),
		);

		return CMap::mergeArray($relations, parent::relations());
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		$labels = array(
			'id'            => Yii::t('campaigns', 'ID'),
			'webhook_id'    => Yii::t('campaigns', 'Webhook'),
			'track_open_id' => Yii::t('campaigns', 'Track open'),
			'retry_count'   => Yii::t('campaigns', 'Retry count'),
			'next_retry'    => Yii::t('campaigns', 'Next retry'),
		);

		return CMap::mergeArray($labels, parent::attributeLabels());
	}

	/**
	 * @inheritdoc
	 */
	protected function beforeSave()
	{
		if (empty($this->next_retry) || strtotime((string)$this->next_retry) < time()) {
			$this->next_retry = date('Y-m-d H:i:s');
		}
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CampaignTrackOpenWebhookQueue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
