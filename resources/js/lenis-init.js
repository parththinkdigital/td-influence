import Lenis from 'lenis'

// Initialize Lenis smooth scroll
const lenis = new Lenis({
  duration: 0.9,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
  orientation: 'vertical',
  gestureOrientation: 'vertical',
  smoothWheel: true,
  wheelMultiplier: 1.1,
  touchMultiplier: 1.5,
  syncTouch: false,
  infinite: false,
})

// Animation frame loop
function raf(time) {
  lenis.raf(time)
  requestAnimationFrame(raf)
}

requestAnimationFrame(raf)

// Make lenis available globally if needed
window.lenis = lenis
