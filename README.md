# Airtable Feed Me Plugin for Craft CMS

A Feed Me feed type that handles Airtable's 100-record API limit with automatic pagination.

## Why This Plugin Exists

While Feed Me has built-in pagination support, it doesn't work with Airtable's API. Here's why:

**The Problem:**
- Airtable's API returns a maximum of 100 records per request
- To get more records, you must use an `offset` parameter provided in the response
- Feed Me's standard pagination expects numbered pages (page 1, 2, 3...) or standard limit/offset parameters
- Airtable uses a unique cursor-based pagination with opaque offset strings
- Result: Feed Me can only fetch the first 100 records from Airtable, ignoring the rest

**The Solution:**
This plugin implements a custom Airtable data type for Feed Me that:
- Automatically detects when Airtable returns an `offset` parameter
- Recursively fetches additional pages using Airtable's offset cursors
- Combines all pages into a single dataset for Feed Me to process
- Works transparently - just set it up like any other Feed Me feed

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

## Technical Details

For developers interested in how this works:

1. The plugin registers a new "Airtable" data type with Feed Me
2. When Feed Me requests data, our data type:
   - Makes the initial API request with authentication headers
   - Checks if the response contains an `offset` parameter
   - If offset exists, makes additional requests until all records are fetched
   - Merges all record arrays into a single response
3. Feed Me processes the complete dataset as if it came from a single request

The key incompatibility was that Airtable uses cursor-based pagination with opaque strings (like `itrXXXXXXXXXXXXX/recXXXXXXXXXXXXX`) rather than numeric offsets, which Feed Me's pagination system couldn't handle.

## Support

This plugin is currently in private testing. For support, please contact:
- Email: jl@juddlyon.com

## License

This plugin is licensed under the MIT License.