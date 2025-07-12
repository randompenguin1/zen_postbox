# Zen Postbox

This is a Friendica add-on that adds a Jot Plugin tool button to the Compose editor allowing users to easily select any of the "Postbox" color backgrounds.

Postbox color backgrounds are similar to a Facebook feature for text-only posts, except Friendica's allows any arbitrary content and users may have more than on Postbox per post. Support for Postbox is built into the Bookface 1.6+ scheme for Frio, but this addon will enable it regardless of what theme/scheme is being used.

This add-on also adds support for displaying Postbox content in all feeds no matter what theeme is in use.

**Animated backgrounds are ONLY available on servers that have either the _Postbox_ or _Zen Postbox_ add-on installed**

_**Note**: It has "zen" on the beginning of the name just to make the add-on load AFTER other Jot Plugins. In particular the "Smileybutton" add-on which has a typo that clears any Jot Plugins that load before it._

## Getting started

1. Place the "zen_postbox" folder in your _friendica/addons_ subfolder.
2. Go to the Main _Menu > Admin > Addons_ and enable "Zen Postbox"
3. On the Compose Modal or Compose Page you should see a rainbox button that opens a background selector.

## Using Zen Postbox

1. Open the message Compose modal or Page
2. To wrap text, etc., in a Postbox select it in the message editor.
3. Press the rainbow button at the bottom of the editor.
4. Select which Postbox background you'd like to wrap the text in.
5. Press the "Preview" tab to see what it will look like.

If no text is selected in the editor a Postbox will be appeneded to the text area with "..." for content. Replace the "..." with your text, etc.

There is a visual reference of available styles at: _/addon/postbox/view/sampler.htm_

While Postbox allows more content than the Facebook version (which is text only), there are limitations due to how Friendica parses BBcode.

**It is STRONGLY recommended you only use Postboxes with text and emoji.**

BBcodes you CANNOT put inside a Postbox:

* [class] (which means you can’t nest Postboxes)
* [hr]
* [h1],[h2],[h3], etc…
* [table],[tr],[th],[td]
* [list],[ul],[ol]
* [quote]
* [abstract]
* [spoiler]
* [map]
* [code]

BBcodes that do not work as intended inside a Postbox:

* [pre]
* [noparse]
* [nobb]

The text will show but will be styled and centered.

BBcodes that **CAN BE INSIDE** a Postbox:
* [i], [b], [u], [o], [s] _(bold has no visible effect)_
* [url]
* [img]
* [audio]
* [video]

And any plain text, including emoji

If you are using Markdown formatting what you can and can’t put in a Postbox is similar, with the exception that (because of how Markdown is parsed into BBcode) you can’t have both a URL and an image in the same Postbox. You *can* however put inline `code` in a Postbox with Markdown where BBcode cannot.

## Known Issues

- Postboxes are not shown on other platforms when your post is shared.
- Postboxes are not shown in third-party apps (at least none do yet)
- Some of the animated backgrounds have glitches in older WebKit browsers
- Currently Postbox BBcode is not parsed correctly by either Diaspora or Hubzilla

## Changelog
1.3 (12 July 2025)
* Fixed issue where postboxes only worked on pages with Compose modal, they now work sitewide.
* Code updates for compatibility with Friendica 2025.7 Release Candidate.

1.2 (24 June 2025)
* Changed stylesheet URL so it no longer appends Friendica version but addon version. This also makes the addon compatible with the Friendica 2025 dev version.
* Fixed missing images for animated backgrounds.

1.1 (28 April 2025)
* Changed names of solid colors to match HTML named colors
* Added 24 new solid colors.
* Added 5 new gradient backgrounds.
* Added 17 new pattern and 11 animated backgrounds.
* Fixed load-order for main stylesheet [Issue #1]


1.0 (25 March 2025)
* Initial Release for Friendica 'Interrupted Fern' 2024.12

## Authors and acknowledgment
Random Penguin <https://gitlab.com/randompenguin>

## License
Assuming AGPL for add-ons since that's the license Friendica is under

## Project status
Unsupported by Friendica devs.