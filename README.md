# Airtable Feed Me Plugin for Craft CMS

A Feed Me feed type that handles Airtable's 100-record API limit with automatic pagination.

## Problem This Solves

Airtable's API limits responses to 100 records per page, requiring manual pagination to access larger datasets. When using Feed Me's built-in JSON feed type with Airtable, you'll only get the first 100 records - missing the rest of your data.

This plugin solves that limitation by automatically handling pagination behind the scenes, fetching all records from your Airtable base regardless of size.

## Features

- **Automatic Pagination** - Transparently fetches all records beyond Airtable's 100-record API limit
- **Easy Configuration** - Set API key via environment variables for security
- **Full Airtable API Support** - Use views, filters, and sorting just like the native API
- **Craft CMS 5 Compatible** - Built for the latest version of Craft and Feed Me

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

Set your Airtable API key via environment variable for security:

```bash
AIRTABLE_API_KEY="your_api_key_here"
```

Add this to your `.env` file. The plugin enforces environment variable usage to prevent accidentally committing API keys.

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