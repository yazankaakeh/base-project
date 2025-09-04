// resources/js/cropper-init.js
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

let cropper = null;

function initCropper({ url, domId = 'crop-image', width = 300, height = 300 }) {
  const img = document.getElementById(domId);
  const btn = document.getElementById('crop-btn');
  if (!img || !btn) return;

  img.style.display = 'block';
  img.src = url;

  // لو فيه كروبر سابق، دمّره
  if (img._cropper) {
    img._cropper.destroy();
    img._cropper = null;
  }

  // هيّئ الكروبر بمقاس ثابت
  const instance = new Cropper(img, {
    viewMode: 1,
    dragMode: 'move',
    cropBoxResizable: false,
    cropBoxMovable: false,
    ready() {
      this.setCropBoxData({
        width,
        height,
        left: Math.max(0, (img.clientWidth - width) / 2),
        top: Math.max(0, (img.clientHeight - height) / 2)
      });
    }
  });

  img._cropper = instance;
  cropper = instance;
  btn.style.display = 'inline-flex';

  // زر القصّ والرفع
  btn.onclick = async () => {
    if (!cropper) return;

    // خزّن الناتج بقياس ثابت
    const canvas = cropper.getCroppedCanvas({ width, height });
    if (!canvas) return;

    // حوّله Blob ثم File
    canvas.toBlob(async (blob) => {
      if (!blob) return;
      const file = new File([blob], 'cropped.jpg', { type: 'image/jpeg' });

      // ارفع الملف إلى خاصية Livewire "cropped"
      // ملاحظة: مع Livewire 3 تقدر تنادي upload عبر $wire
      await window.Livewire.findClosestComponent(btn).upload('cropped', file, () => {
        // success
      }, (err) => {
        console.error(err);
      });

      // استدعِ الميثود لحفظ الملف
      await window.Livewire.findClosestComponent(btn).call('saveCropped');
    }, 'image/jpeg', 0.92);
  };
}

document.addEventListener('livewire:load', () => {
  // حينما يرسل السيرفر الحدث بعد الرفع
  Livewire.on('imageUploaded', ({ url, domId }) => {
    // استخدم wire:ignore حتى ما يُعاد تدمير الكروبر
    initCropper({ url, domId, width: 300, height: 300 });
  });

  // (اختياري) بعد الحفظ
  Livewire.on('croppedSaved', ({ path }) => {
    // سوي toast / تحدّث UI حسب رغبتك
    console.log('Saved at:', path);
  });

  // إعادة التهيئة بعد أي تحديث من Livewire إذا لزم
  Livewire.hook('message.processed', () => {

  });
});
