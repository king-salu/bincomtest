const newpuform = document.getElementsByName('newpuform')[0];
const dropdownload = () => {
    newpuform.submit();
}

const state_dd = document.getElementById('state_dd');
state_dd.addEventListener('change', dropdownload);

const lga_dd = document.getElementById('lga_dd');
lga_dd.addEventListener('change', dropdownload);

const ward_dd = document.getElementById('ward_dd');
ward_dd.addEventListener('change', dropdownload);

const save = document.getElementById('save');
save.addEventListener('click', e => {
    e.preventDefault();
    newpuform.action += '?act=save';
    newpuform.submit();
});