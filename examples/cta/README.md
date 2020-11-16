# Simple CTA Button plugin

This will add a call to action button block type to the blocks field.

## Installation 

Copy the contents of this cta folder to `/site/plugins/cta`

## Usage

You can add it to your block field like this:

```yaml
fields:
    blocks:
        type: blocks
        fieldsets:
            - heading
            - text
            - cta
```
