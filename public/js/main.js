const btnSidebar = document.getElementById('btnSidebar');
const btnClose = document.getElementById('btnClose');
const sidebar = document.getElementById('sidebar');

btnSidebar.addEventListener('click', () => {
    sidebar.classList.add('responsive');
});

btnClose.addEventListener('click', () => {
    sidebar.classList.remove('responsive');
});

const greeting = document.getElementById('greeting');

if(greeting){
const time = new Date().getHours();
if (time >= 0 && time <= 11){
    greeting.textContent = 'Selamat Pagi 🌤️';
}else if(time >= 11 && time <= 15){
    greeting.textContent = 'Selamat Siang 👋🏻';
}else if(time >= 15 && time <= 19){
    greeting.textContent = 'Selamat Sore 🌅';
}else{
    greeting.textContent = 'Selamat Malam 🌙';
}
}else{

const btnEdit = document.querySelectorAll('.btnEdit');

btnEdit.forEach(function(btn){
    btn.addEventListener('click', function() {
        const tr = btn.closest('tr');

        const inputActive = tr.querySelector('.input-text');
        const btnCancel = tr.querySelector('.btnCancel');
        const submit = tr.querySelector('.inputSubmit');

        btn.style.display = 'none';
        btnCancel.style.display = 'inline';
        submit.style.display = 'inline';
        inputActive.removeAttribute('disabled');
        inputActive.focus();

        btnCancel.addEventListener('click', function() {
            btn.style.display = 'inline';
            btnCancel.style.display = 'none';
            submit.style.display = 'none';
            inputActive.setAttribute('disabled', 'true');
        });
    });
})


const label = document.getElementById('label_area');
const inputLabel = document.getElementById('nama_area');

const bgLabel = document.getElementById('banner-2');
const warnaLabel = document.getElementById('warna_label');

inputLabel.addEventListener('input', function(e) {
    label.textContent = e.target.value;
});

warnaLabel.addEventListener('input', function(e) {
    bgLabel.style.backgroundColor = e.target.value;
});
}
