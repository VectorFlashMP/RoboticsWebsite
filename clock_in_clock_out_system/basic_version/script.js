// script.js

function addDigit(d) {
  document.getElementById("code").value += d;
}

function clearCode() {
  document.getElementById("code").value = "";
}

async function verifyCode() {
  const code = document.getElementById("code").value.trim();
  if (!code) {
    alert("Please enter your code first!");
    return;
  }

  const formData = new FormData();
  formData.append("request_type", "verify_code");
  formData.append("code", code);

  const res = await fetch("log2.php", { method: "POST", body: formData });
  const text = await res.text();

  if (text.includes("verified")) {
    window.location.href = `clock.html?code=${code}`;
  } else {
    alert("Invalid code. Try again.");
  }
}

// For clock.html
document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const code = params.get("code");
  const codeField = document.getElementById("code");
  const manualCode = document.getElementById("manualCode");

  if (codeField) codeField.value = code || "";
  if (manualCode) manualCode.value = code || "";
});
