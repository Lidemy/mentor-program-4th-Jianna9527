// textarea autosize
const textarea = document.querySelector('textarea');
textarea.addEventListener('input', (e) => {
  textarea.style.height = '100px';
  textarea.style.height = `${e.target.scrollHeight - 20}px`; // 扣掉padding
});
