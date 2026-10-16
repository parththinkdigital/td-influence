---
paths:
  - 'resources/views/home-*2.blade.php'
  - 'resources/views/home-light3.blade.php'
---

# Views

## Showcase pages are standalone Blade + CDN Tailwind/GSAP
The themed landing pages (home-light2, home-dark2, home-light3, etc.) are fully standalone Blade files: Tailwind via CDN (tailwind.config in-blade), GSAP + ScrollTrigger + Lenis from CDN, Font Awesome icons. They do NOT use the Vite build or resources/css. Keep this pattern when adding new themed variants. Fonts come from the font-pairs lab (Bricolage Grotesque/Unbounded display + Plus Jakarta Sans/Outfit body + Space Grotesk mono + Caveat script).

## home-light3 smooth-scroll exception (GSAP ScrollSmoother, no Lenis)
home-light3 pins `gsap@3.15.0` from jsDelivr with `ScrollTrigger`, `ScrollSmoother`, and `SplitText`, and does NOT use Lenis. Body content is wrapped in `#smooth-wrapper > #smooth-content` (direct children of `<body>`); any `position: fixed` elements (the `#siteNav` pill and `#navOverlay`) must stay OUTSIDE `#smooth-content`, otherwise the transform in `#smooth-content` makes them scroll away. `ScrollSmoother.create({ wrapper, content, smooth: 1, effects: true, normalizeScroll: true })` runs only when `typeof ScrollSmoother !== 'undefined'` and not `prefers-reduced-motion`. The other themes (home-light2, home-dark2, home-light, home-dark, home-dark3) still use cdnjs GSAP 3.12.5 + Lenis. Anchor links go through `smoother.scrollTo(target, true, 'top top+=80')`.

## home-light3 is the video-first gamified variant
home-light3 adds canvas-confetti (CDN) + a WebAudio-synth sound engine (opt-in, no asset files) on top of the standard showcase stack. It also uses scroll-snap `<video>` reel cards (Google sample mp4s + picsum posters as placeholders), a 3-step "vibe" quiz, a pointer-drag swipe-to-match roster deck, and a slider-based rate estimator. All motion is guarded by `prefers-reduced-motion` and libs are feature-detected (`typeof gsap/ScrollTrigger/ScrollSmoother/SplitText/confetti`), so the page degrades to static without CDNs. Adding a variant means: new `home-*.blade.php` + `PublicController` method (static `return view(...)` for showcase variants) + a route in `routes/web.php`.
