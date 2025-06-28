<?php

namespace juddlyon\airtablefeedme;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\feedme\events\RegisterFeedMeDataTypesEvent;
use craft\feedme\services\DataTypes;
use craft\helpers\App;
use juddlyon\airtablefeedme\datatypes\AirtableDataType;
use juddlyon\airtablefeedme\models\Settings;
use yii\base\Event;

/**
 * Airtable Feed Me plugin
 *
 * @author Judd Lyon <jl@juddlyon.com>
 * @copyright Copyright (c) 2024 Judd Lyon
 * @license MIT
 *
 * @property-read Settings $settings
 * @method Settings getSettings()
 */
class AirtableFeedMe extends Plugin
{
    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // Register the Airtable data type
        Event::on(
            DataTypes::class,
            DataTypes::EVENT_REGISTER_FEED_ME_DATA_TYPES,
            function(RegisterFeedMeDataTypesEvent $event) {
                $event->dataTypes[] = AirtableDataType::class;
            }
        );

        Craft::info(
            'Airtable Feed Me plugin loaded',
            __METHOD__
        );
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'airtable-feedme/_settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    /**
     * Get the Airtable API key from environment variable only
     */
    public function getApiKey(): ?string
    {
        return App::env('AIRTABLE_API_KEY');
    }
}