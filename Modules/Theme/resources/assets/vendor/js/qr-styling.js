import QRCodeStyling from 'qr-code-styling';

export function mountQR(targetId, data, logoUrl) {
  const qr = new QRCodeStyling({
    width: 320,
    height: 320,
    data,
    qrOptions: { errorCorrectionLevel: 'H' },
    dotsOptions: { type: 'rounded', color: '#000000' },     // rounded/dots
    cornersSquareOptions: { type: 'extra-rounded', color: '#000000' }, // squircle eyes
    cornersDotOptions: { type: 'rounded', color: '#000000' },
    backgroundOptions: {
      color: 'transparent'       // or "rgba(0,0,0,0)"
    },
    image: logoUrl,
    imageOptions: { margin: 8, imageSize: 0.22, hideBackgroundDots: true, crossOrigin: 'anonymous' }
  });

  const el = document.getElementById(targetId);
  if (!el) return;
  el.innerHTML = '';
  qr.append(el);
}
