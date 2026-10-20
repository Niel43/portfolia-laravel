/* Light / dark mode. Load this in the <head> of every page so the right theme shows before the page paints. */
(() => {
  const KEY = "portfolia-theme";
  const root = document.documentElement;
  let saved = null;
  try { saved = localStorage.getItem(KEY); } catch (e) {}
  // First visit follows the device setting; after that the user's choice is remembered.
  const system = matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
  root.dataset.theme = saved || system;

  const ICON = (d) => `<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${d}</svg>`;
  const SUN = ICON('<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>');
  const MOON = ICON('<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>');

  document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector(".nav nav");
    if (!nav) return;
    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = "theme-btn";
    const paint = () => {
      const dark = root.dataset.theme === "dark";
      btn.innerHTML = dark ? SUN : MOON;
      const label = dark ? "Switch to light mode" : "Switch to dark mode";
      btn.setAttribute("aria-label", label);
      btn.title = label;
    };
    btn.onclick = () => {
      const next = root.dataset.theme === "dark" ? "light" : "dark";
      root.dataset.theme = next;
      try { localStorage.setItem(KEY, next); } catch (e) {}
      paint();
    };
    paint();
    nav.append(btn);
  });
})();
