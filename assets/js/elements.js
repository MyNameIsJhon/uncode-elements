(function () {
  var items = document.querySelectorAll(".es-anim");
  if (!items.length) return;
  if (!("IntersectionObserver" in window)) {
    for (var i = 0; i < items.length; i++) items[i].classList.add("es-in");
    return;
  }
  var io = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (ent) {
        if (ent.isIntersecting) {
          var el = ent.target;
          var dur = el.getAttribute("data-es-dur") || "600";
          var delay = el.getAttribute("data-es-delay") || "0";
          el.style.setProperty("--es-dur", dur + "ms");
          el.style.setProperty("--es-delay", delay + "ms");
          el.classList.add("es-in");
          io.unobserve(el);
        }
      });
    },
    { threshold: 0.2 },
  );
  items.forEach(function (el) {
    io.observe(el);
  });
})();
