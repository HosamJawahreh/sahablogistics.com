# Client-Approved Website Design Specification

## Screenshots — authority order
1. `design-reference/client-approved-full-page.png` (1024 × 1536) is the complete target layout and section hierarchy.
2. `design-reference/client-approved-hero-strip-397x96.png` (397 × 96) is the exact compact hero composition reference. It is a tiny screenshot; do not stretch it, use it as a production image, or include its embedded text as artwork.
3. `design-reference/hero-source-high-resolution.png` plus `source-assets/images/hero-aqaba-logistics.webp`, `hero-aqaba-desktop.webp`, and `hero-aqaba-mobile.webp` are the actual high-resolution photography sources.

## Exact hero composition requirement
The client explicitly wants the hero to closely reproduce the second screenshot:
- compact pale-blue header with the approved logo at left;
- navigation across the top and a strong blue `Request a Quote` action;
- hero text aligned to the LEFT;
- headline `Connecting Jordan with Aqaba Port and Beyond`;
- supporting sentence about reliable, cost-effective transport from all areas of Jordan to Aqaba Port and vice versa;
- two actions: `Request a Quote` and `Our Services`;
- large white freight truck visually dominant in the CENTER-RIGHT;
- Aqaba-style seaport, container ship, cranes and warm sunset visible on the RIGHT;
- dark-to-transparent/blue contrast behind text, but preserve the bright sky and golden port atmosphere;
- a horizontal four-benefit strip directly below the hero.
Use the high-resolution `hero-aqaba-desktop.webp` / `hero-aqaba-logistics.webp`, with carefully tuned `background-position` / `object-position`. Keep the entire truck visible. Do not simply set `background-size: cover` without visual inspection; adjust the crop at 1440px, 1280px, 1024px, 768px, 430px and 390px. Use the mobile hero crop or a dedicated mobile layout to keep both text and truck visible.
- The hero screenshot is 397×96 and its layout is more panoramic than the source image. Use it as a layout guide only; recreate every text/button in real HTML.
- Header and hero should feel like one continuous premium masthead. Keep the benefit strip adjacent to the hero.
- If applying the brand logo to the truck trailer, use the supplied approved logo as a subtle image overlay only if the perspective looks natural. Do not fake logo text or distort the official logo. The truck photo itself need not have a logo if a realistic overlay cannot be produced.

## Full-page section order
1. Header / navigation
2. Hero + benefit strip
3. About Us with Aqaba port photo
4. Vision & Mission in one harmonious panel
5. Service: Jordan – Aqaba Port Transportation, two directions
6. How We Work — four steps, draft until client approves
7. Global Reach / Beyond Borders, using only the client's broad positioning
8. Contact: contact details + enquiry form + map
9. Footer: logo, bilingual company name, quick links, contact info, copyright
10. Floating WhatsApp button at bottom-right

## Visual direction
The page should be a balanced, moderately light corporate design, not fully white and not fully dark:
- pale ice-blue/white content sections;
- soft blue gradients and translucent pale panels;
- navy text and selected deep-blue bands;
- rich blue / cyan accent buttons and icons;
- deep navy footer for anchoring.
Keep the overall composition from the full-page reference, including section rhythm, curve treatments, proportions, form/map layout, and footer.

## Responsive requirements
- Desktop: keep the wide horizontal hero and multi-column layout.
- Tablet: reduce content widths and reflow columns without losing the hero's truck / port composition.
- Mobile: stack content, ensure headline and CTA are readable, show truck image in a dedicated image region if necessary, make forms full width, keep map legible, and avoid floating WhatsApp overlap with form buttons.
