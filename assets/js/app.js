document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("menuToggle");
  const nav = document.getElementById("mainNav");

  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      nav.classList.toggle("active");
    });
  }
});

  // Handle dropdown taps on mobile
  document.querySelectorAll(".nav-item.has-dropdown > a").forEach(link => {
    link.addEventListener("click", function (e) {
      const parent = this.parentElement;

      // If submenu exists
      if (parent.querySelector(".dropdown")) {
        if (!parent.classList.contains("open")) {
          e.preventDefault(); // stop redirect
          // close others
          document.querySelectorAll(".nav-item.open").forEach(el => el.classList.remove("open"));
          parent.classList.add("open");
        } else {
          parent.classList.remove("open"); // second tap closes
        }
      }
    });
  });

  // Close dropdown if clicked outside
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".nav")) {
      document.querySelectorAll(".nav-item.open").forEach(el => el.classList.remove("open"));
    }
  });


