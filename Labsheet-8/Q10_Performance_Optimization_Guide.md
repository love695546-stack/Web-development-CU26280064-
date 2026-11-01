# Question 10: Website Asset Optimization Guide

## Best Practices for High Performance & Speed

1. **Image Compression & Next-Gen Formats:**
   - Convert standard `.png` / `.jpg` images to `.webp` or `.avif` formats.
   - Use dynamic image resizing with HTML `srcset` attributes for responsive mobile loading.

2. **CSS & JS Minification:**
   - Minify production stylesheets using `cssnano` or UglifyCSS.
   - Compress JavaScript scripts using Terser or Babel minification tool.

3. **Browser Caching & CDN:**
   - Enable `Cache-Control` headers for static media assets (`max-age=31536000`).
   - Deliver assets through high-speed CDN edge nodes.

4. **Lazy Loading:**
   - Add `loading="lazy"` attribute to all below-the-fold images and embedded iframes.
