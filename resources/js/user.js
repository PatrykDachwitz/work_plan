

window.addEventListener('load',  () => {
    const btnBodyActive = document.querySelectorAll('.button-active-body');
    btnBodyActive.forEach(btn => {
       btn.addEventListener('click', (e) => {
          e.preventDefault();
          document.querySelector('div[data-body].active').classList.add('d-none');
          document.querySelector('div[data-body].active').classList.remove('active');
          document.querySelector(`div[data-body="${btn.dataset.body}"]`).classList.remove('d-none');
          document.querySelector(`div[data-body="${btn.dataset.body}"]`).classList.add('active');
       });
    });
});