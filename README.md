# FreshRSS-extensions
FreshRSS unofficial extensions

## Reddit Image
If the link in the content is recognized, the content is replaced by the linked
resource (image or video). If the link in the content is not recognized, the link
used in the title is modify to link to the content resource instead of the reddit
comment page.

At the moment, only the following resources are recognized:

&nbsp;  |match                              | type  | support
--------|-----------------------------------|-------|--------
1       | link finish by jpg, png, gif, bmp | image | full
2       | imgur link finish by gifv         | image | full
3       | imgur link finish with a token    | image | partial
4       | link finish by webm, mp4          | video | full
5       | gfycat link finish with a token   | video | full