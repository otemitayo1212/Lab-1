const barItems = [
   { itemName: "Portfolio", ref: "#portfolio"},
   { itemName: "Our Team", ref: "#team"},
   { itemName: "Contact", ref: "#contact"}
]


document.addEventListener("DOMContentLoaded", function() {
   const navLinks = document.querySelector('.nav-links');
   navLinks.innerHTML = "";
   barItems.forEach(item => {
      const li = document.createElement('li');
      const a = document.createElement('a');
      a.href = item.ref;
      a.textContent = item.itemName;
      li.appendChild(a);
      navLinks.appendChild(li);
   });
});