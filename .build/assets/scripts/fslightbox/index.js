/**
 * Lightbox without jQuery
 * https://fslightbox.com/
 *
 * Since 7.5.2022 mark@sayhello.ch
 */

require('fslightbox');

const linked_images = document.querySelectorAll(
    'a[href*=".jpg"], a[href*=".png"], a[href*=".gif"], a[href*=".webp"], a[data-fslightbox]'
);

if (linked_images.length) {
    linked_images.forEach(link => {
        link.dataset.fslightbox = true;
    });

    refreshFsLightbox();
}
