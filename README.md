# Indie Studio

## Introduction
A microformat/schema theme aimed at design professionals. The content comes first with simple image grids. A simple and elegant way to push your content to the world with 'POSSE' (see https://indieweb.org/POSSE) and backfeed. 

Now updated so that it is 100% accessible according to Google's Lighthouse. All you need to do ensure all images are given alt tags, and your font colours are right!

## Image Reveal Built In
Images can be set to animate into view as the reader scrolls down the page. All that is required is for 2 classes to be set on the image.


```
"sr top" - Animates the image from the top
"sr right" - Animates the image from the right
"sr bottom" - Animates the image from the bottom
"sr left" - Animates the image from the left
```

Simples!

## Post Formats
To allow you to pick between a standard blog, or something more focused we have included post formats within the theme.

### Image
This returns a slightly different post page, without parralax. This is to make sure the reader can fully appreciate the image!

### Video
The video post format uses a different module in the feed list. If the first (or only) video in the post is embedded from Youtube or Vimeo then the video thumbnail is used. If a different embed provider is used you must use a featured image.

## Developer Friendly
Built with developers in mind. File organsation has been considered to make a more efficent workflow. Gulp has been used to process all of those boring tasks. That has allowed us to keep the JS and CSS in small, easy to understand files.

To find out more about Gulp check out the [Gulp WordPress Framework](https://github.com/ahmadawais/WPGulp).

The code is documented as per [PHPDocs](https://www.phpdoc.org/) specification. This allows all functions ect to be outputted into a specification document if required.