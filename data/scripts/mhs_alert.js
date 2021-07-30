// BUAT ELEMEN BARU
const alert = document.createElement('a');
const teksAlert = document.createTextNode('data yang anda cari tidak ada ! klik disini untuk kembali');

// SIMPAN TULISAN KEDALAM ELEMENT
alert.appendChild(teksAlert);

// SIMPAN ELEMENT BARU KEDALAM CONTAINER
// select wadah untuk ditempati
const container = document.getElementsByClassName('container')[0];

container.appendChild(alert);

// MENGATUR PROPERTIS CSS (STYLE)	
alert.style.color = "white";
alert.style.fontStyle = "italic";
alert.style.textDecoration = "none";

alert.style.margin = "15px auto";

alert.style.cursor = "pointer";

// ADD ATTRIBUTE PADA ELEMENT A
alert.setAttribute('href', 'index.php');