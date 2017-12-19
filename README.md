# FreshRSS-extensions
FreshRSS unofficial extensions

## Reddit Image
Replace the link to the Reddit topic with the link to the resource in the content.
If the resource in the content is a link to an image or a video, the image or the
video is added to the content.

At the moment, only the following resources are supported in the content modification
process:

&nbsp;  |match                              | type  | support
--------|-----------------------------------|-------|--------
1       | link finish by jpg, png, gif, bmp | image | full
2       | imgur link finish by gifv         | image | full
3       | imgur link finish with a token    | image | partial
4       | link finish by webm, mp4          | video | full
5       | gfycat link finish with a token   | video | partial