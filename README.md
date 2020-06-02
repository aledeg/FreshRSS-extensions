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
2 | imgur links finished by gifv | image | full
3 | imgur links finished with a token | image | partial
4 | links finished by webm, mp4 | video | full
5 | gfycat links finished with a token | video | full
6 | redgifs links finished with a token | video | full

### Configuration

Item | Detail | Default
-----|--------|--------
Media height | Select a media height in viewport percentage | 70%
Muted video | Choose if videos are muted or not | True
Display images | Choose if images are displayed | True
Display videos | Choose if videos are displayed | True
