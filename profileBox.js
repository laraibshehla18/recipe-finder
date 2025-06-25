function toggleProfileBox() {
  var box = document.getElementById("miniProfileBox");
  if (box.style.display === "none" || box.style.display === "") {
    box.style.display = "block";

    // Email & password fetch from server
    fetch('get_user_info.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById("userEmail").textContent = data.email;
        document.getElementById("userPassword").textContent = '********';
      });
  } else {
    box.style.display = "none";
  }
}

// Hide box if clicked outside
document.addEventListener("click", function(e) {
  const box = document.getElementById("miniProfileBox");
  if (!box.contains(e.target) && e.target.innerText !== "Profile") {
    box.style.display = "none";
  }
});
