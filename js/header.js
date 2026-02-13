// header.js - Handles the mobile navigation toggle for the website header

// Wait for the DOM to be fully loaded before attaching event listeners
document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".burger");
  const mobileNav = document.querySelector(".nav-mobile");

  if (!burger || !mobileNav) return;

  burger.addEventListener("click", () => {
    mobileNav.classList.toggle("is-open");
  });
});
