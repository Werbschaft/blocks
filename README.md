# Blocks

This is a temporary repository to write documentation and collect docs, issues and feedback for our new blocks field. Follow announcements and discussions on Discord for more information: https://chat.getkirby.com

![blocks](https://user-images.githubusercontent.com/24532/97420723-f921ab00-190b-11eb-81f3-196a7b8b51ea.png)

## About the new blocks field

The Kirby Builder by Tim Ötting is one of the most popular plugins out there and together with Tim we decided to add it to the core. We've rewritten it from scratch and merged it with our popular Editor plugin. The new field is called Blocks

## Alpha

The new field is currently in alpha. 

## Download

[https://github.com/getkirby/kirby/archive/feature/blocks.zip](https://github.com/getkirby/kirby/archive/feature/blocks.zip)

This is a complete kirby folder. Replace your current installation with it and **make sure to wipe your media folder**. It might also be required to flush the browser cache if the blocks field does not show up correctly. 

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
This will give you the default block types (Heading, Text, Image, Quote, Video, Code)


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

### Use Kirby's default fieldsets

When you define your own fieldsets, Kirby's default fieldsets will be disabled and you have to activate them to use them. 

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

### Disable default fieldsets

If you don't want to use any of the default fieldsets, you can disable them in your fieldset definition:

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsets:
      heading: false
      text: false
```

## Block Selector Setup

When you have a lot of block types you can now group them.

**Ungrouped (default)**

![ungrouped-fieldsets](https://user-images.githubusercontent.com/24532/97420762-02127c80-190c-11eb-94e1-a4b38b14de41.png)

The ungrouped selector will automatically show up, if you just define your fieldsets.

**Grouped**

![grouped-fieldsets](https://user-images.githubusercontent.com/24532/97420757-00e14f80-190c-11eb-947e-3789a576b5b2.png)

With the `fieldsetGroups` option you can take control and create such groups though: 

```yaml
fields:
  blocks:
    label: Text
    type: blocks
    fieldsetGroups:
      text:
        label: Text
        fieldsets:
          - text
          - heading
          - quote
      media:
        label: Media
        fieldsets:
          - image
          - gallery
          - video
      code:
        label: Code
        fieldsets:
          - code
          - kirbytext
```

## Config

You can configure the default setup of your Blocks field in your `config.php`

```php
<?php

return [
    'blocks' => [
        'fieldsets' => [
            'heading' => 'blocks/heading',
            'text'    => 'blocks/text',
            'image'   => 'blocks/image',
	    'video'   => 'blocks/video'
        ],
        'fieldsetGroups' => [
            'text' => [
                'label' => 'Text',
                'fieldsets' => [
                    'text',
                    'heading'
                ]
            ],
            'media' => [
                'label' => 'Media',
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
