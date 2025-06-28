# Airtable Feed Me Plugin for Craft CMS

Airtable data type with automatic pagination support for Feed Me.

## Features

- **Automatic Pagination** - Handles Airtable's 100-record limit seamlessly
- **Easy Configuration** - Set API key via Control Panel or environment variables
- **Full Airtable API Support** - Use views, filters, and sorting
- **Craft CMS 5 Compatible** - Built for the latest version of Craft

## Requirements

- Craft CMS 5.0.0 or later
- Feed Me 6.0.0 or later
- PHP 8.0.2 or later

## Installation

### Via Composer (Local Development)

Since this plugin is not yet publicly released, add it as a local repository:

1. Add to your project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./plugins/airtable-feedme"
        }
    ]
}
```

2. Install the plugin:

```bash
composer require juddlyon/airtable-feedme
```

3. In the Control Panel, go to Settings → Plugins and install the Airtable Feed Me plugin.

## Configuration

### API Key

You can set your Airtable API key in two ways:

1. **Control Panel**: Go to Settings → Airtable Feed Me and enter your API key
2. **Environment Variable**: Set `AIRTABLE_API_KEY` in your `.env` file

### Creating a Feed

1. In Feed Me, create a new feed
2. Select "Airtable" as the Feed Type
3. Enter your Airtable API URL:
   ```
   https://api.airtable.com/v0/{baseId}/{tableIdOrName}
   ```

### Query Parameters

You can add these optional parameters to your feed URL:

- `view` - The name or ID of a view in the table
- `maxRecords` - Maximum total number of records to return
- `sort[0][field]` - Field to sort by
- `sort[0][direction]` - Sort direction (asc/desc)
- `filterByFormula` - Airtable formula to filter records

Example:
```
https://api.airtable.com/v0/appXXXXXX/Videos?view=Published&maxRecords=500&sort[0][field]=Date&sort[0][direction]=desc
```

## Support

This plugin is currently in private testing. For support, please contact:
- Email: jl@juddlyon.com

## License

This plugin is licensed under the MIT License.