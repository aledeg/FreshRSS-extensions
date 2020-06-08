// https://github.com/mathjax/MathJax/releases/tag/3.0.5
window.MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\\(', '\\)']]
  }
};

document.body.addEventListener('freshrss:load-more', e => {
  MathJax.typeset()
});
