> **Notice**: this repository is now archived because it was complicated to maintain 3 extensions in a single repository. Now those 3 extensions have their own
> repository. Here are the links to those:
> 
> - [aledeg/xExtension-DateFormat: A FreshRSS extension to format dates](https://github.com/aledeg/xExtension-DateFormat)
> - [aledeg/xExtension-LatexSupport: A FreshRSS extension which add LaTeX support](https://github.com/aledeg/xExtension-LatexSupport)
> - [aledeg/xExtension-RedditImage: A FreshRSS extension to process Reddit feeds](https://github.com/aledeg/xExtension-RedditImage)
> 
> I've kept the history of changes and all open issues. At the moment, I haven't transfered tags and release since I don't know if it's a good idea.


# FreshRSS-extensions
FreshRSS unofficial extensions

## Reddit Image
If the link in the content is recognized, the content is replaced by the linked
resource (image or video). If the link in the content is not recognized, the link
used in the title is modified to link to the content resource instead of the reddit
comment page.

At the moment, only the following resources are recognized:

&nbsp; |match | type | support
-------|------|------|--------
1 | links finished by jpg, png, gif, bmp | image | full
2 | imgur links finished by gifv | video | full
3 | imgur links finished with a token | image | partial
4 | links finished by webm, mp4 | video | full
5 | gfycat links finished with a token | video | full
6 | redgifs links finished with a token | video | full
7 | reddit links finished with a token | video | limited
8 | reddit image galleries | image | limited

### Configuration

Item | Detail | Default
-----|--------|--------
Media height | Select a media height in viewport percentage | 70%
Muted video | Choose if videos are muted or not | True
Display images | Choose if images are displayed | True
Display videos | Choose if videos are displayed | True
Display original content | Choose if original contents are displayed | True

## Latex Support
When enabled, it will load Mathjax to render LaTeX content.

## Date Format
When enabled, users will be able to format dates in the interface.
There are different options to handle the date:
- Display the dates relative to the browser current date,
- Display the dates adjusted to the browser current date,
- Display the dates in 12-hours format,
- Display the dates with a custom format.

> The custom format must follow the format supported by the `moment.js` library.
> For more information, please check the `moment.js` [format documentation](https://momentjs.com/docs/#/displaying/format/).

> If you want to introduce a carriage return (`\n`) in the date, you must enclose it between square brackets (example: `HH:mm[\n]D/M/YYYY`).
> This alone won't display it since the browser will ignore them by default.
> Thus you need to add a CSS rule to override that behavior:
> ```css
> .item.date time {
>     white-space: pre;
> }
> ```

**Note:**  
There is a conflit with the "Mobile scroll menu" extension which prevents the date formatting on pages loaded in the background.
It seems to occur only when using Firefox though.
