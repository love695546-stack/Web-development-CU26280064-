<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Live Search</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Live Product Search</h2>
<input type="text" id="search" placeholder="Type a product name..." autocomplete="off" style="max-width:380px">
<ul id="suggestions"></ul>

<script>
const input = document.getElementById('search');
const list  = document.getElementById('suggestions');
let timer;

input.addEventListener('input', () => {
    clearTimeout(timer);
    const term = input.value.trim();
    if (term === '') { list.innerHTML = ''; return; }

    timer = setTimeout(() => {                 // 250 ms debounce
        fetch('search_suggest.php?term=' + encodeURIComponent(term))
            .then(res => res.json())
            .then(data => {
                list.innerHTML = '';
                if (data.length === 0) {
                    const li = document.createElement('li');
                    li.textContent = 'No results found';
                    list.appendChild(li);
                    return;
                }
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item.name + ' - Rs. ' + item.price;   // textContent = XSS safe
                    li.addEventListener('click', () => {
                        input.value = item.name;
                        list.innerHTML = '';
                    });
                    list.appendChild(li);
                });
            })
            .catch(() => { list.innerHTML = '<li>Error loading suggestions</li>'; });
    }, 250);
});
</script>
</body></html>
