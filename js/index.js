const puform = document.getElementsByName('puform')[0];
const dropdownload = () => {
    puform.submit();
}

const state_dd = document.getElementById('state_dd');
state_dd.addEventListener('change', dropdownload);

// const lga_dd = document.getElementById('lga_dd');
// lga_dd.addEventListener('change', dropdownload);

const generate = document.getElementById('generate');
generate.addEventListener('click', e => {
    e.preventDefault();
    puform.action += '?act=generate';
    puform.submit();
});

// const ward_dd = document.getElementById('ward_dd');
// ward_dd.addEventListener('change', dropdownload);

