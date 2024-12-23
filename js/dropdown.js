
 const userMenuToggle = document.getElementById('user-menu-toggle');
 const dropdownMenu = document.getElementById('dropdown-menu');

 userMenuToggle.addEventListener('click', () => {
     dropdownMenu.classList.toggle('hidden');
 });


 document.addEventListener('click', (e) => {
     if (!userMenuToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
         dropdownMenu.classList.add('hidden');
     }
 });