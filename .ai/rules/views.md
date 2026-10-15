---
paths:
  - 'resources/views/home-*2.blade.php'
---

# Views

## Showcase pages are standalone Blade + CDN Tailwind/GSAP
The themed landing pages (home-light2, home-dark2, etc.) are fully standalone Blade files: Tailwind via CDN (tailwind.config in-blade), GSAP 3.12.5 + ScrollTrigger + Lenis from CDN, Font Awesome icons. They do NOT use the Vite build or resources/css. Keep this pattern when adding new themed variants. Fonts come from the font-pairs lab (Bricolage Grotesque/Unbounded display + Plus Jakarta Sans/Outfit body + Space Grotesk mono + Caveat script).
