const faqBlock = document.querySelectorAll('.faq_block');
faqBlock.forEach((block) => {
  block.addEventListener('click', (e) => {
    const element = e.target;
    element.classList.toggle('hide-block');
  });
});
