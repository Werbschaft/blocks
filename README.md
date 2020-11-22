# Blocks

This is a temporary repository to write documentation and collect docs, issues and feedback for our new blocks field. Follow announcements and discussions on Discord for more information: https://chat.getkirby.com

![blocks](https://user-images.githubusercontent.com/24532/97420723-f921ab00-190b-11eb-81f3-196a7b8b51ea.png)

## About the new blocks field

The Kirby Builder by Tim Ötting is one of the most popular plugins out there and together with Tim we decided to add it to the core. We've rewritten it from scratch and merged it with our popular Editor plugin. The new field is called Blocks

## Alpha

The new field is currently in alpha.

## Download

[https://github.com/getkirby/kirby/archive/feature/blocks.zip](https://github.com/getkirby/kirby/archive/feature/blocks.zip)

This is a complete kirby folder. Replace your current installation with it and **make sure to wipe your media folder**. It might also be required to flush the browser cache if the blocks field does not show up correctly. Also, for now, you will have to remove the Editor and Builder plugins in your Kirby installation, as they are not compatible with the Blocks field.

## Issues

Please report issues here on Github: https://github.com/getkirby/blocks/issues

----

## Docs

### Basic usage

```yaml
fields:
  blocks:
    label: Text
    type: blocks
```
This will give you the default block types (Heading, Text, Image, Gallery, Quote, Video, Code, Kirbytext)


### Add your own block types

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      pages:
        icon: page
        name: Pages
        fields:
          pages:
            type: pages
            layout: cards
```

**When you define your own fieldsets, Kirby's default fieldsets will be disabled and you have to activate them to use them.**

### Combine custom and default fieldsets

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      heading: true
      text: true
      image: true
      quote: true
      code: true
      gallery: true
      video: true
      kirbytext: true
      pages:
        icon: page
        name: Pages
        fields:
          pages:
            type: pages
            layout: cards
```

### Overwriting an existing fieldset

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      heading:
        extends: blocks/heading
        fields:
          class:
            type: text
      pages:
        icon: page
        name: Pages
        fields:
          pages:
            type: pages
            layout: cards
```

## Block Selector Setup

When you have a lot of block types you can now group them.

**Ungrouped (default)**

![ungrouped-fieldsets](https://user-images.githubusercontent.com/24532/97420762-02127c80-190c-11eb-94e1-a4b38b14de41.png)

The ungrouped selector will automatically show up, if you just define your fieldsets.

**Grouped**

![grouped-fieldsets](https://user-images.githubusercontent.com/24532/97420757-00e14f80-190c-11eb-947e-3789a576b5b2.png)

You can use the group fieldset, to group multiple fieldsets

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      text:
        label: Text
        type: group
        fieldsets:
          - text
          - heading
          - quote
      media:
        label: Media
        type: group
        fieldsets:
          - image
          - gallery
          - video
      code:
        label: Code
        type: group
        fieldsets:
          - code
          - kirbytext
```

By default grouped fieldsets are always open, but it is also possible to close them in the block selection modal with the new option `open: false`

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      text:
        label: Text
        type: group
        open: false
        fieldsets:
          - text
          - heading
          - quote
```


## Config

You can configure the default setup of your Blocks field in your `config.php`

```php
<?php

return [
    'blocks' => [
        'fieldsets' => [
            'text' => [
                'label' => 'Text',
		'type' => 'group',
                'fieldsets' => [
                    'text',
                    'heading'
                ]
            ],
            'media' => [
                'label' => 'Media',
		'type' => 'group',
                'fieldsets' => [
                    'image',
		    'video'
                ]
            ]
        ]
    ]
];
```

## New ways to work with blocks in your block snippets

Your old block snippets should work as expected, but a few things are deprecated and you should follow the new way of doing things in the snippets:

### The `$block` object

The new `$block` object replaces `$data` Yo can still use `$data` instead, but consider this deprecated. The `$block` object comes with the following methods:

`$block->id()` (replaces `$data->_uid()`)

`$block->type()` (replaces `$data->_key()`)

You can still call all your fields directly. I.e.

`$block->title()`

`$block->myField()`

etc.

You can also access fields via the content method if you want to use reserved words for fieldnames:

`$block->content()->id()`

`$block->content()->type()`

### All block methods

`$block->__toString()`

*You can render a block by simply echoing it / converting it to a string* <?= $block ?>

`$block->content()`

Returns the content object with all block fields.

`$block->hasNext()`

*Checks if there's a next block*

`$block->hasPrev()`

*Checks if there's a previous block*

`$block->id()`

*Returns the block id. Block IDs are now created in the universal UUID v4 format.*

`$block->indexOf()`

*Returns the index of the block in the siblings collection*

`$block->is($anotherBlock)`

*Compares the block to another one*

`$block->isEmpty()`

*Checks if the block is empty*

`$block->isFirst()`

*Checks if this is the first block*

`$block->isHidden()`

*Checks if the block has been hidden by the editor*

`$block->isLast()`

*Checks if this is the last block*

`$block->isNotEmpty()`

*Checks if the block has some content*

`$block->isNth($index)`

*Checks if this block is at the current index*

`$block->kirby()`

*Returns the Kirby instance*

`$block->next()`

*Returns the next block object*

`$block->nextAll()`

*Returns all block objects that follow after this block as a Blocks collection*

`$block->parent()`

*Returns the parent model (site, page, file, user)*

`$block->prev()`

*Returns the previous block object*

`$block->prevAll()`

*Returns all block objects that come before this block as a Blocks collection*

`$block->siblings()`

*Returns a collection with all sibling blocks*

`$block->snippet()`

*Returns the name / path to the snippet, which will be used to render the block*

`$block->toArray()`

Turns the block data to an associative array

`$block->toField()`

*Converts the block* *to html first and then places that inside a field object. This can be used further with all available field methods*

`$block->toHtml()`

*Converts the block to HTML with the matching snippet*

`$block->type()`

*Returns the block type, which is defined by the key of your fieldset definition.*

### The `$blocks` collection

All blocks are part of a blocks collection. It follows the regular stuff you can do with collections in Kirby. But the nicest part is that you can now turn the entire list of blocks into HTML by simply echoing it

```php
<?= $page->myBlocksField()->toBlocks() ?>
```

Of course it's still possible to use a foreach loop instead:

```php
<?php foreach ($page->myBlocksField()->toBlocks() as $block): ?>
<?= $block ?>
<?php endforeach ?>
```

or the good old version by manually loading snippets

```php
<?php foreach ($page->myBlocksField()->toBlocks() as $block): ?>
<?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
<?php endforeach ?>
```

if you want to keep the `$data` variable instead of `$block` this is of course possible as well.

```php
<?php foreach ($page->myBlocksField()->toBlocks() as $block): ?>
<?php snippet('blocks/' . $block->type(), ['data' => $block]) ?>
<?php endforeach ?>
```

Rendering the block by converting it to a string will automatically pass `$block` and `$data` to the snippet for enhanced compatibility with the plugin

## The Layout field

In addition to the blocks field we also have a new layout field for complex block layouts in multiple columns.

```yaml
fields:
  layout:
    type: layout
    layouts:
      - "1/1"
      - "1/2, 1/2"
      - "1/4, 1/4, 1/4, 1/4"
      - "1/3, 2/3"
      - "2/3, 1/3"
      - "1/3, 1/3, 1/3"
```

The layout field also accepts the `fieldsets` option from the blocks field to control blocks in columns.

### How to render layouts in your templates

There's a new `toLayouts` field method, which you can use to get a structured collection of layout objects to create your HTML.

```html
<?php foreach ($page->layout()->toLayouts() as $layout): ?>
<section class="grid" id="<?= $layout->id() ?>">
  <?php foreach ($layout->columns() as $column): ?>
  <div class="column" style="--span:<?= $column->span() ?>">
    <div class="blocks">
      <?= $column->blocks() ?>
    </div>
  </div>
  <?php endforeach ?>
</section>
<?php endforeach ?>
```

### Calculate the column span value

Each column in a layout as a `$column->width()` method which will return the width defined in the blueprint. (i.e. `1/2`) but for many grid systems you need to know how many columns the current column should span in the grid. This can be done with the `$column->span()` method. The method calculates with a 12-column grid by default. So for example, if your column width is `1/2` the span method would return a value of 6. If you are working with a different kind of grid system you can pass the number of columns like this: `$column->span(6)`:

```html
<?php foreach ($page->layout()->toLayouts() as $layout): ?>
<section class="6-column-grid" id="<?= $layout->id() ?>">
  <?php foreach ($layout->columns() as $column): ?>
  <div class="column" style="--span:<?= $column->span(6) ?>">
    <div class="blocks">
      <?= $column->blocks() ?>
    </div>
  </div>
  <?php endforeach ?>
</section>
<?php endforeach ?>
```

### Troubleshooting

If the Blocks field is not working, especially right after installation or updating to a new version, make sure to check the following things:

- The `media` folder was wiped after the installation
- Your browser's cache was flushed
- Editor and Builder plugins are removed from your Kirby installation (Blocks is currently not compatible with those, in a future release they will work alongside)

If none of this helps, please open an issue on the [Blocks Github Page](https://github.com/getkirby/blocks/issues) and describe the exact issue in detail.
