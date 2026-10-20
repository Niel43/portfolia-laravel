/* Animated network background. Colors follow the light/dark theme. */
(() => {
  function start() {
  const c = document.createElement("canvas");
  c.id = "bg";
  c.setAttribute("aria-hidden", "true");
  document.body.prepend(c);
  const ctx = c.getContext("2d");
  const still = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const DARK = ["168,85,247", "103,232,249", "139,92,246"];
  const LIGHT = ["124,58,237", "8,145,178", "109,40,217"];
  let w, h, dots = [];

  function size() {
    const d = Math.min(devicePixelRatio || 1, 2);
    w = innerWidth; h = innerHeight;
    c.width = w * d; c.height = h * d;
    ctx.setTransform(d, 0, 0, d, 0, 0);
    const n = Math.round(Math.min(90, (w * h) / 16000));
    dots = Array.from({ length: n }, () => ({
      x: Math.random() * w, y: Math.random() * h,
      vx: (Math.random() - 0.5) * 0.35, vy: (Math.random() - 0.5) * 0.35,
      r: Math.random() * 1.8 + 0.8,
      k: Math.floor(Math.random() * 3)
    }));
  }

  function frame() {
    const light = document.documentElement.dataset.theme === "light";
    const pal = light ? LIGHT : DARK;
    ctx.clearRect(0, 0, w, h);
    if (!still) for (const a of dots) {
      a.x += a.vx; a.y += a.vy;
      if (a.x < 0 || a.x > w) a.vx *= -1;
      if (a.y < 0 || a.y > h) a.vy *= -1;
    }
    for (let i = 0; i < dots.length; i++) {
      const a = dots[i], col = pal[a.k];
      for (let j = i + 1; j < dots.length; j++) {
        const b = dots[j], d = Math.hypot(a.x - b.x, a.y - b.y);
        if (d < 150) {
          ctx.strokeStyle = `rgba(${col},${(1 - d / 150) * (light ? 0.22 : 0.35)})`;
          ctx.lineWidth = 1;
          ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke();
        }
      }
      ctx.fillStyle = `rgba(${col},${light ? 0.55 : 0.9})`;
      ctx.shadowColor = `rgb(${col})`; ctx.shadowBlur = light ? 0 : 10;
      ctx.beginPath(); ctx.arc(a.x, a.y, a.r, 0, 6.283); ctx.fill();
      ctx.shadowBlur = 0;
    }
    if (!still) requestAnimationFrame(frame);
  }

  addEventListener("resize", () => { size(); if (still) frame(); });
  // In reduced-motion mode nothing animates, so redraw when the theme changes.
  if (still) new MutationObserver(frame).observe(document.documentElement, { attributes: true, attributeFilter: ["data-theme"] });
  size(); frame();
  }
  // Works wherever the script tag is placed (head or end of body)
  if (document.body) start(); else document.addEventListener("DOMContentLoaded", start);
})();
