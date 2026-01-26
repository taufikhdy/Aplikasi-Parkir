const btnSidebar = document.getElementById('btnSidebar');
const btnClose = document.getElementById('btnClose');
const sidebar = document.getElementById('sidebar');

btnSidebar.addEventListener('click', () => {
    sidebar.classList.add('responsive');
});

btnClose.addEventListener('click', () => {
    sidebar.classList.remove('responsive');
});


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

