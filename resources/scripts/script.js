const barItems = [
   { itemName: "Portfolio", ref: "#portfolio" },
   { itemName: "Our Team", ref: "#team" },
   { itemName: "Contact", ref: "#contact" }
];

document.addEventListener("DOMContentLoaded", function () {
   const navLinks = document.querySelector('.nav-links');
   navLinks.innerHTML = "";

   // Detect if we're in a subdirectory (e.g., /profiles/)
   const isProfilePage = window.location.pathname.includes('/profiles/');

   barItems.forEach(item => {
      const li = document.createElement('li');
      const a = document.createElement('a');

      if (item.external) {
         // Constitution Day is an external file, so just use its ref
         a.href = item.ref;
         a.classList.add("constitution-nav-item");
      } else {
         // If on a profile page, link to index.html with hash, else just hash
         a.href = isProfilePage ? `../index.html${item.ref}` : item.ref;
      }

      a.textContent = item.itemName;
      li.appendChild(a);
      navLinks.appendChild(li);
   });

   // Year in footer
   const yearEl = document.getElementById("year");
   if (yearEl) yearEl.textContent = new Date().getFullYear();

   // Smooth-scroll for in-page anchors
   document.querySelectorAll('a[href^="#"]').forEach((a) => {
      a.addEventListener("click", (e) => {
         const id = a.getAttribute("href");
         if (id && id.length > 1) {
            const target = document.querySelector(id);
            if (target) {
               e.preventDefault();
               target.scrollIntoView({ behavior: "smooth" });
            }
         }
      });
   });
});
